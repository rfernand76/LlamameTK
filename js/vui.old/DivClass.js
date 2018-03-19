function DivClass(){
	this.width = 250;
	this.height = 300;
	this.properties = 
	{
		id:"idDiv_" + iContadorObjeto,
		name:'',
		style:'overflow:auto;',
		theClass:'ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons',
		title:'',
		align:"",
		url:"",
		mobile:{action:1,name:''},
	};
	
	this.create = function(padre, mode){
		this.properties.id = generateID(mode, this.properties.id, 'idDiv_');
		
		var html = 
		"<div align='"+ this.properties.align +"' "+ getProperties(mode, this.properties) +" title='" +this.properties.title+ "'></div>";
		
		var htmlObject = $(html);
		htmlObject.appendTo( padre );
		
		var wait = true;
		if(mode*1 != 0 && this.properties.url!=""){
			var url = this.properties.url;
			var d = new Date();
			$.ajax({
					url:   url+"?d="+d,
					async: false,
					beforeSend: function () {
						htmlObject.html("Processing, please wait ...");
					},
					success:  function (response) {
						htmlObject.html(response);
					},
					error: function (xhr, ajaxOptions, thrownError) {
						htmlObject.html("Error:</br>Url: "+url+"</br>status:"+xhr.status+"</br>Description:"+thrownError);
					}
			});			
		}
		
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "DivClass");

		return htmlObject;
	}
	
	this.getFromDom = function(elementoSeleccionado){
		var jsonStr = elementoSeleccionado.attr("VIU");
		this.properties = jQuery.parseJSON(jsonStr);
	}
	
	this.resize = function(heightResize100, widthResize100){
		var domElement = $("#"+this.properties.id);
		domElement.css("height", (heightResize100-2)+"px");
		domElement.css("width", (widthResize100-2)+"px");
	}
	
	
	this.editDialog = function(){
	}
	
	this.getPropertisList = function(){
		var ret = new Array();
		
		var list = 
		[
			{name:'', value:''},
			{name:'left', value:'left'},
			{name:'right', value:'right'},
			{name:'center', value:'center'},
			{name:'justify', value:'justify'},
		];
		
		ret.push({name:'Title', attr:'title',   type:0, value:this.properties.title});
		ret.push({name:'Url',   attr:'url',     type:0, value:this.properties.url});

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



