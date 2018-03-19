<?php
$per_nombre="ADMINISTRADOR";
include("../global/header.php");
if($login){
include("encabezado.php");
?>
        <link rel="stylesheet" href="/js/vui/visualUI.css"/>
        <script src='/js/jquery-ui-1.9.1.custom/js/jquery-1.8.2.js'></script>
        <script src='/js/vui/dependence.js'></script>
        <script src='../js/selenit/MantenedorClass.js'></script>
        <script src='../js/selenit/menu.js'></script>
        <script type='text/javascript'>

        $(window).load(function() {
            menu();


        platilla =
            {
	"format": {
		"version": "1.0.3",
		"create": "2014-12-23T04:19:30.898Z"
	},
	"page": {
            "width": 953,
            "height": 383,
		"top": 0,
		"left": 0,
		"name": "",
		"mobilesupport": true
	},
	"fields": [
		{
			"subclass": "FlexiGridClass",
			"parent": "droppable",
			"height": "370",
			"width": "957",
			"top": "45",
			"left": "0",
			"VIU": {
				"id": "idListaCajas",
				"caption": "FlexiGrid",
				"disabled": "",
				"name": "",
				"style": "",
				"theClass": "",
				"url": "Administrar.filas.class.php",
				"dataType": "json",
				"usepager": "usepager",
				"useRp": "",
				"rp": 20,
				"showTableToggleBtn": false,
				"resizable": false,
				"singleSelect": false,
				"striped": false,
				"width": 948,
				"height": 241,
				"mobile": {
					"action": 1,
					"name": "Data"
				},
				"colModel": [
					{
						"display": "Fila",
						"name": "fil_nombre",
						"width": 150,
						"sortable": true,
						"align": "left"
					},
					{
						"display": "Solicitadas",
						"name": "fil_ut",
						"width": 90,
						"sortable": true,
						"align": "right"
					},
					{
						"display": "Atendidas",
						"name": "fil_ta",
						"width": 90,
						"sortable": true,
						"align": "right"
					}
				]
			}
		},
		{
			"subclass": "PanelClass",
			"parent": "droppable",
			"height": "41",
			"width": "954",
			"top": "0",
			"left": "0",
			"VIU": {
				"id": "idPanel_14",
				"idPanel": "idFSP_14",
				"name": "",
				"style": "",
				"theClass": "ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons",
				"title": "",
				"align": "",
				"mobile": {
					"action": 1,
					"name": "Panel"
				}
			}
		},
                
		{
			"subclass": "PanelClass",
			"parent": "idPanel_14",
			"height": "41",
			"width": "305",
			"top": "0",
			"left": "6",
			"VIU": {
				"id": "idPanel_15",
				"idPanel": "idFSP_15",
				"name": "",
				"style": "",
				"theClass": " ui-corner-all ui-widget-header",
				"title": "",
				"align": "",
				"mobile": {
					"action": 1,
					"name": "Panel"
				}
			}
		},
                
		{
			"subclass": "PanelClass",
			"parent": "idFSP_15",
			"height": "35",
			"width": "220",
			"top": "3",
			"left": "2",
			"VIU": {
				"id": "idPanel_16",
				"idPanel": "idFSP_16",
				"name": "",
				"style": "",
				"theClass": "ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons",
				"title": "",
				"align": "",
				"mobile": {
					"action": 1,
					"name": "Panel"
				}
			}
		},
                
		{
			"subclass": "LabelClass",
			"parent": "idFSP_16",
			"height": "29",
			"width": "59",
			"top": "10",
			"left": "6.1",
			"VIU": {
				"id": "idLabel_23",
				"label": "Estado",
				"name": "",
				"style": "",
				"theClass": "ui-corner-all",
				"mobile": {
					"action": 3,
					"name": ""
				}
			}
		},
		{
			"subclass": "SliderClass",
			"parent": "idFSP_16",
			"height": "9",
			"width": "40",
			"top": "8",
			"left": "61",
			"VIU": {
				"id": "idSJornada",
				"maxLength": "",
				"disabled": "",
				"theClass": "ui-corner-all",
				"range": "min",
				"min": "0",
				"max": "1",
				"value": "0",
				"orientation": "horizontal",
                "style": "background:red",
				"mobile": {
					"action": 4,
					"name": "P"
				}
			}
		},
		{
			"subclass": "LabelClass",
			"parent": "idFSP_16",
			"height": "25",
			"width": "150",
			"top": "9",
			"left": "110",
			"VIU": {
				"id": "idLabelEstado",
				"label": "(Jornada Cerrada)",
				"name": "",
				"style": "",
				"theClass": "",
				"mobile": {
					"action": 3,
					"name": ""
				}
			}
		},

		{
			"subclass": "JQBotonClass",
			"parent": "idFSP_15",
			"height": "34",
			"width": "35",
			"top": "3",
			"left": "225",
			"VIU": {
				"id": "idTerminarJornada",
				"maxLength": "",
				"value": "0",
				"disabled": "",
				"theClass": "",
				"primary": "ui-icon-radio-on",
				"secondary": "",
				"text": "",
				"caption": "Terminar Jornada",
				"idCaption": "idCap_15",

			}
		},
		{
			"subclass": "JQBotonClass",
			"parent": "idFSP_15",
			"height": "34",
			"width": "35",
			"top": "3",
			"left": "264",
			"VIU": {
				"id": "idReservaFolios",
				"maxLength": "",
				"value": "0",
				"disabled": "",
				"theClass": "ui-corner-all",
				"primary": "ui-icon-grip-solid-horizontal",
				"secondary": "",
				"caption": "Reservar Folios",
                                "text":"true",
				"idCaption": "idCap_16",

			}
		}
	]
};

            dependence(this.platilla);//importa todos los js que necesita la pagina para funcionar
            $("#idContenedor").run(this.platilla);
            var objJornada = $( "#idSJornada" );

<?php
            $sql = "select jor_codigo, jor_estado from jornada where jor_fecha = curdate()";
            $query = mysqli_query($link, $sql);   

            //$fila = mysql_fetch_assoc($result);
            $fila = mysqli_fetch_array($query);

            $jor_codigo = $fila["jor_codigo"];
            $jor_estado = $fila["jor_estado"];

            $color = 'blue';
            $estadoBoton = 'disable';
            $estadoBotonFolios = 'enable';
            $label = "(Jornada Abierta)";

            echo '            var jor_codigo = "'.$jor_codigo.'";';
            if($jor_codigo == "" || $jor_estado == 0){
                $jor_estado = 0;
                $color = "red";
                $estadoBoton = 'enable';
                $estadoBotonFolios = 'disable';
                $label = "(Jornada Cerrada)";
            }
            echo '            objJornada.slider( "value", '.$jor_estado.');';
            echo '            objJornada.attr("estadoAnterior",'.$jor_estado.');';
            echo '            objJornada.css("background", "'.$color.'");';
            echo '            $("#idTerminarJornada").button( "'.$estadoBoton.'" );';
            echo '            $("#idReservaFolios").button( "'.$estadoBotonFolios.'" );';
            echo '            $("#idLabelEstado").html("'.$label.'");';
            
?>


            $( "#idSJornada" ).on( "slidechange", function( event, ui ) {
                var obj = $( "#idSJornada" );
                var value = obj.slider( "value");
                var estadoAnterior = obj.attr("estadoAnterior");
                if(value == estadoAnterior){
                    return;
                }
                var label = "(Jornada Abierta)";

                if(value == 0){
                    obj.css("background", "red");
                    var conf = confirm("Esta accion deshabilita el dispensador, por lo que no se podran emitir mas ticket. ¿Esta usted seguro de continuar?");
                    if(conf){
                        label = "(Jornada Cerrada)";
                        $("#idTerminarJornada").button( "enable" );
                        $("#idReservaFolios").button( "disable" );
                    }else{
                        value = 1;
                        obj.slider( "value", value);
                        obj.css("background", "blue");
                        return;
                    }
                }else{
                    obj.css("background", "blue");
                    $("#idTerminarJornada").button( "disable" );
                    $("#idReservaFolios").button( "enable" );
                }
                $("#idLabelEstado").html(label);
                obj.attr("estadoAnterior",value);

                setEstadoJornada(value);
            });

            $("#idContenedor #idTerminarJornada").click(function() {terminarJornada()});
            $("#idContenedor #idReservaFolios").click(function() {reservaFolios()});

        });


        function setEstadoJornada(estado){
            var url = "administrar.estadojornada.php?estado="+estado;
            $.ajax(
                {
                    url: url
                }).done(function(result) {
                    
                }
             );
        }

        function terminarJornada(){
            refresh();
            setTimeout(terminarJornadaPostRefresh, 100);
        }
        
        function reservaFolios(){
            $("#dialog").remove();
            
            var html =   
                    '<div id="dialog" title="Reserva de Folios">'+
                    
                    '<b>Fila:</b> '+
                    '<select id="codigo">'+
                    
                    <?php
                        $sql = "select fil_codigo, fil_nemo, fil_nombre from fila";
                        $query = mysqli_query($link, $sql);   

                        
                        echo "'";
	                while ($fila = mysqli_fetch_array($query))
	                {
                            $codigo = $fila["fil_codigo"].":".$fila["fil_nemo"];
		            echo '<option value="'.$codigo.'">'.$fila["fil_nombre"].'</option>';
	                }
                        echo "'+";
                    ?>

                    '</select><br/>'+
                    
                    '<b>Cantidad de reserva:</b> '+
                    '<input type="text" id="cantidadReserva" value="100"/><br/>'+
                    
                    '</div>';
            
            var obj = $(html);
            
            obj.dialog(
            {
                resizable: false,
                modal: true,
                buttons: {
                    "Aceptar": function() {
                        ejecutaReservaFolios();
                    },
                    "Cancelar": function() {
                        $( this ).dialog( "close" );
                    }
                 }
            });
        }
        
        function ejecutaReservaFolios(){
            var dialog = $("#dialog");
            var cantidadReserva = dialog.find("#cantidadReserva").val();
            var cantidadFilas   = dialog.find("#cantidadFilas").val();
            var codigo   = dialog.find("#codigo").val();
            
            dialog.dialog( "close" );
            
            var html = "<div>Procesando...</div>";
            dialog = $(html);
            dialog.dialog(
            {
                resizable: false,
                modal: true,
                buttons: {
                    "Cerrar": function() {
                        $( this ).dialog( "close" );
                    }
                 }
            });
            
            var url = "ejecutaReservaFolios.ajax.php?cantidadReserva="+cantidadReserva+"&cantidadFilas="+cantidadFilas+"&codigo="+codigo;
            $.ajax(
               {
                   url: url,
                   async:true
               }).done(function(result) {
                   if(result.substr(0,5)=="ERROR"){
                       dialog.html("<b>Ocurrio un problema al realizar la accion:</b> <br/>"+result);
                   }else{
                        var obj = jQuery.parseJSON(result);
                        if(obj.status ==="OK"){
                            var url = "ejecutaReservaFolio.ajax.pdf.php?datos="+result;
                            dialog.html("<b>La reserva fue realizada exitosamente:</b><br/><a href='"+url+"'>Reserva</a>");
                        }else{
                            dialog.html("<b>Ocurrio un problema al realizar la accion");
                        }
                   }
                   refresh();
               }
            );
        }
        
        

        function terminarJornadaPostRefresh(){
            var registro = $('.bDiv tbody').children();
            
            var seguir = false;
            var i=0;
            while(seguir == false && i<registro.length){
                var solicitadas = registro[i].childNodes[1].childNodes[0].childNodes[0].textContent;
                var atendidas   = registro[i].childNodes[2].childNodes[0].childNodes[0].textContent;
                seguir = (seguir || solicitadas > atendidas);

                i++;
            }
            var msg = "¿Esta seguro que desea terminar la jornada?";
            if(seguir){
                msg = "Existen filas que aun tienen solicitudes pendiente. ¿Esta seguro que desea terminar la jornada?";
            }

            seguir = !confirm(msg);

            if(!seguir){
                var url = "administrar.terminarJornada.php";
                $.ajax(
                    {
                        url: url
                    }).done(function(result) {
                        refresh();
                        alert("El proceso de termino de jornada fue ejecutado");
                    }
                 );
            }
        }

        function refresh(){
             var idFlexiGridData = $('#idListaCajas').find('.tabla');

             idFlexiGridData.flexOptions(
                 {onSuccess: function() {
                 }
             }).flexReload();
        }
        </script>

        <div id='idContenedor' >

        </div>
<?php }?>


<?php include("footer.php");?>

