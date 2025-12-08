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





   
  // auto preencher mês e ano
  const now = new Date();
  $('#mes').val(String(now.getMonth() + 1).padStart(2,'0')); // 01..12
  $('#ano').val(now.getFullYear());

  // mostrar nome do arquivo ao escolher
  $('#fileInput').on('change', function(){
    const f = this.files && this.files[0];
    if(f) $('#fileName').text(f.name + ' (' + Math.round(f.size/1024) + ' KB)');
    else $('#fileName').text('Nenhum arquivo selecionado');
  });

  // envio com progresso
  $('#uploadForm').on('submit', function(e){
    e.preventDefault();

    const input = $('#fileInput')[0];
    const f = input && input.files && input.files[0];
    if(!f){
      $('#status').text('Selecione um arquivo .xlsm antes.');
      return;
    }
    if(f.size > 10 * 1024 * 1024){
      $('#status').text('Arquivo muito grande. Máx 10MB.');
      return;
    }

    const fd = new FormData();
    fd.append('mes', $('#mes').val());
    fd.append('ano', $('#ano').val());
    fd.append('file', f);

    $('#sendBtn').prop('disabled', true).text('Enviando...');
    $('#status').text('');
    $('.progress').show();

    $.ajax({
      url: 'upload.php',
      method: 'POST',
      data: fd,
      processData: false,
      contentType: false,
      dataType: 'json',
      xhr: function(){
        const xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener('progress', function(e){
          if(e.lengthComputable){
            const pct = Math.round((e.loaded / e.total) * 100);
            $('#bar').css('width', pct + '%').attr('aria-valuenow', pct);
            $('#bar').text(pct + '%'); // opcional: mostra texto
          }
        });
        return xhr;
      },
      success: function(resp){
        if(resp && resp.success){
          $('#status').html('<span style="color: green">Enviado com sucesso.</span>');
          $('#bar').css('width','100%').attr('aria-valuenow', 100).text('100%');
        } else {
          const err = resp && resp.error ? resp.error : 'Resposta inesperada';
          $('#status').html('<span style="color: red">Erro: ' + err + '</span>');
        }
      },
      error: function(xhr){
        let msg = 'Erro no envio';
        try{
          const j = xhr && xhr.responseJSON;
          if(j && j.error) msg = j.error;
        }catch(e){}
        $('#status').text(msg);
      },
      complete: function(){
        $('#sendBtn').prop('disabled', false).text('Enviar');
        setTimeout(function(){
          $('.progress').hide();
          $('#bar').css('width','0%').attr('aria-valuenow',0).text('');
        }, 1500);
      }
    });

  });

});

