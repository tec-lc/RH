<?php
require 'class-php/func.indice.php';
require 'planilhas/temp.php';

//echo 'planilha aberta<br>';

$plan=indice($val);
//print_r($plan);

/*foreach ($plan['tabelas'] as $p){

    echo $p.'<br>';
}*/

echo implode('<->',$plan['tabelas']);












/*
crie uma função em php que pegue os nomes dos indices de uma array e retorne em um vetor assim

$valor=indice([
    'tabela_imposto'=>[
        'coluna_id'=>[
            ['valo1','valor2']
        ],
        'coluna_nome'=>[
            ['felipe1','mariana2']
        ],
    ],
    'tabela_teste'=>[
        'coluna_a'=>[
            ['dados 1','dados 2']
        ],
        'coluna_b'=>[
            ['testeeee','maerna']
        ],
    ],
]);

vai sair assim:
print_r($valor['tabelas']);//mostra todas tabelas
0=> 'tabela_imposto'
1=> 'tabela_teste'

print_r($valor['colunas'][0]);//mostra as colunas da tabela 0
0=> 'coluna_id'
1=> 'coluna_nome'

*/


?>

