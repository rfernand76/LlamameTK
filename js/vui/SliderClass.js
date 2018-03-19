function SliderClass(){
	this.width = 100;
	this.height = 30;
	
	this.properties = 
	{
		id:"idSlider_" + iContadorObjeto,
		maxLength:'',
		disabled:'',
		theClass:"ui-corner-all",
		range:"min",
		min:"0",
		max:"100",
		value:"0",
		orientation: "horizontal",
		mobile:{action:4,name:'P'},
		
	};
	
	this.create = function(padre, mode){
		this.properties.id = generateID(mode, this.properties.id, 'idSlider_');
		
		var html = "<div " +getProperties(mode, this.properties)+ "'></div>";
		
		var htmlObject = $(html);
		htmlObject.appendTo( padre );
		
		htmlObject.slider({orientation:this.properties.orientation, range:(this.properties.range *1), min:(this.properties.min *1), max: (this.properties.max *1), value: (this.properties.value *1)});
		if((mode*1) == 0){
			htmlObject.slider( 'disable');
		}
		
		this.resize(this.height, this.width);
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "SliderClass");

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
		
		var list = [
				{name:'horizontal' , value:'horizontal'},
				{name:'vertical'   , value:'vertical'}
				]
		
		ret.push({name:'Orientation', attr:'orientation',   type:4, value:this.properties.orientation, list:list});
		ret.push({name:'Range', attr:'range',   type:0, value:this.properties.range});
		ret.push({name:'Min', attr:'min',   type:0, value:this.properties.min});
		ret.push({name:'Max', attr:'max',   type:0, value:this.properties.max});
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
