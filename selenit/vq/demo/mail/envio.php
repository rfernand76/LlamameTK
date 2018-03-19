<?php
    include("class/servicios.php");
    include("class/daoServicios.php");
    $servicio = new Servicio();
    $servicio->openDB();

    $x = "";
    $sql = "select par_valor from parametro where par_nombre = 'correos.envio' and par_tipo = 2";
    $result2 = mysql_query($sql);
    $fila2 = mysql_fetch_assoc($result2);
    $x = $fila2["par_valor"];

    if($x == 1){
        $sql = "update parametro set par_valor = 2 where par_nombre = 'correos.envio' and par_tipo = 2";
        mysql_query($sql);

        $correo = file_get_contents("doc/envio.html");
        $titulo = "Selenit - Sistema de Gestión de Filas  ***Gratis**";
        $headers = "MIME-Version: 1.0\r\n"; 
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        //dirección del remitente 
        $headers .= "From: Selenit <info@selenit.cl>\r\n";
        
        $sql = 'select url_id, url_correo2, url_idurl from url_resp  where url_enviado = 0 order by url_id';
        $result = mysql_query($sql);
        $continuar = true;
        while ($continuar){
            $fila = mysql_fetch_assoc($result);

            if($fila){
                $url_id = $fila["url_id"];
                $url_correo2 = $fila["url_correo2"];
                $url_idurl = $fila["url_idurl"];
                $log = "";
            
                $ary = explode(";", $url_correo2);
                foreach ($ary as $para) {
                    $mail = str_replace("{url_idurl}", $para, $correo);

                    $bool = mail($para,$titulo,$mail,$headers);
                    if($bool){
                        $log = $log . "$para :OK\n";
                    }else{
                        $log = $log . "$para :Error\n";
                    }
                }
                $sql = "update url_resp set url_enviado = 1, url_log = '$log', url_fec_envio = CURRENT_TIMESTAMP where url_id = $url_id";
                mysql_query($sql);

                $sql = "select par_valor from parametro where par_nombre = 'correos.envio' and par_tipo = 2";
                $result2 = mysql_query($sql);
                $fila2 = mysql_fetch_assoc($result2);
                $x = $fila2["par_valor"];
                //echo "--".$x."--";
                $continuar = ($x == 2);
            }else{
                $continuar = false;
            }
            //echo "X [$continuar] :$url_id</br>";
        }
        $sql = "update parametro set par_valor = 0 where par_nombre = 'correos.envio' and par_tipo = 2";
        mysql_query($sql);
        echo "FIN!";
    }
    
?>
