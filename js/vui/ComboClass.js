function ComboClass(){
	this.properties = 
	{
		id:"idSelect_" + iContadorObjeto,
		size:"",
		disabled:"",
		name:'',
		style:'',
		theClass:'ui-corner-all',
		elements:new Array(),
		selected:'0',
		multiple:'',
		mobile:{action:4,name:'Select'},
	};
	
	this.create = function(padre, mode){
		this.properties.id = generateID(mode, this.properties.id, 'idSelect_');
	
		var option = "";
		for (var i=0; i<this.properties.elements.length; i++){
			var selected = " ";
			if(i == (this.properties.selected*1)){
				selected = " selected "
			}
			
			option = option + this.getHtmlOption(this.properties.elements[i], selected);
		}
		
		var html = 
		"<SELECT "+ this.properties.multiple +" "+ getProperties(mode, this.properties) +"  size='"+this.properties.size+"' >" + option + "</SELECT>&nbsp;&nbsp;<br/><br/>";
		
		var htmlObject = $(html);
		htmlObject.appendTo( padre );
		
		//this.resize(this.height, this.width);
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "ComboClass");

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
		ret.push({name:'Size', attr:'size',   type:0, value:this.properties.size});
		ret.push({name:'Selected', attr:'selected',   type:0, value:this.properties.selected});
		ret.push({name:'Multiple', attr:'multiple',   type:3, value:this.properties.multiple});
		ret.push({name:'Add', type:1, func:"addElement"});

		ret.push({name:'Mobile Version',attr:'mobile.action',   type:4, value:this.properties.mobile.action, list:getMobileList()});
		ret.push({name:'Mobile Name'   ,attr:'mobile.name',     type:0, value:this.properties.mobile.name});

		return ret;
	}
	
	this.addElement = function(value){
		this.properties.elements.push(value);
		var htmlObject = $("#"+this.properties.id);
		
		var option = this.getHtmlOption(value, "");
		var optionObjects = $(option);
		optionObjects.appendTo( htmlObject );
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
	}
	
	this.getHtmlOption = function(value, selected){
		var l = value.split(",");
		var name = value;
		var val = "";
		if(l.length > 1){
			val = l[0];
			name = l[1];
		}
		
		var option = "<option "+ selected +" value='"+ val + "'>" + name + "</option>"
		return option;
		
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
