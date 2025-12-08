<?php
/*
<section id="seo">
  <h2>O que é SEO?</h2>
  <p>SEO (Search Engine Optimization) é um conjunto de estratégias para melhorar o posicionamento de um site nos mecanismos de busca como o Google.</p>
</section>

<section id="tecnicas">
  <h2>Técnicas de SEO On-Page</h2>
  <ul>
    <li>Uso adequado de palavras-chave no título e conteúdo</li>
    <li>Meta description atrativa</li>
    <li>URLs amigáveis</li>
    <li>Links internos e externos</li>
    <li>Conteúdo original e relevante</li>
  </ul>
</section>

<section id="dicas">
  <h2>Dicas para Melhorar o Ranqueamento</h2>
  <p>Crie conteúdo de valor para o seu público. Use imagens otimizadas, carregamento rápido, e mantenha seu site responsivo para dispositivos móveis.</p>
</section>

crie uma lista em html e css com estylo do google,
cada item da lista deve ter emoji de pasta , nome da pasta, diretorio da pasta e data de criação
*/



?>




  <div class="folder-list">

    <?php
    //quero listar assim,
    include 'class-php/class.BancoTxt.php';
    $b= new BancoTxt('BANCOTXT/bdexportar.xml','utf8');
    $projetos=$b->sel(['projeto']);
    //print_r($projetos);
    function dtReverte($data){
      return implode(' / ', array_reverse(explode('-',$data)) );
    }
      foreach ($projetos as $p) {
        // code...
    ?>
      <div
        class="folder-item"
        id="itemSel-<?=$p['id_projeto']?>"
        codigo="<?=$p['id_projeto']?>"
        nome="<?=$p['nome']?>"
        diretorio="<?=$p['diretorio']?>"
        data="<?=$p['data']?>"
      >
        <div class="folder-icon">📁</div>
        <div class="folder-details">
          <div class="folder-name"><?=$p['nome']?></div>
          <div class="folder-path"><?=$p['diretorio']?></div>
        </div>
        <div class="folder-date"><?=dtReverte($p['data'])?></div>
      </div>
    <?php }  ?>


  </div>





  <div class="painel" style="display:none;">
    <div class="painel-header">
      <span class="pastaSel">📁</span> <span class="txtNomeItem"></span>
    </div>

    <ul class="painel-menu">
      <li class="op-visualizar">👁️ Visualizar em tempo real</li>
      <li class="op-html">📤 Exportar para HTML</li>
      <li class="op-excluir">🗑️ Excluir Projeto</li>
      <li class="op-editar">✏️ Editar Projeto</li>
    </ul>

    <div class="excluirConfirmar" style="display:none;">

      <p class="txtMsgExcluir">Deseja realmente excluir ?</p>
      <div class="actions">
        <button class="no bntMsgExcluir" type="button">Não</button>
        <button class="yes bntMsgExcluir" type="button">Sim</button>
      </div>

    </div>
  </div>


<script>
  //abre painel operações
  const painel = new ClassId('.painel,.painelTransparente');
  const mostraTxt = new ClassId('.txtNomeItem');
  var itemSel={};

  new ClassId('.folder-item', '.painelTransparente')
  .clickNavegador((e) => {
    painel.attr('style','display:block');
    var nome = e.attr('nome');
    itemSel = {
      'id': e.attr('codigo'),
      'nome':nome,
      'diretorio':e.attr('diretorio'),
      'data':e.attr('data')
    };
    console.log(itemSel);
    mostraTxt.html(nome);

  }, (e) => {
    painel.attr('style','display:none');
  });
  //-------------------------------------------------
  //editar .op-editar
  new ClassId('.op-editar').click(() => {
    //alert('editar:'+itemSel['id']+' '+itemSel['nome']+' '+itemSel['diretorio']+' '+itemSel['data']+' ');
    window.location.href='?pg=projeto-editar&id='+itemSel['id']+'&nome='+itemSel['nome']+'&dir='+itemSel['diretorio']+'&data='+itemSel['data'];
  });
  //------------------------------------------------
  //Excluir
  const painelMenu= new ClassId('.painel-menu');
  const excluirConfirmar= new ClassId('.excluirConfirmar');

  new ClassId('.op-excluir', '.no').clickNavegador((e) => {
    painelMenu.attr('style','display:none;');
    excluirConfirmar.attr('style','display:block;');
  }, (e) => {
    painelMenu.attr('style','display:block;');
    excluirConfirmar.attr('style','display:none;');
  });


  var FormEcluir= new Formulario(
    {
      url: '?pg=projeto-back-excluir',
      method: 'POST',
    },
    () => console.log("🔄 Enviando..."),
    (res) => {
      console.log(res);
      new ClassId('#itemSel-'+itemSel['id']).attr('style','display:none;');
      painel.attr('style','display:none;');
      painelMenu.attr('style','display:block;');
      excluirConfirmar.attr('style','display:none;');
      window.history.back();
      window.history.back();
    }
);

  new ClassId('.yes').click(()=>{
    FormEcluir.enviar('&id='+itemSel['id']);
  });
  //-----------------------------------------------------
  //exportar html
  new ClassId('.op-html').click(()=>{
      window.location.href='?pg=projeto-back-exportar&dir='+itemSel['diretorio'];
  });
  //-----------------------------------------------------
  //op-visualizar
  new ClassId('.op-visualizar').click(()=>{
      window.location.href='?pg=projeto-back-loop&pagina='+itemSel['diretorio'];
  });
  //---










</script>
