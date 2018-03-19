<!DOCTYPE html>

<html lang="es">
    <head>
        <title>Selenit - Seguimiento de atención</title>
        <meta name="description" content="Seguimiento de atención"/>
        <meta charset="utf-8">
        <meta name="viewport" content="width=500, initial-scale=1">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        
    </head>
    
    <?php 
        include("virtualQueueIni.php");
        $cfg = VirtualQueueIni::getInstance();
        $server = $cfg->getMobile_server_secondary();
    ?>

    <FRAMESET cols="100%">
        <frame src="<?php echo $server."/index.php?".$_SERVER['QUERY_STRING'] ?>">
    </FRAMESET>

</html>
