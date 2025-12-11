<?php
/**
 * Classe de conexão com MySQL + import/export/backup
 *
 * Fluxo 1 (primeira configuração):
 *
 *   $con = new Conexao();
 *   $dados = [
 *       'ip'      => 'localhost',
 *       'usuario' => 'root',
 *       'senha'   => 'Lucas123$$',
 *       'banco'   => 'bdteste_rh'
 *   ];
 *
 *   $conecta = $con->testeConexao($dados); // testa conexão SEM banco
 *
 *   if ($conecta) {
 *       $conBanco = $con->testeBanco();    // verifica se banco existe
 *
 *       if ($conBanco) {
 *           $con->dropTb();               // exclui todas as tabelas
 *       } else {
 *           $con->Banco();                // cria novo banco UTF8
 *       }
 *
 *       $con->salva(
 *           $dados,
 *           'conexao/conexao.php',        // arquivo de conexão criptografado
 *           'chave_txt_encriptadora',
 *           'chave_desencriptadora'
 *       );
 *   }
 *
 *
 * Fluxo 2 (uso normal depois de configurado):
 *
 *   $con = new Conexao('conexao/conexao.php', 'chave_desencriptadora');
 *   $dados_array = $con->sql_array('SELECT * FROM tbteste');
 *   print_r($dados_array);
 *
 * Importar:
 *   $con->importar('script.sql');
 *
 * Exportar estrutura (tabelas vazias):
 *   $con->exportar('estrutura.sql');
 *
 * Backup completo (estrutura + dados):
 *   $con->backup('backup.sql');
 */

class ConexaoBd
{
    /** @var string */
    private $host;
    /** @var string */
    private $user;
    /** @var string */
    private $pass;
    /** @var string */
    private $dbName;

    /** @var PDO|null Conexão sem banco (servidor apenas) */
    private $pdoServer = null;

    /** @var PDO|null Conexão com banco selecionado */
    private $pdoDb = null;

    public function __construct(string $configPath = null, string $chaveDesencriptadora = null)
    {
        if ($configPath !== null) {
            if (!file_exists($configPath)) {
                throw new RuntimeException("Arquivo de conexão não encontrado: {$configPath}");
            }

            if ($chaveDesencriptadora === null) {
                throw new InvalidArgumentException("É necessário informar a chave de desencriptação.");
            }

            $encData = include $configPath;
            if (!is_array($encData) || !isset($encData['iv'], $encData['data'])) {
                throw new RuntimeException("Formato inválido do arquivo de conexão.");
            }

            $iv    = base64_decode($encData['iv']);
            $dados = base64_decode($encData['data']);

            $key = $this->gerarChave($chaveDesencriptadora);

            $json = openssl_decrypt($dados, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
            if ($json === false) {
                throw new RuntimeException("Falha ao descriptografar dados de conexão. Chave incorreta?");
            }

            $config = json_decode($json, true);
            if (!is_array($config)) {
                throw new RuntimeException("Falha ao decodificar JSON de configuração.");
            }

            $this->host   = $config['ip']      ?? 'localhost';
            $this->user   = $config['usuario'] ?? 'root';
            $this->pass   = $config['senha']   ?? '';
            $this->dbName = $config['banco']   ?? '';

            // Conecta direto no banco
            $this->pdoDb = $this->criarConexaoDb($this->host, $this->user, $this->pass, $this->dbName);
        }
    }

    private function gerarChave(string $chave): string
    {
        // 32 bytes = 256 bits
        return hash('sha256', $chave, true);
    }

    private function criarConexaoServidor(string $host, string $user, string $pass): PDO
    {
        $dsn = "mysql:host={$host};charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $pdo;
    }

    private function criarConexaoDb(string $host, string $user, string $pass, string $dbName): PDO
    {
        $dsn = "mysql:host={$host};dbname={$dbName};charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $pdo;
    }

    /** Garante que $this->pdoDb está aberto */
    private function ensureDbConnection(): void
    {
        if ($this->pdoDb === null) {
            if (!isset($this->host, $this->user, $this->pass, $this->dbName)) {
                throw new RuntimeException("Dados de conexão com banco não definidos.");
            }
            $this->pdoDb = $this->criarConexaoDb($this->host, $this->user, $this->pass, $this->dbName);
        }
    }

    public function testeConexao(array $dados): bool
    {
        $this->host   = $dados['ip']      ?? 'localhost';
        $this->user   = $dados['usuario'] ?? 'root';
        $this->pass   = $dados['senha']   ?? '';
        $this->dbName = $dados['banco']   ?? '';

        try {
            $this->pdoServer = $this->criarConexaoServidor($this->host, $this->user, $this->pass);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function testeBanco(): bool
    {
        if ($this->pdoServer === null) {
            throw new RuntimeException("Conexão com servidor não inicializada. Chame testeConexao() antes.");
        }

        $sql = "SELECT SCHEMA_NAME 
                FROM INFORMATION_SCHEMA.SCHEMATA 
                WHERE SCHEMA_NAME = :db";

        $stmt = $this->pdoServer->prepare($sql);
        $stmt->execute([':db' => $this->dbName]);
        $row = $stmt->fetch();

        return $row !== false;
    }

    public function Banco(): void
    {
        if ($this->pdoServer === null) {
            throw new RuntimeException("Conexão com servidor não inicializada. Chame testeConexao() antes.");
        }

        $db = $this->dbName;
        $sql = "CREATE DATABASE IF NOT EXISTS `{$db}`
                DEFAULT CHARACTER SET utf8mb4
                COLLATE utf8mb4_unicode_ci";

        $this->pdoServer->exec($sql);
    }

    public function dropTb(): void
    {
        if ($this->pdoServer === null) {
            throw new RuntimeException("Conexão com servidor não inicializada. Chame testeConexao() antes.");
        }

        $this->pdoDb = $this->criarConexaoDb($this->host, $this->user, $this->pass, $this->dbName);

        $tables = $this->pdoDb->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

        if (empty($tables)) {
            return;
        }

        $this->pdoDb->exec("SET FOREIGN_KEY_CHECKS = 0");

        foreach ($tables as $table) {
            $this->pdoDb->exec("DROP TABLE IF EXISTS `{$table}`");
        }

        $this->pdoDb->exec("SET FOREIGN_KEY_CHECKS = 1");
    }

    public function salva(
        array  $dados,
        string $caminhoArquivo,
        string $chaveTxtEncriptadora,
        string $chaveDesencriptadora
    ): void {
        $dir = dirname($caminhoArquivo);
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0775, true) && !is_dir($dir)) {
                throw new RuntimeException("Não foi possível criar o diretório: {$dir}");
            }
        }

        $json = json_encode($dados, JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            throw new RuntimeException("Falha ao codificar dados de conexão em JSON.");
        }

        $key = $this->gerarChave($chaveDesencriptadora);
        $iv  = random_bytes(16);

        $cipher = openssl_encrypt($json, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        if ($cipher === false) {
            throw new RuntimeException("Falha ao criptografar dados de conexão.");
        }

        $arrayArquivo = [
            'iv'   => base64_encode($iv),
            'data' => base64_encode($cipher),
        ];

        $php = "<?php\nreturn " . var_export($arrayArquivo, true) . ";\n";

        if (file_put_contents($caminhoArquivo, $php) === false) {
            throw new RuntimeException("Falha ao salvar arquivo de conexão em {$caminhoArquivo}");
        }
    }

    public function sql_array(string $sql): array
    {
        $this->ensureDbConnection();

        $stmt = $this->pdoDb->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $resultado = [];

        foreach ($rows as $rowIndex => $row) {
            foreach ($row as $col => $valor) {
                $resultado[$col][$rowIndex] = $valor;
            }
        }

        return $resultado;
    }

    /* ============================================================
     *  NOVAS FUNÇÕES: importar, exportar (estrutura), backup (estrutura+dados)
     * ============================================================ */

    /**
     * Importa um arquivo .sql e executa todos os comandos dentro dele.
     */
    public function importar(string $arquivoSql): void
    {
        $this->ensureDbConnection();

        if (!file_exists($arquivoSql)) {
            throw new RuntimeException("Arquivo SQL não encontrado: {$arquivoSql}");
        }

        $conteudo = file_get_contents($arquivoSql);
        if ($conteudo === false) {
            throw new RuntimeException("Falha ao ler arquivo SQL: {$arquivoSql}");
        }

        // Remove comentários simples (-- e #) e linhas vazias
        $linhas = preg_split('/\R/', $conteudo);
        $buffer = '';

        foreach ($linhas as $linha) {
            $trim = trim($linha);

            // ignora comentários
            if ($trim === '' || str_starts_with($trim, '--') || str_starts_with($trim, '#')) {
                continue;
            }

            $buffer .= $linha . "\n";

            // Quando encontra ";" no final, considera um comando completo
            if (preg_match('/;\s*$/', $trim)) {
                $comando = trim($buffer);
                $buffer  = '';

                if ($comando !== '') {
                    $this->pdoDb->exec($comando);
                }
            }
        }

        // Se sobrou algo sem ";" no final
        $resto = trim($buffer);
        if ($resto !== '') {
            $this->pdoDb->exec($resto);
        }
    }

    /**
     * Exporta apenas a estrutura (tabelas vazias).
     * Gera DROP TABLE + CREATE TABLE para todas as tabelas do banco.
     */
    public function exportar(string $arquivoSql): void
    {
        $this->ensureDbConnection();

        $dir = dirname($arquivoSql);
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0775, true) && !is_dir($dir)) {
                throw new RuntimeException("Não foi possível criar o diretório: {$dir}");
            }
        }

        $tables = $this->pdoDb->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

        $output  = "-- Export de estrutura (tabelas vazias)\n";
        $output .= "-- Banco: {$this->dbName}\n";
        $output .= "-- Gerado em: " . date('Y-m-d H:i:s') . "\n\n";
        $output .= "CREATE DATABASE IF NOT EXISTS `{$this->dbName}` "
                . "DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
        $output .= "USE `{$this->dbName}`;\n\n";

        foreach ($tables as $table) {
            $createStmt = $this->pdoDb->query("SHOW CREATE TABLE `{$table}`")->fetch(PDO::FETCH_ASSOC);

            $output .= "-- --------------------------------------------------\n";
            $output .= "-- Estrutura da tabela `{$table}`\n";
            $output .= "-- --------------------------------------------------\n\n";
            $output .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $output .= $createStmt['Create Table'] . ";\n\n";
        }

        if (file_put_contents($arquivoSql, $output) === false) {
            throw new RuntimeException("Falha ao salvar export de estrutura em {$arquivoSql}");
        }
    }

    /**
     * Exporta estrutura + dados (backup completo).
     */
    public function backup(string $arquivoSql): void
    {
        $this->ensureDbConnection();

        $dir = dirname($arquivoSql);
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0775, true) && !is_dir($dir)) {
                throw new RuntimeException("Não foi possível criar o diretório: {$dir}");
            }
        }

        $tables = $this->pdoDb->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

        $output  = "-- Backup completo (estrutura + dados)\n";
        $output .= "-- Banco: {$this->dbName}\n";
        $output .= "-- Gerado em: " . date('Y-m-d H:i:s') . "\n\n";
        $output .= "CREATE DATABASE IF NOT EXISTS `{$this->dbName}` "
                . "DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
        $output .= "USE `{$this->dbName}`;\n\n";

        foreach ($tables as $table) {
            // Estrutura
            $createStmt = $this->pdoDb->query("SHOW CREATE TABLE `{$table}`")->fetch(PDO::FETCH_ASSOC);

            $output .= "-- --------------------------------------------------\n";
            $output .= "-- Estrutura da tabela `{$table}`\n";
            $output .= "-- --------------------------------------------------\n\n";
            $output .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $output .= $createStmt['Create Table'] . ";\n\n";

            // Dados
            $rows = $this->pdoDb->query("SELECT * FROM `{$table}`")->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($rows)) {
                $output .= "-- Dados da tabela `{$table}`\n\n";

                foreach ($rows as $row) {
                    $cols = array_map(fn($c) => "`{$c}`", array_keys($row));
                    $vals = array_map(function ($v) {
                        if ($v === null) {
                            return "NULL";
                        }
                        // Usa quote do PDO para escapar
                        return $this->pdoDb->quote($v);
                    }, array_values($row));

                    $output .= "INSERT INTO `{$table}` (" . implode(',', $cols) . ") "
                             . "VALUES (" . implode(',', $vals) . ");\n";
                }

                $output .= "\n";
            }
        }

        if (file_put_contents($arquivoSql, $output) === false) {
            throw new RuntimeException("Falha ao salvar backup em {$arquivoSql}");
        }
    }
}
?>