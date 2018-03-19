<?php  
    include("../global/virtualQueueIni.php");
    $cfg = VirtualQueueIni::getInstance();
    $link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());

    $usuario=$_GET["usuario"];

    $sql = "SELECT par_valor FROM parametro where par_grupo= 1 and par_nombre = 'password_reset'";

    $query = mysqli_query($link, $sql);
    $fila = mysqli_fetch_array($query)
    $password  = $fila["par_valor"];

    $sql = "UPDATE usuario SET usu_password = '$password' WHERE usu_codigo =$usuario";
    mysqli_query($link, $sql);


    mysqli_close($link);

?>
