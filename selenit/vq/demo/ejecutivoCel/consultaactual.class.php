	<?php  
        include("../global/virtualQueueIni.php");
        $cfg = VirtualQueueIni::getInstance();
        $link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());



		$nemo=$_GET["nemo"];

        $sql = "select fil_ta, fil_ut from fila WHERE fil_nemo='$nemo'";
		$query = mysqli_query($link, $sql);
        $fila = mysqli_fetch_array($query);

        $fil_ta = $fila["fil_ta"];

        echo $fil_ta;
        mysqli_close($link);

	?>
