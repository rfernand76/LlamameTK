	<?php  
        include("../global/virtualQueueIni.php");
        $cfg = VirtualQueueIni::getInstance();
    
	    $link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());
		

		$nemo=$_GET["nemo"];
        $modulo=$_GET["modulo"];
        $numero=$_GET["numero"];

		$sql = "UPDATE fila SET fil_ta='$numero', eje_modulo='$modulo' WHERE fil_nemo='$nemo'";
		mysqli_query($link, $sql);

        mysqli_close($link);

	?>
