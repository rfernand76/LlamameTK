function Report(p){
    this.parametros = p;
    this.platilla = 
{
	"format": {
		"version": "1.0.3",
		"create": "2014-12-28T22:18:39.579Z",
        "cssFormat": "redmond"
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
			"subclass": "ToolbarClass",
			"parent": "droppable",
			"height": "50",
			"width": "953",
			"top": "0",
			"left": "0",
			"VIU": {
				"id": "idToolbarClass_2",
				"disabled": "",
				"name": "",
				"style": "",
				"theClass": "ui-state-default ui-corner-all",
				"mobile": {
					"action": 1,
					"name": "Menu"
				},
				"bars": [
					{
						"helpText": "File",
						"id": "idBarFile",
						"elements": [
							{
								"type": "button",
								"label": "Excel",
                                "helpText": "Exportar a formato Excel",
								"id": "buttonExcel",
								"classIcon": "ui-icon-suitcase",
                                text:true,
                        
							}/*,
							{
								"type": "button",
								"label": "PDF",
                                "helpText": "Exportar a formato PDF",
								"id": "buttonPDF",
								"classIcon": "ui-icon-note",
                                text:true,
							},
							{
								"type": "button",
								"label": "Texto",
                                "helpText": "Exportar a archivo de texto",
								"id": "buttonTxt",
								"classIcon": "ui-icon-document",
                                text:true,
							}*/
						]
					}
				]
			}
		},
		{
			"subclass": "AcordionClass",
			"parent": "droppable",
			"height": "346",
			"width": "240",
			"top": "40",
			"left": "0",
			"VIU": {
				"id": "idAcordion_8",
				"disabled": "",
				"name": "",
				"style": "",
				"theClass": "ui-corner-all",
				"nodes": [
					{
						"id": "panel_8",
						"text": "Periodo",
						"padre": "idAcordion_8",
						"idH3": "h3_8"
					},
					{
						"id": "panel_11",
						"text": "Rango de Fechas",
						"padre": "idAcordion_8",
						"idH3": "h3_11"
					}
				],
				"collapsible": "",
				"mobile": {
					"action": 1,
					"name": "A"
				}
			}
		},
		{
			"subclass": "DynatreeClass",
			"parent": "panel_8",
			"height": "261",
			"width": "233",
			"top": "0",
			"left": "-11",
			"VIU": {
				"id": "idDynatree",
				"disabled": "",
				"name": "",
				"style": "",
				"theClass": "ui-corner-all",
				"mobile": {
					"action": 1,
					"name": "D"
				},
				"data": [
					{
						"title": "Hoy",
						"isFolder": false,
						"key": "dthoy",
						"tooltip": "Muestra los datos del dia"
					},
					{
						"title": "Ayer",
						"isFolder": false,
						"key": "dtayer",
						"tooltip": "Muestra los datos del dia de anterior"
					},
					{
						"title": "Semana",
						"isFolder": false,
						"key": "dtsemana",
						"tooltip": "Ultimos 7 dias"
					},
					{
						"title": "Ultimo mes",
						"isFolder": false,
						"key": "dtmes",
						"tooltip": "Muestra los datos de los ultimos 30 dias"
					}
				]
			}
		},
		{
			"subclass": "PanelClass",
			"parent": "panel_11",
			"height": "256",
			"width": "204",
			"top": "10",
			"left": "0",
			"VIU": {
				"id": "idPanel_22",
				"idPanel": "idFSP_22",
				"name": "",
				"style": "",
				"theClass": "",
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
			"parent": "idFSP_22",
			"height": "29",
			"width": "70",
			"top": "11",
			"left": "11.9",
			"VIU": {
				"id": "idLabel_19",
				"label": "Desde",
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
			"subclass": "InputClass",
			"parent": "idFSP_22",
			"height": "40",
			"width": "183",
			"top": "23.9",
			"left": "11.9",
			"VIU": {
				"id": "idDatepickerDesde",
				"maxLength": "",
				"size": "",
				"disabled": "",
				"style": "",
				"name": "",
				"theClass": "ui-corner-all",
				"mobile": {
					"action": 3,
					"name": "Spinner"
				}
			}
		},
		{
			"subclass": "LabelClass",
			"parent": "idFSP_22",
			"height": "26",
			"width": "75",
			"top": "65",
			"left": "11.9",
			"VIU": {
				"id": "idLabel_31",
				"label": "Hasta",
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
			"subclass": "InputClass",
			"parent": "idFSP_22",
			"height": "40",
			"width": "183",
			"top": "74.8",
			"left": "11.9",
			"VIU": {
				"id": "idDatepickerHasta",
				"maxLength": "",
				"size": "",
				"disabled": "",
				"style": "",
				"name": "",
				"theClass": "ui-corner-all",
				"mobile": {
					"action": 3,
					"name": "Spinner"
				}
			}
		},
		{
			"subclass": "JQBotonClass",
			"parent": "idFSP_22",
			"height": "37",
			"width": "167.0",
			"top": "120",
			"left": "11.9",
			"VIU": {
				"id": "idBuscarPorRango",
				"maxLength": "",
				"value": "0",
				"disabled": "",
				"theClass": "ui-corner-all",
				"primary": "",
				"secondary": "",
				"text": "",
				"caption": "Buscar",
				"idCaption": "idCap_43",
				"name": "",
				"mobile": {
					"action": 3,
					"name": "B"
				}
			}
		},
		{
			"subclass": "TabClass",
			"parent": "droppable",
			"height": "340",
			"width": "722",
			"top": "41",
			"left": "235",
			"VIU": {
				"tabs": [
					{
						"idLi": "tabLi_12",
						"idDiv": "tabDiv_12",
						"idPanelTab": "panelTab_12",
						"text": "Datos",
						"padre": "idTab_10"
					},
					{
						"idLi": "tabLi_13",
						"idDiv": "tabDiv_13",
						"idPanelTab": "panelTab_13",
						"text": "Grafico",
						"padre": "idTab_10"
					}
				],
				"id": "idTab_10",
				"disabled": "",
				"idUl": "idTabUl_10",
				"collapsible": "",
				"event": "",
				"name": "",
				"style": "",
				"sortable": "",
				"theClass": "ui-corner-all",
				"mobile": {
					"action": 1,
					"name": "T"
				}
			}
		},
		{
			"subclass": "FlexiGridClass",
			"parent": "panelTab_12",
			"height": "308",
			"width": "714",
			"top": "33.4",
			"left": "2.8",
			"VIU": {
				"id": "idFlexiGrid",
				"disabled": "",
				"name": "",
				"style": "",
				"theClass": "",
				"url": "",
				"dataType": "json",
				"title": "Reporte",
				"usepager": true,
				"useRp": true,
				"rp": 20,
				"showTableToggleBtn": false,
				"resizable": false,
				"singleSelect": false,
				"sortname": "",
				"sortorder": "",
				"striped": false,
				"width": 712,
				"height": 218,
				"mobile": {
					"action": 1,
					"name": "Data"
				}
			}
		},
		{
			"subclass": "DivClass",
			"parent": "panelTab_13",
			"height": "290",
			"width": "705",
			"top": "38",
			"left": "5",
			"VIU": {
				"id": "graficoDiv",
				"name": "",
				"style": "overflow:auto;",
				"theClass": "",
				"title": "",
				"align": "",
				"url": "",
				"mobile": {
					"action": 1,
					"name": ""
				}
			}
		}
	]
}
    ;

    this.create = function(){
        dependence(this.platilla);//importa todos los js que necesita la pagina para funcionar
        addDependence({modulo_name:"jquery-ui", resource_name:"datepicker"});//importa todos los js que necesita la pagina para funcionar

        var jsonStr = JSON.stringify(this.parametros);
        var listaCampos = this.parametros.colModel;
        var flexiGrid = this.platilla.fields[10].VIU;

        flexiGrid.colModel = listaCampos;

        $("#idContenedor").run(this.platilla);
        var me = this;

        
        $("#idContenedor #buttonExcel").click(function() {me.excel()});
        $("#idContenedor #idToolbar2").click(function() {me.pdf()});
        $("#idContenedor #idToolbar3").click(function() {me.texto()});
        $("#idContenedor #idDynatree").click(function() {me.dynatree()});
        $("#idContenedor #idBuscarPorRango").click(function() {me.buscarPorRango()});

        $("#idContenedor #idDatepickerDesde").datepicker({dateFormat: "yy-mm-dd"});
        $("#idContenedor #idDatepickerHasta").datepicker({dateFormat: "yy-mm-dd"});

       flexiGrid.title = this.parametros.title;
    }

    this.excel = function(){
        if(this.parametros.params != undefined){
            var jsonStr = JSON.stringify(this.parametros.params);
            var jsonHeader = JSON.stringify(this.parametros);
            
            var url = this.parametros.url + "?method=exportToExcel&params="+jsonStr+"&jsonHeader="+jsonHeader;
            window.open(url, '_blank');
        }
    }

    this.dynatree = function(){
        var tree = $("#idContenedor #idDynatree");
        var node = tree.dynatree("getActiveNode");
        if (node) {
            var data = node.data;
            var param = {key: data.key};
            this.refresh(param);
            
        }
    }

    this.refresh = function(params){
        var idFlexiGridData = $('#idFlexiGrid').find('.tabla');
        var jsonStr = JSON.stringify(params);
        this.parametros.params = params;

        var me = this;
        idFlexiGridData.flexOptions(
        {
            url: this.parametros.url,
            params: [{name:'method', value: "create"}, {name:'params', value: jsonStr}], 
            onSuccess: function() {me.grafica(idFlexiGridData);}
        }).flexReload();
    }

    this.buscarPorRango = function(){
        var desde = $("#idContenedor #idDatepickerDesde").val();
        var hasta = $("#idContenedor #idDatepickerHasta").val();

        var param = {key:"dtrango", desde:desde, hasta:hasta};
        this.refresh(param);
    }

    this.randomScalingFactor = function(){ return Math.round(Math.random()*100)};

    this.valueFromGrid = function(fila, c, isNumeric) {
        var valor = fila.childNodes[c];
        var cell = $(valor.innerHTML);

        var v = cell.html();
        if(isNumeric){
           v =  (v.replace(",", ".") * 1);
        }
        return v;
    }

    this.grafica = function(idFlexiGridData){
        var graficoDiv = $("#graficoDiv");
        var height = 250;
        var width = 690;

        var labels = new Array();
        var tabla = idFlexiGridData.children().children();
        var datasets = new Array();
        var indexDatasets = 0;

        var grafica = false;
        for(var e=0; e<this.parametros.colModel.length; e++){
            if(this.parametros.colModel[e].graphic != undefined){
                grafica = true;
                if(this.parametros.colModel[e].graphic.type == "labels"){
                    for (var i=0; i<tabla.length; i++) {
                        var fila = tabla[i];
                        labels[i] = this.valueFromGrid(fila, e, false).substring(0, 10);
                    }
                }else{
                    datasets[indexDatasets] = this.parametros.colModel[e].graphic;
                    datasets[indexDatasets].data = new Array();

                    for (var i=0; i<tabla.length; i++) {
                        var fila = tabla[i];
                        datasets[indexDatasets].data[i] = this.valueFromGrid(fila, e, true);
                    }
                    indexDatasets++;
                }
            }
        }

        if(grafica){
            $("#canvas").remove();
            var html = "<canvas id='canvas' height='"+height+"' width='"+width+"'></canvas>";
            var objHtml = $(html);
            objHtml.appendTo(graficoDiv);

            var barChartData = {
		        labels : labels,
		        datasets : datasets
	        };

            var canvas = document.getElementById("canvas");
		    var ctx = canvas.getContext("2d");
		    window.myBar = new Chart(ctx).Bar(barChartData, {responsive : false});
        }else{
            $("#canvas").remove();
            var html = "<div id='canvas' class='noreport'><h1>El reporte no tiene un grafico disponible<h1></div>";
            var objHtml = $(html);
            objHtml.appendTo(graficoDiv);
        }
    }    
}
