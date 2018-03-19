var platilla =
{
	"format": {
		"version": "1.0.3",
		"create": "2015-01-03T01:18:30.923Z",
	},
	"page": {
		"width": 900,
		"height": 243,
		"top": 0,
		"left": 0,
		"name": "",
		"mobilesupport": false
	},
	"fields": [
		{
			"subclass": "ToolbarClass",
			"parent": "droppable",
			"height": "47.1",
			"width": "393",
			"top": "1",
			"left": "0",
			"VIU": {
				"id": "idToolbarClass_4",
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
								"helpText": "Llamar Proximo",
								"id": "llamar",
								"classIcon": "ui-icon-play",
								"text": true
							},
							{
								"type": "button",
								"helpText": "Repetir",
								"id": "repetir",
								"classIcon": "ui-icon-seek-next",
								"text": true
							},
							{
								"type": "button",
								"helpText": "Atender",
								"id": "atender",
								"classIcon": "ui-icon-circle-check",
								"text": true
							},
							{
								"type": "button",
                                "helpText": "Pausar",
								"id": "continua",
								"classIcon": "ui-icon-pause",
								"text": true
							}
						]
					}
				]
			}
		},
		{
			"subclass": "AcordionClass",
			"parent": "droppable",
			"height": "235",
			"width": "490",
			"top": "0",
			"left": "440",
			"VIU": {
				"id": "idAcordionEstaditicas",
				"disabled": "",
				"name": "",
				"style": "",
				"theClass": "ui-corner-all",
				"nodes": [
					{
						"id": "panelDatosGenerales",
						"text": "Mis Datos",
						"padre": "idAcordionEstaditicas",
						"idH3": "h3_1"
					},
					{
						"id": "panelEstadisticas",
						"text": "Estadisticas Filas",
						"padre": "idAcordionEstaditicas",
						"idH3": "h3_2"
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
			"subclass": "DivClass",
			"parent": "panelDatosGenerales",
			"height": "167",
			"width": "470",
			"top": "10",
			"left": "10",
			"VIU": {
				"id": "idDivDatosGenerales",
				"name": "",
				"style": "overflow:auto; font-family: arial, sans-serif; font-size: 13px; color: #999ea2;",
				"theClass": "ui-helper-reset ui-corner-all ui-accordion-icons; ",
				"title": "",
				"align": "",
				"url": "datosGenerales.html",
				"mobile": {
					"action": 1,
					"name": ""
				}
			}
		},
		{
			"subclass": "FlexiGridClass",
			"parent": "panelEstadisticas",
			"height": "240",
			"width": "482",
			"top": "0",
			"left": "-1",
			"VIU": {
				"id": "estadisticasFilas",
				"disabled": "",
				"name": "",
				"style": "",
				"theClass": "",
				"url": "",
				"dataType": "json",
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
				"colModel": [
					{
						"display": "Fila",
						"name": "fil_nombre",
						"width": 120,
						"sortable": true,
						"align": "left"
					},
					{
						"display": "Letra",
						"name": "fil_nemo",
						"width": 30,
						"sortable": true,
						"align": "left"
					},
					{
						"display": "Modulo",
						"name": "eje_modulo",
						"width": 30,
						"sortable": true,
						"align": "right"
					},
					{
						"display": "Ultimo Solicitado",
						"name": "fil_ut",
						"width": 90,
						"sortable": true,
						"align": "right"
					},
					{
						"display": "Ultimo Atendido",
						"name": "fil_ta",
						"width": 90,
						"sortable": true,
						"align": "right"
					}
				]
			}
		},
		{
			"subclass": "TabClass",
			"parent": "droppable",
			"height": "186",
			"width": "398",
			"top": "43",
			"left": "0",
			"VIU": {
				"tabs": [
					{
						"idLi": "tabLi_4",
						"idDiv": "tabDiv_4",
						"idPanelTab": "panelTab_4",
						"text": "Mi último llamado",
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
			"subclass": "DivClass",
			"parent": "panelTab_4",
			"height": "146",
			"width": "388",
			"top": "33",
			"left": "2",
			"VIU": {
				"id": "atendiendo",
				"name": "",
				"style": "overflow:auto; font-size:90px;text-align: center;",
				"theClass": "ultimoLlamado ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons",
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