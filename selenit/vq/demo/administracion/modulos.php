<?php
$per_nombre="ADMINISTRADOR";
include("../global/header.php");
if($login){
include("encabezado.php");
?>

        <script src='/js/jquery-ui-1.9.1.custom/js/jquery-1.8.2.js'></script>
        <script src='/js/vui/dependence.js'></script>
        <script src='../js/selenit/MantenedorClass.js'></script>
        <script src='../js/selenit/menu.js'></script>
        <script type='text/javascript'>
        $(window).load(function() {
            var colModel = [
                        {
                            "display": "Codigo",
                            "name": "mod_codigo",
                            "width": 40,
                            "sortable": true,
                            "align": "center",
                            "pk": true,
                            isInput:false
                        },
                        {
                            "display": "Numero",
                            "name": "mod_modulo",
                            "width": 180,
                            "sortable": true,
                            "align": "left",
                            required: true
                        },
                        {
                            "display": "Ejecutivo",
                            "name": "usu_codigo",
                            "width": 180,
                            "sortable": true,
                            "align": "left",
                            "list":{
                                join: "usu_codigo",
                                origen: "SELECT usu_codigo, CONCAT( IFNULL( usu_nombres,  '' ) ,  ' ', IFNULL( usu_paterno,  '' ) ,  ' ', IFNULL( usu_materno,  '' ) ) FROM usuario "
                            }
                        },
                        {
                            "display": "IP",
                            "name": "mod_ip",
                            "width": 80,
                            "sortable": true,
                            "align": "left"
                        }
                    ];

            var searchitems = JSON.parse(JSON.stringify(colModel));

            var parametros = {title:'Mantenedor de modulos', name:"modulo", method:1, colModel:colModel, searchitems:searchitems};
            var mantenedor = new Mantenedor(parametros);

            mantenedor.create();
            menu();
        });
        </script>

        <div id='idMantenedor' class='ui-state-default ui-corner-all'>
        </div>

<?php }?>


<?php include("footer.php");?>

