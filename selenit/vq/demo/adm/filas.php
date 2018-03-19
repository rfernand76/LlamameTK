<?php
$per_nombre="ADMINISTRADOR";
include("../global/header.php");
if($login){
include("encabezado.php");
?>

        <script src='/js/jquery-ui-1.9.1.custom/js/jquery-1.8.2.js'></script>
        <script src='/js/vui/dependence.js?a=2'></script>
        <script src='../js/selenit/Mantenedor.class.js?i=4'></script>
        <script src='../js/selenit/menu.js'></script>
        <script type='text/javascript'>
        $(window).load(function() {
            var colModel = [
                        {
                            display: "Codigo",
                            name: "fil_codigo",
                            width: 40,
                            sortable: true,
                            align: "center",
                            pk: true,
                            size: 30,
                            isInput:false
                        },
                        {
                            display: "Nemotecnico",
                            name: "fil_nemo",
                            width: 180,
                            sortable: true,
                            align: "left",
                            required: true,
                            size: 30,
                            maxlength: 14,
                            ttype:"text",
                            noUpdate:true
                        },
                        {
                            display: "Nombre",
                            name: "fil_nombre",
                            width: 180,
                            sortable: true,
                            align: "left",
                            required: true,
                            size: 30,
                            maxlength: 30,
                            ttype:"text"
                        }
                        
                    ];

            //var searchitems = JSON.parse(JSON.stringify(colModel));
            var parametros = {
                title:'Mantenedor de Filas', 
                name:"fila", 
                method:1, 
                colModel:colModel, 
                valid: valida, 
                url:"filas.mantenedor.class.php"
            };
            
            var mantenedor = new Mantenedor(parametros);

            mantenedor.create();
            menu();
        });
        
        function valida(accion, obj, parametros){
            return obj.valid(accion, parametros);
        }

        </script>

        <div id='idMantenedor' >
        </div>

<?php }
include("footer.php");?>

