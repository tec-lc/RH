<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <title>Teste Borda</title>
  <style>
    .borda {
      border: solid 1px; /* estilo e largura */
    }
    .bordaCor {
      border-color: #C00; /* cor */
    }

    /* Regra alternativa — garante que funcione mesmo se houver sobrescrita */
    /*.borda.bordaCor {
      border: 1px solid #C00;
    }*/

    /* só para ver o tamanho quando vazio */
    .box {
      width: 200px;
      height: 80px;
      padding: 8px;
    }
  </style>
</head>
<body>
  <div class="bordaCor borda box">
    Conteúdo de teste
  </div>
</body>
</html>
