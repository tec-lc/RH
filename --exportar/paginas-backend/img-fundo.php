<?php /*<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editor de Background Position</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    #preview {
      width: 40px;
      height: 40px;
      background-color: #ccc;
      background-size: auto 100%;
      background-repeat: no-repeat;
      margin-bottom: 10px;
      background-position: 0px center;
      background-image: url('img/icones.png');
    }
    .controls button, .controls input {
      margin: 5px;
      padding: 10px;
    }
    #code {
      margin-top: 10px;
      background: #f3f3f3;
      padding: 10px;
      border: 1px solid #ccc;
      font-family: monospace;
      white-space: pre-line;
    }
    .sliders {
      margin-top: 15px;
    }
    .sliders label {
      display: block;
      margin-top: 10px;
    }
  </style>
</head>
<body>

<h2>Editor de Background Position</h2>

<input type="file" id="fileInput" accept="image/*"><br><br>

<div id="preview"></div>

<div class="controls">
  <button onclick="move('up')">⬆️ Cima</button><br>
  <button onclick="move('left')">⬅️ Esquerda</button>
  <button onclick="move('right')">➡️ Direita</button><br>
  <button onclick="move('down')">⬇️ Baixo</button>
</div>

<div class="sliders">
  <label>
    Sensibilidade (pixels por clique):
    <input type="text" id="sensitivity"  max="100" value="0.5" oninput="updateSensitivity()">
    <span id="sensitivityValue">0.5</span>px
  </label>

  <label>
    Altura da imagem (background-size %):
    <input type="text" id="sizeSlider" min="10" max="300" value="100" oninput="updateSize()">
    <span id="sizeValue">100%</span>
  </label>

  <label>
    Largura da div:
    <input type="text" id="widthSlider" min="10" max="800" value="40" oninput="updateDivSize()">
    <span id="widthValue">40</span>px
  </label>

  <label>
    Altura da div:
    <input type="text" id="heightSlider" min="10" max="600" value="40" oninput="updateDivSize()">
    <span id="heightValue">40</span>px
  </label>
</div>

<div id="code"></div>

<script>
  const preview = document.getElementById('preview');
  const code = document.getElementById('code');
  let x = 0;
  let y = 0;
  let step = 0.5; // Sensibilidade padrão

  document.getElementById('fileInput').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (event) {
      preview.style.backgroundImage = `url('${event.target.result}')`;
      updateCode();
    };
    reader.readAsDataURL(file);
  });

  function move(direction) {
    if (direction === 'up') y -= step;
    if (direction === 'down') y += step;
    if (direction === 'left') x -= step;
    if (direction === 'right') x += step;

    preview.style.backgroundPosition = `${x}px ${y}px`;
    updateCode();
  }

  function updateSensitivity() {
    const sensitivityInput = document.getElementById('sensitivity');
    step = parseFloat(sensitivityInput.value);
    document.getElementById('sensitivityValue').textContent = step;
  }

  function updateSize() {
    const sizeInput = document.getElementById('sizeSlider');
    const sizeValue = sizeInput.value;
    preview.style.backgroundSize = `auto ${sizeValue}%`;
    document.getElementById('sizeValue').textContent = `${sizeValue}%`;
    updateCode();
  }

  function updateDivSize() {
    const width = document.getElementById('widthSlider').value;
    const height = document.getElementById('heightSlider').value;
    preview.style.width = `${width}px`;
    preview.style.height = `${height}px`;
    document.getElementById('widthValue').textContent = width;
    document.getElementById('heightValue').textContent = height;
    updateCode();
  }

  function updateCode() {
    const sizeInput = document.getElementById('sizeSlider');
    const width = document.getElementById('widthSlider').value;
    const height = document.getElementById('heightSlider').value;
    code.textContent = `
background-position: ${x}px ${y}px;
background-size: auto ${sizeInput.value}%;
width: ${width}px;
height: ${height}px;
`.trim();
  }
</script>

</body>
</html>

*/?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editor de CSS Mask Sprite</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
      background-color: #f4f4f9;
      color: #333;
    }

    h2 { margin-top: 0; }

    /* Container para visualizar a transparência */
    .preview-container {
      display: inline-block;
      background-image: linear-gradient(45deg, #ccc 25%, transparent 25%),
                        linear-gradient(-45deg, #ccc 25%, transparent 25%),
                        linear-gradient(45deg, transparent 75%, #ccc 75%),
                        linear-gradient(-45deg, transparent 75%, #ccc 75%);
      background-size: 20px 20px;
      background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
      border: 2px solid #888;
      margin-bottom: 10px;
    }

    #preview {
      width: 40px;
      height: 40px;
      background-color: #000000; /* Cor do ícone */

      /* Propriedades Padrão da Máscara */
      -webkit-mask-repeat: no-repeat;
      mask-repeat: no-repeat;
      -webkit-mask-size: auto 100%;
      mask-size: auto 100%;
      -webkit-mask-position: 0 0;
      mask-position: 0 0;
    }

    .controls-wrapper {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    .control-group {
      background: white;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    button {
      cursor: pointer;
      padding: 8px 12px;
      background: #007BFF;
      color: white;
      border: none;
      border-radius: 4px;
      font-size: 14px;
    }
    button:hover { background: #0056b3; }

    input[type="number"], input[type="text"] {
      width: 60px;
      padding: 5px;
    }

    #code {
      margin-top: 20px;
      background: #2d2d2d;
      color: #50fa7b;
      padding: 15px;
      border-radius: 5px;
      font-family: 'Courier New', monospace;
      white-space: pre;
      overflow-x: auto;
      border: 1px solid #444;
    }

    label {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 8px;
      font-size: 14px;
    }
  </style>
</head>
<body>

<h2>Editor de CSS Mask e Sprites</h2>

<div class="controls-wrapper">
  <div class="control-group">
    <label>
      1. Carregue o Sprite (PNG Transparente):<br>
      <input type="file" id="fileInput" accept="image/*">
    </label>
    <br>
    <div class="preview-container">
      <div id="preview"></div>
    </div>
    <br>
    <label>
      Cor do ícone (background-color):
      <input type="color" id="colorPicker" value="#000000" oninput="updateColor()">
    </label>
  </div>

  <div class="control-group">
    <strong>2. Posição (Mask Position)</strong><br><br>
    <div style="text-align: center;">
      <button onclick="move('up')">⬆️</button><br>
      <button onclick="move('left')">⬅️</button>
      <button onclick="move('right')">➡️</button><br>
      <button onclick="move('down')">⬇️</button>
    </div>
    <br>
    <label>
      Passo (px):
      <input type="number" id="sensitivity" value="1" min="0.1" step="0.1" onchange="updateSensitivity()">
    </label>
  </div>

  <div class="control-group">
    <strong>3. Dimensões</strong>
    <label>
      Tamanho do Sprite (%):
      <input type="number" id="sizeSlider" value="100" oninput="updateSize()">
    </label>

    <label>
      Largura da Div (px):
      <input type="number" id="widthSlider" value="40" oninput="updateDivSize()">
    </label>

    <label>
      Altura da Div (px):
      <input type="number" id="heightSlider" value="40" oninput="updateDivSize()">
    </label>
  </div>
</div>

<h3>Código CSS Gerado:</h3>
<div id="code"></div>

<script>
  const preview = document.getElementById('preview');
  const code = document.getElementById('code');

  let x = 0;
  let y = 0;
  let step = 1;
  let maskUrl = '';

  // Carregar Imagem
  document.getElementById('fileInput').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (event) {
      maskUrl = event.target.result;
      preview.style.webkitMaskImage = `url('${maskUrl}')`;
      preview.style.maskImage = `url('${maskUrl}')`;
      updateCode();
    };
    reader.readAsDataURL(file);
  });

  // Mover a máscara
  function move(direction) {
    if (direction === 'up') y -= step;
    if (direction === 'down') y += step;
    if (direction === 'left') x -= step;
    if (direction === 'right') x += step;

    updatePreview();
  }

  function updatePreview() {
    const posX = `${x}px`;
    const posY = `${y}px`;

    // Aplica para Webkit (Chrome, Safari) e Standard
    preview.style.webkitMaskPosition = `${posX} ${posY}`;
    preview.style.maskPosition = `${posX} ${posY}`;

    updateCode();
  }

  function updateSensitivity() {
    step = parseFloat(document.getElementById('sensitivity').value) || 1;
  }

  function updateColor() {
    const color = document.getElementById('colorPicker').value;
    preview.style.backgroundColor = color;
    updateCode();
  }

  function updateSize() {
    const sizeVal = document.getElementById('sizeSlider').value;
    const sizeStr = `auto ${sizeVal}%`; // Mantendo proporção auto na largura

    preview.style.webkitMaskSize = sizeStr;
    preview.style.maskSize = sizeStr;

    updateCode();
  }

  function updateDivSize() {
    const width = document.getElementById('widthSlider').value;
    const height = document.getElementById('heightSlider').value;

    preview.style.width = `${width}px`;
    preview.style.height = `${height}px`;

    updateCode();
  }

  function updateCode() {
    const sizeVal = document.getElementById('sizeSlider').value;
    const width = document.getElementById('widthSlider').value;
    const height = document.getElementById('heightSlider').value;
    const color = document.getElementById('colorPicker').value;

    // Formatação do código para copiar
    code.textContent = `
.icon-masked {
  width: ${width}px;
  height: ${height}px;
  background-color: ${color};

  /* Mask Properties */
  -webkit-mask-image: url('SEU_SPRITE.png');
  mask-image: url('SEU_SPRITE.png');

  -webkit-mask-position: ${x}px ${y}px;
  mask-position: ${x}px ${y}px;

  -webkit-mask-size: auto ${sizeVal}%;
  mask-size: auto ${sizeVal}%;

  -webkit-mask-repeat: no-repeat;
  mask-repeat: no-repeat;
}`.trim();
  }

  // Inicializa o código na tela
  updateCode();
</script>

</body>
</html>
