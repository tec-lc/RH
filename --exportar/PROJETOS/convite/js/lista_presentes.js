class plangoogle {
    constructor(){
        this.cookie = new Cookie();
        this.retorno=false;
        this.metodo='GET';
        this.link_lista="https://script.google.com/macros/s/AKfycbz4Y94_WSkS58Tjfrk9TPxqhZxULX5LjygCWt5LFFixG7kCnPzk_QbLmisnHCuI39vu/exec";
        //this.link_lista="https://script.googleusercontent.com/macros/echo?user_content_key=AehSKLgtPxzO8B15aBTWkFQhvqEKCKPQTEc4XTfZNHGQhWvgMTy80BKe2j4sjxT-iCujMpdm1St9VzZT_JQkXKBhfDfelTYsNtjpN5rV93GVBGN_rOjuBcASzgG3SfhILyah5m-BUECtOxK_3fNZrhCZlK-CqNjbZuhQ1a0-Av8dhtJ6hwF_x0tmymW3WVkkjRKHkCWbRwD9F9i3Q6wIdWPCyZ9xoOg9-9S68HYbp5a6miXmJaoeBZTI-faPeZwqQLxzYVoyXTMZ_5WjE18OlqDmzC4hO2Ph4w&lib=ML_ZA0O647L1PPwXjgXrQwo6OPeMtZOF9";
        //this.exe_busca();
    }

    /*carregando(t=true){
        if(t==true){

        }else{

        }

    }*/

    get(nome,executavel){
        if(nome==""){ 
            nome=this.cookie.get('item_nome');
            
        }

        //this.exe_busca();
        

        

        this.exe_busca((data)=>{
            var linhas=data.length;

            for(let i=0; i<linhas;i++){
                if(nome == data[i]['item'] && data[i]['comprado']=='n'){
                    //return this.retorno[i];
                    executavel(data[i]);
                    i=linhas;
                }
            
            }

        });
    
        

    }


    exe_busca(executavel=false){

        //this.carregando();

        fetch(this.link_lista)
            .then(res => res.json())
            .then(data => {
            //console.log(data);
            this.retorno= data;
            if(executavel==false){
                this.listar_presentes(data); 
            }else{
                executavel(data);
            }
            //this.listar_presentes(data);   
        });

    }

    listar_presentes(v){
        
        var linhas=v.length;
        var scriptjs='<script>new abre_compra(menu)</script>';
        var dados =' ';
        var dados_cookie =' ';
        for(let i=0; i<linhas;i++){
            //console.log(v[i]['item']);
            //console.log(v[i]['link']);
            if(v[i]['comprado']=='n'){ //alert(v['google']);

                //if(typeof v['google'] === 'undefined'){
                if(v[i]['google'] == ''){
                    v[i]['google']=v[i]['item'].split(' ').join('+');
                    //alert('funciona');
                }

                if(this.cookie.get(v[i]['google'])){
                    dados_cookie=dados_cookie+this.layout_lista(v[i],i);
                }else{
                    dados=dados+this.layout_lista(v[i],i);
                }
                
            }
            
        }


        if(dados_cookie!=' '){
            dados_cookie= '<div class="">'
          
            +'<h2 class="font1 centro es_20">Avisar os noivos!</h2>'
            +'<p class="font2 centro ">Aqui está o seu  histórico de presentes que você demonstrou interesse em comprar! </p>'
            +'<p class="font2 centro es_20">Se você já comprou é importante abrir o item e clicar em “AVISAR OS NOIVOS” para avisar os noivos da sua compra!</P>'
    
            +'</div>'
            +dados_cookie
            +'<div class="rodape"></div>'
            +'<div class="es_80"></div>';
        }

        if(dados!=' '){
            dados='<div class="">'
            +'<h2 class="font1 centro es_20">Sugestão de presentes!</h2>'
            +'<p class="font2 centro">Ao clicar em um dos presentes automaticamente irá abrir, um painel com informações sobre o endereço de entrega!</p>'
            +'<p class="font2 centro es_20"> Depois da compra você deve avisar os noivos,seja por contato ou pelo próprio site na opção “AVISAR OS NOIVOS”</p>'

            +'</div>'
            +dados
            +'<div class="rodape"></div>'
            +'<div class="es_80"></div>';
        }

        if(dados==' ' && dados_cookie==' '){
            dados='<div class="">'
            +'<h2 class="font1 centro es_20">Contribua com um PIX!</h2>'
            +'<p class="font2 centro es_20"">Infelizmente não tem mais sugestões de presentes!</p>'
           

            +'</div>'
            +'<div class="es_80"></div>';

        }

        $('.itens_carregado').html(
            scriptjs
            +dados_cookie
            +dados
        );

        //alert(dados);
        //this.carregando(false);
    }

    layout_lista(v,id){
        
        
        return ''
        +'<div class="lista_presentes" id="'+id+'" google="'+v['google']+'">'
          +'<div class="lista_bloco">'
              +'<div class="img_item" id="img_item_'+id+'" style="background-image: url('+"'"+v['link']+"'"+');"></div>'
              +'<p class="lista_titulo" id="lista_titulo_'+id+'">'+v['item']+'</p>'
              +'<p class="lista_valor"> '+this.mas_dinheiro(v['valor'])+'</p>'
          +'</div>'
        +'</div>';
    }

    mas_dinheiro(valor) {
        if (typeof valor === "string") {
          // Remove espaços
          valor = valor.trim();
          // Troca vírgula por ponto se necessário
          valor = valor.replace(',', '.');
        }
      
        // Converte para número
        const numero = parseFloat(valor);
      
        if (isNaN(numero)) {
          return '_ _ , _ _';
        }
      
        // Formata em Real Brasileiro
        valor= numero.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        valor=valor.replace('R$', '<span>R$</span>');
        return valor.replace(',', '<span>,')+'</span>';
      }
      
      

}

class abre_compra{
    
    constructor(eve){
        this.link='https://www.google.com/search?&udm=28&q=';
        this.valor=[];

        this.cookie= new Cookie();

        new Evento({
            click:'.lista_presentes, .bnt_fechar_painel, .fundo_painel',
            div: [
                {
                  vetor: '.fundo_painel, .produto_painel',
                  aberto: '.abre',
                  fechado: '.fecha'
                }
            ],
            abrir: ()=>{ //alert('abre');


                if(this.cookie.get('termos')){
                    this.aceita_termos();
                }

                
                if(eve.aberto){ 
                    eve.toggle();
                    
                }
                
                var cod_id = $(event.currentTarget).attr('id');
                this.valor={
                    'item': $('#lista_titulo_'+cod_id).html(),
                    'img':  $('#img_item_'+cod_id).attr('style'),
                    'google': $(event.currentTarget).attr('google')
                }
                //alert('grava cookie');
                //this.cookie.set('item_img',this.valor['img'],30);//armazena imagem
                this.cookie.set('item_nome',this.valor['item'],30);//armazena nome
                this.executa();
                

                /*$('.armazena_cookie').click((event) => {
                    this.cookie.set(this.valor['google'],'true',30);
                    this.bnt_cookie();
                    //$('#'+cod_id).attr('style','opacity: 0.5;');
                });


                $('.aceito_termos').click((event) => {
                    this.aceita_termos();
                });*/


            }
        });
    
        $('.armazena_cookie').click((event) => {
            this.cookie.set(this.valor['google'],'true',30);
            
            this.bnt_cookie();
            //$('#'+cod_id).attr('style','opacity: 0.5;');
        });


        $('.aceito_termos').click((event) => {
            this.aceita_termos();
        });

    }
    executa(){

        

        $('.img_comprar').attr('style',this.valor['img']);
        $('.spannome').html(this.valor['item']);
        $('.link_comprar').attr('href',this.link+this.valor['google']);
        $('.link_confirmar').attr('href','confirmar.html?id='+this.valor['item']);
        
        if(this.cookie.get(this.valor['google'])){
            this.bnt_cookie();
        }else{
            this.bnt_cookie_off();
        }

    }

    aceita_termos(){
        $('.termos_aceitos').attr('style','display:block');
        $('.termos_nao_aceitos').attr('style','display:none');
        this.cookie.set('termos','true',10);
    }

    /*termos_nao(){
        $('.termos_aceitos').attr('style','display:none');
        $('.termos_nao_aceitos').attr('style','display:block');
    }*/

    bnt_cookie(){
        $('.link_ocultar').attr('style','display:block');
        $('.link_mostrar').attr('style','display:none');
    }
    bnt_cookie_off(){
        $('.link_ocultar').attr('style','display:none');
        $('.link_mostrar').attr('style','display:block');
    }

}


