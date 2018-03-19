<?php 
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
		mysql_close($link);
    }
	
	function consultaEjemplos(){
		$link = $this->openDB();
		$dao = new daoServicios();
		return $dao->consultaEjemplos($link);
	}
	
	function consultaFormatoEjemplos($id){
		$link = $this->openDB();
		$dao = new daoServicios();
		return $dao->consultaFormatoEjemplos($link, $id);
	}

	function ejecuta($sql){
		$link = $this->openDB();
		$dao = new daoServicios();
		
		if ($_SESSION[$ip] == null) 
		{
			$dao->ejecuta($link, $sql);
		}
		
		mysql_close($link);
	}
	
	function openDB(){
		$link = mysql_connect('', 'selenit_root', 'selenit5566');
		if (!$link) {
			die('Not connected : ' . mysql_error());
		}
		
		// make foo the current db
		$db_selected = mysql_select_db('selenit_produccion', $link);
		if (!$db_selected) {
			die ('Can\'t use foo : ' . mysql_error());
		}
		
		return $link;
	}
}
   
?>
