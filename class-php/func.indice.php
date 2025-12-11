<?php

function indice(array $dados): array
{
    $tabelas = [];
    $colunas = [];

    foreach ($dados as $nomeTabela => $tabela) {
        // Guarda o nome da tabela
        $tabelas[] = $nomeTabela;

        // Guarda as colunas dessa tabela (pelas chaves)
        $colunas[] = array_keys($tabela);
    }

    return [
        'tabelas' => $tabelas,
        'colunas' => $colunas,
    ];
}

//=================================================================

function executa_conversao($entradaXlsm, $saidaPhp) {
    // Caminhos fixos
    $venvPython = '/var/www/html/rh/backend/venv/bin/python';
    $script     = '/var/www/html/rh/backend/converte.py';

    // Monta o comando com segurança
    $cmd = escapeshellarg($venvPython) . ' ' .
           escapeshellarg($script) . ' ' .
           escapeshellarg($entradaXlsm) . ' ' .
           escapeshellarg($saidaPhp) . ' 2>&1';

    $saida = [];
    $ret   = 0;

    exec($cmd, $saida, $ret);

    return [
        'cmd'    => $cmd,
        'ret'    => $ret,
        'saida'  => $saida,
    ];
}
//==================================================================



?>