
//----------------------------------------------------------

class ContagemRegressiva {
    constructor(dataAlvo, elementos) {
      this.dataAlvo = new Date(dataAlvo).getTime();
      this.elementos = elementos;
      this.intervalo = null;
    }
  
    iniciar() {
      this.atualizarContagem(); 
      this.intervalo = setInterval(() => this.atualizarContagem(), 1000);
    }
  
    atualizarContagem() {  
      const agora = new Date().getTime();
      const diferenca = this.dataAlvo - agora;
  
      if (diferenca <= 0) { 
        document.getElementById("contador").innerHTML = "Tempo esgotado!";
        clearInterval(this.intervalo);
        return;
      }
  
      const segundosTotal = Math.floor(diferenca / 1000);
      const dias = Math.floor(segundosTotal / (60 * 60 * 24));
      const horas = Math.floor((segundosTotal % (60 * 60 * 24)) / (60 * 60));
      const minutos = Math.floor((segundosTotal % (60 * 60)) / 60);
      const segundos = segundosTotal % 60;
      
      $('#'+this.elementos.dias).html(dias);
      $('#'+this.elementos.horas).html(horas);
      $('#'+this.elementos.minutos).html(minutos);
      $('#'+this.elementos.segundos).html(segundos);
     
  
    

      
    }
  }
  //------------------------------------------------------
  class copiar {
    constructor(divId, text) {
      this.divId = divId;
      this.text = text;
      this.init();
    }
  
    init() {
      const div = document.getElementById(this.divId);
      if (!div) {
        console.error(`Elemento com ID "${this.divId}" não encontrado.`);
        return;
      }
  
      div.style.cursor = 'pointer';
      div.addEventListener('click', () => this.copyText());
    }
  
    async copyText() {
      try {
        await navigator.clipboard.writeText(this.text);
        console.log('Texto copiado com sucesso!');
      } catch (err) {
        console.error('Erro ao copiar texto:', err);
      }
    }
  }
  
  // Exemplo de uso:
  // new CopyToClipboard('bnt_endereco', 'Texto que será copiado');
  
//--------------------------------------------------------------------


class Evento {
  constructor(e) {
    this.e = e;
    this.v = e;
    this.aberto = false;

   /* if(e['exe']){
      this.exe= e['exe'];
    }else{
      this.exe= {
        abre:false,
        fecha:false
      }
    }*/
    

    // Liga evento de clique
    $(this.e['click']).click((event) => {
      this.toggle();
    });

    // Ao voltar no histórico
    window.addEventListener('popstate', () => {
      this.toggle(false); // força o fechamento
    });
  }

  toggle(alternar = true) {
    if (alternar) {
      if (this.aberto) {
        //executa funçãao antes de fechar
        if(this.e.fechar){
          this.e.fechar();
        }
        
        this.remove_classes('aberto');
        this.add_classes('fechado');
        this.aberto = false;
      } else {
        //executa funçãao antes de barir
        if(this.e.abrir){
          this.e.abrir();
        }
        
        
        this.remove_classes('fechado');
        this.add_classes('aberto');
        this.aberto = true;

        // Adiciona histórico apenas ao abrir
        history.pushState({ aberto: true }, '');
      }
    } else {
      // chamado por history.back()
      if (this.aberto) {
        //executa funçãao antes de fechar
        if(this.e.fechar){
          this.e.fechar();
        }

        this.remove_classes('aberto');
        this.add_classes('fechado');
        this.aberto = false;
      }
    }
  }

  

  add_classes(estado) {
    const divs = this.v['div'];
    for (let i = 0; i < divs.length; i++) {
      this.add_class(divs[i]['vetor'], divs[i][estado]);
    }
  }

  add_class(vetor, class_def) {
    class_def = class_def.replace(/\./g, "");
    const vetores = vetor.split(',');
    const classes_add = class_def.split(',');

    for (let i = 0; i < vetores.length; i++) {
      let classes_antiga = $(vetores[i]).attr('class') || "";
      for (let x = 0; x < classes_add.length; x++) {
        const nova_classe = classes_add[x].trim();
        if (!classes_antiga.includes(nova_classe)) {
          classes_antiga += ' ' + nova_classe;
        }
      }
      $(vetores[i]).attr('class', classes_antiga.trim());
    }
  }

  remove_classes(estado) {
    const divs = this.v['div'];
    for (let i = 0; i < divs.length; i++) {
      this.remove_class(divs[i]['vetor'], divs[i][estado]);
    }
  }

  remove_class(vetor, class_def) {
    class_def = class_def.replace(/\./g, "");
    const vetores = vetor.split(',');
    const classes_remover = class_def.split(',');

    for (let i = 0; i < vetores.length; i++) {
      let classes_antiga = $(vetores[i]).attr('class') || "";
      for (let x = 0; x < classes_remover.length; x++) {
        const regex = new RegExp('\\b' + classes_remover[x].trim() + '\\b', 'g');
        classes_antiga = classes_antiga.replace(regex, '');
      }
      $(vetores[i]).attr('class', classes_antiga.trim());
    }
  }
}

///-------------------------------------------------------------------

class Cookie {
  // Define um cookie
  set(name, value, days = 7) {
      const date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      const expires = "expires=" + date.toUTCString();
      document.cookie = `${name}=${encodeURIComponent(value)}; ${expires}; path=/`;
  }

  // Lê um cookie específico
  get(name) {
      const decodedCookie = decodeURIComponent(document.cookie);
      const cookies = decodedCookie.split('; ');
      for (let cookie of cookies) {
          const [key, val] = cookie.split('=');
          if (key === name) return val;
      }
      return null;
  }

  // Apaga um cookie
  delete(name) {
      document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
  }

  // Lista todos os cookies como objeto
  list() {
      const decodedCookie = decodeURIComponent(document.cookie);
      const cookies = decodedCookie.split('; ');
      const result = {};
      for (let cookie of cookies) {
          const [key, val] = cookie.split('=');
          result[key] = val;
      }
      return result;
  }
}






// Uso correto:


/*
class painel {
  constructor(
    iddiv,
    idbnt,
    classabre = 'abre',
    classfecha = 'fecha',
    titulo = 'controle menu',
    func_abre = false,
    func_fecha = false,
  ) {
    this.divs = document.querySelectorAll(iddiv);
    this.buttons = document.querySelectorAll(idbnt);
    this.titulo = titulo;
    this.classabre = classabre;
    this.classfecha = classfecha;
    this.func_abre = func_abre;
    this.func_fecha = func_fecha;

    this.isVisible = false;

    this.buttons.forEach(button => {
      button.addEventListener('click', () => this.toggle());
    });

    window.addEventListener('popstate', () => {
      this.isVisible = false;
      this.updateView();
    });
  }

  toggle() {
    if (this.isVisible) {
      history.back();
    } else {
      this.show();
    }
  }

  show() {
    this.isVisible = true;
    this.updateView();
    history.pushState({ divVisible: true }, this.titulo);
  }

  updateView() {
    this.divs.forEach(div => {
      div.classList.toggle(this.classabre, this.isVisible);
      div.classList.toggle(this.classfecha, !this.isVisible);
    });

   
    if (this.isVisible && this.func_abre) {
      this.func_abre();
    }
    if (!this.isVisible && this.func_fecha) {
      this.func_fecha();
    }
  }
}

*/

// Cria o objeto de comportamento

// Cria o controlador

/*
const b = new BntMenu();
new painel (

    iddiv='minhaDiv',
    idbnt='toggleBtn',
    classabre='abre',
    classfecha='fecha',
    titulo='controle menu',
    func_abre = b.abre(' funciona a'),
    func_fecha = b.fecha(' funciona b')
);

*/


/*
$('#buscar').on('click', function() {
    $.ajax({
      url: 'http://localhost/servidor/servidor.php', // Substitua pela URL real
      method: 'GET',
      success: function(data) {alert(data);
        // Converte a resposta HTML e busca o primeiro <p>
        const doc = new DOMParser().parseFromString(data, "text/html");
        const texto = doc.querySelector("p")?.textContent || 'Parágrafo não encontrado';
        
        $('#resultado').text(texto);
      },
      error: function(xhr, status, error) {
        $('#resultado').text("Erro ao buscar: " + error);
      }
    });
  });*/