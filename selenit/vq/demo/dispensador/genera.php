<?php
$global = dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'global';
//set it to writable location, a place for temp generated PNG files
$PNG_TEMP_DIR = $global .DIRECTORY_SEPARATOR. 'temp' . DIRECTORY_SEPARATOR;

//html PNG location prefix
$PNG_WEB_DIR = 'temp/';


include "../global/qr/qrlib.php";

//ofcourse we need rights to create temp dir
if (!file_exists($PNG_TEMP_DIR)){
    mkdir($PNG_TEMP_DIR);
}
 
$filename = $PNG_TEMP_DIR . 'test.png';
unlink($filename);

//processing form input
//remember to sanitize user input in real-life solution !!!
$errorCorrectionLevel = 'L';
$matrixPointSize = 4;

//display generated file
include("../global/virtualQueueIni.php");
$cfg = VirtualQueueIni::getInstance();

$link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());

//virificar si la jornada esta abierta
$sql = "SELECT count(1) c FROM jornada where jor_fecha = curdate() and jor_estado = 1";
$query = mysqli_query($link, $sql);
mysqli_query($link, $sql);
$fila = mysqli_fetch_array($query);
$c = $fila["c"];

if ($c > 0) {
    $nemo = $_GET["nemo"];
    $fil_codigo = $_GET["fil_codigo"];
    $token = rand(1000, 9999);

    $sql = "UPDATE fila SET fil_ut=fil_ut+1 WHERE fil_codigo='$fil_codigo'";
    mysqli_query($link, $sql);

    $sql = "select fil_ut, fil_nombre, fil_nemo, eje_modulo, fil_ut, fil_ta  from fila WHERE fil_codigo='$fil_codigo'";
    $query = mysqli_query($link, $sql);
    mysqli_query($link, $sql);
    $fila = mysqli_fetch_array($query);

    $ut = $fila["fil_ut"];
    $fil_nombre = $fila["fil_nombre"];
    $fil_nemo = $fila["fil_nemo"];
    $eje_modulo = $fila["eje_modulo"];
    $fil_ta = $fila["fil_ta"];


    $d = time();
    $sql = "INSERT INTO seguimiento(fil_nemo, seg_numero, seg_fecha, seg_seguridad, fil_codigo, eje_codigo, eje_modulo, seg_llamado, seg_seguimiento, seg_fecllamada, seg_fecatencion, seg_fecfinatencion, seg_atendido)
                VALUES ('$nemo', '$ut', CURRENT_TIMESTAMP, '$token', $fil_codigo, 0, 0, 0,0, null, null, null, 0)";

    mysqli_query($link, $sql);
    
    $https_user      = $cfg->getMobile_username();
    $mobile_password = $cfg->getMobile_password();
    $nemo = $cfg->getMobile_enterprisId().  "."  .$nemo;
    
    
    $h = header('Content-Type: text/html; charset=UTF-8');
    $url1 = $cfg->getMobile_server_secondary()."/create?nemo=$nemo&user=$https_user&password=$mobile_password&fil_ut=$ut&fil_ta=$fil_ta&seg_seguridad=$token&fil_codigo=$fil_codigo";
    $seg_remoto = file_get_contents($url1, false);
        
    $urlCodigo = $token ."-". $seg_remoto;
    echo $ut.":". $urlCodigo;
    
    $url = $cfg->getMobile_server_display() . "?codigoManual=$urlCodigo";
    QRcode::png($url, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    
    
} else {
    echo "ERROR: Estimado cliente, le informmos que la jornada de atención a finalizado por el dia de hoy.";
}
mysqli_close($link);