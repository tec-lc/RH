<?php
require 'icon/icon.php';

//define categoria esta 

?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <script src="js/bibli.jquery.js" ></script>
    <script src="js/formulario.js"></script>
    <link rel="stylesheet" href="css/estrutura.css">
    <link rel="stylesheet" href="fonte/google-Whereas-recognition-of/importar.php">
    
    <title>IDA</title>


</head>
<?=$this->categoria()?>
<body class="corBacAzul">

  <div class="top sombra corBacBranco corLinha">

    <div class="alinhaTop">
        <div class="quadroTop">
            <div class="iconQuadro"><?=$ICON['icone-fechar']?></div>
        </div>

        

       
        <a class="linkOff" opr="aplicar" href="?pgw=importabanco">
          <div class="bntAplicacao"  style="display:none;">
             Aplicar
          </div>
        </a>


         <div class="bntApagar" cod_tab="" style="display:none;">
             Apagar
          </div>


        <h1 class="txtTitulo">IDA</h1>
        <!-- Unificação Dados-->
    </div>



   

    <div class="clear"></div>
  </div>

  <div class="menu sombra corBacBranco corLinha">

    <div class="menuLateral corBacAzul" >
      <div class="quadroIcon categoria-opcoes" menu="opcoes">
        <div class="iconQuadro"><?=$ICON['icone-filtro']?></div>
        <div class="fontIcon">Opçoes</div>
      </div>
      <div class="quadroIcon categoria-planilha" menu="planilha">
        <div class="iconQuadro"><?=$ICON['icone-planilha']?></div>
        <div class="fontIcon">Planilha</div>
      </div>
      <div class="quadroIcon categoria-usuario" menu="usuario">
        <div class="iconQuadro"><?=$ICON['icone-login']?></div>
        <div class="fontIcon">Usuario</div>
      </div>
    </div>

    <div class="menuMais caixaCategoria-opcoes" style="display:none;">

        <a class="linkOff" href="?pgw=importar">
            <div class="itenMenu subCat-importar">
                <div class="iconFloat"><?=$ICON['icone-importar']?></div>
                <div class="fontMenu">Importar informações</div>
                <div class="clear"></div>
            </div>
        </a>

        <a class="linkOff" href="?pgw=exportar">
            <div class="itenMenu subCat-exportar">
                <div class="iconFloat"><?=$ICON['icone-exportar']?></div>
                <div class="fontMenu">Exportar para template</div>
                <div class="clear"></div>
            </div>
        </a>

        <a class="linkOff" href="?pgw=informacoes">
            <div class="itenMenu subCat-informacoes">
                <div class="iconFloat"><?=$ICON['icone-duvidas']?></div>
                <div class="fontMenu">Informações</div>
                <div class="clear"></div>
            </div>
        </a>
    </div>


    <div class="menuMais caixaCategoria-planilha" style="display:none;">Planilha</div>
    <div class="menuMais caixaCategoria-usuario" style="display:none;">Usuario</div>

    

    <div class="clear"></div>
  </div>

  <div class="corpo corBacBranco sombra corLinha" id="espacoMenu">
    <?=$this->pagina()?>
  </div>



  </div>
</body>
</html>
