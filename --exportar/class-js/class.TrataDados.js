class TrataDados {
  constructor() {}

  // Converte strings de data em objeto Date válido
  parseData(data) {
    if (data instanceof Date && !isNaN(data)) return data;
    if (typeof data !== 'string') return null;

    let d = new Date(data);
    if (!isNaN(d)) return d;

    const regex1 = /^(\d{2})[\/-](\d{2})[\/-](\d{4})(?:[ T](\d{2}):(\d{2})(?::(\d{2}))?)?$/;
    const regex2 = /^(\d{4})[\/-](\d{2})[\/-](\d{2})(?:[ T](\d{2}):(\d{2})(?::(\d{2}))?)?$/;

    let match = data.match(regex1);
    if (match) {
      const [_, dd, mm, yyyy, hh = '00', mi = '00', ss = '00'] = match;
      return new Date(`${yyyy}-${mm}-${dd}T${hh}:${mi}:${ss}`);
    }

    match = data.match(regex2);
    if (match) {
      const [_, yyyy, mm, dd, hh = '00', mi = '00', ss = '00'] = match;
      return new Date(`${yyyy}-${mm}-${dd}T${hh}:${mi}:${ss}`);
    }

    return null;
  }

  // Retorna a data no formato "dd/mm/yyyy hh:mm:ss"
  dataBr(dataEntrada) {
    const data = this.parseData(dataEntrada);
    if (!data) return dataEntrada;

    const dd = String(data.getDate()).padStart(2, '0');
    const mm = String(data.getMonth() + 1).padStart(2, '0');
    const yyyy = data.getFullYear();
    const hh = String(data.getHours()).padStart(2, '0');
    const mi = String(data.getMinutes()).padStart(2, '0');
    const ss = String(data.getSeconds()).padStart(2, '0');

    return `${dd}/${mm}/${yyyy} ${hh}:${mi}:${ss}`;
  }

  // Retorna o tempo passado desde a data
  tempoPostagem(dataEntrada) {
     const data = this.parseData(this.dataBr(dataEntrada));
    //const data = this.parseData(dataEntrada);
    if (!data) return dataEntrada;

    const agora = new Date();
    const diff = agora - data;

    const minutos = Math.floor(diff / 60000);
    const horas = Math.floor(diff / 3600000);
    const dias = Math.floor(diff / 86400000);
    const meses = Math.floor(dias / 30);
    const anos = Math.floor(dias / 365);

    if (minutos < 1) return 'agora';
    if (minutos < 60) return `há ${minutos} min`;
    if (horas < 24) return `há ${horas} h`;
    if (dias < 30) return `há ${dias} dias`;
    if (dias < 365) return `há ${meses} meses`;
    return `há ${anos} ano${anos > 1 ? 's' : ''}`;
  }
}


/*exemplo:
const dt = new TrataDados();

//data em qualquer formato
console.log("Formato padrão:", dt.dataBr('2025-02-01T12:30:00'));
console.log("Tempo de postagem:", dt.tempoPostagem('2025-02-01T12:30:00'));
*/



/*

/////////////cor aleatoria para alternativa foto de perfil////////////////////// */
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