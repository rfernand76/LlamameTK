<?php 
    @session_start();
    $_SESSION['usuario']  = '';
    $_SESSION['password'] = '';
    $_SESSION['usu_codigo'] = '';
    include("../global/autentica.php");
?>
