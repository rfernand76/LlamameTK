<?php
$per_nombre="EJECUTIVO_ATENCION";
include("../global/header.php"); 
if($login){

        $sql = "SELECT m.mod_modulo FROM modulo m where  m.usu_codigo = '$usu_codigo' ";
		$result = mysql_query($sql);
        $fila = mysql_fetch_assoc($result); 
        $modulo = $fila["mod_modulo"];


        $sql = "
            select pau_codigo from pausa 
            where pau_codigo = (select max(pau_codigo) from pausa where eje_codigo = $usu_codigo )
            and pau_fin = '0000-00-00 00:00:00'
        ";

		$result = mysql_query($sql);
        $fila = mysql_fetch_assoc($result); 
        $pau_codigo = $fila["pau_codigo"];


        if($pau_codigo == ""){
            $sql = "
            select seg_codigo, seg_numero, seg_atendido from seguimiento 
            where seg_codigo = (select max(seg_codigo) from seguimiento where eje_codigo = $usu_codigo) and seg_atendido <> 2";

		    $result = mysql_query($sql);
            $fila = mysql_fetch_assoc($result); 
            $ultimoNumero = $fila["seg_numero"];
            $seg_atendido = $fila["seg_atendido"];
            $seg_codigo = $fila["seg_codigo"];
        }
?>
<link rel="stylesheet" href="/js/vui/visualUI.css"/>
<script src='/js/jquery-ui-1.9.1.custom/js/jquery-1.8.2.js'></script>
 
<script src='/js/vui/dependence.js'></script>
<script src='../js/selenit/menu.js'></script>
<script type='text/javascript'>
        $(window).load(function() {
            addDependence({modulo_name:"jquery-ui", resource_name:"accordion"});//importa todos los js que necesita la pagina para funcionar

            //menu();
            pau_codigo = '<?php echo $pau_codigo;?>';
            ultimoNumero = '<?php echo $ultimoNumero;?>';
            if(pau_codigo != ""){
                deshabilitaAll();
                habilita("continua");
                $("#continua").html("Continuar");
            }else{
                if(ultimoNumero != ""){
                    deshabilitaAll();
                    habilita("llamar");
                    habilita("repetir");
                    habilita("atender");
                    habilita("continua");

                    $("#atendiendo").html(ultimoNumero);

                    seg_atendido = '<?php echo $seg_atendido;?>';
                    seg_codigo = '<?php echo $seg_codigo;?>';
                    if(seg_atendido == 1){
                        deshabilitaAll();
                        $("#atender").html("Terminar atencion");
                        habilita("atender");
                    }
                }
            }
            $( "#accordion" ).accordion();
        });

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

        var ultimoNumero = "";        
        function llamar(){
            var nemo = $("#fila").val();
            var modulo = '<?php echo $modulo;?>';
            var usu_codigo = '<?php echo $usu_codigo;?>';
            var url = "server_actualiza.class.php?nemo="+nemo+"&modulo="+modulo+"&eje_codigo="+usu_codigo;


            $.ajax(
                {
                    url: url
                }).done(function(result) {
                    var a = result.split(".");
                    $("#atendiendo").html(a[0]);
                    ultimoNumero = a[0];
                    seg_codigo   = a[1];
                    if(seg_codigo != ""){
                        $("#atender").removeAttr("disabled");
                        $("#repetir").removeAttr("disabled");
                    }else{
                        $("#atender").attr("disabled", "true");
                        $("#repetir").attr("disabled", "true");
                    }
                }
             );
        }

        function refresca(){
            var nemo = $("#fila").val();
            var url = "consultaactual.class.php?nemo="+nemo;
            $.ajax(
                {
                    url: url
                }).done(function(result) {
                    $("#atendiendo").html(result);
                    $("#atender").attr("disabled", "true");
                }
             );
        }

        function cambiaFila(){
            $("#atender").attr("disabled", "true");
            $("#repetir").attr("disabled", "true");
        }

        var seg_codigo = "";
        function atender(){
            var estado = $("#atender").html();
            var nuevoEstado = "Atender";
            if(estado === "Atender"){
                nuevoEstado = "Terminar atencion";
                deshabilitaAll();
                habilita("atender");
            }else{
                habilitaAll();
                deshabilita("repetir");
                deshabilita("atender");
            }
            $("#atender").html(nuevoEstado);

            var usu_codigo = '<?php echo $usu_codigo;?>';
            var url = "server_atiende.class.php?seg_codigo="+seg_codigo+"&eje_codigo="+usu_codigo+"&accion="+estado;

            $.ajax(
                {
                    url: url
                }).done(function(result) {

                }
             );
        }

        var pau_codigo = "";
        function pausar_continua(){
            var estado = $("#continua").html();
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
            $("#continua").html(nuevoEstado);

            var usu_codigo = '<?php echo $usu_codigo;?>';
            var url = "server_pausa.class.php?eje_codigo="+usu_codigo+"&accion="+estado+"&pau_codigo="+pau_codigo;
            $.ajax(
                {
                    url: url
                }).done(function(result) {
                    pau_codigo = result;
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
</script>


        <section class="services" style="font-size:13px;">
                <p>Mi Modulo: <b><?php echo $modulo;?></b></p>
                <p>Fila:
                    <select name="fila" id="fila" onChange="cambiaFila();">
                    <?php 
                            $nemo=$_GET["nemo"];

                            $sql = 
                            "select f.fil_nemo, f.fil_nombre".
                            " from fila f, usu_fila uf".
                            " where f.fil_codigo = uf.fil_codigo".
                            " and uf.usu_codigo = $usu_codigo";

		                    $result = mysql_query($sql);

	                        while ($fila = mysql_fetch_assoc($result))
	                        {
		                        echo '<option value='.$fila["fil_nemo"].'>'.$fila["fil_nombre"]. ' : ('.$fila["fil_nemo"].')</option>';
	                        }
                    ?>
                    </select>
                </p>

                Mi último llamado
                <div class="ultimoLlamado">
                    <p id="atendiendo"></p>
                </div>
                <br/>
                <button id="llamar"           onClick="llamar()" >Llamar próximo</button> 
                <button id="repetir" disabled onClick="repetir()" >Repetir</button> 
                <button id="atender" disabled onClick="atender()">Atender</button> 
                <button id="continua"         onClick="pausar_continua()">Pausar</button>


          <div class="cl">&nbsp;</div>
        </section><!-- end of services -->

        <section class="infoCuadro">
              <div id="accordion" style="height:230px;" >
                  <h3>Mis estadisticas</h3>
                  <div style="height:2300px;">
                  </div>
                  <h3>Estadisticas sucursal</h3>
                  <div>
                  </div>

              </div>
        </section><!-- end of services -->

<?php  
}
include("footer.php"); 
mysql_close($link);
?>



