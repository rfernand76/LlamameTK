<?php  
    include("../global/virtualQueueIni.php");
    $cfg = VirtualQueueIni::getInstance();
    $link = mysql_connect($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword());
    if (!$link) {
        die('Not connected : ' . mysql_error());
    }
    $db_selected = mysql_select_db($cfg->getDatabase(), $link);
    $usuario=$_GET["usuario"];

    $sql = "SELECT par_valor FROM parametro where par_grupo= 1 and par_nombre = 'password_reset'";

    $result = mysql_query($sql);
    $fila = mysql_fetch_assoc($result);
    $password  = $fila["par_valor"];

    $sql = "UPDATE usuario SET usu_password = '$password' WHERE usu_codigo =$usuario";
    mysql_query($sql);

    mysql_close($link);
?>
