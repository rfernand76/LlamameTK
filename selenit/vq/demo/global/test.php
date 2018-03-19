<?php 

    include("../global/virtualQueueIni.php");
    $cfg = VirtualQueueIni::getInstance();
    echo $cfg->getServer()."/";
    echo $cfg->getUsername()."/";
    echo $cfg->getPassword()."/";
    echo $cfg->getDatabase()."/";

?>
