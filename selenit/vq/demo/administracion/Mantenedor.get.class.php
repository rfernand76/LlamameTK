<?php
	

	$page = isset($_POST['page']) ? $_POST['page'] : 1; 
	$rp = isset($_POST['rp']) ? $_POST['rp'] : 10; 
	$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : ''; 
	$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : ''; 
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

                            $campos = "";
                            foreach($parametros->colModel as $key => $value) {
                               $campos = $campos .$value->name. ',';
                            }
                            $campos = $campos. "''";

                            $where = "";
		                    if($_POST['query']!=''){
			                    $where = "WHERE `".$_POST['qtype']."` LIKE '%".$_POST['query']."%' ";
		                    } else {
			                    $where ='';
		                    }
		                    if($_POST['letter_pressed']!=''){
			                    $where = "WHERE `".$_POST['qtype']."` LIKE '".$_POST['letter_pressed']."%' ";	
		                    }
		                    if($_POST['letter_pressed']=='#'){
			                    $where = "WHERE `".$_POST['qtype']."` REGEXP '[[:digit:]]' ";
		                    }


                            $sql = "select count(1) c from $parametros->name $query";
                            $result = mysql_query($sql);
                            $fila = mysql_fetch_assoc($result);
                            $totalRegistros = $fila["c"];

                            $order = "";
                            if($sortname != ''){
                                $order = "order by $sortname $sortorder $query";
                            }

                            $sql = "select $campos from $parametros->name $order limit $inicio, $fin";
		                    $result = mysql_query($sql);

                            $jsonData = array('sql'=>$sql,'page'=>$page,'total'=>$totalRegistros,'rp'=>$rp,'rows'=>array());
	                        while ($fila = mysql_fetch_assoc($result))
	                        {
                                $list = array();
                                foreach($parametros->colModel as $key => $value) {
                                  $v = $fila[$value->name];
                                  array_push($list, $v);
                                }
                                
	                            $entry = array('cell' => $list); 

	                            $jsonData['rows'][] = $entry;
	                        }
                mysql_close($link);

	echo json_encode($jsonData); 
?>
