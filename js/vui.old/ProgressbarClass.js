function ProgressbarClass(){
	this.width = 300;
	this.height = 30;

	this.properties = 
	{
		id:"idProgressbar_" + iContadorObjeto,
		maxLength:'',
		value:'0',
		disabled:'',
		name:'',
		style:'',
		theClass:'ui-corner-all',
		mobile:{action:4,name:'P'},
	};
	
	this.create = function(padre, mode){
		this.properties.id = generateID(mode, this.properties.id, 'idProgressbar_');
	
		var html = 
		"<div " + getProperties(mode, this.properties) + "/>";
		
		var htmlObject = $(html);
		htmlObject.appendTo( padre );
		
		$("#"+this.properties.id).progressbar({value: (this.properties.value*1),});
		this.resize(this.height, this.width);
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "ProgressbarClass");

		return htmlObject;
	}
	
	this.getFromDom = function(elementoSeleccionado){
		var jsonStr = elementoSeleccionado.attr("VIU");
		this.properties = jQuery.parseJSON(jsonStr);
	}
	
	this.resize = function(heightResize100, widthResize100){
		var domElement = $("#"+this.properties.id);
		domElement.css("height", "100%");
		domElement.css("width", "100%");
	}
	
	this.editDialog = function(){
		
	}
	
	this.getPropertisList = function(){
		var ret = new Array();
		var domElement = $("#"+this.properties.id);
		
		ret.push({name:'Value', attr:'value',   type:0, value:this.properties.value});
		ret.push({name:'Mobile Version',attr:'mobile.action',   type:4, value:this.properties.mobile.action, list:getMobileList()});
		ret.push({name:'Mobile Name'   ,attr:'mobile.name',     type:0, value:this.properties.mobile.name});
		return ret;
	}
	
	this.attr = function(name, value){
		this.properties = setAttribute(this.properties, name, value);
	}
	
	this.getAttr = function(name){
		var domElement = $("#"+this.properties.id);
		eval("ret = this.properties."+name);
		return ret;
	}
}
