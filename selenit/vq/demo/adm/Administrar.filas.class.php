<?php
	

	$page = isset($_POST['page']) ? $_POST['page'] : 1; 
	$rp = isset($_POST['rp']) ? $_POST['rp'] : 10; 
	$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'cif'; 
	$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc'; 
	$squery = isset($_POST['query']) ? $_POST['query'] : ""; 
	$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : ""; 

    $jsonStr = isset($_POST['jsonStr']) ? $_POST['jsonStr'] : ''; 
    $parametros = json_decode($jsonStr);
    $inicio = ($page*$rp)-$rp;
    $fin=     ($inicio)+$rp;

	

    include("../global/virtualQueueIni.php");
    $cfg = VirtualQueueIni::getInstance();
	$link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());


		            if (!$link) {
			            die('Not connected : ' . mysql_error());
		            }
                            $sql = "select count(1) c from fila";
							$query = mysqli_query($link, $sql);
							$fila = mysqli_fetch_array($query);

                            $totalRegistros = $fila["c"];
                            $order = "";
                            if($sortname != ''){
                                $order = "order by $sortname $sortorder $squery";
                            }

                            $sql = "select fil_nombre, fil_ut, fil_ta from fila $order limit $inicio, $fin";
		                    $query = mysqli_query($link, $sql);

                            $jsonData = array('sql'=>$sql,'page'=>$page,'total'=>$totalRegistros,'rp'=>$rp,'rows'=>array());
	                        while ($fila = mysqli_fetch_array($query))
	                        {
                                $list = array($fila["fil_nombre"], $fila["fil_ut"], $fila["fil_ta"]);
	                            $entry = array('cell' => $list); 
	                            $jsonData['rows'][] = $entry;
	                        }
                mysqli_close($link);


	echo json_encode($jsonData); 
?>
