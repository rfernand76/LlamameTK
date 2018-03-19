<?php 
	class daoServicios{
		function registaVisita($pdo, $ip){

			//$sql = "INSERT INTO visitas (fecha, ip) VALUES(CURRENT_TIMESTAMP(), ?)";
			//mysql_query($sql);
			//return mysql_insert_id();

			$sql = "INSERT INTO visitas (fecha, ip) VALUES(CURRENT_TIMESTAMP(), ?)";
			$sentencia = $pdo->prepare($sql);
			$sentencia->execute(array($ip));

			return $pdo->lastInsertId();
		}

		function registraRecurso($pdo, $id, $url){
			$sql = "INSERT INTO visitas_url (id, url, fecha) VALUES(?, ?, CURRENT_TIMESTAMP());";
			$sentencia = $pdo->prepare($sql);
			$sentencia->execute(array($id, $url));
		}
		
		function consultaEjemplos($pdo){
			$sql = "SELECT formato, nombre, id FROM ejemplos";
			//$result = mysql_query($sql);

			return $result;
		}
		
		function consultaFormatoEjemplos($pdo, $id){
			$sql = "SELECT nombre, formato FROM ejemplos where id= $id";
			//$result = mysql_query($sql);

			return $result;
		}
		
		function ejecuta($pdo, $sql){
			//mysql_query($sql);
		}
	}
?>
