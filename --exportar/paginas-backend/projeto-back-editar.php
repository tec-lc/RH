<?php include 'class-php/class.BancoTxt.php';
$b= new BancoTxt('BANCOTXT/bdexportar.xml','utf8');





// Atualização
$b->update('projeto', ['id_projeto' => $_POST['id']], [
  'nome'=>$_POST['nome_projeto'],
  'diretorio' => $_POST['diretorio_projeto'],
  'data' => $_POST['data_criacao']
]);

 ?>
