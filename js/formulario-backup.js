// garante DOM pronto

/*$(function() {
    alert('funciona');
});*/


$(function(){


    //paginação via js
    var categoria=$('.valor-categoria').val();
    var pagina = $('.valor-pagina').val();
    $('.categoria-'+categoria).attr('id','corBacBranco');
    $('.subCat-'+pagina).attr('id','corBacAzul');





   /*
  // auto preencher mês e ano
  const now = new Date();
  $('#mes').val(String(now.getMonth() + 1).padStart(2,'0')); // 01..12
  $('#ano').val(now.getFullYear());
*/

  



});

function monta_html(nome){
    return 
    '<div class="itenMenu subCat-importar">'+
        '<div class="iconFloat"></div>'+
        '<div class="fontMenu">'+nome+'</div>'+
        '<div class="clear"></div>'+
    '</div>'+
    '';
}


function mapeia_planilhas(plan){
    plan =plan.split('<->');
    for (let i = 0; i < plan.length; i++) {
        //const char = plan[i];
        //console.log(i, char);
         var html=$('.caixaCategoria-planilha').html();
         $('.caixaCategoria-planilha').html(html+monta_html(plan[i]));
         
    }
    alert('importado');
}


function abre_planilha() {
    $.ajax({
        url: '?pgw=abreplanilha',
        method: 'GET',
        success: function (data) {
        // data.status, data.mensagem...
        $('#status').text(data);
            console.log(data);
            mapeia_planilhas(data);

        }
    });
}



  async function enviarArquivo() { //alert('teste');
      const input = document.getElementById('arquivo');
      const status = document.getElementById('status');

      // Verifica se algum arquivo foi selecionado
      if (!input.files || input.files.length === 0) {
          status.textContent = 'Selecione um arquivo primeiro.';
          return;
      }

      const arquivo = input.files[0];

      // Monta o FormData para enviar via POST
      const formData = new FormData();
      formData.append('arquivo', arquivo); // "arquivo" será o nome do campo no PHP

      try {
          status.textContent = 'Enviando...';

          const resposta = await fetch('?pgw=importar/backend', {
              method: 'POST',
              body: formData
          });



          const texto = await resposta.text();
          status.textContent = 'Aguarde, abrindo planilha...';
          abre_planilha();
          console.log(texto);




      } catch (erro) {
          console.error(erro);
          status.textContent = 'Erro ao enviar arquivo.';
      }
  }

