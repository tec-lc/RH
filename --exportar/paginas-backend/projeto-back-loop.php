<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Recarregando iframe</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body, iframe {
      width: 100%;
      height: 100%;
    }

    iframe {
      border: none;
      display: block;
    }
  </style>
</head>
<body>

  <?php
    $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '';
    $src = "http://192.168.15.11/$pagina?t=timestamp";
  ?>

  <iframe id="tela" src="<?=$src?>"></iframe>

  <script>
    window.addEventListener("load", () => {
      const iframe = document.getElementById("tela");

      function recarregar() {
        // Força nova URL com timestamp para evitar cache
        const urlSemCache = iframe.src.split('?')[0] + '?t=' + new Date().getTime();
        iframe.src = urlSemCache;
      }

      setInterval(recarregar, 3000); // a cada 3 segundos
    });
  </script>
  pagina loop
</body>
</html>
