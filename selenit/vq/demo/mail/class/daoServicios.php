<?php 
	class daoServicios{
		function registaVisita($link, $ip){
			$sql = "INSERT INTO visitas (fecha, ip) VALUES(CURRENT_TIMESTAMP(), '$ip')";
			mysql_query($sql);
			return mysql_insert_id();
		}

		function registraRecurso($link, $id, $url){
			$sql = "INSERT INTO visitas_url (id, url, fecha) VALUES($id, '$url', CURRENT_TIMESTAMP());";
			mysql_query($sql);
		}
		
		function consultaEjemplos($link){
			$sql = "SELECT formato, nombre, id FROM ejemplos";
			$result = mysql_query($sql);

			return $result;
		}
		
		function consultaFormatoEjemplos($link, $id){
			$sql = "SELECT nombre, formato FROM ejemplos where id= $id";
			$result = mysql_query($sql);

			return $result;
		}
		
		function ejecuta($link, $sql){
			mysql_query($sql);
		}
	}
?>
