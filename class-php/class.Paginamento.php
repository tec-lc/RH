<?php

class Paginamento{

    public $PG;


    public function __construct($home,$mapa=[]){

        //verifica url
        if(@$_GET['pgw']==''){//peagina em branco
            $pg=$mapa[$home];
            $nome=$home;
        }else if(@$mapa[$_GET['pgw']]){
            $pg=$mapa[$_GET['pgw']];
            $nome=$_GET['pgw'];
        }else{
            $pg=$mapa['erro404'];
            $nome='erro404';
        }
        $this->PG=$pg;
        $this->PG['nome']=$nome;

        //print_r($pg);
        //verificando layout
        $diretorio=false;
        if(@$pg['layout']){
            $diretorio= $pg['layout'];
        }

        //echo $diretorio;
        $this->pagina($diretorio);
      
        
    }//------------------------

    public function pagina($layout=false){
        if($layout===false){
            $layout=$this->PG['dir'];
        }
        //echo $layout;
        require $layout;
    }
    //--------------------------------------
    public function categoria(){
        echo '<input class="valor-categoria" value="'.$this->PG['categoria'].'">'.
        '<input class="valor-pagina" value="'.$this->PG['nome'].'">'
        ;
    }

}





?>