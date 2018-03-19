<table class="tabla" id="tabla" class="ui-corner-all " cellspacing="0"  cellpadding="0">
                <tr class="header">
                    <td align="center" class="ui-corner-top ui-state-active">Modulo</td>
                    <td align="center" class="ui-corner-top ui-state-active">Turno</td>
                </tr>


                <?php 
                    include("../global/virtualQueueIni.php");
                    $cfg = VirtualQueueIni::getInstance();
		            $link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());

                    $sql = "select fil_nemo, fil_ta, eje_modulo from fila";
                    $query = mysqli_query($link, $sql);

	                while ($fila = mysqli_fetch_array($query))
	                {
                        $numero = $fila["fil_nemo"]. " ". $fila["fil_ta"];
		                echo 
                            '<tr class="muestra">'.
                            '<td align="center" class="ui-tabs-tab ui-state-default ui-tab ui-tabs-active">'.$fila["eje_modulo"].'</td>'.
                            '<td align="center" class="ui-tabs-tab ui-state-default ui-tab ui-tabs-active">'.$numero.'</td></tr>';
	                }
                    mysqli_close($link);
                ?>
</table>
