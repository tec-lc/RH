function doPost(e) {
  const sheet = SpreadsheetApp.openById("1L2mlYy50jtMRqsU7YoKKvYdxrlR2kGNdix-8t0sL07E");
  
  if(e.parameter.INSTALL && !sheet.getSheetByName("BANCO_DADOS")){
    //Cria planilha como se fosse banco de dados
    
  }
  
  

  const foto = e.parameter.foto;
  const nome = e.parameter.nome;
  const emailNovo = e.parameter.email;
  const confirmacao = e.parameter.confirmacao;

  const dados = sheet.getDataRange().getValues();
  let atualizado = false;

  for (let i = 0; i < dados.length; i++) {
    if (dados[i][3] === emailNovo) { // Coluna D (email)
      sheet.getRange(i + 1, 1, 1, 5).setValues([[new Date(), foto, nome, emailNovo, confirmacao]]);//5 colunas
      atualizado = true;
      break;
    }
  }

  if (!atualizado) {
    sheet.appendRow([new Date(), foto, nome, emailNovo, confirmacao]);
  }

  return ContentService
    .createTextOutput(atualizado ? "atualizado" : "cadastrado")
    .setMimeType(ContentService.MimeType.TEXT);
}
