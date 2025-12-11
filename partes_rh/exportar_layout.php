<?php
//crie uma class em php que gere um arquivo em csv a partir de um array:
//exempo de de array:

require 'class-php/class.Planilha.php';
require 'class-php/func.indice.php';
$val=[
    0=>[//coluna zero 
        'linha 0',
        'linha 1',
    ],
    1=>[//coluna 1 
        'conteudo 0',
        'conteudo 1',
    ],
];

$plan= new Planilha();
$plan->arquivo($val,'downloads/planilha.csv');//salva oarquivo csv

print_r(executa_python('/var/www/html/rh/backend/exporta.py'));

?>