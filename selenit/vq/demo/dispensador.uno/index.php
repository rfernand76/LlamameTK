<!DOCTYPE html>
<html lang="en">
<head>
<title>Selenit - Dispensador de numeros</title>
<meta name="description" content="Modulo de auto consulta"/>
<meta charset="utf-8">

<script src="/js/jquery-ui-1.9.1.custom/js/jquery-1.8.2.js"></script>
<script src="/js/jquery-ui-1.9.1.custom/development-bundle/ui/jquery.ui.core.js"></script>
<script src="/js/jquery-ui-1.9.1.custom/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="/js/jquery-ui-1.9.1.custom/development-bundle/ui/jquery.ui.mouse.js"></script>
<script src="/js/jquery-ui-1.9.1.custom/development-bundle/external/jquery.bgiframe-2.1.2.js"></script>
<script src="/js/jquery-ui-1.9.1.custom/development-bundle/external/jquery.mousewheel.js"></script>
<link rel="stylesheet" href="/css/jquiryui/normal/jquery-ui.css"/>
<script src="/js/jquery-ui-1.9.1.custom/development-bundle/ui/jquery.ui.dialog.js"></script>
<script src="/js/jquery-ui-1.9.1.custom/development-bundle/ui/jquery.ui.draggable.js"></script>
<script src="/js/jquery-ui-1.9.1.custom/development-bundle/ui/jquery.ui.droppable.js"></script>
<script src="/js/jquery-ui-1.9.1.custom/development-bundle/ui/jquery.ui.resizable.js"></script>
<script src="/js/jquery-ui-1.9.1.custom/development-bundle/ui/jquery.ui.position.js"></script>
<script src="/js/jquery-ui-1.9.1.custom/development-bundle/ui/jquery.ui.button.js"></script>
<link rel="stylesheet" href="/js/vui/visualUI.css"/>


<link rel="stylesheet" href="../css/style.css" type="text/css" media="all">

	<script type="text/javascript">
	function muestraTicket(numero, letra){
            var checked = $("#check").attr("checked");
            var d = new Date();
            var n = d.getTime(); 
            if(checked === "checked"){
                $("#dialog").remove();
                $.ajax({
                    url: "ticket.php?n="+n+"&letra="+letra+"&numero="+numero+"&nomFila="+nomFila+"&url="+primary
                }).done(function(html) {
                    var obj = $(html);
                    obj.dialog({resizable: false, modal: true, width: "520", height: "480", top:"100",
                        buttons: {
                            "Imprimir": function() {
                                imprimir(numero, letra, nomFila);
                            },                                        
                             "Cerrar": function() {
                                cerrar();
                            },
                        }
                    });
                });    
            }else{
                imprimir(numero, letra, nomFila);
            }
            $("#check").removeAttr("checked");
        }

        var nomFila  = "";
        var bloqueo = false;
        function fila(fil_codigo, nemo, nombre){
            if(!imprimiendo && !bloqueo){
                cerrar();
                
                var html = 
                        '<div id="dialog"  title="Generando ticket de atención"><div class="dialogType"><img src="../img/loading.gif" height="60" width="60"> <p style="margin-top: -40px; margin-left: 80px">Por favor espere un momento.</p></div></div>';
                var obj = $(html);
                obj.dialog({dialogClass: "alert", resizable: false, modal: true, width: "500", height: "150", top:"100"});
                
                bloqueo = true;
                setTimeout(function() {bloqueo = false;}, 1500);
                nomFila = nombre;
                $.ajax(
                    {
                        url: "genera.php?nemo="+nemo+"&fil_codigo="+fil_codigo
                    }).done(function(result) {
                        if(result.substring(0, 5) === "ERROR"){
                            $("#dialog").remove();
                            var html = '<div id="dialog" title="Ticket de atención">' + result.substring(7) + '</div>';
                            var obj = $(html);

                            obj.dialog({dialogClass: "alert", resizable: false, modal: true, width: "500", height: "250", top:"100",
                            buttons: {
                                            "Cancelar": function() {
                                                $( this ).dialog( "close" );
                                            }
                                         }
                            });
         
                            
                        }else{
                            muestraTicket(result, nemo);
                        }
                    }
                 );
            }
        }

        function cerrar(){
            $("#dialog").dialog("close");
            $("#dialog").remove();
            bloqueo = false;
        }
        
        function formatToPrint(str){
            str = str.replace("&aacute;", "a");
            str = str.replace("&eacute;", "e");
            str = str.replace("&iacute;", "i");
            str = str.replace("&oacute;", "o");
            str = str.replace("&uacute;", "u");
            str = str.replace("&ntilde;", "n");
            str = str.replace("&Ntilde;", "N");

            str = str.replace("á", "a");
            str = str.replace("é", "e");
            str = str.replace("í", "i");
            str = str.replace("ó", "o");
            str = str.replace("ú", "u");
            str = str.replace("ñ", "n");
            str = str.replace("Ñ", "n");

            return str;
        }

        var imprimiendo = false;
        function imprimir(numero, letra, nomFila){
            nomFila = formatToPrint(nomFila);
            cerrar();
            imprimiendo = true;

            var html = $("<div id='dialog' title='Ticket'><p>Retire su ticket de atencion</p></div>");
            var obj = $(html);
            var d = obj.dialog({dialogClass: 'alert', resizable: false, modal: true, width: "400", height: "150", top:"100"});
            setTimeout(function() {
                $.ajax({
                    url: "imprimeTicket.php?letra="+letra+"&numero="+numero+"&nomFila="+nomFila+"&primary="+primary, 
                    async: false 
                }).done(function(html) {
//alert(html);
                    cerrar();
                    setTimeout(function() {imprimiendo = false; bloqueo = false;}, 100);
                }, 100);

                cerrar();
            });
        }

        var filas = [
                <?php 
                    include("../global/virtualQueueIni.php");
                    $cfg = VirtualQueueIni::getInstance();
		            $link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());

                    $sql = "select fil_codigo, fil_nemo, fil_nombre from fila";
                    $query = mysqli_query($link, $sql);



                    $c = 0;
	                while ($fila = mysqli_fetch_array($query))
	                {
		               echo 
                            '{fil_codigo:'.$fila["fil_codigo"].', nemo:"'.$fila["fil_nemo"]  .'",name:"'. $fila["fil_nombre"] .'"},';
	                }
                    mysqli_close($link);
                ?>
        ];
        
        var primary =  '<?php echo str_replace("http://", "", $cfg->getMobile_server_display()) ?>';


        $(window).load(function() {
            muestraMenu();
            $("body").css("overflow", "hidden");
        });
        
        function setMouseMano(elem){
            elem.style.cursor="pointer";
            $(elem.children[0]).css("color", "#47a1c4");
        }
        
        function setMouseNormal(elem){
            elem.style.cursor="default";
            $(elem.children[0]).css("color", "#999ea2");
        }
        
        function muestraMenu(){
            var e=0;
            var objMenu = $("#menu");
            var encabezado = '<section class="box"><div class="entries" style="height: 90px;"> ';
            var pie        = '<br><br></div></section>';

            var html = "";
            for(var i=0; i<filas.length; i++){
                if(e==0){
                    html = html + encabezado;
                }

                var parametros = "'" + filas[i].fil_codigo + "', '"+filas[i].nemo+"', '"+filas[i].name + "'";
                html = html+ 
                               '<div class="entry" style="height: 90px;" onclick="fila('+parametros+');" onMouseOver="setMouseMano(this);" onMouseOut="setMouseNormal(this)">'+
                               '   <h2>'+filas[i].name+'</h2>'+
                               '   <span class="shadow"/></span>'+
                               '</div>';

                e++;
                if(e==4){
                    html = html + pie;
                    e=0;
                }
            }
            html = html + pie;
            if(e!=0){
                html = html + "<br/><br/>";
            }
            var objHtml = $(html);
            objHtml.appendTo("#menu");
        }


	</script>

</head>
<body>
    <div id="wrapper">
      <div class="shell">
        <div class="container">
            <header class="header">
              <h1 id="logo"></h1>
              <div class="cl">&nbsp;</div>
            </header>



            <div id='menu'>
            </div>


            <section style="margin-top: -20px;" onMouseOver="setMouseMano(this);" onMouseOut="setMouseNormal(this)">
                <div style="height:55px;">
                    <?php if($cfg->getMobile_Follow() == 1) { ?>
                     <input type="checkbox" id="check"> 
                     <label for="check"><b>Mostrar código por pantalla (ahorre papel y ciude el planeta)</b>
                        <p>
                           El habilitar esta opción, permite sincronizar su ticket de atención con su smartphone y de esta manera
                           realizar seguimiento de manera virtual. Debe tener instalado un lector de código QR e internet en su dispositivo.
                        </p>
                     </label>
                    <?php
                    }
                    ?>
                     
                <div>
                <span class="shadow-b"></span> </div>
            </section>
        </div>
      </div>
    </div>
</div>
</body>
</html>




    
