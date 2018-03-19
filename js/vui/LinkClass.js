function LinkClass(){
	this.properties = 
	{
		id:"idLink_" + iContadorObjeto,
		href:"http://www.sqltxt.cl",
		caption:'Link',
		disabled:'',
		target:'',
		name:'',
		style:'',
		theClass:'ui-corner-all',
		mobile:{action:4,name:'P'},
	};
	
	this.create = function(padre, mode){
		this.properties.id = generateID(mode, this.properties.id, 'idLink_');
	
		var href = "#";
		if((mode*1) != 0){
			href = this.properties.href;
		}
	
		var html = 
		"<a target ='"+this.properties.target+"' href='"+href+"'" + getProperties(mode, this.properties) + ">" + this.properties.caption +"</a>&nbsp;&nbsp;<br/><br/>";
		
		var htmlObject = $(html);
		htmlObject.appendTo( padre );
		
		this.resize(this.height, this.width);
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "LinkClass");

		return htmlObject;
	}
	
	
	this.getFromDom = function(elementoSeleccionado){
		var jsonStr = elementoSeleccionado.attr("VIU");
		this.properties = jQuery.parseJSON(jsonStr);
	}
	
	this.resize = function(heightResize100, widthResize100){
	}
	
	this.editDialog = function(){
	}
	
	this.getPropertisList = function(){
		var ret = new Array();
		var domElement = $("#"+this.properties.id);
		
		ret.push({name:'URL', attr:'href',   type:0, value:this.properties.href});
		ret.push({name:'Target', attr:'target',   type:0, value:this.properties.target});
		ret.push({name:'Caption', attr:'caption',   type:0, value:this.properties.caption});

		ret.push({name:'Mobile Version',attr:'mobile.action',   type:4, value:this.properties.mobile.action, list:getMobileList()});
		ret.push({name:'Mobile Name'   ,attr:'mobile.name',     type:0, value:this.properties.mobile.name});
		return ret;
	}
	
	this.attr = function(name, value){
		if(name=='caption'){
			$("#"+this.properties.id).html(value);
			this.properties = setAttribute(this.properties, name, value);
		}else if(name=='href'){
			this.properties = setAttributeVerif(this.properties, name, value, false);
		}else{
			this.properties = setAttribute(this.properties, name, value);
		}
	}
	
	this.getAttr = function(name){
		var domElement = $("#"+this.properties.id);
		eval("ret = this.properties."+name);
		return ret;
	}
}



