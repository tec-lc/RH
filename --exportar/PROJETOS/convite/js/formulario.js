class ForcarMaiuscula {
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



class CadastroGoogleForm {
  constructor({ formSelector, emailInputId, respostaId, endpoint }) {
    this.cookie = new Cookie();
    this.form = document.querySelector(formSelector);
    this.emailInput = document.getElementById(emailInputId);
    this.resposta = document.getElementById(respostaId);
    this.endpoint = endpoint;

    this.apaga_google();

    if (!this.form || !this.emailInput || !this.resposta) {
      console.error("Elementos obrigatórios não encontrados.");
      return;
    }

    this.msg = {
      email: {
        msg: "Atenção!<br>Você precisa logar com sua conta do Google para autenticar seu email!",
        cor: "#F00",
        ok: false
      },
      atualizado: {
        msg: "Você atualizou seu status de presença! Fique à vontade para navegar no site!",
        cor: "#294e10",
        ok: true
      },
      cadastrado: {
        msg: "Sua presença foi confirmada com sucesso! Fique à vontade para navegar no site!",
        cor: "#535e43",
        ok: true
      },
      erro: {
        msg: "Erro de envio! Tente novamente.",
        cor: "#F00",
        ok: false
      },
      Sucesso: {
        msg: "Muito Obrigado pelo carinho e atenção! Uma mensagem foi enviada aos noivos!<br>Veja mais informações pelo nosso site!",
        cor: "#535e43",
        ok: true
      }
    };

    this.form.addEventListener("submit", (e) => this.handleSubmit(e));
  }

  apaga_google(){
    var email=this.cookie.get('email');
    var foto=this.cookie.get('foto');
    //alert(email);
    if(email!=null){
      $('.fecha_login_google').attr('style','display:none;');
      this.emailInput.value = email;
      document.getElementById("txt_bnt_google").innerHTML = "Email autenticado!";
      document.getElementById("email_logado").innerHTML = email;
      document.getElementById("painel_email_logado").style.display = "block";
      this.cookie.set('email',email,30);

    }

    if(foto!=null){
      const fotoInput = document.getElementById("foto");
      const imgUsuario = document.getElementById("foto_usuario");
      fotoInput.value = foto;
      imgUsuario.src = foto;
      this.cookie.set('foto',foto,30);
      imgUsuario.style.display = "inline";

    }
  }

  preencherEmailComGoogle(response) {
    const data = jwt_decode(response.credential);

    this.emailInput.value = data.email;
    document.getElementById("txt_bnt_google").innerHTML = "Email autenticado!";
    document.getElementById("email_logado").innerHTML = data.email;
    document.getElementById("painel_email_logado").style.display = "block";
    this.cookie.set('email',data.email,30);

    // FOTO DO USUÁRIO
    const fotoInput = document.getElementById("foto");
    const imgUsuario = document.getElementById("foto_usuario");

    if (fotoInput && imgUsuario && data.picture) {
      fotoInput.value = data.picture;
      imgUsuario.src = data.picture;
      this.cookie.set('foto',data.picture,30);
      imgUsuario.style.display = "inline";
    }

    document.getElementById("bnt_google").style.display = "none";

    this.form.style.display = "block";
  }

  async handleSubmit(e) {
    e.preventDefault();
    const dados = new FormData(this.form);

    if (this.email_autenticado()) {
      try {
        this.inicia_loading();
        const response = await fetch(this.endpoint, {
          method: "POST",
          body: dados
        });
        const texto = await response.text();
        this.res_msg(texto);
      } catch (erro) {
        console.error("Erro:", erro);
        this.res_msg("erro");
      }
    }
  }

  email_autenticado() {
    const email = $("#email").val();
    if (email === '') {
      this.res_msg("email");
      return false;
    }
    return true;
  }

  inicia_loading() {
    $(".bntenviar, .campo_msg").hide();
    $(".campo_loading").show();
  }

  res_msg(cod) {
    const m = this.msg[cod] || this.msg.erro;
    if (m.ok) {
      //$(".formtxt, .descritxt, .txtbuton, .select").hide();
      //armazena mensagem 
      //this.cookie.set('nome_login',$('#nome_login').val(),30);
      //this.cookie.set('mensagen_noivos',$('.mensagen_noivos').val(),30);
      var msg=$('.mensagen_noivos').val();
      if(msg!=''){
        var re= new lista_msg();
        re.set({
          'data':'agora',
          'nome':$('#nome_login').val(),
          'mensagens':msg,
          'foto':$('#foto_usuario').attr('src')
        });
      }
      

      $(".bntok").show();
    } else {
      $(".bntenviar").show();
    }
    $(".campo_loading").hide();
    $(".campo_msg").html(m.msg).css("color", m.cor).show();
  }
}



/*--------------------------------------------------------- */
class CorEscuraAleatoria {
  constructor(texto) {
    this.textoOriginal = texto || '';
    this.letra = this.extrairLetra(texto);
    this.cor = this.letra ? this.gerarCorHexCurto() : '#000'; // fallback seguro
  }

  extrairLetra(texto) {
    const match = texto.toUpperCase().match(/[A-Z]/);
    return match ? match[0] : null;
  }

  gerarCorHexCurto() {
    const base = this.letra.charCodeAt(0) - 65;
    const r = this.quantizarCor((base * 67) % 256);
    const g = this.quantizarCor((base * 137 + 50) % 256);
    const b = this.quantizarCor((base * 191 + 100) % 256);
    return `#${r}${g}${b}`;
  }

  quantizarCor(valor) {
    const steps = [0x00, 0x11, 0x22, 0x33, 0x44, 0x55, 0x66, 0x77,
                   0x88, 0x99, 0xAA, 0xBB, 0xCC, 0xDD, 0xEE, 0xFF];
    const nearest = steps.reduce((prev, curr) =>
      Math.abs(curr - valor) < Math.abs(prev - valor) ? curr : prev
    );
    return (nearest >> 4).toString(16); // retorna só 1 dígito para hex curto
  }

  getLetra() {
    return this.letra;
  }

  getCor() {
    return this.cor;
  }
}

/*const cor = new CorEscuraAleatoria("Lucas");
console.log("Letra:", cor.getLetra()); // "L"
console.log("Cor:", cor.getCor());     // Ex: "#436" */


class lista_msg{
  constructor(){
    this.plan=false;
    this.link="https://script.google.com/macros/s/AKfycbwj6X8N800pgbNrGp_CPd0r8TyScwMdxlc2TzCMx80mEUQRSeucoCSTN03TaZJXBZ_I/exec";
  }



  set(v){
    //$('.html_mensagens').prepend(html);
    if(v['foto']==''){
        const cor = new CorEscuraAleatoria(v['nome']);
        v['foto']='<div class="sem_foto" style="background-color:'+cor.getCor()+';"><div class="txt_sem_foto">'+cor.getLetra()+'</div></div>';
    }else{
      v['foto']='<img class="foto_mensagem" src="'+v['foto']+'" alt="Foto do usuário" style="">';
    }
    var html= ''
    +'<div class="painel_mensagem">'
            +v['foto']
            +'<div class="caixa_comen">'
                +'<div class="ponta_msg"></div>'
                +'<div class="email_mensagem">'+v['nome']+'</div>'
                +'<div class="comentario_mensagem">'+v['mensagens']+'</div>'
                +'<div class="data">'+this.tempoPostagem(v['data'])+'</div>'
            +'</div>'
            +'<div class="rodape"></div>'
        +'</div>';
    $('.html_mensagens').prepend(html);

  }

  inicia(){
    if(this.plan==false){
      this.plan= new plangoogle();
      this.plan.link_lista=this.link;
    }
    this.plan.exe_busca((data)=>{
      console.log(data);
      var linhas=data.length;
      if(linhas>0){
        for(let i=0; i<linhas;i++){
          if(data[i]['mensagens'] != '' && data[i]['publicado']==''){
            this.set(data[i]);
          }     
        }
        $('.html_mensagens,.titulo_msg_html').attr('style','display:block;');
      }
      $('.msg_loading').attr('style','display:none;');
    });
  }


  tempoPostagem(dataISO) {
    // Tenta converter para data
    const data = new Date(dataISO);

    // Verifica se é uma data inválida
    if (isNaN(data.getTime())) {
      return dataISO; // É um texto comum → retorna como está
    }

    const agora = new Date();
    const diffMs = agora - data;

    const minutos = Math.floor(diffMs / 60000);
    const horas = Math.floor(diffMs / 3600000);
    const dias = Math.floor(diffMs / 86400000);
    const meses = Math.floor(dias / 30);
    const anos = Math.floor(dias / 365);

    if (minutos < 1) return 'agora';
    if (minutos < 60) return `há ${minutos}min`;
    if (horas < 24) return `há ${horas}h`;
    if (dias < 30) return `há ${dias}dias`;
    if (dias < 365) return `há ${meses}meses`;
    return `há ${anos}ano${anos > 1 ? 's' : ''}`;
  }
}