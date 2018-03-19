<?php 
    include("../global/virtualQueueIni.php");
    include("../global/Service.php");

    $service = Service::getInstance();
    if($service->isLoggin()){
        $HORA_COMIENZO  = $POST["HORA_COMIENZO"];

        $estadisticasJornada = $service->estadisticasJornada($HORA_COMIENZO);
        echo json_encode($estadisticasJornada); 
        mysqli_close($link);
    }else{
        echo "Error, la session se ha perdido"; 
    }
?>
