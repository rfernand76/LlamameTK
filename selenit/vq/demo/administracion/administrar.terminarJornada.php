<?php  
    include("../global/virtualQueueIni.php");
    $cfg = VirtualQueueIni::getInstance();
    $link = mysql_connect($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword());
    if (!$link) {
        die('Not connected : ' . mysql_error());
    }
    $db_selected = mysql_select_db($cfg->getDatabase(), $link);

    $sql = "update fila set fil_ut = 0, fil_ta = 0, eje_modulo = '--'";
    mysql_query($sql);

    $sql = "update pausa set pau_fin = CURRENT_TIMESTAMP() where pau_fin = 0";
    mysql_query($sql);

    $sql = 
      'INSERT INTO seguimiento_hist 
       (seg_codigo, fil_codigo, fil_nemo, seg_numero, eje_codigo, seg_fecha, seg_fecllamada, seg_llamado, seg_seguridad, seg_seguimiento, seg_fecatencion, seg_atendido, seg_fecfinatencion
      ) 
      SELECT seg_codigo, fil_codigo, fil_nemo, seg_numero, eje_codigo, seg_fecha, seg_fecllamada, seg_llamado, seg_seguridad, seg_seguimiento, seg_fecatencion, seg_atendido, seg_fecfinatencion
      FROM seguimiento';

    mysql_query($sql);

    $sql = "delete from seguimiento";
    mysql_query($sql);

    $sql = "delete from jornada";
    mysql_query($sql);

    mysql_close($link);
?>
