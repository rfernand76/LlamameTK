<?php    
    if(@session_start() == false){
	//session_destroy();
	session_start();
    }

    try{
	$servicio = new Servicio();
	$servicio->registaVisita();
    }catch(Exception $e){
        
    }
?>
