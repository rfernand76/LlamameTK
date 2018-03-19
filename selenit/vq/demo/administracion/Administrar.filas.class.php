<?php
	

	$page = isset($_POST['page']) ? $_POST['page'] : 1; 
	$rp = isset($_POST['rp']) ? $_POST['rp'] : 10; 
	$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'cif'; 
	$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc'; 
	$query = isset($_POST['query']) ? $_POST['query'] : ""; 
	$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : ""; 

    $jsonStr = isset($_POST['jsonStr']) ? $_POST['jsonStr'] : ''; 
    $parametros = json_decode($jsonStr);
    $inicio = ($page*$rp)-$rp;
    $fin=     ($inicio)+$rp;
	

    include("../global/virtualQueueIni.php");
    $cfg = VirtualQueueIni::getInstance();
	$link = mysql_connect('', $cfg->getUsername(), $cfg->getPassword());

		            if (!$link) {
			            die('Not connected : ' . mysql_error());
		            }
		
		            // make foo the current db
		            $db_selected = mysql_select_db($cfg->getDatabase(), $link);
		            if (!$db_selected) {
			            die ('Can\'t use foo : ' . mysql_error());
		            }

                            $sql = "select count(1) c from fila";
                            $result = mysql_query($sql);
                            $fila = mysql_fetch_assoc($result);
                            $totalRegistros = $fila["c"];

                            $order = "";
                            if($sortname != ''){
                                $order = "order by $sortname $sortorder $query";
                            }

                            $sql = "select fil_nombre, fil_ut, fil_ta from fila $order limit $inicio, $fin";
		                    $result = mysql_query($sql);

                            $jsonData = array('sql'=>$sql,'page'=>$page,'total'=>$totalRegistros,'rp'=>$rp,'rows'=>array());
	                        while ($fila = mysql_fetch_assoc($result))
	                        {
                                $list = array($fila["fil_nombre"], $fila["fil_ut"], $fila["fil_ta"]);
                                
	                            $entry = array('cell' => $list); 

	                            $jsonData['rows'][] = $entry;
	                        }
                mysql_close($link);

	echo json_encode($jsonData); 
?>
