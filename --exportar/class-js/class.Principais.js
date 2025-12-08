/*class Click {
  constructor(abrirSelector, onClick, fecharSelector, onBack) {
    this.abrirSelector = abrirSelector;
    this.fecharSelector = fecharSelector;
    this.onClick = onClick;
    this.onBack = onBack;
    this.aberto = false; // controla o estado
    this.popstateUsado = false; // evita duplo onBack

    this.init();
  }

  init() {
    const abrirEls = document.querySelectorAll(this.abrirSelector);
    const fecharEls = document.querySelectorAll(this.fecharSelector);

    const abrirSet = new Set(abrirEls);
    const fecharSet = new Set(fecharEls);

    const todos = new Set([...abrirEls, ...fecharEls]);

    todos.forEach(el => {
      el.addEventListener('click', () => {
        const éAbrir = abrirSet.has(el);
        const éFechar = fecharSet.has(el);

        if (éAbrir && !éFechar) {
          this.abrir();
        } else if (éFechar && !éAbrir) {
          this.fecharComHistory();
        } else if (éAbrir && éFechar) {
          // alterna
          if (!this.aberto) {
            this.abrir();
          } else {
            this.fecharComHistory();
          }
        }
      });
    });

    window.addEventListener('popstate', () => {
      if (this.popstateUsado) {
        this.popstateUsado = false;
        return;
      }
      this.onBack?.();
      this.aberto = false;
    });
  }

  abrir() {
    this.onClick?.();
    history.pushState({ menu: 'open' }, '');
    this.aberto = true;
  }

  fecharComHistory() {
    this.onBack?.(); // executa ação de fechar
    this.popstateUsado = true; // bloqueia próximo popstate
    history.back(); // simula voltar
    this.aberto = false;
  }
}*/

/* Exemplo de uso:
//ele so pode ser usado no estado inicial de fechado
new Click(
  '#bnt_abrir_fechar,#icone_abre',
  () => {
    console.log('abre_menu');
    alert('menu abre');
  },
  '#bnt_abrir_fechar,#icone_fecha',
  () => {
    console.log('fecha_menu');
    alert('fecha menu');
  }
);

*/



//----------------------------------------------------------

class ContagemRegressiva {
  constructor(dataAlvo,Exec) {
      this.exe=Exec;
      this.dataAlvo = new Date(dataAlvo).getTime();
      //this.elementos = elementos;
      this.intervalo = null;
      this.iniciar();
  }

  iniciar() {
      var val =this.atualizarContagem();
      this.intervalo = setInterval(() => this.atualizarContagem(), 1000);
      return val;
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


      this.exe( {
        dia: dias,
        hor: horas,
        min: minutos,
        seg: segundos
      });
  }
}
/* exemplo
new ContagemRegressiva('10/11/2025 18:30',(data)=>{
  console.log(data);
});

*/


  //------------------------------------------------------
  class Copiar {
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
  // new CopyToClipboard('id_bnt_endereco', 'Texto que será copiado');

//--------------------------------------------------------------------
//cookie pode ser adicionado array e tambem classes
class Cookie {
  // Define um cookie
  set(name, value, days = 7) {
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    const expires = "expires=" + date.toUTCString();

    let current = this.get(name);

    // Se for array ou objeto, empilha
    if (typeof value === 'object') {
      let newVal = [];

      if (Array.isArray(value)) {
        newVal = value;
      } else {
        newVal = [value]; // transforma objeto em array
      }

      if (Array.isArray(current)) {
        newVal = [...newVal, ...current];
      }

      value = JSON.stringify(newVal);
    } else {
      // valor simples (string, número, etc.) sobrescreve
      value = encodeURIComponent(value);
    }

    document.cookie = `${name}=${encodeURIComponent(value)}; ${expires}; path=/`;
  }

  // Lê um cookie específico
  get(name) {
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookies = decodedCookie.split('; ');
    for (let cookie of cookies) {
      const [key, val] = cookie.split('=');
      if (key === name) {
        try {
          return JSON.parse(val);
        } catch {
          return val;
        }
      }
    }
    return null;
  }

  // Apaga o cookie
  delete(name) {
    document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
  }
}

/*exeplo de uso:
// 1. Array de objetos (empilha)
cook.set('usuarios', [
  { nome: 'Lucas', foto: 'off' },
  { nome: 'Caio', foto: 'off' }
], 30);

cook.set('usuarios', [
  { nome: 'Marcos', foto: 'off' }
], 30);

console.log(cook.get('usuarios'));
// Resultado esperado: [{Marcos...}, {Lucas...}, {Caio...}]

// 2. Array simples (empilha)
cook.set('ingre', ['cebola', 'mocoto'], 30);
cook.set('ingre', ['alho'], 30);

console.log(cook.get('ingre'));
// Resultado esperado: ['alho', 'cebola', 'mocoto']

// 3. Texto simples (sobrescreve)
cook.set('id_cod', 'MG09', 30);
cook.set('id_cod', 'MG10', 30);

console.log(cook.get('id_cod'));
// Resultado: 'MG10'

*/

//-------------------------------------------------------------------
class ListArray {
  constructor(obj, callback) {
    if (typeof obj !== 'object' || obj === null) return;

    // Converte objeto em array se necessário
    const values = Array.isArray(obj) ? obj : Object.values(obj);

    for (const item of values) {
      callback(item);
    }
  }
}

/* exemplo de uso
var dados = {
  0: {
    nome: 'luis',
    vendas: {
      0: 'iaras',
      1: 'salvador'
    }
  },
  1: {
    nome: 'carlos',
    vendas: {
      0: 'iaras',
      1: 'salvador',
      2: 'BH'
    }
  },
};

new ListArray(dados, (d) => {
  //console.log("Vendedor: " + d.nome);
  new ListArray(d.vendas, (v) => {
    console.log(d.nome+" vendeu em : " + v);
  });
});
*/
//---------------eventos html -------------------------------------
/*class ClassId {
  constructor(seletorOuElemento, seletorVoltar = null) {
    if (typeof seletorOuElemento === 'string') {
      this.elementos = Array.from(document.querySelectorAll(seletorOuElemento));
    } else {
      this.elementos = [seletorOuElemento];
    }

    if (seletorVoltar) {
      this.elementosVoltar = Array.from(document.querySelectorAll(seletorVoltar));
    }

    this._bloqueioPop = false;
    this._jaAbriu = false; // flag para controlar abertura
  }

  attr(nome, valor) {
    if (valor !== undefined) {
      this.elementos.forEach(el => el.setAttribute(nome, valor));
    } else {
      const ultimo = this.elementos[this.elementos.length - 1];
      return ultimo ? ultimo.getAttribute(nome) : null;
    }
  }

  html(conteudo) {
    if (conteudo !== undefined) {
      this.elementos.forEach(el => el.innerHTML = conteudo);
    } else {
      const ultimo = this.elementos[this.elementos.length - 1];
      return ultimo ? ultimo.innerHTML : null;
    }
  }

  click(callback) {
    this.elementos.forEach(el => {
      el.addEventListener('click', (e) => {
        callback(new ClassId(e.currentTarget));
      });
    });
  }

  clickNavegador(abrirCallback, voltarCallback) {
    // clique para abrir
    this.elementos.forEach(el => {
      el.addEventListener('click', (e) => {
        if (this._jaAbriu) return; // impede múltiplas aberturas
        this._jaAbriu = true;

        history.pushState({ painel: true }, null, '');
        abrirCallback(new ClassId(e.currentTarget));
      });
    });

    // clique para fechar manualmente
    if (this.elementosVoltar) {
      this.elementosVoltar.forEach(el => {
        el.addEventListener('click', (e) => {
          history.back(); // simula botão voltar
        });
      });
    }

    // evento botão voltar
    window.addEventListener('popstate', (e) => {
      if (this._jaAbriu) {
        this._jaAbriu = false; // permite reabrir depois
        const alvo = this.elementosVoltar?.slice(-1)[0] || document.body;
        voltarCallback(new ClassId(alvo));
      }
    });
  }
}
//ao chamar a classe abaixo ela funciona normal
const menu = new ClassId('.painelTransparente,.painelMenu');



new ClassId('.bntMenu','.painelTransparente')
.clickNavegador((e) => {
  menu.attr('style','display:block;');
}, (e)=> {
  menu.attr('style','display:none;');
});


//agora quando eu adiono esse novo codigo ao clicar no elemento .painelTransparente o navegador volta para pagina anterior por alguma razão ela não função clickNavegador da esse problema ao ser chamada mais de uma vez mesmo sendo new class
const login = new ClassId('.painelTransparente,.painelLogin');
new ClassId('.bntLogin','.painelTransparente')
.clickNavegador((e) => {
  login.attr('style','display:block;');
}, (e)=> {
  login.attr('style','display:none;');
});
//por favor tente arrumar de uma forma que esse problena para
*/
class ClassId {
  static _pilhaPainel = []; // pilha de painéis abertos
  static _popstateRegistrado = false;

  constructor(seletorOuElemento, seletorVoltar = null) {
    if (typeof seletorOuElemento === 'string') {
      this.elementos = Array.from(document.querySelectorAll(seletorOuElemento));
    } else {
      this.elementos = [seletorOuElemento];
    }

    if (seletorVoltar) {
      this.elementosVoltar = Array.from(document.querySelectorAll(seletorVoltar));
    }

    this._jaAbriu = false;
    this._abrirCallback = null;
    this._voltarCallback = null;
  }

  attr(nome, valor) {
    if (valor !== undefined) {
      this.elementos.forEach(el => el.setAttribute(nome, valor));
    } else {
      const ultimo = this.elementos[this.elementos.length - 1];
      return ultimo ? ultimo.getAttribute(nome) : null;
    }
  }

  html(conteudo) {
    if (conteudo !== undefined) {
      this.elementos.forEach(el => el.innerHTML = conteudo);
    } else {
      const ultimo = this.elementos[this.elementos.length - 1];
      return ultimo ? ultimo.innerHTML : null;
    }
  }

  click(callback) {
    this.elementos.forEach(el => {
      el.addEventListener('click', (e) => {
        callback(new ClassId(e.currentTarget));
      });
    });
  }

  clickNavegador(abrirCallback, voltarCallback) {
    this._abrirCallback = abrirCallback;
    this._voltarCallback = voltarCallback;

    // Clique no botão que abre
    this.elementos.forEach(el => {
      el.addEventListener('click', (e) => {
        if (this._jaAbriu) return;

        this._jaAbriu = true;
        ClassId._pilhaPainel.push(this);
        history.pushState({ painel: true }, null, '');
        this._abrirCallback(new ClassId(e.currentTarget));
      });
    });

    // Clique no botão de voltar (painelTransparente)
    if (this.elementosVoltar) {
      this.elementosVoltar.forEach(el => {
        el.addEventListener('click', (e) => {
          if (ClassId._pilhaPainel[ClassId._pilhaPainel.length - 1] === this) {
            history.back(); // fecha só se for o topo
          }
        });
      });
    }

    // Registrar um único popstate global
    if (!ClassId._popstateRegistrado) {
      window.addEventListener('popstate', () => {
        const painel = ClassId._pilhaPainel.pop();
        if (painel) {
          painel._jaAbriu = false;
          const alvo = painel.elementosVoltar?.slice(-1)[0] || document.body;
          painel._voltarCallback(new ClassId(alvo));
        }
      });
      ClassId._popstateRegistrado = true;
    }
  }
}


/*
// Defina o painelMenu
const menu = new ClassId('.painelTransparente,.painelMenu');

// Primeiro painel (Menu)
new ClassId('.bntMenu','.painelTransparente')
.clickNavegador((e) => {
  menu.attr('style','display:block;');
}, (e) => {
  menu.attr('style','display:none;');
});

// Segundo painel (Login)
const login = new ClassId('.painelTransparente,.painelLogin');
new ClassId('.bntLogin','.painelTransparente')
.clickNavegador((e) => {
  login.attr('style','display:block;');
}, (e) => {
  login.attr('style','display:none;');
});

// Lógica para controlar a navegação entre os painéis
let currentPanel = null;  // Para controlar qual painel está visível

function showPanel(panelId) {
  if (currentPanel) {
    currentPanel.attr('style', 'display:none;'); // Esconde o painel atual
  }

  currentPanel = new ClassId(panelId);
  currentPanel.attr('style', 'display:block;');  // Exibe o painel solicitado
}

// Adicionando o controle de navegação via histórico
window.addEventListener('popstate', function (e) {
  // Ao pressionar o botão voltar, chama a função para mostrar o painel correto
  if (e.state && e.state.painel === 'menu') {
    showPanel('.painelMenu');
  } else if (e.state && e.state.painel === 'login') {
    showPanel('.painelLogin');
  }
});
*/

/* exemplo de uso
const titulos = new ClassId('.titulo, #subTitulo');
titulos.click((e) => {
  alert('funciona click: ' + e.html());
  e.attr('style', 'color:#F00;');
  e.html('foi clicado');
  alert('Novo style: ' + e.attr('style'));
});
const nome= new ClassId('.titulo');
alert(nome.html());
alert(nome.attr('style'));
nome.html('classe nome recebe nome novo');
nome.attr('style','border:solid 1px #F00;');

//tem que ser diferente a classe de fechar da de abrir
const titulos = new ClassId('.titulo, #subTitulo', '.oculta');
titulos.clickNavegador((e) => {
  alert('abre apinel ' + e.html());
}, (e) => {
  alert('fecha painel' + e.html());
});
*/
