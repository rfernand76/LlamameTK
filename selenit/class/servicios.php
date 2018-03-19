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
		$pdo = $this->openDB();
		$ip = $this->getIP();

		$dao = new daoServicios();

		$id = isset($_SESSION['id']);
		if ($id) 
		{
			$id = $dao->registaVisita($pdo, $ip);

			$_SESSION[$ip] = $ip;
			$_SESSION['id'] = $id;
		}

		$url = $_SERVER['REQUEST_URI'];
		$dao->registraRecurso($pdo, $ip, $url);
		//mysql_close($link);
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
		$pdo = new PDO('mysql:host=localhost;dbname=selenit_produccion', 'selenit_root', 'selenit5566');
		
		return $pdo;
	}
}
   
?>
