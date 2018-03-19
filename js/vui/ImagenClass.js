function ImagenClass(){
	this.properties = 
	{
		id:"idImg_" + iContadorObjeto,
		disabled:"",
		src:"",
		border:"",
		name:'',
		style:'',
		theClass:'ui-corner-all',
		alt:'',
		mobile:{action:4,name:'File'},
		
	};
	
	this.create = function(padre, mode){
		this.properties.id = generateID(mode, this.properties.id, 'idImg');
	
		var html = 
		"<img "+ getProperties(mode, this.properties) +
				"src='"+this.properties.src+"'"+
				"border='"+this.properties.border+"'"+
				"alt='"+this.properties.alt+"'"+
				"/>&nbsp;&nbsp;<br/><br/>";
		
		var htmlObject = $(html);
		htmlObject.appendTo( padre );
		
		//this.resize(this.height, this.width);
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "ImagenClass");

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
		ret.push({name:'Src',    attr:'src',     type:0, value:this.properties.src});
		ret.push({name:'Border', attr:'border',  type:0, value:this.properties.border});
		ret.push({name:'Alt',    attr:'alt',     type:0, value:this.properties.alt});

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
