<p>Seleccione las filas que desea asignar</p>

<table class="tabla" id="tabla" cellspacing="0"  cellpadding="0">
<tr><td>Privilegio</td><td align="center">Acceso</td></tr>
<?php  
    include("../global/virtualQueueIni.php");
    $cfg = VirtualQueueIni::getInstance();
    $link = mysql_connect($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword());
    if (!$link) {
        die('Not connected : ' . mysql_error());
    }
    $db_selected = mysql_select_db($cfg->getDatabase(), $link);
    $usuario=$_GET["usuario"];

    $sql = 
    "SELECT f.fil_codigo, f.fil_nombre, uf.usu_codigo 
    FROM fila f LEFT JOIN usu_fila uf ON f.fil_codigo = uf.fil_codigo and uf.usu_codigo =".$usuario;
    $result = mysql_query($sql);

	while ($fila = mysql_fetch_assoc($result))
	{
        $usu_codigo  = $fila["usu_codigo"];
        $checked = "";
        if($usu_codigo != null){
            $checked = "checked";
        }
        
		echo '<tr class="muestra"><td>'.$fila["fil_nombre"].'</td><td align="center"><input type="checkbox"  value="'.$fila["fil_codigo"].'" '.$checked.'/></td></tr>';
	}


    mysql_close($link);
?>
</table>
