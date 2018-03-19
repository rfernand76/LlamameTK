<?php 

    @session_start();
    $usuario=$_POST["usuario"];
    $password=$_POST["password"];
    $login = false;
    $accion = $_POST["accion"];


    if($usuario == "" || $password == ""){
        $usuario=$_SESSION['usuario'];
        $password=$_SESSION['password'];
    }

    if(($usuario == "" || $password == "") && $accion != "resetear"){
        include("../global/autentica.php");
    }else{
        include("../global/virtualQueueIni.php");
        include("../global/Service.php");
        $cfg = VirtualQueueIni::getInstance();
        //$service = Service::getInstance();



        $link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());
        if (!$link) {
            echo "Error de depuración: " . mysqli_connect_errno() . PHP_EOL;
        }
	
        $sql = 
        "SELECT u.usu_nombres, u.usu_paterno, u.usu_materno, u.usu_codigo ".
        "FROM usuario u, per_usu pu, perfil p ".
        "where  ".
        "    u.usu_codigo = pu.usu_codigo ".
        "    and pu.per_codigo = p.per_codigo ".
        "    and p.per_nombre = '$per_nombre' ".
        "    and u.usu_usuario = '$usuario' ".
        "    and u.usu_password = '$password' ";

        $query = mysqli_query($link, $sql);
        $fila = mysqli_fetch_array($query);


        $eje_nombre = $fila["usu_nombres"];
        $usu_paterno = $fila["usu_paterno"];
        $usu_materno = $fila["usu_materno"];
        $usu_codigo = $fila["usu_codigo"];


        if($eje_nombre == ""){
            if($accion != "resetear"){
                include("../global/autentica.php");
                exit();
            }else{
                 include("../global/resetpassword.php");
                 exit();                
            }
        }else{
            $sql = "SELECT par_valor FROM parametro where par_grupo= 1 and par_nombre = 'password_reset'";
            $query = mysqli_query($link, $sql);
            $fila = mysqli_fetch_array($query);
            $password_reset  = $fila["par_valor"];

            if($password == $password_reset && $accion != "resetear"){
                include("../global/resetpassword.php");
                $login = false;
                exit();
            }else{

                if($accion == "resetear"){
                    $password_new = $_POST["password_new"];
                    $password_confirm = $_POST["password_confirm"];
                    if($password_new == $password_confirm){
                        $sql = "UPDATE usuario SET usu_password = '$password_new' WHERE usu_usuario = '$usuario'";
                        mysqli_query($link, $sql);

                        include("../global/autentica.php");
                        exit();
                    }else{
                        include("../global/resetpassword.php");
                        exit();
                    }
                }else{
                    $login = true;
                }
            }
            $_SESSION['usu_codigo']  = $usu_codigo;
            $_SESSION['eje_nombre']  = $eje_nombre;
            $_SESSION['usu_paterno']  = $usu_paterno;
            $_SESSION['usu_materno']  = $usu_materno;
            $_SESSION['usuario']  = $usuario;
            $_SESSION['password'] = $password;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Virtual Queue - Administracion</title>
<meta name="description" content="Modulo de auto consulta"/>
<meta charset="utf-8">
        <meta name="description" content="Seguimiento de atención"/>
        <meta charset="utf-8">
        <meta name="viewport" content="width=500, initial-scale=1">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <meta name="viewport" content="width=device-width, user-scalable=no">
            
        <script src="/js/jquery-ui-1.9.1.custom/js/jquery-1.8.2.js"></script>
        <link rel="stylesheet" href="../css/style.css?a=6" type="text/css" media="all">
	    <script type="text/javascript">
            //var GLOBAL_VUI_CSS = "dot-luv";
            var GLOBAL_VUI_CSS = "redmond";
            
	    </script>
</head>
<body>
    <div id="wrapper">
      <div id="shell" class="shell">
        <div class="container">
            <header class="header">
              <h1 id="logo"></h1>
              <div class="cl">&nbsp;</div>
            </header>

            <section>
                <div class="personal">
                    <h2 class="ui-widget-header ui-corner-top">Nombre</h2>
                    <p><?php echo "$eje_nombre $usu_paterno $usu_materno";?> </p>
                    <h2 class="ui-widget-header">User</h2>
                    <p><?php echo $usuario;?> <a href="logout.php">Cerrar sesión</a></p>
                <div>
            </section>
        <?php }
    }
?>



