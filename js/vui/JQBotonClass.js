function JQBotonClass(){
	this.width = 100;
	this.height = 60;
	
	this.properties = 
	{
		id:"idJQBoton_" + iContadorObjeto,
		maxLength:'',
		value:'0',
		disabled:'',
		theClass:"ui-corner-all",
		primary:'',
		secondary:'',
		text:'',
		caption:'boton',
		idCaption:"idCap_" + iContadorObjeto,
		name:'',

		mobile:{action:3,name:'B'},
	}
	
	this.create = function(padre, mode,isMobil){ 
		this.properties.id = generateID(mode, this.properties.id, 'idJQBoton_');
		this.properties.idCaption = generateID(mode, this.properties.idCaption, 'idCap_');
		
		var tag = "div";
		if(mode*1 == 3){
			tag = "button"
		}

		var html = "<"+tag+" " + getProperties(mode, this.properties) 
        + "><div id='"+this.properties.idCaption+"'>" 
        +this.properties.caption+ "</div></"+tag+">";
		
		var htmlObject = $(html);
		htmlObject.appendTo( padre );

		var text = false; 
		if(this.properties.text == 'text'){
			text = true;
		}
		
		$("#"+this.properties.id).button({icons: {primary: this.properties.primary, secondary: this.properties.secondary}, text: text});
		
		this.resize(this.height, this.width);
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "JQBotonClass");

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

		var list = getIconsList();
		ret.push({name:'Text View', attr:'text', type:3, value:this.properties.text});
		ret.push({name:'Primary', attr:'primary',   type:4, value:this.properties.primary, list:list});
		ret.push({name:'Secondary', attr:'secondary',   type:4, value:this.properties.secondary, list:list});
		ret.push({name:'Caption', attr:'caption',   type:0, value:this.properties.caption});

		ret.push({name:'Mobile Version',attr:'mobile.action',   type:4, value:this.properties.mobile.action, list:getMobileList()});
		ret.push({name:'Mobile Name'   ,attr:'mobile.name',     type:0, value:this.properties.mobile.name});
		
		return ret;
	}
	
	this.attr = function(name, value){
		this.properties = setAttribute(this.properties, name, value);
		
		var text = false; 
		if(this.properties.text == 'text'){
			text = true;
		}
		
		$("#"+this.properties.id).button({icons: {primary: this.properties.primary, secondary: this.properties.secondary}, text: text});
		$("#"+this.properties.idCaption).html(this.properties.caption);
	}
	
	this.getAttr = function(name){
		var domElement = $("#"+this.properties.id);
		eval("ret = this.properties."+name);
		return ret;
	}
}
