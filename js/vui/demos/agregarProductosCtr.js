function agregarProductosCtr(){
	var form = 
		{"format":{"version":"1.0.1","create":"2013-09-24T17:33:19.597Z"},
		 "page":{"width":800,"height":600,"top":0,"left":0,"name":""}
		 ,"fields":
		 [
				{"subclass":"FlexiGridClass","parent":"droppable","height":"549.7","width":"547.7","top":"48.2","left":"250.2",
					"VIU":{"id":"idFlexiProductos"
					,"caption":"FlexiGrid"
					,"disabled":""
					,"name":"","style":""
					,"theClass":""
					,"url":"php/todosLosProductos.php"
					,"dataType":"json"
					,"title":"Productos por categoria"
					,"usepager":true
					,"useRp":true
					,"rp":"20"
					,"showTableToggleBtn":false
					,"resizable":false
					,"singleSelect":false
					,"sortname":"iso"
					,"sortorder":"asc"
					,"striped":false
					,"width":794.7
					,"height":459.70000000000005
					,"colModel":[
						 {"display":"Sel" ,"name":"seleccionar" ,"width":30,"sortable":true,"align":"left"}
						,{"display":"Nombre"      ,"name":"nombre"      ,"width":200,"sortable":true,"align":"left"}
						,{"display":"Categoria"   ,"name":"categoria"   ,"width":130,"sortable":true,"align":"left"}
						,{"display":"Descripcion" ,"name":"descripcion" ,"width":220,"sortable":true,"align":"left"}
						,{"display":"Fabricante"  ,"name":"fabricante"  ,"width":100,"sortable":true,"align":"left"}
						,{"display":"Unidad"      ,"name":"unidad"      ,"width":60,"sortable":true,"align":"left"}
						]
					,"searchitems":[{"display":"Nombre","name":"Nombre","isdefault":true}]
					}
				}
			,{"subclass":"ToolbarClass","parent":"droppable","height":"48.7","width":"793","top":"0","left":"2",
				"VIU":{"id":"idToolbarAddProducts","disabled":"","name":"","style":"","theClass":"ui-state-default ui-corner-all"
					,"bars":
					[{"helpText":"File","id":"idBarFile",
						"elements":
						[
							 {"type":"button","helpText":"Hacer Favoritos los productos seleccionados","id":"idAceptar","classIcon":"ui-icon-star"}
							,{"type":"button","helpText":"Volver","id":"idClose","classIcon":"ui-icon-home"}
						]
					  }
					]}
			}
			,{"subclass":"DynatreeClass","parent":"droppable","height":"544.7","width":"244","top":"48.9","left":"2",
				"VIU":{"id":"idDynatree_6","disabled":"","name":"","style":"","theClass":"ui-corner-all",
				"data":
				[
					 {"title":"Frutas y verduras"}
					 ,{"title":"Legumbres y cereales"}
					 ,{"title":"Huevos y lácteos"}
					 ,{"title":"Aceites y vinagres"}
					 ,{"title":"Hierbas e infusiones"}
					 ,{"title":"Miel"}
					 ,{"title":"Vinos y bebidas"}
					 ,{"title":"Mermeladas y conservas"}
					 ,{"title":"Panadería"}
					 ,{"title":"Aliños"}
					 ,{"title":"Otros"}
				]}
			}
		  ]
		}
	;
		
	this.patern = {};
	this.id = "";
	this.selector = "";
	
	this.execute = function(id, title, patern){
		this.patern = patern;
		this.id = id;
		this.selector = "#"+id;
		this.title = title;
		this.show();
	}
	
	this.show = function(){
		dependence(form);//importa todos los js que necesita la pagina para funcionar
		this.closeDialog();
		var html = "<div id='"+this.id+"' title='"+this.title+"' class='ui-state-default ui-corner-all'></div>";
		
		var win = $(html);
		win.dialog({autoOpen: true, resizable: false, modal: true, width: (form.page.width), height: (form.page.height)});
		
		win.dialog( "open");
		win.run(form);
		
		this.setEvents();
		this.load();
	}
	
	this.closeDialog = function(){
		$(this.selector).dialog( "close" );
		$(this.selector).remove();
	}
	
	this.setEvents = function(){
		var dialog = $(this.selector);
		var me = this;
		//dialog.find("#idAceptar").click(function() {me.closeDialog()});	//new
		dialog.find("#idClose").click(function() {me.closeDialog()});	//new
	}
	
	this.load = function(){
	}
	
}
