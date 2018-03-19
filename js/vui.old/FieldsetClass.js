function FieldsetClass(){
	this.width = 250;
	this.height = 300;
	
	this.properties = 
	{
		id:"idFieldset_" + iContadorObjeto,
		idPanel:'idFS_'+iContadorObjeto,
		idLegend:'idLegent_' + iContadorObjeto,
		
		disabled:'',
		name:'',
		style:'',
		theClass:'',
		legend:'Legend',
		legendAlign:'left',

		mobile:{action:1,name:'Fields'},
	};
	
	this.getHtml = function(mode){
		this.properties.id = generateID(mode, this.properties.id, 'idFieldset_');
		this.properties.idPanel = generateID(mode, this.properties.idPanel, 'idFS_');
		this.properties.idLegend = generateID(mode, this.properties.idLegend, 'idLegent_');
		
		var html = 
		'<div ' +getProperties(mode, this.properties)+ '>\n'+
		'    <div class="vui-title">\n'+
		'       <div class ="ui-tabs-anchor ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" id="'+this.properties.idLegend+'" align="'+this.properties.legendAlign+'">'+this.properties.legend+'</div>\n'+
		'    </div>\n'+
		'    <div class="VIU ui-widget ui-widget-content ui-corner-all" id="'+this.properties.idPanel+'"></div>\n'+
		'</div>\n';

		return html;
	}
	
	this.create = function(padre, mode){
		var html = this.getHtml(mode);
		
		var htmlObject = $(html);
		htmlObject.appendTo( padre );
		
		if((mode*1) == 0){
			var panel = $("#"+this.properties.idPanel);
			panel.droppable({
				hoverClass: "ui-state-hover",

				drop: function( myEvento, myUi ) {
					return onDropEventPanel(myEvento, myUi, this);
				}
			});
		}
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "FieldsetClass");

		return htmlObject;
	}
	
	this.getFromDom = function(elementoSeleccionado){
		var jsonStr = elementoSeleccionado.attr("VIU");
		this.properties = jQuery.parseJSON(jsonStr);
	}
	
	this.resize = function(heightResize100, widthResize100){
		var domElement = $("#"+this.properties.id);
		domElement.css("height", (heightResize100)+"px");
		domElement.css("width", (widthResize100)+"px");
		
		var domPanel = domElement.find("#"+this.properties.idPanel);
		domPanel.css("height", (heightResize100-28)+"px");
		domPanel.css("width", (widthResize100-2)+"px");
		
		var domLegend = domElement.find("#"+this.properties.idLegend);
		domLegend.css("width", (widthResize100-18)+"px");
		
	}
	
	
	this.editDialog = function(){
	}
	
	this.getPropertisList = function(){
		var ret = new Array();
		var list = [
				{name:'Left',   value:'Left'},
				{name:'Center', value:'center'},
				{name:'Right',  value:'right'},
				];
		
		ret.push({name:'Legend',       attr:'legend',      type:0, value:this.properties.legend});
		ret.push({name:'Legend Align', attr:'legendAlign', type:4, value:this.properties.legendAlign, list:list});

		ret.push({name:'Mobile Version',attr:'mobile.action',   type:4, value:this.properties.mobile.action, list:getMobileList()});
		ret.push({name:'Mobile Name'   ,attr:'mobile.name',     type:0, value:this.properties.mobile.name});
		
		return ret;
	}
	
	this.attr = function(name, value){
		this.properties = setAttribute(this.properties, name, value);
		
		if(name == 'legend'){
			var domElement = $("#"+this.properties.id);
			var domLegend = domElement.find("#"+this.properties.idLegend);
			domLegend.html(value);
		}else if(name == 'legendAlign'){
			var domElement = $("#"+this.properties.id);
			var domLegend = domElement.find("#"+this.properties.idLegend);
			domLegend.attr("align", value);
		}
	}
	
	this.getAttr = function(name){
		var domElement = $("#"+this.properties.id);
		eval("ret = this.properties."+name);
		return ret;
	}
	

}

