<?php
require 'class-php/class.ConexaoBd.php';
require 'class-php/class.Mysql.php';
require 'sql/bancoArray.php';


$con = new ConexaoBd('conexao/conexao.php','chave_desencriptadora');
    $sql = new Mysql();
    $dados_tabela=$sql->create($tabelas);
    file_put_contents(
        'sql/tabelas.sql',
        $dados_tabela
    );
    $con->importar('sql/tabelas.sql');
?>