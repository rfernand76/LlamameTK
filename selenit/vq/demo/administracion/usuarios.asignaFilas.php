<?php  
    include("../global/virtualQueueIni.php");
    $cfg = VirtualQueueIni::getInstance();
    $link = mysql_connect($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword());
    if (!$link) {
        die('Not connected : ' . mysql_error());
    }
    $db_selected = mysql_select_db($cfg->getDatabase(), $link);
    $lista=$_GET["lista"];
    $usuario=$_GET["usuario"];
    $a = explode(",", $lista);

    $sql = "delete from usu_fila where usu_codigo = ".$usuario;
    mysql_query($sql);
    for($i = 0; $i < count($a); $i++ ){
        $sql = "INSERT INTO usu_fila (usu_codigo, fil_codigo) VALUES ($usuario, $a[$i])";
        mysql_query($sql);
    }

    mysql_close($link);
?>
