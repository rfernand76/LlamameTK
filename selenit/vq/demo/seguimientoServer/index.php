<!DOCTYPE html>
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="Pragma" content="no-cache">

<html lang="es">
    <head>
        <title>http://llamame.tk - Seguimiento de atención</title>
        <meta name="description" content="Seguimiento de atención"/>
        <meta charsetf="utf-8">
        <meta name="viewport" content="width=500, initial-scale=1">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <meta name="viewport" content="width=device-width, user-scalable=no">
            
        <script src="/js/jquery-ui-1.9.1.custom/js/jquery-1.8.2.js"></script>
        <link rel="stylesheet" href="/js/css/jquiryui/dot-luv/jquery-ui.css">

        <link rel="stylesheet" href="style-seguimiento.css?a=<?php echo time()?>" type="text/css" media="all">
        

<script type="text/javascript">
    <?php
        $nemo = $_GET["nemo"];
        $miNumero = $_GET["ut"];

        $seg_codigo = $_GET["seg_codigo"];
        $token = $_GET["token"];
        $codigoManual = $_GET["codigoManual"];
    ?>
    
    $(window).load(
        function() {
            if('<?php echo $codigoManual?>' !== ""){
                connect();
            }else{
                var json = {codigo:""};
                solicitar(json);
            }
            resize(); 
            botones();
        }
    );

    var ws = null;
    var host = "18.216.150.210";
    var portWS = "1337";
    var portHttp = "8888";
    var timeRefresh = "10000";
    
    function connect(){
        var c = connectWS();
        if(!c){
            if('<?php echo $codigoManual?>' !== ""){
                alert("Su dispositivo no soporta html5 (con tecnologia de resfresco automatico), por lo que el sistema se auto refrescara con tecnologia ajax (anterior).  Si la informacion no se refresca adecuadamente, se sugerimos refrescar manualmente desde el navegador");
            }
            conectAjax();
        }
    }

    var muestraAdvertencia = true;
    function conectAjax(){
        var msg = getMsg();
        var json = JSON.stringify(msg);
        var url = "observerAjax.php?data="+json;
                $.ajax({
                    url: url,
                    async: true,
                    timeout: 2000
                }).done(function(html) {
                    if(html !== ""){
                        setConected();

                        try{
                            var data = JSON.parse(html);
                            addMessage(data);
                            
                            if(reconect){
                                muestraAdvertencia = true;
                                setTimeout(function(){ conectAjax() }, timeRefresh);
                            }
                        }catch(e){
                            setAjaxError();
                        }
                    }
                }).fail(function(html) {
                    setAjaxError();
                })
                ;
    }

    function setAjaxError(){
        if(muestraAdvertencia){
            setDisconected();
        }

        muestraAdvertencia = false;
        if(reconect){
            setTimeout(function(){ conectAjax() }, timeRefresh);
        }
    }

    function connectWS() {
        var URL = "ws://"+host+":"+portWS+"";
        if ('WebSocket' in window) {
            ws = new WebSocket(URL);
        } else if ('MozWebSocket' in window) {
            ws = new MozWebSocket(URL);
            return true;
        } else {
            return false;
        }
        
        ws.onopen = function () {
            setConected();
            // pintamos mensaje
            setObsever();
        };
        ws.onmessage = function (event) {
            var data = JSON.parse(event.data);
            addMessage(data);
        };
        ws.onclose = function () {
            if(reconect){
                setDisconected();
                setTimeout(function(){ connectWS() }, 3000);
            }
        };
       
        return true;
    }
    
    function setConected(){
        $(".status").html("<img height='30' width='30' src='14016.png'><p><img height='30' width='30' style='display:none' src='no.png'></img></p>");
    }
    
    function setDisconected(){
        $(".status").html("<p>NO</p>");
    }
    
    var reconect = true;
    function disconnect() {
        reconect = false;
        $(".status").css("display", "none");
        
        if (ws !== null) {
            ws.close();
            ws = null;
        }
    }
    
    function getMsg(){
        var msg = {
            message: "/observer",
            date: Date.now(),
            nemo: '<?php echo $nemo?>',
            miNumero: '<?php echo $miNumero?>',
            seg_codigo: '<?php echo $seg_codigo?>',
            token: '<?php echo $token?>',
            codigoManual: '<?php echo $codigoManual?>'
        };
        
        return msg;
    }

    function setObsever() {
        var msg = getMsg();
        var json = JSON.stringify(msg);
        ws.send(json);
    }

    function addMessage(json){
        if(json !== "" && json.accion){
            var js = json.accion + "(json)";
            eval(js);
        }
    }
    
    var miNumero = 0;
    function activar(json){
        $("#contenido").css("display", "block");
        $("#idNumero").html(json.numero);
        $("#idMiModulo").html(json.modulo);
        $("#miNumero").html(json.letra + " "+ json.miNumero);
        miNumero = json.miNumero;
        verificaEstado(json);
    }
    
    function update(json){
        $("#contenido").css("display", "block");
        $("#idNumero").html(json.numero);
        $("#idMiModulo").html(json.modulo);
        verificaEstado(json);
        beep();
    }
    
    var sigue = true;
    function solicitar(json) {
        $(".status").css("display", "none");
        
        $("#contenido").css("display", "none");
        var html = "<p>Ingresa el número de ticket aquí:</p>"
        + " <input class ='ui-corner-all' maxlength='15' value='"+json.codigo+"' id='codigoManual' style='font-size:24px;width:200px; type='text' name='codigoManual'/>"
        + " <input class='input ui-button ui-tabs-tab ui-state-default ui-tab ui-tabs-active ui-corner-all' type='button' value='Comenzar a seguir' onClick='submitCodigo();'/><br/>";
                
        $('#info').html(html);
        reconect = false;
    }
    
    
    function verificaEstado(json){

        if(miNumero <= json.numero){
            var suturno = $("#suturno");
            suturno.html("Diríjase al módulo " + json.miModulo);
            suturno.addClass("llamado");
            suturno.css("width", (getWidth()-50) + "px");
            disconnect();
        }
    }
                 
    function submitCodigo(){
        var codigoManual = $("#codigoManual").val();
        var url = window.location.href;
        var instr = url.indexOf("?");
        if(instr > 0){
            url = url.substr(0, instr-1);
        }
        url = "";
        window.parent.location = url + "?codigoManual="+codigoManual;
    }
            
    function resize(){
        var publi = $("#publi");
        var screen_height = getHeight();
                
        var top = 85;
        var h = $("#info").css("height");
        var info_height = (h.substr(0, h.length -2)*1);
                
        if(screen_height < info_height+top){
            publi.css("top", (1)+"px");
            return;
        }
                
                
        publi.css("top", (screen_height-321)+"px");
    }
            
    function getWidth()
    {
        var x = 0;
        if (self.innerWidth){
                x = self.innerWidth;
        }else if (document.documentElement && document.documentElement.clientWidth){
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

    function botones(){
        //( ".boton" ).button();
    }

    function enviaPorWZ(){

    }

    function beep() {
        var snd = new Audio("data:audio/wav;base64,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qJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=");  
        snd.play();
    }
</script>

    </head>
    <body onresize="resize();">
        <div class="titulo ui-tabs-tab ui-state-default ui-tab ui-tabs-active">
            <h1>Llamame.tk</h1>
            <h2>La manera inteligente de esperar</h2>
            <h2><div class="status"></div></h2>
        </div>

        <div align="center">
            <div id="info" style="height:180px;border:0px solid;">
                <div id="contenido" style="display: none">

                <p>Mi número de atención <div class="dato ui-button ui-tabs-tab ui-state-default ui-tab ui-tabs-active ui-corner-all" id="miNumero"><?php echo $letra ." ". $miNumero; ?></div></p>

                <div class="form">
                    <table width="100%" border="0"> 
                        <tr>
                            <td width="48%" align="center">Atendiendo al</td>
                            <td width="20px"></td>
                            <td width="48%" align="center">En el módulo</td>
                        </tr>

                        <tr>
                            <td align="center"><div class="dato ui-button ui-tabs-tab ui-state-default ui-tab ui-tabs-active ui-corner-all" id="idNumero"></td>
                            <td width="20px"></td>
                            <td align="center"><div class="dato ui-button ui-tabs-tab ui-state-default ui-tab ui-tabs-active ui-corner-all" id="idMiModulo"></div></td>
                        </tr>

                    </table>
                </div>
                <p id="suturno" ></p>

                <a class='input wz boton ui-button ui-tabs-tab ui-state-default ui-tab ui-tabs-active ui-corner-all' href="whatsapp://send?text=llamame.tk/?codigoManual=<?php echo $codigoManual?>">Envir esta fila por Whatsapp</a>
                </div>

            </div>
        </div>


        <div id="about-section" >
        <div class="container" >
            <div class="row main-top-margin text-center">
                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" data-scrollreveal="enter top and move 100px, wait 0.5s">
                    <h1>Llamame.tk</h1>
                    <h2>
                       Es un poderoso sistema de gestión de filas de espera, capaz de notificar el avance directamente en tu smartphone.
                    </h2>
                </div>
            </div>
            <!-- ./ Main Heading-->
            <div class="row main-low-margin text-center">
                <div class="col-md-3 col-sm-3" data-scrollreveal="enter left and move 100px, wait 0.7s">
                    <img class="img-circle" src="espera1.png" height="180" width="280" alt="">
                    <h1>Misión</h1>
                    <h2>Nuestra misión es hacer mas fácil la espera de personas en tramites comunes.</h2>
                </div>
                
                <div class="col-md-3 col-sm-3" data-scrollreveal="enter bottom and move 100px, wait 0.7s">
                    <img class="img-circle" src="espera2.png" height="180" width="280" alt="">
                    <h1>Notificaciones</h1>
                    <h2>Recibe las notificaciones de avance directamente en tu smartphone.  Cada vez que exista un llamado te avisaremos.</h2>
                </div>

                <div class="col-md-3 col-sm-3" data-scrollreveal="enter right and move 100px, wait 0.7s">
                    <img class="img-circle" src="espera4.png" height="180" width="280" alt="">
                    <h1>Date un tiempo</h1>
                    <h2>
                        Mientras esperas disfruta la vida: refrescarse, caminar o simplemente descansar.  Pero no te alejes demasiado.
                    </h2>
                </div>
                
                
            </div>
              <!-- ./ Row Content-->
        </div>
    </div>
    </body>
</html>
