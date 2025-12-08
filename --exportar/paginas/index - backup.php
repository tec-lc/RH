<?php

class SiteExporter {
    private $nomePasta;
    private $origem;
    private $destino;

    public function __construct($nomePasta,$permitido=['css', 'js', 'img', 'fotos', 'video']) {
        $this->nomePasta = $nomePasta;
        //$this->origem = __DIR__ . "/$nomePasta";
        $this->origem = '../'. "/$nomePasta";
        $this->destino = __DIR__ . "/PROJETOS/$nomePasta";
        $this->permitido=$permitido;

    }

    public function exportar() {
        $this->apagarPasta();
        $this->criarDiretorios();
        $this->exportarPaginas();
        $this->copiarPastas($this->permitido);
    }

    private function criarDiretorios() {
        @mkdir($this->destino . '/paginas', 0777, true);
    }

    private function exportarPaginas() {
        $paginasDir = $this->origem . '/paginas';
        $arquivos = scandir($paginasDir);

        foreach ($arquivos as $arquivo) {
            if ($arquivo === '.' || $arquivo === '..') continue;
            $nome = pathinfo($arquivo, PATHINFO_FILENAME);

            $url = "http://localhost/{$this->nomePasta}/?pg=$nome";
            $conteudo = @file_get_contents($url);

            if ($conteudo === false) {
                echo "Falha ao ler: $url\n";
                continue;
            }

            file_put_contents("{$this->destino}/{$nome}.html", $conteudo);
            echo "Exportado: $nome.html\n";
        }
    }

    private function copiarPastas(array $pastas) {
        foreach ($pastas as $pasta) {
            $origemPasta = $this->origem . "/$pasta";
            $destinoPasta = $this->destino . "/$pasta";
            if (is_dir($origemPasta)) {
                $this->copiarRecursivo($origemPasta, $destinoPasta);
                echo "Copiada pasta: $pasta\n";
            }
        }
    }

    private function copiarRecursivo($origem, $destino) {
        @mkdir($destino, 0777, true);
        foreach (scandir($origem) as $item) {
            if ($item === '.' || $item === '..') continue;

            $origemItem = $origem . '/' . $item;
            $destinoItem = $destino . '/' . $item;

            if (is_dir($origemItem)) {
                $this->copiarRecursivo($origemItem, $destinoItem);
            } else {
                copy($origemItem, $destinoItem);
            }
        }
    }



    private function apagarPasta($pasta=false) {
        if($pasta==false){
            $pasta= $this->destino;
        }
        if (!is_dir($pasta)) return;

        $itens = scandir($pasta);
        foreach ($itens as $item) {
            if ($item === '.' || $item === '..') continue;

            $caminho = $pasta . DIRECTORY_SEPARATOR . $item;
            if (is_dir($caminho)) {
                $this->apagarPasta($caminho); // Recursão para subpastas
            } else {
                unlink($caminho); // Apaga arquivo
            }
        }
         @chmod($pasta, 0777); // garantir permissão
        if (!@rmdir($pasta)) {
            echo "Erro ao apagar pasta: $pasta<br>";
        }
    }

}




//require 'SiteExporter.php'; // ou cole o código diretamente aqui
if(@$_GET['dir']){
    if(@$_GET['per']!='') { $per=explode(',',$_GET['per']);
        $exportador = new SiteExporter($_GET['dir'],$per); // substitua por sua pasta real
    }else{
        $exportador = new SiteExporter($_GET['dir']); // substitua por sua pasta real
    }
    $exportador->exportar();
    header('location:PROJETOS/'.$_GET['dir']);
    exit;
}
//echo 'teste de erro de pagina';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Converter PHP para HTML</title>
  <style>
    a{
        text-decoration: none;
        color: #202124;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f8f9fa; color: #202124; }

    header {
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px;
      box-shadow: 0 1px 5px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 10;
    }

    header .left-menu {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    header h1 {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      font-size: 1.5em;
    }

    .menu-btn {
      background: none;
      border: none;
      font-size: 1em;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .panel {
      position: fixed;
      top: 60px;
      left: 20px;
      background: #fff;
      border: 1px solid #ddd;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 15px;
      display: none;
      flex-direction: column;
      gap: 10px;
      z-index: 100;
      max-width: 300px;
      width: calc(100% -20px);
    }

    .panel input[type="text"] {
      padding: 8px;
      width: 100%;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .panel button {
      padding: 10px;
      background: #1a73e8;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .project-list {
      padding: 20px;
    }

    .project-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px;
      background: #fff;
      margin-bottom: 10px;
      border-radius: 4px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      cursor: pointer;
    }
    .remover-btn {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 1.1em;
}

    @media (max-width: 600px) {
      header h1 { font-size: 1.2em; }
      .panel { right: 10px; left: 10px;  }
    }
  </style>
</head>
<body>
  <header>
    <div class="left-menu">
      <button class="menu-btn" onclick="abrirPainel()">📁 Nova exportação</button>
      <a class="menu-btn" href="imagens.html">🖼️ Testa imagem</a>
    </div>
    <h1>Converter PHP para HTML</h1>
  </header>

  <div class="panel" id="exportPanel">
    <label>Nome da pasta:</label>
    <input type="text" id="nome_pasta" />
    <label>Pastas permitidas:</label>
    <input type="text" id="pastas_permitidas" />
    <button onclick="salvarProjeto()">Salvar</button>
  </div>

  <div class="project-list" id="listaProjetos"></div>
<div id="loadingPanel" style="
  display: none;
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.7);
  z-index: 200;
  align-items: center;
  justify-content: center;
  padding: 20px;
  overflow: auto;
">
  <div id="loadingContent" style="
    background: #fff;
    color: #000;
    padding: 20px;
    max-width: 600px;
    width: 100%;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.3);
  ">
    Carregando projeto...
  </div>
</div>



  <script>
    function abrirPainel() {
      const panel = document.getElementById('exportPanel');
      panel.style.display = 'flex';
      history.pushState({ painelAberto: true }, '');
    }

    window.addEventListener('click', function (e) {
      const panel = document.getElementById('exportPanel');
      if (!panel.contains(e.target) && !e.target.classList.contains('menu-btn')) {
        fecharPainel();
      }
    });

    window.addEventListener('popstate', function (event) {
      if (event.state && event.state.painelAberto) {
        fecharPainel();
      }
    });

    function fecharPainel() {
      const panel = document.getElementById('exportPanel');
      panel.style.display = 'none';
    }

    function salvarProjeto() {
      const nome = document.getElementById('nome_pasta').value.trim();
      const per = document.getElementById('pastas_permitidas').value.trim();
      if (!nome) return alert('Informe o nome da pasta');

      const projetos = JSON.parse(localStorage.getItem('projetos') || '[]');
      projetos.push({ nome, per });
      localStorage.setItem('projetos', JSON.stringify(projetos));
      listarProjetos();
      fecharPainel();
    }

    function listarProjetos() {
  const lista = document.getElementById('listaProjetos');
  lista.innerHTML = '';
  const projetos = JSON.parse(localStorage.getItem('projetos') || '[]');
  
  projetos.forEach((proj, index) => {
    const div = document.createElement('div');
    div.className = 'project-item';
    
    div.innerHTML = `
      📁 <a href="#" data-nome="${proj.nome}" data-per="${proj.per}">${proj.nome}</a>
      <button class="remover-btn" style="margin-left:auto; background:none; border:none; cursor:pointer;">🗑️</button>
    `;
    
    // Evento para abrir o projeto
    div.querySelector('a').addEventListener('click', async function (e) {
      e.preventDefault();
      const nome = this.dataset.nome;
      const per = this.dataset.per;
      const url = `index.php?dir=${encodeURIComponent(nome)}&per=${encodeURIComponent(per)}`;

      const loadingPanel = document.getElementById('loadingPanel');
      loadingPanel.style.display = 'flex';

      try {
  const res = await fetch(url);
  const texto = await res.text();

  const loadingPanel = document.getElementById('loadingPanel');

  if (texto.toLowerCase().includes('erro')) {
    loadingPanel.innerHTML = `<div style="margin:auto; color:white; text-align:center;">
      <strong>Erro ao carregar o projeto!</strong><br><br>
      <pre style="max-height: 60vh; overflow:auto; background:#333; padding:10px; border-radius:6px;">${texto}</pre>
    </div>`;
  } else {
    window.location.href = url;
  }
} catch (err) {
  const loadingPanel = document.getElementById('loadingPanel');
  loadingPanel.innerHTML = `<div style="margin:auto; color:white; text-align:center;">
    <strong>Falha na conexão:</strong><br><br>${err.message}
  </div>`;
}
    });

    // Evento para remover projeto
    div.querySelector('.remover-btn').addEventListener('click', function () {
      if (confirm(`Deseja remover o projeto "${proj.nome}"?`)) {
        projetos.splice(index, 1);
        localStorage.setItem('projetos', JSON.stringify(projetos));
        listarProjetos();
      }
    });

    lista.appendChild(div);
  });
}



    window.onload = listarProjetos;
  </script>
</body>
</html>

