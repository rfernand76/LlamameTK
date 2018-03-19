<?php
    include("../global/virtualQueueIni.php");

    $letra=$_GET["letra"];  
    $numero=$_GET["numero"];
    $nomFila=$_GET["nomFila"];
    $a = explode(":", $numero);
    $primary = $_GET["primary"];
    
    $cfg = VirtualQueueIni::getInstance();
    $mobile_Follow = $cfg->getMobile_Follow();

    $comando = "java -jar JavaPrint.jar \"$nomFila\" \"$letra $a[0]\" \"$a[1]\" \"$primary\" $mobile_Follow";
    //echo $comando;
    system($comando, $retval);
    sleep(2);
?>
