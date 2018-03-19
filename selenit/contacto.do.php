    <?php  
    session_start();
    
    include("class/servicios.php");
    include("class/daoServicios.php");
    include("class/registravisita.php");
    try{
		$producto = 5;
		$author = $_GET['author'];
		$email = $_GET['email'];
		$titulo = 'Consulta selenit';
		$mensaje = $_GET['mensaje'];
		$telefono  = $_GET['telefono'];
		$sql = "INSERT INTO contactos (producto, author, correo, telefono, titulo, mensaje, fecha) VALUES('$producto', '$author', '$email', '$telefono', '$titulo', '$mensaje', CURRENT_TIMESTAMP());";
		$servicio->ejecuta($sql);
		
    }catch(Exception $e){
    }

    ?>

