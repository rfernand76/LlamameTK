<?php  
    include("../global/virtualQueueIni.php");
    $cfg = VirtualQueueIni::getInstance();
    $link = mysql_connect($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword());
    if (!$link) {
        die('Not connected : ' . mysql_error());
    }
    $db_selected = mysql_select_db($cfg->getDatabase(), $link);

    $cantidadReserva = $_GET["cantidadReserva"];
    $cantidadFilas = $_GET["cantidadFilas"];
    $codigo = $_GET["codigo"];
    
    $a = explode(":", $codigo);
    $fil_codigo = $a[0];
    $nemo = $a[1];
    
    if($cantidadFilas == "" || $cantidadReserva == ""){
        echo "ERROR: Problema interno, no se han especificado todos los parámetros.";
        return;
    }
    
    
    $sql = "select fil_ut, fil_ta, fil_nombre, eje_modulo, fil_nemo from fila where fil_codigo = $fil_codigo";
    $result = mysql_query($sql);
    $fila = mysql_fetch_assoc($result);
    $ut = $fila["fil_ut"];
    $ta = $fila["fil_ta"];
    $inicio = $ut;
    $fil_nombre = $fila["fil_nombre"];
    $eje_modulo = $fila["eje_modulo"];
    $fil_nemo   = $fila["fil_nemo"];
            
    /// genera seguimientos locales
    $tokensList = "";
    for ($i = 0; $i < $cantidadReserva; $i++) {
        $token = rand();
        $tokensList = $tokensList . ":" . $token;
        $ut++;
        $sql = "INSERT INTO seguimiento(fil_nemo, seg_numero, seg_fecha, seg_seguridad, fil_codigo)
                VALUES ('$nemo', '$ut', CURRENT_TIMESTAMP(), '$token', $fil_codigo)";
        
        mysql_query($sql);
        $seg_codigo = mysql_insert_id();
    }
    
    // actualiza fila
    $sql = "UPDATE fila SET fil_ut=$ut WHERE fil_codigo='$fil_codigo'";
    mysql_query($sql);

    /// genera seguimientos remotos
    $nemotecnico = $cfg->getMobile_enterprisId() . ".". $nemo;
    $data = array (
     'nemo'          => $nemotecnico
    ,'fil_nombre'    => $fil_nombre
    ,'eje_modulo'    => $eje_modulo
    ,'fil_ta'        => $ta
    ,'inicio'        => $inicio
    ,'cantidad'      => $cantidadReserva
    ,'fil_codigo'    => $fil_codigo
    ,'seg_seguridad' => $tokensList
    );
    
    $body = http_build_query($data);
    
    $https_user      = $cfg->getMobile_username();
    $mobile_password = $cfg->getMobile_password();

    $h = header('Content-Type: text/html; charset=UTF-8');
            
    $opts = array (
        'http' => array (
            'method' => 'POST',
            'header'=> $h,
            'content' => $body
            )
        );

    $url1 = $cfg->getMobile_server_primary() . "/reservaFolios.php";
    $context  = stream_context_create($opts);
    $seg_remoto = file_get_contents($url1, false, $context);
    
    if($cfg->getMobile_server_secondary != ""){
        $url1 = $cfg->getMobile_server_secondary() . "/reservaFolios.php";
        file_get_contents($url1, false, $context);
    }

    echo '{"status": "OK", "fil_nombre": "'.$fil_nombre.'", "fil_nemo": "'.$nemotecnico.'", "seg_remoto":"'.$seg_remoto.'", "tokensList": "'.$tokensList.'", "fil_ta": "'.$fil_ta.'", "inicio": "'.$inicio.'", "cantidadReserva": "'.$cantidadReserva.'", "letra":"'.$nemo.'"}';
    mysql_close($link);
?>