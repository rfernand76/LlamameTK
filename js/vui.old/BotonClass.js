function BotonClass(){
	this.properties = 
	{
		id:"idButton_" + iContadorObjeto,
		disabled:'',
		name:'',
		style:'',
		theClass:'ui-corner-all',
		value:'boton',
		mobile:{action:3,name:'B'},
	};
	
	this.create = function(padre, mode){
		this.properties.id = generateID(mode, this.properties.id, 'idButton_');
		
		var html = 	"<input type='button' " + getProperties(mode, this.properties) + " value='" + this.properties.value + "' />&nbsp;&nbsp;<br/><br/>";
		var htmlObject = $(html);
		htmlObject.appendTo( padre );
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "BotonClass");

		return htmlObject;
	}
	
	this.getFromDom = function(elementoSeleccionado){
		var jsonStr = elementoSeleccionado.attr("VIU");
		this.properties = jQuery.parseJSON(jsonStr);
	}
	
	this.resize = function(heightResize100, widthResize100){
		var domElement = $("#"+this.properties.id);
		domElement.css("height", (heightResize100-5)+"px");
		domElement.css("width", (widthResize100-5)+"px");
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

