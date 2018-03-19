<?php
$per_nombre="SUPERVISOR";
include("../global/header.php");
if($login){
include("encabezado.php");
?>
        <script src='/js/jquery-ui-1.9.1.custom/js/jquery-1.8.2.js'></script>
        <script src='/js/vui/dependence.js'></script>
        <script src='../js/selenit/ReportClass.js'></script>
        <script src='../js/selenit/menu.js'></script>
        <script src="../js/Chart.js-master/Chart.js"></script>
        <script type='text/javascript'>

        $(window).load(function() {

            var colModel = 
				 [
					{
						"display": "Nombre",
						"name": "fil_nombre",
						"width": 150,
						"sortable": true,
						"align": "left"
					},
					{
						"display": "Turno",
						"name": "seg_numero",
						"width": 60,
						"sortable": true,
						"align": "right"
					},
					{
						"display": "Usuario Atencion",
						"name": "usu_usuario",
						"width": 80,
						"sortable": true,
						"align": "left"
					},
					{
						"display": "Tiempo Espera",
						"name": "cal_tespera",
						"width": 80,
						"sortable": true,
						"align": "right",
					},
					{
						"display": "Tiempo Llamado",
						"name": "cal_tllama",
						"width": 80,
						"sortable": true,
						"align": "right",
					},
					{
						"display": "Tiempo Atencion",
						"name": "cal_tatencion",
						"width": 80,
						"sortable": true,
						"align": "right",
					},
					{
						"display": "Fecha Solicitud",
						"name": "seg_fecha",
						"width": 120,
						"sortable": true,
						"align": "right"
					},
					{
						"display": "Fecha LLamado",
						"name": "seg_fecllamada",
						"width": 80,
						"sortable": true,
						"align": "right"
					},
					{
						"display": "Fecha Atencion",
						"name": "seg_fecatencion",
						"width": 80,
						"sortable": true,
						"align": "right"
					},
					{
						"display": "Fecha fin Atencion",
						"name": "seg_fecfinatencion",
						"width": 80,
						"sortable": true,
						"align": "right"
					}
               ]
            ;

            //var searchitems = JSON.parse(JSON.stringify(colModel));
            var parametros = {title:'Detalle de solicitudes por filas', url:"report.filas.detalle.class.php", colModel:colModel};
            var report = new Report(parametros);

            report.create();
            menu();
            

        });

        </script>

        <div id='idContenedor' >

        </div>

<?php }?>
<?php include("footer.php");?>

