function InputClass(){
	this.properties = 
	{
		id:"idInput_" + iContadorObjeto,
		maxLength:'',
		size:'',
		disabled:'',
		name:'',
		style:'',
		theClass:'ui-corner-all',
		mobile:{action:3,name:'Input'},

	};
	
	this.create = function(padre, mode){
		this.properties.id = generateID(mode, this.properties.id, 'idInput_');
	
		var html = 
		"<input " + getProperties(mode, this.properties) + " maxLength='"+this.properties.maxLength+"' size='"+this.properties.size+"' type='text'/>&nbsp;&nbsp;<br/><br/>";
		
		var htmlObject = $(html);
		htmlObject.appendTo( padre );
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "InputClass");

		return htmlObject;
	}
	
	this.getFromDom = function(elementoSeleccionado){
		var jsonStr = elementoSeleccionado.attr("VIU");
		this.properties = jQuery.parseJSON(jsonStr);
	}
	
	this.resize = function(heightResize100, widthResize100){
		var domElement = $("#"+this.properties.id);
		domElement.css("height", (heightResize100-20)+"px");
		domElement.css("width", (widthResize100-20)+"px");
	}
	
	this.editDialog = function(){
		
	}
	
	this.getPropertisList = function(){
		var ret = new Array();
		var domElement = $("#"+this.properties.idObject);
		
		ret.push({name:'MaxLength', attr:'maxLength',   type:0, value:this.properties.maxLength});
		ret.push({name:'Size',      attr:'size',        type:0, value:this.properties.size});

		ret.push({name:'Mobile Version',attr:'mobile.action',   type:4, value:this.properties.mobile.action, list:getMobileList()});
		ret.push({name:'Mobile Name'   ,attr:'mobile.name',     type:0, value:this.properties.mobile.name});
		return ret;
	}
	
	this.attr = function(name, value){
		this.properties = setAttribute(this.properties, name, value);
	}
	
	this.getAttr = function(name){
		var domElement = $("#"+this.properties.idObject);
		eval("ret = this.properties."+name);
		return ret;
	}
}
