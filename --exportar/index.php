<?php

include 'class-php/class.ControladorPagina.php';

new ControladorPagina(
  $mapa= [
    'projeto-listar'=>[
      'css'=> ['css.listaItens']
    ],
    'projeto-novo' => [
      'css' => ['css.formulario']
    ],
    'projeto-editar' => [
      'css' => ['css.formulario']
    ],



    'icone'=>'backend',
    'projeto-back-cadastrar' => 'backend',
    'projeto-back-editar' => 'backend',
    'projeto-back-excluir' => 'backend',
    'projeto-back-exportar' => 'backend',
    'projeto-back-loop' => 'backend',
    'img-fundo' => 'backend'
  ],

  $layoutGlobal ='googleMenuSeta',//layout global
  $pgHome= 'projeto-listar'//pagina home
);

//include 'paginas-layout/home-painelAdm/start.php';
/*monte um painel com html e css
que tenha 400 px de largura
fique flutuando na tela com uma altura do tamnho do conteudo que for colocado,
se o conteudo for maior que a tela então uma barra de rolagem aparecera
ele deve ter o estylo do google
e conter um menu com as opções : Visualizar, Exportar, Excluir, Editar
*/







 ?>
