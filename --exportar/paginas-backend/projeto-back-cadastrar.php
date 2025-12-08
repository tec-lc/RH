<?php include 'class-php/class.BancoTxt.php';
$b= new BancoTxt('BANCOTXT/bdexportar.xml','utf8');


if(!file_exists('BANCOTXT/bdexportar.xml')){
  $b->newBanco([
      'projeto' => [
          'id_projeto' => ['int', 'auto'],
          'nome' => ['varchar', '150'],
          'diretorio' => ['varchar', '150'],
          'data' => ['date']

      ]
  ]);

}//if



//cadastra
$b->insert('projeto', [
    [$_POST['nome_projeto'],$_POST['diretorio_projeto'],$_POST['data_criacao']]
]);

 ?>
