
function AcordionClass(){
	this.width = 250;
	this.height = 300;
	
	this.properties = 
	{
		id:"idAcordion_" + iContadorObjeto,
		disabled:'',
		name:'',
		style:'',
		theClass:'ui-corner-all',
		nodes:new Array(),
		collapsible: '',
		mobile:{action:1,name:'A'},
	};
	
	this.getHtml = function(padre, mode){
		var domElement = $("#"+this.properties.id);
		return domElement.html();
	}
	
	this.create = function(padre, mode, isMobil){
		this.properties.id = generateID(mode, this.properties.id, 'idAcordion_');
	
		var html = "<div "+ getProperties(mode, this.properties) +"></div>";
		
		var htmlObject = $(html);
		htmlObject.appendTo( padre );
		
		var nodes = this.properties.nodes;
		this.properties.nodes = new Array();
		
		var push = ((mode*1) == 0);
		for(var i=0; i<nodes.length; i++){
			this.addNode(nodes[i].text, this.properties.id, push, mode, nodes[i]);
			
			var idPanelTab = nodes[i].id;
			var panelTab = $("#"+idPanelTab);
			var objTab = $("#"+this.properties.nodes[i].id);
			
			creteChildenTab(panelTab, objTab, mode);
		}
		
		
		if(this.properties.nodes.length == 0){
			this.addNode("Section 1", this.properties.id, true, mode, "");
			this.addNode("Section 2", this.properties.id, true, mode, "");
		}
		
		var collapsible = false;
		if((mode*1) != 0){
			if(this.properties.collapsible != ""){
				collapsible = true;
			}
		}
		
		htmlObject.accordion({collapsible: this.properties.collapsible});
		htmlObject.css("font-size", calculaZoom(10, 100, zoom) + "px");
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "AcordionClass");

		return htmlObject;
	}
	
	this.getFromDom = function(elementoSeleccionado){
		var jsonStr = elementoSeleccionado.attr("VIU");
		this.properties = jQuery.parseJSON(jsonStr);
	}
	
	this.addNode = function(text, idPadre, push, mode, nod){
		var iContadorObjeto = randomId();
		var id = "";
		var idH3 = "";

		
		if(nod == ""){
			id = "panel_"+iContadorObjeto;
			idH3 = "h3_"+iContadorObjeto;	
		}else{
			id = nod.id;
			idH3 = nod.idH3;
		}
		
		
		var padre = $("#"+idPadre);
		var html =
		"	<h3 id='"+idH3+"'>" + text + "</h3>"+
		"	<div id='"+id+"' class='VIU' style='position:relative;'>"+
		"	</div>";
		
		var node = 
		{
			id:id,
			text:text,
			padre:idPadre,
			idH3:idH3,
		};
		
		this.properties.nodes.push(node);
		
		var htmlObject = $(html);
		htmlObject.appendTo( padre );
		
		if(push){
			var panel = $("#"+id);
			panel.droppable({
				hoverClass: "ui-state-hover",

				drop: function( myEvento, myUi ) {
					return onDropEventPanel(myEvento, myUi, this);
				}
			});
		}
	}
	

	this.resize = function(heightResize100, widthResize100){
		var difH = calculaZoom((this.properties.nodes.length+1)*28, 100, zoom);
		var difW = calculaZoom(56, 100, zoom);
		
		var domElement = $("#"+this.properties.id);
		domElement.css("height", (heightResize100-10)+"px");
		domElement.css("width", (widthResize100-10)+"px");
	
		for(var i=0; i<this.properties.nodes.length; i++){
			var nodo = this.properties.nodes[i];
			
			var domTab = $("#"+nodo.id);
			domTab.css("height", (heightResize100-difH)+"px");
			domTab.css("width", (widthResize100-difW)+"px");
		}
	}
	
	this.editDialog = function(){
	}
	
	this.getPropertisList = function(){
		var ret = new Array();
		ret.push({name:'Collapsible', attr:'collapsible', type:3, value:this.properties.collapsible});
		
		ret.push({name:'New Node', type:1, func:"nuevoNode"});
		ret.push({name:'Rename Node', type:1, func:"renameTab"});
		ret.push({name:'Remove Node', type:2, func:"eliminarTAB"});

		ret.push({name:'Mobile Version',attr:'mobile.action',   type:4, value:this.properties.mobile.action, list:getMobileList()});
		ret.push({name:'Mobile Name'   ,attr:'mobile.name',     type:0, value:this.properties.mobile.name});
		return ret;
	}
	
	this.nuevoNode = function(valor){
		var htmlObject = $("#"+this.properties.id);
		var parent = $("#"+this.properties.id).parent();
		
		this.addNode(valor, this.properties.id, true, 0, "");
		var tabs = htmlObject.accordion();
		tabs.accordion('destroy').accordion();

		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);

		var parent = htmlObject.parent();
		var height = quitaPX(parent.css("height"))*1;
		var width = quitaPX(parent.css("width"))*1;
		this.resize(calculaZoom(height, 100, zoom), calculaZoom(width, 100, zoom));
	}
	
	this.renameTab = function(value){
		var htmlObject = $("#"+this.properties.id);
		var active = htmlObject.find('.ui-accordion-header-active');
		
		active.html(value)
		var idH3 = active.attr("id");
		var continuar = true;
		var i=0;
		while(continuar && i<this.properties.nodes.length){
			var nodo = this.properties.nodes[i];
			if(nodo.idH3 == idH3){
				this.properties.nodes[i].text = value;
				continuar = false;
			}
			
			i++;
		}
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
	}
	
	this.eliminarTAB = function(){
		if(this.properties.nodes.length == 1){
			alert("Debe existir almenos un NODO en el objeto");
			return;
		}
	
		var htmlObject = $("#"+this.properties.id);
		var active = htmlObject.find('.ui-accordion-header-active');
		
		var idH3 = active.attr("id");
		var continuar = true;
		var i=0;
		while(continuar && i<this.properties.nodes.length){
			var nodo = this.properties.nodes[i];
			if(nodo.idH3 == idH3){
				continuar = false;
			}
			
			i++;
		}
		var selectedTab = i-1;
		
		$("#"+this.properties.nodes[selectedTab].idH3).remove();
		$("#"+this.properties.nodes[selectedTab].id).remove();
		
		this.properties.nodes.splice(selectedTab, 1);
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
	}
	
	this.attr = function(name, value){
		eval("this.properties." + name +" = value;");
		var htmlObject = $("#"+this.properties.id);
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
			
		var domElement = $("#"+this.properties.idObject);
		domElement.attr(name, value);
	}
	
	this.getAttr = function(name){
		var domElement = $("#"+this.properties.idObject);
		eval("ret = this.properties."+name);
		return ret;
	}
}

