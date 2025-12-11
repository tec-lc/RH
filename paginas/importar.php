<!--<input class="input" type="file" id="arquivo" />
<input class="input" type="text" >
<button class="bnt_enviar" onclick="enviarArquivo()">Enviar arquivo</button>

<div id="status"></div>-->
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: "Roboto", Arial, sans-serif;
    }

    /*body {
      background-color: #ffffff;
      color: #202124;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }*/

    .wrapper {
      text-align: center;
      width: 100%;
      max-width: 480px;
      padding: 24px;
    }

    .logo {
      font-size: 48px;
      font-weight: 500;
      letter-spacing: -1px;
      margin-bottom: 32px;
    }

    /* Cores tipo Google */
    .logo span:nth-child(1) { color: #4285f4; }
    .logo span:nth-child(2) { color: #ea4335; }
    .logo span:nth-child(3) { color: #fbbc05; }
    .logo span:nth-child(4) { color: #4285f4; }
    .logo span:nth-child(5) { color: #34a853; }
    .logo span:nth-child(6) { color: #ea4335; }

    .card {
      /*border-radius: 24px;
      box-shadow: 0 1px 6px rgba(32,33,36,.28);*/
      padding: 24px 24px 28px;
      text-align: left;
    }

    .card-title {
      font-size: 18px;
      margin-bottom: 16px;
      font-weight: 500;
    }

    .form-group {
      margin-bottom: 16px;
    }

    label {
      display: block;
      font-size: 13px;
      color: #5f6368;
      margin-bottom: 4px;
    }

    .input-field {
      width: 100%;
      padding: 10px 14px;
      border-radius: 24px;
      border: 1px solid #dadce0;
      font-size: 14px;
      outline: none;
      background: #fff;
      transition: box-shadow 0.15s ease, border-color 0.15s ease;
      -webkit-appearance: none;
         -moz-appearance: none;
              appearance: none;
    }

    .input-field:focus {
      border-color: #4285f4;
      box-shadow: 0 1px 6px rgba(66,133,244,.4);
    }

    select.input-field {
      padding-right: 32px;
      background-image:
        linear-gradient(45deg, transparent 50%, #5f6368 50%),
        linear-gradient(135deg, #5f6368 50%, transparent 50%);
      background-position:
        calc(100% - 18px) calc(50% - 3px),
        calc(100% - 12px) calc(50% - 3px);
      background-size: 6px 6px, 6px 6px;
      background-repeat: no-repeat;
    }

    .actions {
      margin-top: 20px;
      display: flex;
      gap: 10px;
      justify-content: flex-end;
    }

    .btn {
      border-radius: 4px;
      border: 1px solid #dadce0;
      padding: 8px 16px;
      font-size: 14px;
      background-color: #f8f9fa;
      color: #3c4043;
      cursor: pointer;
      transition: background-color 0.15s ease, box-shadow 0.15s ease;
    }

    .btn-primary {
      background-color: #1a73e8;
      border-color: #1a73e8;
      color: #fff;
    }

    .btn:hover {
      box-shadow: 0 1px 3px rgba(60,64,67,.3);
      background-color: #f1f3f4;
    }

    .btn-primary:hover {
      background-color: #1765cc;
    }

    @media (max-width: 480px) {
      .card {
        padding: 18px 16px 22px;
      }

      .logo {
        font-size: 40px;
        margin-bottom: 24px;
      }
    }
  </style>

  <div class="wrapper">
    <!-- "Logo" estilo Google, só pra compor o layout -->
    

    <div class="card">
      <div class="card-title">Enviar arquivo</div>


        <div class="form-group">
          <label for="ano">Selecione sua planilha </label>
          <input
            type="file" 
            id="arquivo" 
            name="arquivo[]" 
            multiple
            class="input-field input"
         />
        </div>
    
        
        <!-- Campo de ano (select) -->
        <div class="form-group">
          <label for="ano">Tipo de Documento</label>
          <select id="tipo" name="tipo" class="input-field" required>
            <option value="" disabled selected>VR/VA</option>
            <!-- Você pode ajustar a faixa de anos aqui -->
            <option>VR</option>
            <option>VA</option>

          </select>
        </div>

        <div class="actions">
            <button type="reset" class="btn">Limpar</button>
            <button  onclick="enviarArquivo()" class="btn btn-primary">Enviar</button>
        </div>

        <div id="status"></div>
     
    </div>
  </div>

