<?php

include("../global/virtualQueueIni.php");
$cfg = VirtualQueueIni::getInstance();

$link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());


$seg_codigo = $_GET["seg_codigo"];
$eje_codigo = $_GET["eje_codigo"];
$accion = $_GET["accion"];
$nemo = $_GET["nemo"];

if ($accion == "Atender") {
    $sql = "UPDATE seguimiento 
            SET eje_codigo = '$eje_codigo', seg_fecatencion = CURRENT_TIMESTAMP(), seg_atendido = 1 
            where seg_codigo ='$seg_codigo'";
} else {
    $sql = "UPDATE seguimiento 
            SET eje_codigo = '$eje_codigo', seg_fecfinatencion = CURRENT_TIMESTAMP(), seg_atendido = 2
            where seg_codigo ='$seg_codigo'";
}
mysqli_query($link, $sql);
mysqli_close($link);
?>
