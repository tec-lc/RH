//////////////////////tambem envia url pro google planilhas//////////////////
class Formulario {
  constructor(configOrFormSelector, onStart, onFinish) {
    this.onStart = onStart;
    this.onFinish = onFinish;

    if (typeof configOrFormSelector === 'string') {
      // Forma 2: usando seletor de formulário
      this.form = document.querySelector(configOrFormSelector);
      if (!this.form) throw new Error("Formulário não encontrado");
      this.url = this.form.action;
      this.method = this.form.method || 'POST';
      this.initFormSubmit();
    } else {
      // Forma 1: usando config manual
      const { bnt_click, url, method, data } = configOrFormSelector;
      this.url = url;
      this.method = method || 'POST';
      this.data = data;

      
      if (!bnt_click || bnt_click === false) {
        // Disparo direto
        if(data && data!=false){//somente se existir dados
          this.sendData(this.data);
        }
        //this.sendData(this.data);
      } else {
        const btn = document.querySelector(bnt_click);
        if (!btn) throw new Error("Botão não encontrado");
        btn.addEventListener('click', () => this.sendData(this.data));
      }



    }
  }

  enviar(dt){
    this.data=dt;
    this.sendData(this.data);


  }


  initFormSubmit() {
    this.form.addEventListener('submit', (e) => {
      e.preventDefault();
      const formData = new FormData(this.form);
      const isGoogleScript = this.url.startsWith("https://script.google.com");
      let body = isGoogleScript ? new URLSearchParams(formData).toString() : formData;
      this.sendData(body, isGoogleScript);
    });
  }

  async sendData(body, isGoogle = false) {
    try {
      this.onStart && this.onStart();

      const isString = typeof body === 'string';

      const res = await fetch(this.url, {
        method: this.method,
        headers: isString
          ? { "Content-Type": "application/x-www-form-urlencoded" }
          : undefined,
        body: body
      });

      const isJson = res.headers.get("content-type")?.includes("application/json");
      const result = isJson ? await res.json() : { ok: res.ok, msg: await res.text() };
      this.onFinish && this.onFinish(result);
    } catch (e) {
      this.onFinish && this.onFinish({ ok: false, msg: e.message });
    }
  }
}

/* exemplo:
//----------------------disparto direto---------------------------------
new Formulario(
  {
    //bnt_click: '#bnt_enviar',//pode colocar por click mas não recebe parametros do elemento clicado
    url: 'servidor/teste.php',
    method: 'POST',
    data: '&nome=Adailton&email=sdfsadf@teste.com&confirmacao=SIM&foto=testefdfff'
  },
  () => console.log("🔄 Enviando..."),
  (res) => { 
    if (res.ok) {
      console.log("✅ Sucesso:", res);
    } else {
      console.error("❌ Erro:", res);
  }
});
//----------------------disparto Armazenado---------------------------------
var Form= new Formulario(
  {
    url: 'servidor/teste.php',
    method: 'POST',
  },
  () => console.log("🔄 Enviando..."),
  (res) => { 
    if (res.ok) {
      console.log("✅ Sucesso:", res);
    } else {
      console.error("❌ Erro:", res);
  }
});
//envia depois por outra função com dados especificos
Form.enviar('&nome=Adailton&email=sdfsadf@teste.com&confirmacao=SIM&foto=testefdfff');


//----------------------disparto formulario submit---------------------------------
new Formulario('.class_formulario',
  () => console.log("🔄 Enviando..."),
  (res) => { 
    if (res.ok) {
      console.log("✅ Sucesso:", res);
    } else {
      console.error("❌ Erro:", res);
  }
});


*/


/* exemplo de como chamar ele pode enviar no link do google tambem


     new Formulario(
      "#form-teste",

      () => console.log("🔄 Enviando..."),
      (res) => {
        if (res.ok) {
          console.log("✅ Sucesso:", res);
        } else {
          console.error("❌ Erro:", res);
        }
      }
    );

    new Formulario(
    {
      bnt_click: '#bnt_enviar',
      url: 'servidor/teste.php',
      method: 'POST',
      data: '&nome=Luis&estado=sp&texto=gosto de abelhas'
    },
    () => console.log("🔄 Enviando..."),
    (res) => {
      if (res.ok) {
        console.log("✅ Sucesso:", res);
      } else {
        console.error("❌ Erro:", res);
      }
    });

exemplo de saida do servidor:

<?php
header('Content-Type: application/json');

if (!empty($_POST['nome'])) {
    echo json_encode(['ok'=>true,'msg' => 'Dados recebidos com sucesso!']);
} else {
    echo json_encode(['erro'=>'input_01','msg' => 'Campo nome é obrigatório.']);
}

?>


//////////////////////força maiscula no input///////////////////////
*/
class Maiuscula {
  constructor(selector) {
    this.campos = document.querySelectorAll(selector);
   
    this.inicializar();
  }

  inicializar() {
    this.campos.forEach(campo => {
      campo.addEventListener('input', () => {
        campo.value = campo.value.toUpperCase();
      });
    });
  }
}
/*

new Maiuscula('.txt_maisculo');


*/


