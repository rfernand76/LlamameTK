function SpinnerClass(){
	this.width = 100;
	this.height = 40;
	
	this.properties = 
	{
		id:"idJQSpinner_" + iContadorObjeto,
		maxLength:'',
		//value:'0',
		disabled:'',
		theClass:"ui-corner-all",
		min:'0',
		max:'10',
		step:'1',
		start:'1',
		numberFormat:'C',
		mobile:{action:3,name:'Spinner'},
		
	};
	
	this.create = function(padre, mode){
		this.properties.id = generateID(mode, this.properties.id, 'idJQSpinner_');
		var html = "";

		if(mode*1 == 3){
			html = "<input type='text' " +getProperties(mode, this.properties) +" value='"+this.properties.start+"'/>";
		}else{
			html = "<div "+getProperties(mode, this.properties) +">"+ this.properties.start +"</div>";
		}


		var htmlObject = $(html);
		htmlObject.appendTo( padre );
		
		if((mode*1) != 0){
			$("#"+this.properties.id).spinner(
			{min: (this.properties.min*1), 
			 max: (this.properties.max*1),
			 step: (this.properties.step*1),
			 numberFormat: this.properties.numberFormat
			});
		}else{
			//$("#"+this.properties.id).css("border", "1px solid;");
			$("#"+this.properties.id).progressbar({value: 0,});
		}
		
		this.resize(this.height, this.width);
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "SpinnerClass");

		return htmlObject;
	}
	
	this.getFromDom = function(elementoSeleccionado){
		var jsonStr = elementoSeleccionado.attr("VIU");
		this.properties = jQuery.parseJSON(jsonStr);
	}
	
	this.resize = function(heightResize100, widthResize100){
		var domElement = $("#"+this.properties.id);
		domElement.css("height", (heightResize100)+"px");
		domElement.css("width", (widthResize100)+"px");
	}
	
	this.editDialog = function(){
		
	}
	
	this.getPropertisList = function(){
		var ret = new Array();
		var domElement = $("#"+this.properties.id);
		
		ret.push({name:'Min', attr:'min',   type:0, value:this.properties.min});
		ret.push({name:'Max', attr:'max',   type:0, value:this.properties.max});
		ret.push({name:'Step', attr:'step',   type:0, value:this.properties.step});
		ret.push({name:'Start', attr:'start',   type:0, value:this.properties.start});
		ret.push({name:'NumberFormat', attr:'numberFormat',   type:0, value:this.properties.numberFormat});

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
