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
                        "name": "fil_codigo",
                        "width": 50,
                        "sortable": true,
                        "align": "right"
                    },
                    {
                        "display": "Nombre",
                        "name": "fil_nombre",
                        "width": 150,
                        "sortable": true,
                        "align": "left",
                        "graphic": {
                            type: "labels"
                        }
                    },
                    {
                        "display": "Solicitudes",
                        "name": "cal_solicitudes",
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
                    }
                ]
            ;

            //var searchitems = JSON.parse(JSON.stringify(colModel));
            var parametros = {title:'Solicitudes por filas', url:"report.filas.solicitudes.class.php", colModel:colModel};
            var report = new Report(parametros);

            report.create();
            menu();
            

        });

        </script>

        <div id='idContenedor' >

        </div>

<?php }?>
<?php include("footer.php");?>

