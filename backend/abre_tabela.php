<?php
if (@$_GET['cod']==''){ exit;}

require 'class-php/func.indice.php';
require 'planilhas/temp.php';

$plan=indice($val);
//echo implode('<->',$plan['tabelas']);
//echo $_GET['cod'];
$cod=$_GET['cod'];

//print_r($plan);
/*
foreach( $plan['colunas'][$cod] as $colunas){
    echo "coluna: $colunas \n";
    echo "valores: \n";
    foreach($val[$plan['tabelas'][$cod]][$colunas] as $dao){
        echo "$dao: \n";
    }

}*/





// $cod = índice da tabela que você quer usar (por exemplo 0)
// $plan  = resultado da função indice([...])
// $val   = array original com os dados

$tabelaAtual    = $plan['tabelas'][$cod] ?? null;
$colunasTabela  = $plan['colunas'][$cod] ?? [];

// segurança básica
if ($tabelaAtual === null || empty($colunasTabela)) {
    echo 'Nenhuma tabela/coluna encontrada.';
    return;
}

$conteudo  = '<table style="width:100%; border-collapse: collapse;" border="1">' . PHP_EOL;

/*
 * 1) CABEÇALHO (colunas na horizontal)
 */
$conteudo .= '<tr>';

foreach ($colunasTabela as $nomeColuna) {
    $nomeColunaStr = (string)$nomeColuna; // evita null
    $conteudo .= '<th>' . htmlspecialchars($nomeColunaStr) . '</th>';
}

$conteudo .= '</tr>' . PHP_EOL;

/*
 * 2) DADOS
 *
 * Vamos descobrir quantas "linhas" de dados temos.
 * Ex.: se $val['tabela_imposto']['coluna_id'] tem 2 itens,
 * e 'coluna_nome' também, teremos 2 linhas.
 */

$maxLinhas = 0;

foreach ($colunasTabela as $nomeColuna) {
    if (isset($val[$tabelaAtual][$nomeColuna]) && is_array($val[$tabelaAtual][$nomeColuna])) {
        $qtd = count($val[$tabelaAtual][$nomeColuna]);
        if ($qtd > $maxLinhas) {
            $maxLinhas = $qtd;
        }
    }
}

// Monta cada linha de dados
for ($i = 0; $i < $maxLinhas; $i++) {
    $conteudo .= '<tr>';

    foreach ($colunasTabela as $nomeColuna) {
        $celula = '';

        if (isset($val[$tabelaAtual][$nomeColuna][$i])) {
            $celula = $val[$tabelaAtual][$nomeColuna][$i];

            // se for array (ex: ['valor1','valor2']), junta:
            if (is_array($celula)) {
                $celula = implode(', ', $celula);
            }
        }

        $celulaStr = (string)$celula; // evita null
        $conteudo .= '<td>' . htmlspecialchars($celulaStr) . '</td>';
    }

    $conteudo .= '</tr>' . PHP_EOL;
}

$conteudo .= '</table>' . PHP_EOL;

echo $conteudo;






?>