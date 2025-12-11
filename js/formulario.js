// garante DOM pronto
$(function() {

    mapeia_pagina();

    /*
    // auto preencher mês e ano
    const now = new Date();
    $('#mes').val(String(now.getMonth() + 1).padStart(2,'0')); // 01..12
    $('#ano').val(now.getFullYear());
    */

    window.abre_tabela = function(nome,cod) {
        
        //alert(nome);
        $.ajax({
            url: '?pgw=abretabela&tabela='+nome+'&cod='+cod,
            method: 'GET',
            success: function (data) {
                // data: string retornada pelo PHP (com os nomes separados por <->)
                //$('#status').text(data);
                //console.log('RETORNO abre_tabela:', data);
                $('.corpo').html(data);
                mapeia_pagina('tabela-'+cod);
                $('.bntAplicacao').attr('style','');





                //monta_tabela(data);
            },
            error: function (xhr, status, error) {
                console.error('Erro em abre_tabela:', status, error);
                //$('#status').text('Erro ao abrir planilha.');
                
            }
        });



    };
    //-------------------------------------------------

    $(".quadroIcon").click(function(){//categoria
        mapeia_subMenu($(this).attr('menu'));
    });
   
    //----------------------------------------------------
    
    //---------------------------------------------------------
    function mapeia_subMenu(menu){
        $('.quadroIcon').attr('id', 'corBacAzulo');
        $('.categoria-' + menu).attr('id', 'corBacBranco');
        $('.menuMais').attr('style','display:none;');
        console.log('.caixaCategoria-'+menu);
        $('.caixaCategoria-'+menu).attr('style','');

        if(menu=='planilha'){
            abre_planilha();
            //abre_tabela('',0);
        }
    }
    // ---------------------------------------------------------
    function mapeia_pagina(item=false){
        if(item==false){
            var categoria = $('.valor-categoria').val();
            var pagina    = $('.valor-pagina').val();
            $('.categoria-' + categoria).attr('id', 'corBacBranco');
            $('.subCat-' + pagina).attr('id', 'corBacAzul');
            mapeia_subMenu(categoria);
        }else{//se for tabela
            $('.itenMenu').attr('id','');//limpa todos
            $('.subCat-'+item).attr('id','corBacAzul');
        }
        

        

    }
    // ---------------------------------------------------------
    function monta_htmlBnt(){
         return `
            <a class="linkOff" href="?pgw=importabanco">
                <div class="bntAplicacao">
                    Salvar no Banco
                </div>
            </a>
        `;

    }
    //----------------------------------------------------------
    function monta_html(nome,cod) {
        // IMPORTANTE: return + string na MESMA expressão
        return `
            <div class="itenMenu subCat-tabela-${cod}" onclick="abre_tabela('${nome}','${cod}')">
                <div class="iconFloat"></div>
                <div class="fontMenu">${nome}</div>
                <div class="clear"></div>
            </div>
        `;


    }

    // ---------------------------------------------------------
    function mapeia_planilhas(plan) {
        const partes = plan.split('<->');

        for (let i = 0; i < partes.length; i++) {
            const nome = partes[i].trim();
            if (!nome) continue; // ignora vazios (ex: se terminar com <->)
            $('.caixaCategoria-planilha').append(monta_html(nome,i));
            
        }

        

        
    }
    // ---------------------------------------------------------
    function abre_planilha() {
        //antes de consultar limpa planilha
        $('.caixaCategoria-planilha').html('');
        

        $.ajax({
            url: '?pgw=abreplanilha',
            method: 'GET',
            success: function (data) {
                // data: string retornada pelo PHP (com os nomes separados por <->)
                $('#status').text(data);
                console.log('RETORNO abre_planilha:', data);
                mapeia_planilhas(data);
                abre_tabela('',0);
            },
            error: function (xhr, status, error) {
                console.error('Erro em abre_planilha:', status, error);
                $('#status').text('Erro ao abrir planilha.');
            }
        });
    }
    // ---------------------------------------------------------
   async function enviarArquivo() { 
        const input  = document.getElementById('arquivo');
        const status = document.getElementById('status');
        var tipo = $('#tipo').val();
    
        // Verifica se algum arquivo foi selecionado
        if (!input.files || input.files.length === 0) {
            status.textContent = 'Selecione pelo menos um arquivo primeiro.';
            return;
        } else if (!tipo) {
            status.textContent = 'Defina um tipo de documento.';
            return;
        }

        const files = input.files; // FileList com todos os arquivos selecionados

        // Monta o FormData para enviar via POST
        const formData = new FormData();

        // IMPORTANTE: usar arquivo[] para múltiplos arquivos
        for (let i = 0; i < files.length; i++) {
            formData.append('arquivo[]', files[i]); 
        }

        try {
            status.textContent = 'Enviando...';

            const resposta = await fetch('?pgw=importar/backend&tipo=' + encodeURIComponent(tipo), {
                method: 'POST',
                body: formData
            });

            const texto = await resposta.text();
            console.log('RETORNO importar/backend:', texto);

            status.textContent = 'Aguarde, abrindo planilha...';

            // depois do upload, chama o backend que lista as planilhas
            
            //window.location.href = "?pgw=planilha";

        } catch (erro) {
            console.error(erro);
            status.textContent = 'Erro ao enviar arquivo.';
        }
    }


    //(para usar no onclick do HTML)
    window.enviarArquivo  = enviarArquivo;
    window.abre_planilha  = abre_planilha;
    window.mapeia_planilhas = mapeia_planilhas;
    window.abre_planilha= abre_tabela;

});
