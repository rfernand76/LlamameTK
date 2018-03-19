
var iContadorTab = 0;
function TabClass(){
	this.width = 250;
	this.height = 300;
	
	
	this.properties = 
	{
		tabs:new Array(),
		id:"idTab_" + iContadorObjeto,
		disabled:'',
		idUl:"idTabUl_" + iContadorObjeto,
		collapsible:'',
		event:"",
		name:'',
		style:'',
		sortable:'',
		theClass:'ui-corner-all',
		mobile:{action:1, name:'T'},
	};
	
	this.create = function(padre, mode, isMobil){
		this.properties.id = generateID(mode, this.properties.id, 'idTab_');
		this.properties.idUl = generateID(mode, this.properties.idUl, 'idTabUl_');
	
		var html = 
		"<div "+ getProperties(mode, this.properties) +">"+
		"<ul id='"+this.properties.idUl+"'>"+
		"</ul>"+
		"</div>";
		
		var htmlObject = $(html);
		htmlObject.appendTo( padre );
		
		var tabs = this.properties.tabs;
		this.properties.tabs = new Array();
		
		var push = ((mode*1) == 0);
		for(var i=0; i<tabs.length; i++){
			this.addNode(tabs[i].text, this.properties.idUl, htmlObject, push, mode, tabs[i]);
			
			var idPanelTab = tabs[i].idPanelTab;
			var panelTab = $("#"+idPanelTab);
			var objTab = $("#"+this.properties.tabs[i].idPanelTab);
			
			creteChildenTab(panelTab, objTab, mode);
		}
		
		var creado = false;
		if(this.properties.tabs.length == 0){
			this.addNode("Tab 1", this.properties.idUl, htmlObject, true, mode, "");
			creado = true;
		}
		
		var collapsible = false;
		var sortable = false;
		var event;
		if((mode*1) != 0){
			if(this.properties.collapsible != ""){
				collapsible = true;
			}
			
			if(this.properties.sortable != ""){
				sortable = true;
			}
			
			if(this.properties.event != ""){
				event = this.properties.event;
			}
		}
		var tabs = htmlObject.tabs({collapsible: collapsible, event: event});
		if(sortable){
			tabs.find( ".ui-tabs-nav" ).sortable({      axis: "x",      stop: function() {        tabs.tabs( "refresh" );      }    });
		}
		
		if(creado){
			this.resize(calculaZoom(this.height, 100, zoom), calculaZoom(this.width, 100, zoom));
		}
		htmlObject.css("font-size", calculaZoom(10, 100, zoom) + "px");
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "TabClass");

		return htmlObject;
	}
	
	this.getFromDom = function(elementoSeleccionado){
		var jsonStr = elementoSeleccionado.attr("VIU");
		this.properties = jQuery.parseJSON(jsonStr);
	}
	
	this.addNode = function(text, idUl, padre, push, mode, tab){
	
		var idLi = "";
		var idDiv = "";
		var idPanelTab = "";
		iContadorTab++;
		if(tab == ""){
			idLi = "tabLi_"+iContadorTab;
			idDiv = "tabDiv_"+iContadorTab;
			idPanelTab = "panelTab_"+iContadorTab;		
		}else{
			idLi = tab.idLi;
			idDiv = tab.idDiv;
			idPanelTab = tab.idPanelTab;
		}
		var htmlLi = "<li><a id='"+idLi+"' href='#"+ idDiv +"'>" + text + "</a></li>";
		var htmlDiv = "<div id='"+idDiv+"'><div class='VIU' style='overflow:aunto;' topAnt='40' id='"+idPanelTab+"'></div></div>";
		
		var node = 
		{
			idLi:idLi,
			idDiv:idDiv,
			idPanelTab:idPanelTab,
			text:text,
			padre:padre.attr("id"),
		};
		
		var htmlNewUL = $(htmlLi);
		var divUL = $("#"+idUl);
		htmlNewUL.appendTo( divUL );
		
		var htmlNewDiv = $(htmlDiv);
		htmlNewDiv.appendTo( padre );
		
		
		this.properties.tabs.push(node);
		
		if(push){
			var panel = $("#"+idPanelTab);
			panel.droppable({
				hoverClass: "ui-state-hover",

				drop: function( myEvento, myUi ) {
					return onDropEventPanel(myEvento, myUi, this);
				}
			});
		}
	}
	
	this.resize = function(heightResize100, widthResize100){
		var difH = calculaZoom(50, 100, zoom);
		var difW = calculaZoom(30, 100, zoom);
		
		var domElement = $("#"+this.properties.id);
		domElement.css("height", (heightResize100-10)+"px");
		domElement.css("width", (widthResize100-10)+"px");
	
		for(var i=0; i<this.properties.tabs.length; i++){
			var nodo = this.properties.tabs[i];
			
			var domTab = $("#"+nodo.idPanelTab);
			domTab.css("height", (heightResize100-difH)+"px");
			domTab.css("width", (widthResize100-difW)+"px");
		}
	}
	
	this.editDialog = function(){
		
	}
	
	this.getPropertisList = function(){
		var ret = new Array();
		ret.push({name:'New Tab', type:1, func:"nuevoTab"});
		ret.push({name:'Rename Tab', type:1, func:"renameTab"});
		ret.push({name:'Remove Tab', type:2, func:"eliminarTAB"});
		ret.push({name:'Event',  attr:'event',   type:0, value:this.properties.event});
		ret.push({name:'Sortable',attr:'sortable',   type:3, value:this.properties.sortable});

		ret.push({name:'Mobile Version',attr:'mobile.action',   type:4, value:this.properties.mobile.action, list:getMobileList()});
		ret.push({name:'Mobile Name'   ,attr:'mobile.name',     type:0, value:this.properties.mobile.name});
		
		return ret;
	}
	
	this.nuevoTab = function(valor){
		var htmlObject = $("#"+this.properties.id);
		var parent = $("#"+this.properties.id).parent();
		
		this.addNode(valor, this.properties.idUl, htmlObject, true, 0, "");

		var nodo = this.properties.tabs[this.properties.tabs.length-1];
		var domElement = $("#"+nodo.idPanelTab);
		
		domElement.css("height", (quitaPX(parent.css("height"))-100)+"px");
		domElement.css("width", (quitaPX(parent.css("width"))-50)+"px");

		var tabs = htmlObject.tabs();
		tabs.tabs( "refresh" );
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
	}
	
	this.renameTab = function(value){
		var htmlObject = $("#"+this.properties.id);
		var tabs = htmlObject.tabs();
		
		var selectedTab = tabs.tabs('option', 'selected'); 
		this.properties.tabs[selectedTab].text = value;
		var idTexto = $("#"+this.properties.tabs[selectedTab].idLi);
		idTexto.html(value);
		
		tabs.tabs( "refresh" );
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
	}
	
	this.eliminarTAB = function(){
		if(this.properties.tabs.length == 1){
			alert("There must be at least a tab in the object");
			return;
		}
	
		var htmlObject = $("#"+this.properties.id);
		var tabs = htmlObject.tabs();
		
		var selectedTab = tabs.tabs('option', 'selected'); 
		tabs.tabs('remove', selectedTab);
		this.properties.tabs.splice(selectedTab, 1);
		
		tabs.tabs( "refresh" );
		
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

