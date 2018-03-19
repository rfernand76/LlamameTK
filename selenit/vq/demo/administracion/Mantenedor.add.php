<?php
    $parametros = $_GET['parametros']; 

    $jsonStr = json_decode($parametros);
    $campos = "";

    $campos = "";
    $values = "";
    
    foreach($jsonStr->colModel as $key => $value) {
        if(!($value->pk == true)){
            $campos = $campos .$value->name. ',';
            $values = $values ."'".$value->value. "',";
        }
    }
    $campos = substr($campos, 0, strlen($campos)-1);
    $values = substr($values, 0, strlen($values)-1);
    

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
    $sql = "insert into $jsonStr->name ($campos) values($values)";
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

