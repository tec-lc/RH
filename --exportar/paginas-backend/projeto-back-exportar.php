<?php

include 'class-php/class.SiteExporter.php';
$RAIZ='/var/www/html/exportar/PROJETOS/';
if(@$_GET['dir']){
    if(@$_GET['per']!='') { $per=explode(',',$_GET['per']);
        $exportador = new SiteExporter($RAIZ,$_GET['dir'],$per); // substitua por sua pasta real
    }else{
        $exportador = new SiteExporter($RAIZ,$_GET['dir']); // substitua por sua pasta real
    }

    $exportador->exportar();
    header('location:PROJETOS/'.$_GET['dir']);
    exit;
}


?>
