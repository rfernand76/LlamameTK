<!DOCTYPE html>
<html lang="en">
<head>
<title>Selenit - Seguimiento de atención</title>
<meta name="description" content="Seguimiento de atención"/>
<meta charset="utf-8">

<link rel="stylesheet" href="style.css?a=<?php echo time()?>" type="text/css" media="all">
<!--link rel="stylesheet" href="/vui2/css/jquiryui/start/jquery-ui.css"-->
<!--link rel="stylesheet" href="/js/css/jquiryui/cupertino/jquery-ui.css"-->
<!--link rel="stylesheet" href="/js/css/jquiryui/dark-hive/jquery-ui.css"-->
<link rel="stylesheet" href="/js/css/jquiryui/dot-luv/jquery-ui.css">

<script src="/js/jquery-ui-1.9.1.custom/js/jquery-1.8.2.js"></script>
<script src="js/monitor/info.json.js"></script>
<script type="text/javascript">
    var alturaTapa = 185; 

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
        refrescaNumeros();
        refrescaFecha();
        setVideo();
        resizePanel();

        $( window ).resize(function() {
              resizePanel();
        });


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

        setTimeout(refrescaNumeros,  2000);
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
        setTimeout(refrescaFecha,  2000);
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
        var width = getWidth() -320;
        var height = getHeight() -30;

        var publi = $("#publicidad");
        publi.css("width", width+"px");
        publi.css("height", height+"px");
        publi.css("top", "10px");

        var video = $("#video");
        video.css("width", width+"px");
        video.css("height", height+"px");

        var top = getHeight()-alturaTapa;
        $("#tapaInterior").css("top", top+"px");
        $("#sabiasque").css("top", top+"px");

    }

    function setVideo(){
        var width = getWidth();
        var height = getHeight();
        var video = $("#video");

        var url = "http://www.tvn.cl/envivo/";
        //var url = "http://localhost";

        // 20/12/2017
        var top = -260;
        var left = -120;
        var ancho = width-100;
        var alto = height-30+200;

        var html = "<object id='objectVideo' style='position: relative; top:"+top+"px; left:"+left+"px;' width='"+ancho+"' height='"+alto+"' type='text/html' data='"+url+"'></object>";
        var objHtml = $(html);
        objHtml.appendTo(video);

        tapa(width, height);

    }

    /*
    Agrega 2 div sobre el video que tapan loselementos no deseados
    */
    function tapa(width, height){
        var top = height-alturaTapa;
        var left = 1335;
        var ancho = width- left;
        crearCaja("tapaDerecha", "tapaDerecha", 0, left, height, ancho);

        var left = 0;
        var ancho = width;
        var top = height-alturaTapa;
        //crearCaja("tapaInterior", "tapa ui-tabs-tab ui-state-default ui-tab ui-tabs-active", top, left, alturaTapa, ancho);
          crearCaja("tapaInterior", "tapa", top, left, alturaTapa, ancho);

        //var altura = 100;
        //var top = height-altura;
        var left = 100;
        var ancho = width-(left*2);

        crearCaja("sabiasque", "sabiasque ui-tabs-tab ui-state-default ui-tab ui-tabs-active ui-state-active", top, left, alturaTapa, ancho);
        publicidad();
    }

    function crearCaja(id, clase, top, left, altura, ancho){
        var padre = $(document.body);

        var htmlTapaInterior ="<div id='"+id+"' class='"+clase+"' style=' left:"+left+"px; top:"+top+"px; height:"+altura+"px; width:"+ancho +"px;'><div>";
        var objHtml = $(htmlTapaInterior);
        objHtml.appendTo(padre);
    }

    function publicidad(){
        
        lista = getInfoList();
        creaSabiasQue(lista, 0, 0, 0);
    }

</script>


</head>
<body>
    <!--div class="logo">
        <img src="../css/images/logotipo.png">
    </div-->

    <div class="modulos"/></div>

    <!--div class="fecha" id="fecha"/></div-->



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

