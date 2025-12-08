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

  'exportar'=>['dir'=>'backend/exportar.php'],
  
  'importar/backend'=>['dir'=>'backend/importar.php'],
  'erro404'=>['dir'=>'paginas/erro404.php'],

]);




?>