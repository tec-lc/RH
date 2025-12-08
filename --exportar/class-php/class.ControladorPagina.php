<?php

class ControladorPagina{

  public $RAIZ;
  public $PG;
  public $TAG;

  public function __construct(
    $mapa=[],
    $layoutGlobal='',
    $pgHome='home'
  ){

    include $this->caminho($mapa,$pgHome,$layoutGlobal);

  }//-----------------------------------------
  public function caminho($mapa,$pgHome,$layoutGlobal){
    $this->PG=$pgHome;//define pg home
    if(@$_GET['pg']!='' ){//se pagina tem nome
      $this->PG=$_GET['pg'];

    }

    //verificar se existe
    if(@$mapa[$this->PG]){ //echo 'existe';

      //verificar se é backend
      if(@$mapa[$this->PG]=='backend'){
        //pagina sem layoute
        return 'paginas-backend/'.$this->PG.'.php';
      }else{
        if(!@$mapa[$this->PG]['layout']){
          $mapa[$this->PG]['layout']=$layoutGlobal;//se não tem layout pega o padrao
        }
        $this->TAG=$mapa[$this->PG];
        return 'paginas-layout/'.$mapa[$this->PG]['layout'].'/start.php';
      }

    }else{
      //pagina erro 404
      return 'paginas-layout/erro404/start.php';
    }

    /*
    $this->PG=$layout;

    if($pg[$layout] == 'backend'){
      //echo 'paginas-backend/'.$pg[$layout].'/'.$layout.'.php';
      return 'paginas-backend/'.$pg[$layout].'/'.$layout.'.php';
    }else if ($pg[$layout] == '') {
      return 'paginas-layout/erro404/start.php';
    }
    }else{
      return 'paginas-layout/'.$pg[$layout].'/start.php';
    }*/
  }//-----------------------------


  public function pagina(){
    include 'paginas/'.$this->PG.'.php';
  }//--------------------------------------

  public function htmlMetaTag($nome,$tipo='css'){
    $metaTag=[
      'css' => '<link rel="stylesheet" href="'.$this->RAIZ.$nome.'.css">',
      'js' => '<script src="'.$this->RAIZ.$nome.'.js" ></script>',
    ];

    if(@$metaTag[$tipo]){
      return $metaTag[$tipo];
    }

  }//---------------------------------------
  public function tag($tipo='css'){
    if(@$this->TAG[$tipo]){
      foreach ($this->TAG[$tipo] as $t) {
        echo $this->htmlMetaTag($t,$tipo)."\n";
      }
    }

  }//---------------------------------------


}






?>
