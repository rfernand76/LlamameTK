function LabelClass(){
	this.properties = 
	{
		id:"idLabel_" + iContadorObjeto,
		label:'Label',
		name:'',
		style:'',
		theClass:'ui-corner-all',
		mobile:{action:3,name:''},
	};
	
	this.create = function(padre, mode){
		this.properties.id = generateID(mode, this.properties.id, 'idLabel_');
		var html = "<div " + getProperties(mode, this.properties) + ">"+this.properties.label+"</div>";
		
		var htmlObject = $(html);
		htmlObject.appendTo( padre );
		
		this.resize(this.height, this.width);
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "LabelClass");

		return htmlObject;
	}
	
	this.getFromDom = function(elementoSeleccionado){
		var jsonStr = elementoSeleccionado.attr("VIU");
		this.properties = jQuery.parseJSON(jsonStr);
	}
	
	this.resize = function(heightResize100, widthResize100){
		var domElement = $("#"+this.properties.id);
		domElement.css("height", (heightResize100-10)+"px");
		domElement.css("width", (widthResize100-10)+"px");
	}
	
	
	this.editDialog = function(){
	}
	
	this.getPropertisList = function(){
		var ret = new Array();
		ret.push({name:'Label', attr:'label',   type:0, value:this.properties.label});
		ret.push({name:'Mobile Version',attr:'mobile.action',   type:4, value:this.properties.mobile.action, list:getMobileList()});
		ret.push({name:'Mobile Name'   ,attr:'mobile.name',     type:0, value:this.properties.mobile.name});
		return ret;
	}
	
	this.attr = function(name, value){
		this.properties = setAttribute(this.properties, name, value);
		
		if(name == 'label'){
			$("#"+this.properties.id).html(value);
		}
	}
	
	this.getAttr = function(name){
		var domElement = $("#"+this.properties.id);
		eval("ret = this.properties."+name);
		return ret;
	}
}
