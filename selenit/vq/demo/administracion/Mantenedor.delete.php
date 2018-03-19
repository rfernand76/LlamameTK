<?php
    $name = $_GET['name']; 
    $valueList = $_GET['valueList']; 
    $pk = $_GET['pk']; 

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
    $sql = "delete FROM $name where $pk in($valueList)";
    mysql_query($sql);
    mysql_close($link);
    echo "OK";
?>

