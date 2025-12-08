 
     
 
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

    var form=new Formulario(
    {
      //bnt_click: '#bnt_enviar',
      url: 'servidor/teste.php',
      method: 'POST',
      data: '&nome=coco&email=sdfsadf@teste.com&confirmacao=SIM&foto=testefdfff'
    },
    () => console.log("🔄 Enviando..."),
    (res) => { 
      if (res.ok) {
        console.log("✅ Sucesso:", res);
      } else {
        console.error("❌ Erro:", res);
      }
    });

const titulos = new ClassId('.titulo, #subTitulo');
titulos.click((e) => {
  form.enviar('&nome=coco&email=sdfsadf@teste.com&confirmacao=SIM&foto=testefdfff');
  alert('funciona click: ' + e.html());
  e.attr('style', 'color:#F00;');
  e.html('foi clicado');
  alert('Novo style: ' + e.attr('style'));
});

const txt= new ClassId('.titulo');
txt.attr('style','color:#000;');
alert(txt.html());