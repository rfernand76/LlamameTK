<?php  
    include("../global/virtualQueueIni.php");
    $cfg = VirtualQueueIni::getInstance();
    $link = mysql_connect($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword());
    if (!$link) {
        die('Not connected : ' . mysql_error());
    }
    $db_selected = mysql_select_db($cfg->getDatabase(), $link);
    $estado=$_GET["estado"];

    $sql = "select jor_codigo from jornada where jor_fecha = curdate()";
    $result = mysql_query($sql);
    $fila = mysql_fetch_assoc($result);
    $jor_codigo = $fila["jor_codigo"];

    if($jor_codigo == ""){
        $sql = "INSERT INTO jornada (jor_fecha, jor_inicio, jor_estado) VALUES (curdate(), CURTIME(), $estado);";
        mysql_query($sql);
        $jor_codigo = mysql_insert_id();
    }else{
        if($estado == 0){
            //cerrar
            $sql = "UPDATE jornada SET jor_estado = $estado, jor_fin = CURTIME() WHERE jor_codigo = $jor_codigo;";
            mysql_query($sql);
            
        }else{
            //abrir
            $sql = "UPDATE jornada SET jor_estado = $estado, jor_inicio = CURTIME(), jor_fin=null WHERE jor_codigo = $jor_codigo;";
            mysql_query($sql);
        }
    }

    $sql = 
      'INSERT INTO jornada_hist (jor_codigo, joh_hora, jor_fecha, jor_inicio, jor_fin, jor_estado) 
      SELECT jor_codigo, CURTIME(), jor_fecha, jor_inicio, jor_fin, jor_estado
      FROM jornada where jor_codigo ='.$jor_codigo;
    mysql_query($sql);

    mysql_close($link);
?>
