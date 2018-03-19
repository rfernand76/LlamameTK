    <?php

include("../global/virtualQueueIni.php");
$cfg = VirtualQueueIni::getInstance();
$link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());


$nemo = $_GET["nemo"];
$modulo = $_GET["modulo"];
$eje_codigo = $_GET["eje_codigo"];

$sql = "select fil_ta, fil_ut from fila WHERE fil_nemo='$nemo'";
$query = mysqli_query($link, $sql);
$fila = mysqli_fetch_array($query);
$fil_ta = $fila["fil_ta"];
$fil_ut = $fila["fil_ut"];
$seg_codigo = "";

if ($fil_ta < $fil_ut) {
    
    $key     = ftok(__FILE__,'m');
    $a        = sem_get($key);
    sem_acquire($a);
    //seccion semaforizada
    //$sql = "SELECT min(seg_numero) proximo, seg_codigo  FROM seguimiento WHERE fil_nemo = '$nemo' and seg_llamado = 0";
    //$sql = "SELECT min(seg_numero) proximo, seg_codigo  FROM seguimiento WHERE fil_nemo = '$nemo' and seg_llamado = 0";
    $sql = "SELECT min(seg_codigo) as seg_codigo FROM seguimiento WHERE fil_nemo = '$nemo' and seg_llamado = 0";


    $query = mysqli_query($link, $sql);
    $fila = mysqli_fetch_array($query);
    $seg_codigo = $fila["seg_codigo"];

    $sql = "SELECT seg_numero as proximo FROM seguimiento WHERE seg_codigo = $seg_codigo";

    $query = mysqli_query($link, $sql);
    $fila = mysqli_fetch_array($query);
    $fil_ta = $fila["proximo"];
    $a = false;

    if (fil_ta != "") {
        $sql = "UPDATE fila SET fil_ta=$fil_ta, eje_modulo='$modulo' WHERE fil_nemo='$nemo'";
        mysqli_query($link, $sql);

        $sql = "UPDATE seguimiento SET eje_codigo = '$eje_codigo', seg_fecllamada = CURRENT_TIMESTAMP(), seg_llamado = 1 where seg_codigo = '$seg_codigo'";
        mysqli_query($link, $sql);

        if ($cfg->getMobile_Follow() == 1) {
            $h = header('Content-Type: text/html; charset=UTF-8');
            
            $nemo = $cfg->getMobile_enterprisId() . ".". $nemo;
            $https_user      = $cfg->getMobile_username();
            $mobile_password = $cfg->getMobile_password();
            
            $url1 = $cfg->getMobile_server_secondary().
            "/update?nemo=$nemo&user=$https_user&password=$mobile_password&eje_modulo=$modulo&fil_ut=$ut&fil_ta=$fil_ta";
            file_get_contents($url1, false);
        }
    }
} else {
    $fil_ta = '--';
    $fil_ut = '--';
}
echo $fil_ta . "." . $seg_codigo;
mysqli_close($link);

?>
