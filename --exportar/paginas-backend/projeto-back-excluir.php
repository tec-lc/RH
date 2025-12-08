<?php include 'class-php/class.BancoTxt.php';
$b= new BancoTxt('BANCOTXT/bdexportar.xml','utf8');






echo $b->delete('projeto', ['id_projeto' => $_POST['id']]);
echo $_POST['id'];
 ?>
