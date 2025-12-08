
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta property="og:title" content="titulo whtsaap"/>
  <meta property="og:description" content="sub titulo whatsaap"/>
  <meta property="og:site_name" content="dominio.netlif.app"/>
  <meta property="og:image" content="https://lucasenatalia.netlify.app/img/capaurl.png"/>
  <meta property="og:image:width" content="158"/>
  <meta property="og:image:height" content="158"/>
  <meta property="og:url" content="https://lucasenatalia.netlify.app/">
  <meta property="og:type" content="website">
  <meta name="author" content="Seu Nome">
  <!--<meta property="fb:app_id" content="621352837957736"/>-->





  <!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
  <script src="class-js/class.Formulario.js" ></script>
  <script src="class-js/class.Principais.js" ></script>
  <script src="class-js/class.TrataDados.js" ></script>
  <?=$this->tag('js')?>
   <!--<script src="js/pg.Principais.js" ></script>-->


  <link rel="stylesheet" href="<?=$this->RAIZ?>css.estrutura.css">
  <?=$this->tag('css')?>

  <link rel="icon" href="adfgdfg.png">
  <title>CMD</title>



</head>
<body>

  <header>
    <div class="">
    </div>

    <div class="top">
      <div class="alinha">

        <div class="bntMenu">

          <!--<div class="iconMenu"></div>-->
          <div class="emojiMenu">📋</div>
          <div class="txtMenu">
            Menu
          </div>

          <div class="clear"></div>
        </div><!--bntMenu-->

        <div class="meioTop">

          <!--<div class="iconPg"></div>-->
          <div class="emojiPg">🏠</div>
          <div class="txtPg">
              Pagina de inícialização de codigo
          </div>


           <!--<div class="iconPes"></div>-->
          <div class="emojiPes">🔍</div>
          <div class="txtPes">
              Pesquise
          </div>

          <div class="clear"></div>
        </div><!--bntMeio-->

        <div class="bntLogin">

          <!--<div class="iconLogin"></div>-->
          <div class="emojiLogin">🤵🏻</div>
          <div class="txtLogin">
            Login
          </div>

          <div class="clear"></div>
        </div><!--bntLogin-->



        <div class="clear"></div>
      </div><!--alinha-->
    </div><!--top-->

    <div class="painelTransparente painelTransparente2" style="display:none;"></div>

    <div class="alinha alinha1">

      <div class="painelMenu" style="display:none;">
        <div class="autoRolagem">

          <a href="?" target="_self">
            <div class="itemMenu">
              <!--<div class="iconItem"></div>-->
              <div class="emojiItem">✏️</div>
              <div class="txtItem">Lista de Projetos</div>
              <div class="clear"></div>
            </div>
          </a>

          <a href="?pg=projeto-novo" target="_self">
            <div class="itemMenu">
              <!--<div class="iconItem"></div>-->
              <div class="emojiItem">➕</div>
              <div class="txtItem">Novo Projeto</div>
              <div class="clear"></div>
            </div>
          </a>

          <a href="?pg=img-fundo" target="_self">
            <div class="itemMenu">
              <!--<div class="iconItem"></div>-->
              <div class="emojiItem">🖼️</div>
              <div class="txtItem">Background Icons</div>
              <div class="clear"></div>
            </div>
          </a>

          <a href="?pg=icone" target="_self">
            <div class="itemMenu">
              <!--<div class="iconItem"></div>-->
              <div class="emojiItem">🖼️</div>
              <div class="txtItem">Icones SGV</div>
              <div class="clear"></div>
            </div>
          </a>

        </div>

      </div>

      <div class="alinhaLogin">
        <div class="painelLogin" style="display:none;">
          <div class="autoRolagem">
            <?php for($x=0;$x<30;$x++){echo'teste<br>';}?>
          </div>
        </div>
      </div>
    </div>
    <script>



      const menu = new ClassId('.painelTransparente,.painelMenu');



      new ClassId('.bntMenu','.painelTransparente')
      .clickNavegador((e) => {
        menu.attr('style','display:block;');
      }, (e)=> {
        menu.attr('style','display:none;');
      });

      const login = new ClassId('.painelTransparente,.painelLogin');
      new ClassId('.bntLogin','.painelTransparente')
      .clickNavegador((e) => {
        login.attr('style','display:block;');
      }, (e)=> {
        login.attr('style','display:none;');
      });


    </script>



  </header>

  <main>
    <?=$this->pagina()?>

  </main>

  <footer>
    <p>&copy; 2025 - Todos os direitos reservados | Desenvolvido por Você</p>
  </footer>

</body>
</html>
