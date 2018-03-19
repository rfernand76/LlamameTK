<?php 
	include("../global/virtualQueueIni.php");

   class Servicio
   {
	//La finalidad de este netodo es registrar la conexion de un usuario
	function getIP() {
		if (isset($_SERVER)) {
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				return $_SERVER['REMOTE_ADDR'];
			}
		} else {
			if (isset($GLOBALS['HTTP_SERVER_VARS']['HTTP_X_FORWARDER_FOR'])) {
				return $GLOBALS['HTTP_SERVER_VARS']['HTTP_X_FORWARDED_FOR'];
		} else {
			return $GLOBALS['HTTP_SERVER_VARS']['REMOTE_ADDR'];
			}
		}
	}
	
	//patron singleton
	static function getInstance(){
		return new Servicio();
	}
	
	function registaVisita() {
		$link = $this->openDB();
		$ip = $this->getIP();
		$dao = new daoServicios();
		$id = 1;

		if ($_SESSION[$ip] == null) 
		{
			$id = $dao->registaVisita($link, $ip);
			$_SESSION[$ip] = $ip;
			$_SESSION['id'] = $id;
		}else{
			$id = $_SESSION['id'];
		}

		if($id == null){
			$id = -1;
		}


		$url = $_SERVER['REQUEST_URI'];
		$dao->registraRecurso($link, $id, $url);
		mysqli_close($link);

    }
	
	function ejecuta($sql){
		$link = $this->openDB();
		$dao = new daoServicios();
		
		if ($_SESSION[$ip] == null) 
		{
			$dao->ejecuta($link, $sql);
		}
		
		mysqli_close($link);
	}
	
	function openDB(){
    	$cfg = VirtualQueueIni::getInstance();
    	$link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());

				
		return $link;
	}
}
   
?>
