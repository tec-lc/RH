<?php
class SvgImportar{

  public $copiar;
  public $enviar;
  public $arquivo;

  public function __construct($dir_copiar='icon/',$arquivo_criar='ico.php'){

    $this->copiar=$dir_copiar;
    $this->enviar=$arquivo_criar;

    //$conteudo = file_get_contents('arquivo.txt');//le conteudo
    $this->listaArquivos();

  }
  //-------------------------------------------------
  public function listaArquivos(){

    foreach (glob($this->copiar."*.svg") as $nome) {

      $this->arquivo='';
      $iconItem .= $this->htmlItem($nome);
      //$iconAmostra .= $this->htmlItemAmostra();
    }

    //$this->montaDocumento($iconItem,$iconAmostra);


    $arquivo = tempnam(sys_get_temp_dir(), 'tmp_');

    // escreve conteúdo
    file_put_contents($arquivo, $this->montaDocumento($iconItem));

    // usa o arquivo para algo...
    // exemplo: forçar download
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="'.$this->enviar.'"');
    readfile($arquivo);

    // apaga depois do envio
    unlink($arquivo);

  }
  //--------------------------------------------------
  public function montaDocumento($val){
    /*return
    "<?php ".
    '$ICO'.'["blib"]='."'".
      '<svg xmlns="http://www.w3.org/2000/svg" style="display:none;">
        '.$va1.'
      </svg>'.
      "';".
      $val2.
      " ?>";*/

      return
      "<?php ".'$ico=['.$val."]; ?>";
  }
  //--------------------------------------------------
  public function htmlItemAmostra(){

    /*
    return
      '$ICO'.'["'.$this->arquivo['nome'].'"]='."'".
      '<svg width="'.$this->arquivo['width'].'" height="'.$this->arquivo['height'].'" >'.
        '<use class="ico ico-'.$this->arquivo['nome'].'" id="ico-'.$this->arquivo['nome'].'" href="#'.$this->arquivo['nome'].'"></use>'.
      '</svg>'."\n';";
      */

  }
  //--------------------------------------------------
  public function htmlItem($dir){
    //echo '('.$nome.'.svg)<br>';
    $nome=pathinfo($dir, PATHINFO_FILENAME);;
    $this->arquivo=file_get_contents($dir);

    $width=$this->get('width="','px"');
    $height=$this->get('height="','px"');

    $path=$this->get('<metadata id="CorelCorpID_0Corel-Layer"/>','</g>');
    //echo '('.$path.")";
    $path=str_replace('fil', 'icone-glo '.$nome, $path);//coloca classe
    //echo '('.$path.")";

    $this->arquivo=[
      'width'=>$width,
      'height'=>$height,
      'nome'=>$nome,
      'ico'=>$path
    ];
    return
    "'".$nome."'=>'".
      '<svg class="svg svg-'.$nome.'" id="svg-'.$nome.'" style=" fill-rule:evenodd;" viewBox="0 0 '.$width.' '.$height.'">
        '.$path.'
      </svg>'.
      "',";


  }
  //---------------------------------------------------
  public function get($p1,$p2){
    //$arquivo=file_get_contents($this->arquivo);
    $arquivo=explode($p1,$this->arquivo);
    $arquivo=explode($p2,$arquivo[1]);
    return $arquivo[0];
  }
  //---------------------------------------------------

}








?>
