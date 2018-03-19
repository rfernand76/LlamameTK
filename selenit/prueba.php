    <?php  

    
	try{
		

	    if(@session_start() == false){
			//session_destroy();
			session_start();
			echo 'session_start()\n';

	    	}

		ini_set('display_errors', 1);
		error_reporting(E_ALL);

		phpinfo();

		//$pdo = new PDO('mysql:host=localhost;dbname=selenit_produccion', 'selenit_root', 'selenit5566');
		$link = mysql_connect('selenit_root', 'selenit5566');

		$sql = "INSERT INTO visitas (fecha, ip) VALUES(CURRENT_TIMESTAMP(), 'Prueba11')";
		mysql_query($sql);

	} catch (Exception $e) {
		echo 'Excepción capturada: ',  $e->getMessage(), "\n";
	}

    ?>

hola mundo
