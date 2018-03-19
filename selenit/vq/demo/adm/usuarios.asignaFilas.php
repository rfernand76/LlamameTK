<?php  
    include("../global/virtualQueueIni.php");
    $cfg = VirtualQueueIni::getInstance();
    $link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());


    $lista=$_GET["lista"];
    $usuario=$_GET["usuario"];
    $a = explode(",", $lista);

    $sql = "delete from usu_fila where usu_codigo = ".$usuario;
    mysqli_query($link, $sql);

    for($i = 0; $i < count($a); $i++ ){
        $sql = "INSERT INTO usu_fila (usu_codigo, fil_codigo) VALUES ($usuario, $a[$i])";
        mysqli_query($link, $sql);
    }

    mysqli_close($link);

?>
