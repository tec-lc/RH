<?php

class SiteExporter {
    private $nomePasta;
    private $origem;
    private $destino;

    public function __construct($dir,$nomePasta,$permitido=['css', 'js', 'img', 'fotos', 'video']) {
        $this->nomePasta = $nomePasta;
        //$this->origem = __DIR__ . "/$nomePasta";
        $this->origem = '../'. "/$nomePasta";
        $this->destino =  "$dir$nomePasta";
        $this->permitido=$permitido;

    }

    public function exportar() {
        $this->apagarPasta();
        $this->criarDiretorios();
        $this->exportarPaginas();
        $this->copiarPastas($this->permitido);
    }

    private function criarDiretorios() {
        @mkdir($this->destino . '/paginas', 0777, true);
    }

    private function exportarPaginas() {
        $paginasDir = $this->origem . '/paginas';
        $arquivos = scandir($paginasDir);

        foreach ($arquivos as $arquivo) {
            if ($arquivo === '.' || $arquivo === '..') continue;
            $nome = pathinfo($arquivo, PATHINFO_FILENAME);

            $url = "http://localhost/{$this->nomePasta}/?pg=$nome";
            $conteudo = @file_get_contents($url);

            if ($conteudo === false) {
                echo "Falha ao ler: $url\n";
                continue;
            }

            file_put_contents("{$this->destino}/{$nome}.html", $conteudo);
            echo "Exportado: {$this->destino}/$nome.html<br>\n";
        }
    }

    private function copiarPastas(array $pastas) {
        foreach ($pastas as $pasta) {
            $origemPasta = $this->origem . "/$pasta";
            $destinoPasta = $this->destino . "/$pasta";
            if (is_dir($origemPasta)) {
                $this->copiarRecursivo($origemPasta, $destinoPasta);
                echo "Copiada pasta: $pasta<br>\n";
            }
        }
    }

    private function copiarRecursivo($origem, $destino) {
        @mkdir($destino, 0777, true);
        foreach (scandir($origem) as $item) {
            if ($item === '.' || $item === '..') continue;

            $origemItem = $origem . '/' . $item;
            $destinoItem = $destino . '/' . $item;

            if (is_dir($origemItem)) {
                $this->copiarRecursivo($origemItem, $destinoItem);
            } else {
                copy($origemItem, $destinoItem);
            }
        }
    }



    private function apagarPasta($pasta=false) {
        if($pasta==false){
            $pasta= $this->destino;
        }
        if (!is_dir($pasta)) return;

        $itens = scandir($pasta);
        foreach ($itens as $item) {
            if ($item === '.' || $item === '..') continue;

            $caminho = $pasta . DIRECTORY_SEPARATOR . $item;
            if (is_dir($caminho)) {
                $this->apagarPasta($caminho); // Recursão para subpastas
            } else {
                unlink($caminho); // Apaga arquivo
            }
        }
         @chmod($pasta, 0777); // garantir permissão
        if (!@rmdir($pasta)) {
            echo "Erro ao apagar pasta: $pasta<br>";
        }
    }

}






?>
