<?php

class Mysql
{
    /**
     * Gera instruções CREATE TABLE a partir da definição de $tabelas.
     *
     * Formato esperado:
     * $tabelas = [
     *     'funcionario_ativo' => [
     *         ['cpf','int'],
     *         ['id_funcionario', 'int'],
     *         ['nome','varchar(110)'],
     *         ...
     *     ],
     *     'faltas' => [
     *         ['id_funcionario','int'],
     *         ...
     *     ],
     * ];
     */
    public function create(array $tabelas): string
    {
        $sqlParts = [];

        foreach ($tabelas as $nomeTabela => $colunas) {
            if (!is_array($colunas) || empty($colunas)) {
                continue;
            }

            $tabelaSql = $this->sanitizeIdentifier($nomeTabela, 'tab_');

            $colsSql = [];
            foreach ($colunas as $colDef) {
                // cada $colDef = [nome, tipo]
                if (!is_array($colDef) || count($colDef) < 2) {
                    continue;
                }

                [$colNome, $colTipo] = $colDef;

                $colNomeSql = $this->sanitizeIdentifier((string)$colNome, 'col_');
                $colTipoSql = trim((string)$colTipo) ?: 'VARCHAR(255)';

                $colsSql[] = "   `{$colNomeSql}` {$colTipoSql}";
            }

            if (empty($colsSql)) {
                continue;
            }

            $create = "CREATE TABLE `{$tabelaSql}` (\n"
                    . implode(",\n", $colsSql)
                    . "\n);";

            $sqlParts[] = $create;
        }

        return implode("\n\n", $sqlParts);
    }

    /**
     * Gera instruções INSERT com base em:
     * - $tabelas: definição das tabelas
     * - $dados: dados "crus"
     * - $map: mapeamento entre os conjuntos de dados e as colunas das tabelas
     *
     * Exemplo de uso:
     * $insert = $v->insert(
     *     $tabelas,
     *     $dados,
     *     [
     *         'nome de pessoas' => [
     *             'cpf da pessoa',
     *             'codigo de cadastro'
     *         ]
     *     ]
     * );
     */
    public function insert(array $tabelas, array $dados, array $map): string
    {
        $sqlParts = [];

        // Ordem das tabelas
        $nomesTabelas = array_keys($tabelas);
        $indiceTabela = 0;

        foreach ($map as $nomeConjuntoDados => $colunasDados) {
            if (!isset($dados[$nomeConjuntoDados])) {
                // conjunto de dados não existe em $dados
                continue;
            }

            if (!isset($nomesTabelas[$indiceTabela])) {
                // não há mais tabelas para mapear
                break;
            }

            $nomeTabelaOriginal = $nomesTabelas[$indiceTabela];
            $tabelaSql          = $this->sanitizeIdentifier($nomeTabelaOriginal, 'tab_');

            $defColsTabela = $tabelas[$nomeTabelaOriginal] ?? [];
            if (empty($defColsTabela)) {
                $indiceTabela++;
                continue;
            }

            // Número de colunas que vamos usar é o mínimo entre
            // colunas mapeadas e colunas definidas na tabela
            $numColunasMapa = count($colunasDados);
            $numColunasTab  = count($defColsTabela);
            $numColunas     = min($numColunasMapa, $numColunasTab);

            if ($numColunas === 0) {
                $indiceTabela++;
                continue;
            }

            // Colunas de tabela que serão usadas (na ordem)
            $colunasTabelaSql = [];
            for ($i = 0; $i < $numColunas; $i++) {
                $nomeColOriginal = $defColsTabela[$i][0] ?? ('col_' . $i);
                $colunasTabelaSql[] = $this->sanitizeIdentifier($nomeColOriginal, 'col_');
            }

            // Dados: array de colunas "brutas"
            $dadosConjunto = $dados[$nomeConjuntoDados];

            // Descobre quantas linhas temos (pega o maior comprimento entre as colunas mapeadas)
            $maxLinhas = 0;
            for ($i = 0; $i < $numColunas; $i++) {
                $nomeColDados = $colunasDados[$i] ?? null;
                if ($nomeColDados === null || !isset($dadosConjunto[$nomeColDados])) {
                    continue;
                }

                $qtd = count($dadosConjunto[$nomeColDados]);
                if ($qtd > $maxLinhas) {
                    $maxLinhas = $qtd;
                }
            }

            if ($maxLinhas === 0) {
                $indiceTabela++;
                continue;
            }

            // Montar INSERT
            $colsSql = "`" . implode("`, `", $colunasTabelaSql) . "`";

            $linhasValues = [];
            for ($linha = 0; $linha < $maxLinhas; $linha++) {
                $valsLinha = [];

                for ($i = 0; $i < $numColunas; $i++) {
                    $nomeColDados = $colunasDados[$i] ?? null;

                    $valor = null;
                    if ($nomeColDados !== null && isset($dadosConjunto[$nomeColDados])) {
                        $valor = $dadosConjunto[$nomeColDados][$linha] ?? null;
                    }

                    $valsLinha[] = $this->escapeSqlValue($valor);
                }

                $linhasValues[] = "(" . implode(", ", $valsLinha) . ")";
            }

            $valuesSql = implode(",\n", $linhasValues);

            $insert = "INSERT INTO `{$tabelaSql}` ({$colsSql}) VALUES\n{$valuesSql};";

            $sqlParts[] = $insert;

            // Próxima tabela para o próximo conjunto no mapa
            $indiceTabela++;
        }

        return implode("\n\n", $sqlParts);
    }

    /**
     * Sanitiza nomes de tabela/coluna para serem válidos no MySQL.
     */
    protected function sanitizeIdentifier(string $name, string $prefix = 'col_'): string
    {
        $name = trim($name);

        if ($name === '') {
            return $prefix . 'sem_nome';
        }

        // Tenta remover acentos (se iconv existir)
        if (function_exists('iconv')) {
            $converted = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $name);
            if ($converted !== false) {
                $name = $converted;
            }
        }

        // Substitui qualquer coisa que não seja A-Z, a-z, 0-9 ou _ por _
        $name = preg_replace('/[^A-Za-z0-9_]/', '_', $name);
        // Colapsa múltiplos _
        $name = preg_replace('/_+/', '_', $name);
        // Remove _ no início/fim
        $name = trim($name, '_');

        if ($name === '') {
            $name = $prefix . 'sem_nome';
        }

        // Se começar com número, prefixa
        if (preg_match('/^[0-9]/', $name)) {
            $name = $prefix . $name;
        }

        // Limite de 64 caracteres para segurança
        if (strlen($name) > 64) {
            $name = substr($name, 0, 64);
        }

        return $name;
    }

    /**
     * Escapa valor para uso em SQL.
     */
    protected function escapeSqlValue($value): string
    {
        if ($value === null || $value === '') {
            return 'NULL';
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        // Se for numérico puro, você pode optar por não colocar aspas
        if (is_int($value) || is_float($value)) {
            return (string)$value;
        }

        $str = (string)$value;
        $str = addslashes($str);

        return "'{$str}'";
    }
}

?>
