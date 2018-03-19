<?php  
    include("../global/virtualQueueIni.php");
    $cfg = VirtualQueueIni::getInstance();
    $link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());

    if (!$link) {
        die('Not connected : ' . mysql_error());
    }

    $sql = "update fila set fil_ut = 0, fil_ta = 0, eje_modulo = '--'";
    $query = mysqli_query($link, $sql);


    $sql = "update pausa set pau_fin = CURRENT_TIMESTAMP() where pau_fin = 0";
    mysqli_query($link, $sql);

    $sql = 
      'INSERT INTO seguimiento_hist 
       (seg_codigo, fil_codigo, fil_nemo, seg_numero, eje_codigo, seg_fecha, seg_fecllamada, seg_llamado, seg_seguridad, seg_seguimiento, seg_fecatencion, seg_atendido, seg_fecfinatencion
      ) 
      SELECT seg_codigo, fil_codigo, fil_nemo, seg_numero, eje_codigo, seg_fecha, seg_fecllamada, seg_llamado, seg_seguridad, seg_seguimiento, seg_fecatencion, seg_atendido, seg_fecfinatencion
      FROM seguimiento';

    mysqli_query($link, $sql);

    $sql = "delete from seguimiento";
    mysqli_query($link, $sql);

    $sql = "delete from jornada";
    mysqli_query($link, $sql);

    mysqli_query($link, $sql);
?>
