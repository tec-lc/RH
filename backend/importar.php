<?php
  // upload.php
  header('Content-Type: application/json; charset=utf-8');

  // Diretório e nome final conforme solicitado
  $diretorio_salvar = __DIR__ . DIRECTORY_SEPARATOR . 'arquivo' . DIRECTORY_SEPARATOR . 'planilha.xlsm';

  // Cria a pasta 'arquivo' se não existir
  $pasta = dirname($diretorio_salvar);
  if(!is_dir($pasta)){
      if(!mkdir($pasta, 0755, true)){
          echo json_encode(['success' => false, 'error' => 'Falha ao criar diretório de destino.']);
          exit;
      }
  }

  // Verifica envio
  if(empty($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK){
      echo json_encode(['success' => false, 'error' => 'Nenhum arquivo enviado ou erro no upload.']);
      exit;
  }

  // Você pode adicionar validações extras (tipo MIME, tamanho, extensão)
  $tmpName = $_FILES['file']['tmp_name'];

  // Força salvar com o nome solicitado (planilha.xlsm)
  if(move_uploaded_file($tmpName, $diretorio_salvar)){
      // Opcional: salvar informações recebidas (mês/ano)
      $mes = isset($_POST['mes']) ? $_POST['mes'] : null;
      $ano = isset($_POST['ano']) ? $_POST['ano'] : null;
      // Aqui você pode gravar em um log ou banco de dados se quiser

      echo json_encode(['success' => true]);
      exit;
  } else {
      echo json_encode(['success' => false, 'error' => 'Falha ao mover arquivo para destino.']);
      exit;
  }
  ?>