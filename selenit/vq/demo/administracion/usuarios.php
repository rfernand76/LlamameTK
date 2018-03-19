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
                            "name": "usu_codigo",
                            "width": 40,
                            "sortable": true,
                            "align": "center",
                            "pk": true,
                            isInput:false
                        },
                        {
                            "display": "Usuario",
                            "name": "usu_usuario",
                            "width": 90,
                            "sortable": true,
                            "align": "left",
                            required: true
                        },
                        {
                            "display": "Nombres",
                            "name": "usu_nombres",
                            "width": 180,
                            "sortable": true,
                            "align": "left",
                            required: true
                        },
                        {
                            "display": "Paterno",
                            "name": "usu_paterno",
                            "width": 180,
                            "sortable": true,
                            "align": "left",
                            required: true
                        },
                        {
                            "display": "Materno",
                            "name": "usu_materno",
                            "width": 180,
                            "sortable": true,
                            "align": "left"
                        },
                        {
                            "display": "Cargo",
                            "name": "usu_cargo",
                            "width": 180,
                            "sortable": true,
                            "align": "left"
                        },
                        {
                            "display": "Correo",
                            "name": "usu_correo",
                            "width": 180,
                            "sortable": true,
                            "align": "left",
                            ttype:"email"
                        },
                        {
                            "display": "Telefono",
                            "name": "usu_telefono",
                            "width": 180,
                            "sortable": true,
                            "align": "left"
                        },
                        {
                            "display": "Fec. Nacimiento",
                            "name": "usu_fecnacimiento",
                            "width": 180,
                            "sortable": true,
                            "align": "left",
                            ttype:"date"
                        }
                    ];

                    var button =
                    {
                        "helpText": "",
                        "id": "idBarOther",
                        "elements": [
                                {
                                     "helpText": "Asignar Privilegios",
                                     "id": "asignaPrivilegios",
                                     "classIcon": "ui-icon-person",
                                     "type": "button",
                                     onClick: asignaPrivilegios
                                },
                                {
                                     "helpText": "Asigna Filas",
                                     "id": "asignaFilas",
                                     "classIcon": "ui-icon-document",
                                     "type": "button",
                                     onClick: asignaFilas
                                },
                                {
                                     "helpText": "Cambiar Password",
                                     "id": "asignaPassoword",
                                     "classIcon": "ui-icon-key",
                                     "type": "button",
                                     onClick: asignaPassoword
                                }
                            ]
                        }


            var parametros = {title:'', name:"usuario", method:1, colModel:colModel, button:button};
            var mantenedor = new Mantenedor(parametros);

            mantenedor.create();
            menu();
        });

        function asignaPassoword(lista){
            var a = lista.split(",");
            var usuario = a[0];
            if(a.length != 2){
                alert("Para esta funcionalidad debe seleccionar solo un usuario");
                return;
            }

            $("#dialog").remove();  
            var html = '<div id="dialog" title="Resetea Password usuario"><p>¿Esta seguro que desea resetear la password del usuario?</p></div>';
            var obj = $(html);
            obj.dialog({resizable: false, modal: true,
                buttons: {
                    "Aceptar": function() {
                        asignaEjecuta("usuarios.passwordReset.php", usuario);
                        $( this ).dialog( "close" );
                    },
                    "Cancelar": function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        }
        
        function asignaFilas(lista){
            var a = lista.split(",");
            var usuario = a[0];
            if(a.length != 2){
                alert("Para esta funcionalidad debe seleccionar solo un usuario");
                return;
            }

            $("#dialog").remove();  
            var html = '<div id="dialog" title="Asigna privilegios"></div>';
            var obj = $(html);
            obj.dialog({dialogClass: "alert", resizable: false, modal: true, width: "500", height: "300", top:"90",
                buttons: {
                    "Aceptar": function() {
                        asignaEjecuta("usuarios.asignaFilas.php", usuario);
                        $( this ).dialog( "close" );
                    },
                    "Cancelar": function() {
                        $( this ).dialog( "close" );
                    }
                }
            });

           
            cargaPagina("usuarios.cargaFilas.php?usuario="+usuario);
        }

        function asignaPrivilegios(lista){
            var a = lista.split(",");
            var usuario = a[0];
            if(a.length != 2){
                alert("Para esta funcionalidad debe seleccionar solo un usuario");
                return;
            }

            $("#dialog").remove();  
            var html = '<div id="dialog" title="Asigna privilegios"></div>';
            var obj = $(html);
            obj.dialog({dialogClass: "alert", resizable: false, modal: true, width: "500", height: "200", top:"100",
                buttons: {
                    "Aceptar": function() {
                        asignaEjecuta("usuarios.asignaPrivilegios.php", usuario); 
                        $( this ).dialog( "close" );
                    },
                    "Cancelar": function() {
                        $( this ).dialog( "close" );
                    }
                }
            });

           
            cargaPagina("usuarios.cargaPrivilegios.php?usuario="+usuario);
        }

        function asignaEjecuta(url, usuario){
            var lista = $("#dialog input");
            var list = "";
            for(var i=0; i<lista.length; i++){
                var obj = $(lista[i]);
                var checked = obj.attr("checked") == "checked";
                if(checked){
                    var per_codigo = obj.attr("value");
                    list = list + per_codigo + ",";
                }
            }
            list = list.substring(0, list.length -1);
            var url = url+"?lista="+list+"&usuario="+usuario;
            ejecutaUrl(url);
        }


        function cargaPagina(url){
                $.ajax(
                    {
                        url: url
                    }).done(function(result) {
                        $("#dialog").html(result);
                    }
                 );
        }

        function ejecutaUrl(url){
                $.ajax(
                    {
                        url: url
                    }).done(function(result) {
                    }
                 );
        }


        </script>

        <div id='idMantenedor'>
        </div>

<?php }?>


<?php include("footer.php");?>

