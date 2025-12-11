<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'class-php/class.Paginamento.php';

new Paginamento(
  'informacoes',
  [
  
  'informacoes'=>[
    'layout'=>'layout/html.php',
    'dir'=>'paginas/informacoes.php',
    'categoria'=>'opcoes',

  ],

  'importar'=>[
    'layout'=>'layout/html.php',
    'dir'=>'paginas/importar.php',
    'categoria'=>'opcoes',
  ],

  'planilha'=>[
    'layout'=>'layout/html.php',
    'dir'=>'paginas/planilha.php',
    'categoria'=>'planilha',

  ],

  'novo-banco'=>['dir'=>'backend/novo-banco.php'],
  'novo-tabela'=>['dir'=>'backend/novo-tabela.php'],

  'bnt-limpar'=>['dir'=>'backend/bnt-limpar.php'],

  'importabanco'=>['dir'=>'backend/importa_banco.php'],
  'abreplanilha'=>['dir'=>'backend/abre_planilha.php'],
  'abretabela'=>['dir'=>'backend/abre_tabela.php'],
  'exportar'=>['dir'=>'backend/exportar.php'],
  'importar/backend'=>['dir'=>'backend/importar.php'],
  'erro404'=>['dir'=>'paginas/erro404.php'],

]);




?>