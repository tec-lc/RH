<?php

class Planilha
{
    // Gera e salva arquivo CSV
    public function arquivo(array $val, string $caminho)
    {
        // Garantir que o diretório existe
        $dir = dirname($caminho);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        // Abrir arquivo para escrita
        $fp = fopen($caminho, 'w');

        if (!$fp) {
            throw new Exception("Não foi possível criar o arquivo CSV.");
        }

        // Determina quantas linhas existem (assumindo que todas as colunas têm o mesmo número)
        $totalLinhas = 0;
        foreach ($val as $col) {
            $totalLinhas = max($totalLinhas, count($col));
        }

        // Monta o CSV linha por linha (transposição)
        for ($i = 0; $i < $totalLinhas; $i++) {
            $linha = [];

            foreach ($val as $col) {
                $linha[] = $col[$i] ?? ""; // se não existir, coloca vazio
            }

            fputcsv($fp, $linha, ';'); // salva com separador ";"
        }

        fclose($fp);
    }
}
