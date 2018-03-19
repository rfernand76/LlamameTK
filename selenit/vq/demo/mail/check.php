<?php
$dir = "/var/www/html/selenit/vq/demo/mail/cur/";
//$dir = "/mail/cur/";

$directorio = opendir($dir); //ruta actual
$busqueda="vq.php?id=";
$i = 1;
while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
{
    if (!is_dir($archivo)){
        //echo $archivo;
        $respuesta = file_get_contents($dir.$archivo);
        $iposicion = strpos($respuesta, $busqueda) + 10;
        $fin = strpos($respuesta, '">', $iposicion);
        $correo = substr($respuesta, $iposicion, ($fin - $iposicion));
        
        $error1 = "Subject: Undelivered Mail Returned to Sender";
        $error1 = "Subject: Mail delivery failed: returning message to sender";

        
        //echo $correo;
        $iposicion = strpos($respuesta, $error1);
        if($iposicion > 0){
            //echo ":error1:$i";
        }else{
            $iposicion = strpos($respuesta, $error2);
            if($iposicion > 0){
                
                //echo ":error2:$i";
            }else{
                echo "$correo:OK:$i:[$dir.$archivo]</br>";
            }
        }
        $i++;
    }
}
?>
