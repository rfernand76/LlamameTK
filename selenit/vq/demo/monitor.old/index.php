<!DOCTYPE html>
<html lang="en">
<head>
<title>Selenit - Seguimiento de atención</title>
<meta name="description" content="Seguimiento de atención"/>
<meta charset="utf-8">

<link rel="stylesheet" href="style.css?a=<?php echo time()?>" type="text/css" media="all">
<script src="/js/jquery-ui-1.9.1.custom/js/jquery-1.8.2.js"></script>
<script type="text/javascript">
    $(window).load(function() {
        $(window).resize(function(event) {resizePanel(event);});
        init();
    });

    function getWidth()
    {
        var x = 0;
        if (self.innerHeight){
            x = self.innerWidth;
        }else if (document.documentElement && document.documentElement.clientHeight){
            x = document.documentElement.clientWidth;
        }else if (document.body){
            x = document.body.clientWidth;
        }
        return x;
    }

    /*retorna el alto de la pagina*/
    function getHeight()
    {
        var y = 0;
        if (self.innerHeight){
            y = self.innerHeight;
        }else if (document.documentElement && document.documentElement.clientHeight){
            y = document.documentElement.clientHeight;
        }else if (document.body){
            y = document.body.clientHeight;
        }

        return y;
    }

    function init(){
        resizePanel();
        refrescaNumeros();
        refrescaFecha();
        setVideo();
    }

    function refrescaNumeros(){
            var url = "actualiza.php";
            $.ajax(
                {
                    url: url
                }).done(function(result) {
                    $(".modulos").html(result);
                }
             );

        setTimeout(refrescaNumeros,  1*1000);
    }

    function refrescaFecha(){
        var fecha = $("#fecha");
        var d = new Date();
        var hours = d.getHours();
        var minutes = ""+d.getMinutes();
        if(minutes.length < 2){
            minutes = "0"+minutes;
        }
        var dia = d.getDate();
        var nombreDia = getDayName(d);
        var nombreMes = getMonthName(d);

        var html = "<p>"+nombreDia+" "+dia+" de "+nombreMes+"</p><p>"+hours+":"+minutes+"</p>";
        fecha.html(html);
        setTimeout(refrescaFecha,  60*1000);
    }

    function getDayName(dt){
        var d = dt.getDay();
        switch(d) {
            case 0: return "Domingo";
            case 1: return "Lunes";
            case 2: return "Martes";
            case 3: return "Miercoles";
            case 4: return "Jueves";
            case 5: return "Viernes";
            case 6: return "Sabado";
        } 
    }

    function getMonthName(dt){
        var d = dt.getMonth();
        switch(d) {
            case 0: return "Enero";
            case 1: return "Febrero";
            case 2: return "Marzo";
            case 3: return "Abril";
            case 4: return "Mayo";
            case 5: return "Junio";
            case 6: return "Julio";
            case 7: return "Agosto";
            case 8: return "Septiembre";
            case 9: return "Octubre";
            case 10: return "Noviembre";
            case 11: return "Diciembre";
        } 
    }

    function resizePanel(){
            //alert(1);
            var width = getWidth() -500;
            var height = getHeight() -30;

            var publi = $("#publicidad");
            publi.css("width", width+"px");
            publi.css("height", height+"px");
            publi.css("top", "60px");

            var video = $("#video");
            video.css("width", width+"px");
            video.css("height", height+"px");
    }

    function setVideo(){
        var width = getWidth();
        var height = getHeight();

        var video = $("#video");

        var url = "http://www.tvn.cl/envivo/";
        //var url = "http://localhost";

        var html = "<object id='objectVideo' style='position: relative; top:-300px; left:-106px;' width='"+(width-100)+"' height='"+(height-30+200)+"' type='text/html' data='"+url+"'></object>";

        var objHtml = $(html);
        objHtml.appendTo(video);
        

        var tvn = $("#screen-clae3-video");
        tvn.css("width", "100px");

        //var htmlTapaInterior ="<div id='tapaInterior' style='z-index:10; position: relative; left:0px; top:-300px; width: 500px; height:"+height+"px; width:"+width +"px; background-color:blue;'><div>";
        //var objHtml = $(htmlTapaInterior);
        //objHtml.appendTo(video);
    }

</script>


</head>
<bodsy>
    <div class="logo">
        <img src="../css/images/logotipo.png">
    </div>

    <div class="modulos"/></div>

    <div class="fecha" id="fecha"/></div>

    <div id="">
        <div class="publicidad" id="publicidad" style="border:0px solid;">
            <!--video id="video" width="450" height="50" autoplay="autoplay" loop>
            <source src="images/publicidad/sample2.mp4" type="video/mp4">
            <source src="movie.ogg" type="video/ogg">
                    Su navegador no soporta menejo de videos, pongase en contacto con el proveedor.
            </video--> 

        <div id="video">
        </div>

        <!--div id='tapaInterior' style='z-index:10; position: relative; left:0px; top:-112px; width: 800px; height:100px; width:1000px; background-color:#000000;'></div>
        <div id='tapaDerecha' style='z-index:20; position: relative; left:1010px; top:-900px; width: 800px; height:800px; width:1000px; background-color:#000000;'>Adios</div-->

    </div>

</body>
</html>

