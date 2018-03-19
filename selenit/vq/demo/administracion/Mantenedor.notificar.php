<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include("../global/virtualQueueIni.php");
$cfg = VirtualQueueIni::getInstance();


$p = $_SERVER['QUERY_STRING'];
/*$data = $_GET["data"];
$parametros = json_decode($data);

$parametros->nemo_empresa = $cfg->getMobile_enterprisId();
$parametros->username = $cfg->getMobile_username();
$parametros->username = $cfg->getMobile_password();*/

$datosExtras = "&usuario=".$cfg->getMobile_username().
               "&password=".$cfg->getMobile_password().
               "&enterprisId=".$cfg->getMobile_enterprisId();


$url1 = "http://54.94.203.188:8888/actualizaParametro?".$p.$datosExtras;
$r = file_get_contents($url1, false);
echo "$r";


?>
