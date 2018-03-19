	<?php  
        include("../global/virtualQueueIni.php");
        $cfg = VirtualQueueIni::getInstance();
    
	    $link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());

	
		$accion=$_GET["accion"];
        $eje_codigo=$_GET["eje_codigo"];

        if($accion == "Pausar"){
		$sql =  "INSERT INTO pausa(".
                "eje_codigo, pau_inicio".
                ")".
                "VALUES (".
                "'$eje_codigo', CURRENT_TIMESTAMP() ".
                ")";

            mysqli_query($link, $sql);

            $pau_codigo = mysqli_insert_id($link);
            echo $pau_codigo;
        }else{
            $pau_codigo=$_GET["pau_codigo"];
            
		    $sql = "UPDATE pausa SET pau_fin = CURRENT_TIMESTAMP() where pau_codigo = '$pau_codigo'";
		    mysqli_query($link, $sql);

        }

        mysqli_close($link);
	?>
