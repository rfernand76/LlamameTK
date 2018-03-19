<p>Seleccione los privilegios que desea asignar</p>

<table class="tabla" id="tabla" cellspacing="0"  cellpadding="0">
<tr><td>Privilegio</td><td align="center">Acceso</td></tr>
<?php  
    include("../global/virtualQueueIni.php");
    $cfg = VirtualQueueIni::getInstance();
    $link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());

    $usuario=$_GET["usuario"];

    $sql = 
    "SELECT p.per_codigo, p.per_nombre, pu.usu_codigo 
    FROM perfil p LEFT JOIN per_usu pu ON p.per_codigo = pu.per_codigo and pu.usu_codigo =".$usuario;
    $query = mysqli_query($link, $sql);

	while ($fila = mysqli_fetch_array($query))
	{
        $usu_codigo  = $fila["usu_codigo"];
        $checked = "";
        if($usu_codigo != null){
            $checked = "checked";
        }
        
		echo '<tr class="muestra"><td>'.$fila["per_nombre"].'</td><td align="center"><input type="checkbox"  value="'.$fila["per_codigo"].'" '.$checked.'/></td></tr>';
	}


    mysqli_close($link);

?>
</table>
