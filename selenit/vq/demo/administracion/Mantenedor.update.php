<?php
    $parametros = $_GET['parametros']; 
    $jsonStr = json_decode($parametros);


    $sSet = "";
    $sWhere = "";
    
    foreach($jsonStr->colModel as $key => $value) {
        if(!($value->pk == false)){
            $sWhere = $sWhere . $value->name .'='. $value->value . ' AND ';
        }else{
            $sSet = $sSet . $value->name .'="'. $value->value . '",';
        }
    }
    $sWhere = substr($sWhere, 0, strlen($sWhere)-4);
    $sSet = substr($sSet, 0, strlen($sSet)-1);
    

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
    $sql = "update $jsonStr->name set $sSet where $sWhere";

    mysql_query($sql);
    $errno   = mysql_errno(); 
    $errdes   = mysql_error(); 
    mysql_close($link);

    if($errno == ""){
        echo '{"status": "OK"}';
    }else{
        echo '{"status": "ERROR", "errno": "'.$errno.'","errdes":"'.$errdes.'"}';
    }
?>

