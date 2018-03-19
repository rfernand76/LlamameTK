<?php 
    $usuario=$_POST["usuario"];
    $password=$_POST["password"];
    if($usuario == "" || $password == ""){
        include("../global/autentica.php");
    }else{
        include("../global/virtualQueueIni.php");
        $cfg = VirtualQueueIni::getInstance();

	    $link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());

	    if (!$link) {
            die('Not connected : ' . mysql_error());
        }


        $sql = 
        "SELECT u.usu_nombres, u.usu_codigo ".
        "FROM usuario u, per_usu pu, perfil p ".
        "where  ".
        "    u.usu_codigo = pu.usu_codigo ".
        "    and pu.per_codigo = p.per_codigo ".
        "    and p.per_nombre = 'ADMINISTRADOR' ".
        "    and u.usu_usuario = '$usuario' ".
        "    and u.usu_password = '$password' ";

        $query = mysqli_query($link, $sql);
        $fila = mysqli_fetch_array($query);

        $eje_nombre = $fila["usu_nombres"];
        $eje_codigo = $fila["usu_codigo"];

        if($eje_nombre == ""){
            include("../global/autentica.php");
        }else{
            include("administracion.php");
        }

        mysqli_close($link);
    }
?>




    
