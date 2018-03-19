function CheckClass(){
	this.properties = 
	{
		id:"idCheckbox_" + iContadorObjeto,
		value:"",
		disabled:"",
		name:'',
		style:'',
		theClass:'ui-corner-all',
		checked:'',
		mobile:{action:4,name:'File'},
		
	};
	
	this.create = function(padre, mode){
		this.properties.id = generateID(mode, this.properties.id, 'idCheckbox_');
	
		var html = 
		"<input "+ this.properties.checked +" "+ getProperties(mode, this.properties) +"  value='"+ this.properties.value +"' type='checkbox' />&nbsp;&nbsp;<br/><br/>";
		
		var htmlObject = $(html);
		htmlObject.appendTo( padre );
		
		this.resize(this.height, this.width);
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "CheckClass");

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
		ret.push({name:'Value', attr:'value',   type:0, value:this.properties.value});
		ret.push({name:'Checked', attr:'checked',   type:3, value:this.properties.checked});
		
		ret.push({name:'Mobile Version',attr:'mobile.action',   type:4, value:this.properties.mobile.action, list:getMobileList()});
		ret.push({name:'Mobile Name'   ,attr:'mobile.name',     type:0, value:this.properties.mobile.name});
		return ret;
	}
	
	this.attr = function(name, value){
		this.properties = setAttribute(this.properties, name, value);
		if(name == 'checked'){
			var domElement = $("#"+this.properties.id);
			if(value == ''){
				domElement.removeAttr('checked');
			}else{
				domElement.attr('checked', true);
			}
		}
		
	}
	
	this.getAttr = function(name){
		var domElement = $("#"+this.properties.id);
		eval("ret = this.properties."+name);
		
		return ret;
	}
}



