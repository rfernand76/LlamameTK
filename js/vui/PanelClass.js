function PanelClass(){
	this.width = 250;
	this.height = 300;
	this.properties = 
	{
		id:"idPanel_" + iContadorObjeto,
		idPanel:'idFSP_'+iContadorObjeto,
		name:'',
		style:'',
		theClass:'ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons',
		title:'',
		align:"",

		mobile:{action:1,name:'Panel'},
	};
	
	this.create = function(padre, mode, isMobil){
		this.properties.id = generateID(mode, this.properties.id, 'idPanel_');
		this.properties.idPanel = generateID(mode, this.properties.idPanel, 'idFSP_');
	
		var html = 
		"<div align='"+ this.properties.align +"' "+ getProperties(mode, this.properties) +" title='" +this.properties.title+ "'>"
		+'  <div class="VIU" id="'+this.properties.idPanel+'"></div>\n'+
		+'</div>';
		
		var htmlObject = $(html);
		htmlObject.appendTo( padre );
		
		if((mode*1) == 0){
			var panel = $("#"+this.properties.idPanel);
			panel.droppable({
				hoverClass: "ui-state-hover",

				drop: function( myEvento, myUi ) {
					return onDropEventPanel(myEvento, myUi, this);
				}
			});
		}

		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "PanelClass");

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
		
		//alert(this.properties.idPanel);
		var domPanel = domElement.find("#"+this.properties.idPanel);
		domPanel.css("height", (heightResize100-1)+"px");
		domPanel.css("width", (widthResize100-1)+"px");
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
		ret.push({name:'Align', attr:'align',   type:4, value:this.properties.align, list:list});

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
	
	this.setModel = function(model){
		var str = "model."+this.properties.model;
		var obj = eval(str);
		
		$("#"+this.properties.id).html(obj);
		
	}
}



