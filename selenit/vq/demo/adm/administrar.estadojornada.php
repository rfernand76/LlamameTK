<?php  
    include("../global/virtualQueueIni.php");
    $cfg = VirtualQueueIni::getInstance();
    $link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());

    if (!$link) {
        die('Not connected : ');
    }
    $estado=$_GET["estado"];

    $sql = "select jor_codigo from jornada where jor_fecha = curdate();";

    $query = mysqli_query($link, $sql);
    $fila = mysqli_fetch_array($query);
    $jor_codigo = $fila["jor_codigo"];

    if($jor_codigo == ""){
        $sql = "INSERT INTO jornada (jor_fecha, jor_inicio, jor_estado) VALUES (curdate(), CURTIME(), $estado);";
        mysqli_query($link, $sql);

        //$jor_codigo = mysql_insert_id();
        $jor_codigo   = $link->insert_id;
    }else{
        if($estado == 0){
            //cerrar
            $sql = "UPDATE jornada SET jor_estado = $estado, jor_fin = CURTIME() WHERE jor_codigo = $jor_codigo;";
            mysqli_query($link, $sql);
            
        }else{
            //abrir
            $sql = "UPDATE jornada SET jor_estado = $estado, jor_inicio = CURTIME(), jor_fin=null WHERE jor_codigo = $jor_codigo;";
            mysqli_query($link, $sql);
        }
    }

    $sql = 
      'INSERT INTO jornada_hist (jor_codigo, joh_hora, jor_fecha, jor_inicio, jor_fin, jor_estado) 
      SELECT jor_codigo, CURTIME(), jor_fecha, jor_inicio, jor_fin, jor_estado
      FROM jornada where jor_codigo ='.$jor_codigo;

    mysqli_query($link, $sql);

?>
