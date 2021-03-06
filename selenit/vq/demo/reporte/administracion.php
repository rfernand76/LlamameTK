<!DOCTYPE html>
<html lang="en">
<head>
<title>Selenit - Servicio dispensador de numeros</title>
<meta name="description" content="Modulo de auto consulta"/>
<meta charset="utf-8">
<script src="../js/jquery-1.7.2.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

<link rel="stylesheet" href="../css/style.css" type="text/css" media="all">
	<script type="text/javascript">

        $(window).load(function() {
            refresca();
        });

        function repetir(){
            var nemo = $("#fila").val();
            var modulo = '<?php echo $modulo;?>';
            var eje_codigo = '<?php echo $eje_codigo;?>';
            var url = "server_replicar.class.php?nemo="+nemo+"&modulo="+modulo+"&eje_codigo="+eje_codigo+"&numero="+ultimoNumero;

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
            var eje_codigo = '<?php echo $eje_codigo;?>';
            var url = "server_actualiza.class.php?nemo="+nemo+"&modulo="+modulo+"&eje_codigo="+eje_codigo;

            $.ajax(
                {
                    url: url
                }).done(function(result) {
                    var a = result.split(".");
                    $("#atendiendo").html("Ultimo llamado "+a[0]);
                    ultimoNumero = a[0];
                    seg_codigo   = a[1];
                    if(seg_codigo != ""){
                        $("#atender").removeAttr("disabled");
                    }else{
                        $("#atender").attr("disabled", "true");
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
                    $("#atendiendo").html("Ultimo llamado "+result);
                    $("#atender").attr("disabled", "true");
                }
             );
        }

        var seg_codigo = "";
        function atender(){
            var eje_codigo = '<?php echo $eje_codigo;?>';
            var url = "server_atiende.class.php?seg_codigo="+seg_codigo+"&eje_codigo="+eje_codigo;
            $.ajax(
                {
                    url: url
                }).done(function(result) {
                }
             );
        }

        var pau_codigo = "";
        function pausar_continua(){
            var estado = $("#bpausar_continua").html();
            var nuevoEstado = "Pausar";
            if(estado === "Pausar"){
                nuevoEstado = "Continuar";
                deshabilitaAll();
            }else{
                habilitaAll();
            }
            $("#bpausar_continua").html(nuevoEstado);

            var eje_codigo = '<?php echo $eje_codigo;?>';
            var url = "server_pausa.class.php?eje_codigo="+eje_codigo+"&accion="+estado+"&pau_codigo="+pau_codigo;
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
        }

        function habilitaAll(){
            habilita("llamar");
            habilita("repetir");
            habilita("atender");
        }



        function deshabilita(id){
            var estadoActual = $("#"+id).attr("disabled");
            $("#"+id).attr("estadoResp", estadoActual);
            $("#"+id).attr("disabled", "true");
        }

        function habilita(id){
            var estadoActual = $("#"+id).attr("estadoResp");
            if(estadoActual != "disabled"){
                $("#"+id).removeAttr("disabled");
            }
            
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
            <section  >
                <p align="right">Ejecutivo: <?php echo $eje_nombre;?></p>
                <p align="right">Usuario: <?php echo $usuario;?></p>
                <p align="right">Mi Caja: <?php echo $modulo;?></p>
            </section>

            <section class="services" align="left">
              <div class="widget">
                <p>Fila:
                    <select name="fila" id="fila" onChange="refresca();">
                    <?php 
                            $nemo=$_GET["nemo"];
		                    $link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());

                            $sql = "select fil_nemo, fil_nombre from fila";
		                    $query = mysqli_query($link, $sql);


	                        while ($fila = mysqli_fetch_array($query))
	                        {
		                        echo '<option value='.$fila["fil_nemo"].'>'.$fila["fil_nombre"].'</option>';
	                        }
                            mysqli_close($link);
                    ?>
                    </select>
                </p>
                <p id="atendiendo">Ultimo llamado <?php echo $fil_ta; ?> de 555</p>
                <button id="llamar" onClick="llamar()" >Llamar próximo</button> 
                <button id="repetir" onClick="repetir()" >Repetir</button> 
                <button id="atender" onClick="atender()">Atender</button> 
                <button id="bpausar_continua" onClick="pausar_continua()">Pausar</button>
              </div>
              <div class="cl">&nbsp;</div>

            </section>
        </div>
      </div>
    </div>


</div>
</body>
</html>




    
