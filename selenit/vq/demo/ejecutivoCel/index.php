<?php
$per_nombre="EJECUTIVO_ATENCION";
include("../global/header.php"); 

if($login){

        $sql = "SELECT m.mod_modulo FROM modulo m where  m.usu_codigo = '$usu_codigo' ";
        $query = mysqli_query($link, $sql);
        $fila = mysqli_fetch_array($query);


        $modulo = $fila["mod_modulo"];


        $sql = "
            select pau_codigo from pausa 
            where pau_codigo = (select max(pau_codigo) from pausa where eje_codigo = $usu_codigo )
            and pau_fin = '0000-00-00 00:00:00'
        ";

        $query = mysqli_query($link, $sql);
        $fila = mysqli_fetch_array($query);

        $pau_codigo = $fila["pau_codigo"];


        if($pau_codigo == ""){
            $sql = "
            select seg_codigo, seg_numero, seg_atendido, fil_nemo from seguimiento 
            where seg_codigo = (select max(seg_codigo) from seguimiento where eje_codigo = $usu_codigo) and seg_atendido <> 2";

            $query = mysqli_query($link, $sql);
            $fila = mysqli_fetch_array($query);
            $ultimoNumero = $fila["seg_numero"];
            $seg_atendido = $fila["seg_atendido"];
            $seg_codigo = $fila["seg_codigo"];
            $fil_nemo = $fila["fil_nemo"];
        }
?>
<script src='/js/jquery-ui-1.9.1.custom/js/jquery-1.8.2.js'></script>
<script src='/js/vui/dependence.js'></script>
<script src='../js/selenit/menu.js'></script>
<script src='index.form.js?1=7'></script>

<script type='text/javascript'>
        

        function datosGenerales(){
            var fila = $("#fila");

            <?php
                $cfg     = VirtualQueueIni::getInstance();  
                 $sql = 
                "select f.fil_nemo, f.fil_nombre".
                " from fila f, usu_fila uf".
                " where f.fil_codigo = uf.fil_codigo".
                " and uf.usu_codigo = $usu_codigo";

                $query = mysqli_query($link, $sql);
        

                while ($fila = mysqli_fetch_array($query)){
                    $nombre = $fila["fil_nombre"];
                    $nemo = $fila["fil_nemo"];
                    echo 
                    "var o = new Option('$nombre : ($nemo)', '$nemo');
                     fila.append(o);
                    ";
	            }
            ?>

            $( "#miModulo" ).html("<?php echo $modulo;?>");
            refrescaEstadisticasJornada();
            refrescaEstadisticasFilas();
        }

        function repetir(){
            var nemo = $("#fila").val();
            var modulo = '<?php echo $modulo;?>';
            var usu_codigo = '<?php echo $usu_codigo;?>';
            var url = "server_replicar.class.php?nemo="+nemo+"&modulo="+modulo+"&eje_codigo="+usu_codigo+"&numero="+ultimoNumero;

            $.ajax(
                {
                    url: url
                }).done(function(result) {
                    
                }
             );
        }
        
        function habilitaEspera(){
           habilita("llamar"); 
        }

        var ultimoNumero = "";        
        function llamar(){
            $("#atendiendo").html("<img src='../img/loading.gif' height='60' width='60'>");
            
            var nemo = $("#fila").val();
            var modulo = '<?php echo $modulo;?>';
            var usu_codigo = '<?php echo $usu_codigo;?>';
            var url = "server_actualiza.class.php?nemo="+nemo+"&modulo="+modulo+"&eje_codigo="+usu_codigo;
            deshabilita("llamar");
            setTimeout(habilitaEspera, 1000);
            
            $.ajax(
                {
                    url: url
                }).done(function(result) {
                    var a = result.split(".");
                    var nemo = $("#fila").val();
                    $("#atendiendo").html(nemo + " " + a[0]);
                    ultimoNumero = a[0];
                    seg_codigo   = a[1];
                    if(seg_codigo != ""){
                        $("#atender").removeAttr("disabled");
                        $("#repetir").removeAttr("disabled");
                    }else{
                        $("#atender").attr("disabled", "true");
                        $("#repetir").attr("disabled", "true");
                    }
                    refrescaEstadisticasJornada();
                }
             );
        }

        function refrescaEstadisticasJornada(){
            if(isMobile()){
                var nemo = $("#fila").val();
                var horaComienzo = $("#HORA_COMIENZO").val();

                var url = "estadisticasJornada.php";
                $.ajax(
                    {
                        url: url,
                        params: [{name:'HORA_COMIENZO', value: "horaComienzo"}]
                    }).done(function(result) {
                        var datos = jQuery.parseJSON(result);
                        $("#LLAMADOS").html(datos.LLAMADOS);
                        $("#ATENDIDOS").html(datos.ATENDIDOS);
                        $("#TIEMPO_PROMEDIO_ATENCION").html(datos.TIEMPO_PROMEDIO_ATENCION);
                        $("#PAUSAS_REALIZADAS").html(datos.PAUSAS_REALIZADAS);
                        $("#PAUSAS_REALIZADAS").html(datos.PAUSAS_REALIZADAS);
                        $("#TIEMPO_TOTAL_PAUSADO").html(datos.TIEMPO_TOTAL_PAUSADO);
                        $("#HORA_COMIENZO").html(datos.HORA_COMIENZO);
                    }
                 );
            }
        }

        function refrescaEstadisticasFilas(){
            var idAcordionEstaditicas = $('#idAcordionEstaditicas');
            var active = idAcordionEstaditicas.accordion('option', 'active');
            var espera = 500;

            if(active == 1){ //valida si esta en la parte de estadisticas de la fila para refrescar, en caso contrario no refresca
                var idFlexiGridData = $('#estadisticasFilas').find('.tabla');
                espera = 3000;
                idFlexiGridData.flexOptions(
                {
                    url: "estadisticasFilas.php",
                    params: [{name:'method', value: "create"}], 
                    onSuccess: function() {
                        var i=0;
                    }
                }).flexReload();
            }

            setTimeout(refrescaEstadisticasFilas, espera);
        }

        function cambiaFila(){
            $("#atender").attr("disabled", "true");
            $("#repetir").attr("disabled", "true");
        }
        
        function habilitaAtender(){
            habilita("atender");
        }

        var seg_codigo = "";
        function atender(){
            var estado = $("#atender").attr("title");
            var nuevoEstado = "Atender";
            if(estado === "Atender"){
                nuevoEstado = "Terminar";
                deshabilitaAll();
                setTimeout(habilitaAtender, 1000);
            }else{
                habilitaAll();
                deshabilita("repetir");
                deshabilita("atender");
            }

            $("#atender").button( "option", "label", nuevoEstado );
            $("#atender").attr("helpText", nuevoEstado);
            $("#atender").attr("title", nuevoEstado);

            var usu_codigo = '<?php echo $usu_codigo;?>';
            var nemo = $("#fila").val();
            var url = "server_atiende.class.php?seg_codigo="+seg_codigo+"&eje_codigo="+usu_codigo+"&accion="+estado+"&nemo="+nemo;

            $.ajax(
                {
                    url: url
                }).done(function(result) {
                    refrescaEstadisticasJornada();
                }
             );
        }

        var pau_codigo = "";
        function pausar_continua(){
            var estado = $("#continua").attr("title");
            var nuevoEstado = "Pausar";
            if(estado === "Pausar"){
                nuevoEstado = "Continuar";
                deshabilitaAll();
                habilita("continua");
            }else{
                deshabilitaAll();
                habilita("continua");
                habilita("llamar");
            }
            $("#continua").button( "option", "label", nuevoEstado );
            $("#continua").attr("helpText", nuevoEstado);
            $("#continua").attr("title", nuevoEstado);

            var usu_codigo = '<?php echo $usu_codigo;?>';
            var url = "server_pausa.class.php?eje_codigo="+usu_codigo+"&accion="+estado+"&pau_codigo="+pau_codigo;
            $.ajax(
                {
                    url: url
                }).done(function(result) {
                    pau_codigo = result;
                    refrescaEstadisticasJornada();
                }
             );
        }

        function deshabilitaAll(){
            deshabilita("llamar");
            deshabilita("repetir");
            deshabilita("atender");
            deshabilita("continua");
        }

        function habilitaAll(){
            habilita("llamar");
            habilita("repetir");
            habilita("atender");
            habilita("continua");
        }

        function deshabilita(id){
            $("#"+id).attr("disabled", "true");
        }

        function habilita(id){
            $("#"+id).removeAttr("disabled");
        }

        function isMobile(){
            var dispositivo = navigator.userAgent.toLowerCase();
            var isMobile = (dispositivo.search(/iphone|ipod|ipad|android|mobile/) > -1);
            return isMobile;
        }

        function resize(){
            if(isMobile()){
                var width  = getWidth();
                var height = getHeight();

                var strWidth = width + "px";
                var strHeight = height-30 + "px";

                $("#shell").removeClass("shell");

                $(".container").css("width", strWidth);
                $(".container").css("height", strHeight);

                $("#logo").css("background-image", "none");


                $("body").css("overflow", "hidden");
                $("#idAcordionEstaditicas").parent().css("display", "none");  

                $("#idPlantilla").css("left", "0px");
                $("#idPlantilla").css("width", strWidth);
                $("#idPlantilla").css("top", "-40px");

                $(".services").css("width", "10px");
                $("#idToolbarClass_4").css("width", strWidth);
                //$("#idToolbarClass_4").css("top", "-50px");


                $(".ui-button").css("height", "40px");
                $(".ui-button").css("top", "-7px");
                $(".toolbarPanel").css("padding-top", "23px");

                $(".toolbarPanel").css("padding-top", "25px");
                $("#idTab_10").css("width", (width-10) + "px");
                $("#idTab_10").css("height", (height-190) + "px");
                $("#idTab_10").parent().css("left", "-30px");
                $("#idToolbarClass_4").parent().css("left", "-32px");

                $("#atendiendo").css("width", (width-10) + "px");
                $("#atendiendo").css("height", (height-245) + "px");
                $("#atendiendo").css("overflow-x",  "hidden");
                //$("#atendiendo").parent().css("top", "55px");


            }
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

    function filaCfg(){
            var objMenu = $("#menu");

            var html = '<section id="dialog" style="font-size:19px;" class="box">Seleccione la fila que desea operar<br/><br/><select id="filaCfgBtn">';

            <?php
                 $sql = 
                "select f.fil_nemo, f.fil_nombre".
                " from fila f, usu_fila uf".
                " where f.fil_codigo = uf.fil_codigo".
                " and uf.usu_codigo = $usu_codigo";

                $query = mysqli_query($link, $sql);
                while ($fila = mysqli_fetch_array($query)){
                    $nombre = $fila["fil_nombre"];
                    $nemo = $fila["fil_nemo"];
                    echo 'html = html + "<option value= \''.$nemo.'\'>  '.$nombre. ': (' .$nemo.')</option>";';
                }

            ?>

            html =html + '</select></section>';
            $("#dialog").remove();
            var obj = $(html);

            obj.dialog({resizable: false, modal: false, width: "350", height: "200",
                        buttons: {
                             "Aceptar": function() {
                                cambiaFila();
                                var val = $("#filaCfgBtn option:selected").val()

                                $("#fila").val(val);

                                $("#dialog").dialog("close");
                                $("#dialog").remove();

                            },"Cancelar": function() {
                                $("#dialog").dialog("close");
                                $("#dialog").remove();
                            },
                        }
                    });

            var val = $("#fila option:selected").val();
            $("#filaCfgBtn").val(val);
    }



                
        $(window).load(function() {
            dependence(platilla);//importa todos los js que necesita la pagina para funcionar

            $("#idPlantilla").run(platilla);
            $("#panelDatosGenerales").css("overflow", "hidden");
            $("#panelEstadisticas").css("overflow", "hidden");
            $("#llamar").click(function() {llamar(); });
            $("#repetir").click(function() {repetir()});
            $("#atender").click(function() {atender()});
            $("#continua").click(function() {pausar_continua()});
            $("#filaCfg").click(function() {filaCfg()});

            pau_codigo = '<?php echo $pau_codigo;?>';
            ultimoNumero = '<?php echo $ultimoNumero;?>';
            var fil_nemo = '<?php echo $fil_nemo;?>';

            deshabilitaAll();
            if(pau_codigo != ""){
                deshabilitaAll();
                habilita("continua");
                $("#continua").button( "option", "label", "Continuar" );
                $("#continua").attr("helpText", "Continuar");
                $("#continua").attr("title", "Continuar");
            }else{
                if(ultimoNumero != ""){
                    deshabilitaAll();
                    habilita("llamar");
                    habilita("repetir");
                    habilita("atender");
                    habilita("continua");

                    $("#atendiendo").html(fil_nemo + " " + ultimoNumero);

                    seg_atendido = '<?php echo $seg_atendido;?>';
                    seg_codigo = '<?php echo $seg_codigo;?>';
                    if(seg_atendido == 1){
                        deshabilitaAll();
                        $("#atender").button( "option", "label", "Terminar" );
                        $("#atender").attr("helpText", "Terminar");
                        $("#atender").attr("title", "Terminar");
                        habilita("atender");
                    }
                }else{
                    habilita("llamar");
                    habilita("continua");
                }
            }
            $( "#accordion" ).accordion();
            datosGenerales();
            resize();

            $( window ).resize(function() {
              resize();
            });
        });
</script>


<section class="services" style="font-size:13px;">
    <div id="idPlantilla"></div>
            
    <div class="cl">&nbsp;</div>
</section><!-- end of services -->

<?php  
}
include("footer.php"); 
mysqli_close($link);
?>



