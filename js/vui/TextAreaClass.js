function TextAreaClass(){
	this.properties = 
	{
		id:"idTextArea_" + iContadorObjeto,
		cols:"",
		maxlength:"",
		placeholder:"",
		rows:"",
		wrap:"",
		disabled:"",
		name:'',
		style:'',
		theClass:'ui-corner-all',
		mobile:{action:4,name:'File'},
	};
	
	this.create = function(padre, mode){
		this.properties.id = generateID(mode, this.properties.id, 'idTextArea_');
	
		var html = 
		"<textarea "+ getProperties(mode, this.properties) +" "+
		"cols='"+this.properties.cols+"'"+
		"maxlength='"+this.properties.maxlength+"'"+
		"placeholder='"+this.properties.placeholder+"'"+
		"rows='"+this.properties.rows+"'"+
		"wrap='"+this.properties.wrap+"'>"+
		"</textarea>&nbsp;&nbsp;<br/><br/>";
		
		var htmlObject = $(html);
		htmlObject.appendTo( padre );
		
		this.resize(this.height, this.width);
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "TextAreaClass");

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
		ret.push({name:'Cols', attr:'cols',   type:0, value:this.properties.cols});
		ret.push({name:'Maxlength', attr:'maxlength',   type:0, value:this.properties.maxlength});
		ret.push({name:'Placeholder', attr:'placeholder',   type:0, value:this.properties.placeholder});
		ret.push({name:'Rows', attr:'rows',   type:0, value:this.properties.rows});
		ret.push({name:'Wrap', attr:'wrap',   type:0, value:this.properties.wrap});
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


