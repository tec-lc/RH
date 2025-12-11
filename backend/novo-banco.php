<?php
require 'class-php/class.ConexaoBd.php';
//require 'class-php/class.Mysql.php';
//require 'sql/bancoArray.php';

//'senha'   => 'Lucas123$$',
$con = new ConexaoBd();
    $dados = [
        'ip'      => 'localhost',
        'usuario' => 'root',
        'senha'   => 'Lucas123$$',
        'banco'   => 'bdteste_rh'
    ];
 
    $conecta = $con->testeConexao($dados); // testa conexão SEM banco
 
    if ($conecta) {
        $conBanco = $con->testeBanco();    // verifica se banco existe
 
        if ($conBanco) {
            $con->dropTb();               // exclui todas as tabelas
            echo "banco ja existe então apagamos as tabelas!";
        } else {
            $con->Banco(); 
            echo "banco criado com sucesso";               // cria novo banco UTF8
        }
 
        $con->salva(
            $dados,
            'conexao/conexao.php',        // arquivo de conexão criptografado
            'chave_txt_encriptadora',
            'chave_desencriptadora'
        );
    }

   
  
 






?>