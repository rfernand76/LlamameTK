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
            var parametros = {title:'Mantenedor de Filas', name:"fila", method:1, colModel:colModel, valid: valida, onChange:modifica};
            var mantenedor = new Mantenedor(parametros);

            mantenedor.create();
            menu();
        });
        
        function valida(accion, obj, parametros){
            return obj.valid(accion, parametros);
        }
        
        
        function modifica(accion, obj, parametros){
            
            
            var msg = {
                message: "/"+accion,
                date: Date.now(),
                fil_nemo: parametros.colModel[1].value,
                fil_nombre: parametros.colModel[2].value,
                name: parametros.name,
            };
            
            
            if(accion === "delete"){
                valueList = "";
                var registro = $('.bDiv .trSelected');
                for(var e=0; e<registro.length; e++){
                    valueList = valueList + registro[e].childNodes[2].childNodes[0].childNodes[0].textContent + ",";
                }
                valueList = valueList.substring(valueList, valueList.length-1);
                msg.valueList = valueList;
            }

            var str = JSON.stringify(msg);
            var url = "Mantenedor.notificar.php?data="+str;
            
            obj.dialogInfo("<img src='../img/loading.gif' height='60' width='60'> Actualizando");
            
            $.ajax(
            {
                url: url,
                async: false,
                timeout: 3000
            }).done(function(result) {
                if(result === "OK"){
                    obj.dialogInfo("Proceso ejecutado correctamente");
                    obj.ret = true;
                }else{
                    obj.dialogInfo("Ocurrio un error al notificar los valores en el servidor, el servidor dice: "+result);
                    obj.ret = false;
                }
            }).fail(function(result) {
                obj.dialogInfo("Ocurrio un error al notificar los valores en el servidor");
                obj.ret = false;
            });
        }

        </script>

        <div id='idMantenedor' >
        </div>

<?php }
include("footer.php");?>

