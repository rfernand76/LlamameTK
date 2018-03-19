    <?php  
    session_start();

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include("class/servicios.php");
    include("class/daoServicios.php");
    include("class/registravisita.php");
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Selenit - Servicios computacionales Integrales</title>
<meta name="keywords" content="SERVICIOS INTEGRALES DE INFORMATICA, CONSULTORIA, DESARROLLO, SOFTWARE, software a medida, servicios computacionales, Desarrollo a la medida, desarrollo aplicaciones, desarrollo de software, sistema, monitoreo, encuestas, java, .net, php, javascript, android, iphone, windows phone, oracle, sybase, sql server, sqlserver, mysql, bea, weblogic, webshere, jboss, tomcat, jquery, jquery ui, jquery mobile"/>
<meta name="description" content="SERVICIOS INTEGRALES DE INFORMATICA, CONSULTORIA, DESARROLLO, SOFTWARE"/>
<meta charset="utf-8">
<link rel="shortcut icon" type="image/x-icon" href="css/images/ico-03.png">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="all">
<script src="js/jquery-1.7.2.min.js"></script>
<!--[if lt IE 9]><script src="js/modernizr.custom.js"></script><![endif]-->
<script src="js/jquery.flexslider-min.js"></script>
<script src="js/functions.js"></script>
</head>
<body>
<!-- wrapper -->
<div id="wrapper">
  <!-- shell -->
  <div class="shell">
    <!-- container -->
    <div class="container">
      <!-- header -->
      
      <header class="header">
        <h1 id="logo"></h1>
	<?php  include("menu.php"); ?>
        <div class="cl">&nbsp;</div>
      </header>
      <!-- end of header -->
