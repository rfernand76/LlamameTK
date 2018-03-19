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
						"display": "Codigo",
						"name": "usu_codigo",
						"width": 50,
						"sortable": true,
						"align": "right"
					},
					{
						"display": "Nombre",
						"name": "usu_usuario",
						"width": 150,
						"sortable": true,
						"align": "left",
                        "graphic": {
                            type: "labels"
                        }
					},
					{
						"display": "Llamadas",
						"name": "cal_llamadas",
						"width": 80,
						"sortable": true,
						"align": "right",
                        "graphic": {
                            type: "datasets", 
                            fillColor : "rgba(151,187,205,0.5)",
                            strokeColor : "rgba(151,187,205,0.8)",
                            highlightFill : "rgba(151,187,205,0.75)",
                            highlightStroke : "rgba(151,187,205,1)"
                        }
					},
					{
						"display": "Atendidas",
						"name": "cal_atendidas",
						"width": 80,
						"sortable": true,
						"align": "right",
                        "graphic": {
                            type: "datasets", 
				            fillColor : "rgba(220,220,220,0.5)",
				            strokeColor : "rgba(220,220,220,0.8)",
				            highlightFill: "rgba(220,220,220,0.75)",
				            highlightStroke: "rgba(220,220,220,1)"
                        }
					},
					{
						"display": "Tiempo LLamado",
						"name": "cal_tllamado",
						"width": 80,
						"sortable": true,
						"align": "right"
					},
					{
						"display": "Tiempo Atencion",
						"name": "cal_tatencion",
						"width": 80,
						"sortable": true,
						"align": "right"
					}
				]
            ;

            //var searchitems = JSON.parse(JSON.stringify(colModel));
            var parametros = {title:'Tiempo de atencion por usuario', url:"report.usuarios.global.class.php", colModel:colModel};
            var report = new Report(parametros);

            report.create();
            menu();
            

        });

        </script>

        <div id='idContenedor' >

        </div>

<?php }?>
<?php include("footer.php");?>

