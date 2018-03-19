<?php


//include("virtualQueueIni.php");
//$cfg = VirtualQueueIni::getInstance();
$parametros = $_SERVER['QUERY_STRING'];

$url1 = "http://llamame.tk:8888/consulta?$parametros";
//echo $url1;
$r = file_get_contents($url1, false);
echo $r;

?>
