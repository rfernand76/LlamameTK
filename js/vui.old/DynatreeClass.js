var iContadorItemDynatree = 1;
function DynatreeClass(){
	this.width = 250;
	this.height = 300;

	this.properties = 
	{
		id:"idDynatree_" + iContadorObjeto,
		disabled:'',
		name:'',
		style:'',
		theClass:'ui-corner-all',
		mobile:{action:1,name:'D'},
		
      data :[
        {title: "Item 1"},
        {title: "Folder 2", isFolder: true, key: "folder2",
          children: [
            {title: "Sub-item 2.1"},
            {title: "Sub-item 2.2"}
          ]
        },
        {title: "Item 3"}
      ]
	};

	this.getHtml = function(){
		return this.__getHtml(0);
	}

	this.__getHtml = function(mode){
		var html = "<div "+getProperties(mode, this.properties)+">\n</div>";
		return html;
	}

	this.getJS = function(){
		var jsonStr = JSON.stringify(this.properties.data);
	
		var js = 
			'$("#'+this.properties.id+'").dynatree({\n'+
			'children:'+jsonStr+'\n'+
			'});';
			
		return js;
	}

	this.create = function(padre, mode){
		this.properties.id = generateID(mode, this.properties.id, 'idDynatree_');

		var html = this.__getHtml(mode);
		var htmlObject = $(html);
		htmlObject.appendTo( padre );

		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "DynatreeClass");

		var js = this.getJS();
		eval(js);

		return htmlObject;
	}
	
	this.editDialog = function(){
	}

	this.getFromDom = function(elementoSeleccionado){
		var jsonStr = elementoSeleccionado.attr("VIU");
		this.properties = jQuery.parseJSON(jsonStr);
	}

	this.resize = function(heightResize100, widthResize100){
		var domElement = $("#"+this.properties.id);
		domElement.css("height", (heightResize100-10)+"px");
		domElement.css("width", (widthResize100-1)+"px");
	}

	this.getPropertisList = function(){
		var ret = new Array();
		ret.push({name:'Remove', type:2, func:"eliminar"});
		ret.push({name:'Add', type:2, func:"add"});
		ret.push({name:'Edit', type:2, func:"edit"});

		ret.push({name:'Mobile Version',attr:'mobile.action',   type:4, value:this.properties.mobile.action, list:getMobileList()});
		ret.push({name:'Mobile Name'   ,attr:'mobile.name',     type:0, value:this.properties.mobile.name});

		return ret;
	}
	
	this.eliminar = function(){
		var htmlObject = $("#"+this.properties.id);
		var node = htmlObject.dynatree("getActiveNode");
		if( !node ){
			alert("No active node.");
			return;
		}
		node.remove();
		this.copyData(htmlObject);
	}
	
	this.copyData = function(htmlObject){
		var newData = new Array();
		this.properties.data = this.getData(newData, htmlObject.dynatree("getRoot"));
		
		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);		
	}
	
	this.getData = function(newData, obj){
		for(var i=0; i<obj.childList.length; i++){
			var element = {title: obj.childList[i].data.title, isFolder: obj.childList[i].data.isFolder, key: obj.childList[i].data.key, tooltip: obj.childList[i].data.tooltip};
			if(obj.childList[i].childList != null){
				var childList = new Array();
				element.children = this.getData(childList, obj.childList[i]);
			}
			
			newData.push(element);
		}
		
		return newData;
	}
	
	this.add = function(){		
		this.addEdit(1);
	}
	
	
	this.edit = function(){	
		this.addEdit(2);
	}
	
	this.addEdit = function(accion){
		var title = "Add Element";
		var htmlObject = $("#"+this.properties.id);
		var node = htmlObject.dynatree("getActiveNode");
		
		if(accion == 2){
			title = "Edit Element";
			if(node == undefined || node == null){
				alert("No active node.");
				return;
			}
		}
		
		var html = "<div id='idDialog' title='"+title+"'></div>";
		var win = $(html);
		
		var d = new Date();
		var format = 

		{"format":{"version":"1.0.1","create":"2013-09-08T16:20:00.770Z"},
		"page":	{"width":300,"height":270,"top":0,"left":0,"name":""},
		"fields":[
			{"subclass":"JQBotonClass","parent":"droppable","height":"55","width":"96","top":"226","left":"35",
			 "VIU":{"id":"idJQBoton_OK","maxLength":"","value":"0",	"disabled":"",
				"theClass":"ui-corner-all","primary":"","secondary":"",
				"text":"","caption":"OK","idCaption":"idCap_10"
			       }
			},
			{"subclass":"JQBotonClass","parent":"droppable","height":"55","width":"96","top":"226","left":"162.1",
			 "VIU":{"id":"idJQBoton_CANCEL","maxLength":"","value":"0","disabled":"",
				"theClass":"ui-corner-all","primary":"","secondary":"","text":"","caption":"Cancel",
				"idCaption":"idCap_12"
				}
			},{"subclass":"TabClass","parent":"droppable","height":"211","width":"294","top":"0","left":"0",
			"VIU":{"tabs":
			      [{"idLi":"tabLi_1","idDiv":"tabDiv_1","idPanelTab":"panelTab_1",
				"text":"Element","padre":"idVUITabEditNewElement"}
			      ,{"idLi":"tabLi_2","idDiv":"tabDiv_2","idPanelTab":"panelTab_2",
				"text":"Position","padre":"idVUITabEditNewElement"}	
			      ]
			      ,"id":"idVUITabEditNewElement","disabled":""
			      ,"idUl":"DynaidTabUl_9","collapsible":"","event":"","name":""
			      ,"style":"","sortable":"","theClass":"ui-corner-all"
			      }
			}


,{"subclass":"DivClass","parent":"panelTab_1","height":"151","width":"249","top":"42","left":"16",
			"VIU":{"id":"idDiv_13","name":"","style":"border: 0px solid;overflow:auto",
			"theClass":"ui-corner-all","title":"","align":"","url":"form/dynatree.add.html?d="+d}}
			,{"subclass":"RadioClass","parent":"panelTab_2","height":"33","width":"33","top":"59","left":"0",
			"VIU":{"id":"idRadio_13","value":"1","disabled":"","name":"posicion","style":"","theClass":"ui-corner-all"}},{"subclass":"LabelClass","parent":"panelTab_2","height":"22","width":"236","top":"90","left":"23","VIU":{"id":"idLabel_17","label":"Insertar elemento al inicio del padre","name":"","style":"","theClass":"ui-corner-all"}},{"subclass":"RadioClass","parent":"panelTab_2","height":"33","width":"33","top":"87","left":"0","VIU":{"id":"idRadio_25","value":"2","disabled":"","name":"posicion","style":"","theClass":"ui-corner-all"}},{"subclass":"RadioClass","parent":"panelTab_2","height":"33","width":"33","top":"120","left":"0","VIU":{"id":"idRadio_29","value":"3","disabled":"","name":"posicion","style":"","theClass":"ui-corner-all"}},{"subclass":"LabelClass","parent":"panelTab_2","height":"17","width":"237","top":"63","left":"25.1","VIU":{"id":"idLabel_37","label":"Insertar antes del seleccionado","name":"","style":"","theClass":"ui-corner-all"}},{"subclass":"LabelClass","parent":"panelTab_2","height":"28","width":"238","top":"123","left":"24","VIU":{"id":"idLabel_41","label":"Insertar despues del seleccionado","name":"","style":"","theClass":"ui-corner-all"}}]}

		win.dialog({autoOpen: false, resizable: false, modal: true, width: (format.page.width), height: (format.page.height)});
		
		win.dialog( "open");
		win.run(format);
		
		$("#idRadio_13").attr("checked", "checked");
		
		var me = this;
		$("#idJQBoton_OK").click(function() {
			me.OK_click(accion);
		});
		
		$("#idJQBoton_CANCEL").click(function() {
			me.CANCEL_click();
		});
		
		if(accion == 2){
			$('#idTitle').val(node.data.title);
			$('#idKey').val(node.data.key);
			$('#idTooltip').val(node.data.tooltip);
			
			if(node.data.isFolder){
				$('#idIsFolder').attr("checked", "checked");
			}else{
				$('#idIsFolder').removeAttr("checked");
			}
		
			var htmlTab = $("#idVUITabEditNewElement");
			var tabs = htmlTab.tabs();
			tabs.tabs( "disable", 1 );
		}
	}
	
	
	this.OK_click = function(accion){
		this.asignaPropiedades(accion);
		this.closeDialog();
	}
	
	this.CANCEL_click = function(name, value){
		this.closeDialog();
	}
	
	this.asignaPropiedades = function(accion){
		var htmlObject = $("#"+this.properties.id);
		var node = htmlObject.dynatree("getActiveNode");
		var beforeNode = null;
		
		var win = $('#idDialog');
		var posicion = win.find('input[name=posicion]:checked').val();
		
		
		var newNode = {
			title: $('#idTitle').val(),
			key: $('#idKey').val(),
			tooltip: $('#idTooltip').val(),
			isFolder: ($('#idIsFolder'  ).attr("checked") == "checked")
		};
		
		if(accion == 1){//add
			if( node == undefined || node == null ){
				node = htmlObject.dynatree("getRoot");
			}else{
				
				if(posicion == "1"){//en elemento seleccionado
					//en estricto rigor no debe hacer nada
					beforeNode = null;
					node = node;
				}else if(posicion == "2"){//Insertar elemento antes del seleccionado
					beforeNode = node;
					node = node.parent;
				}else if(posicion == "3"){//Insertar al final del padre
					beforeNode = null;
					node = node.parent;
				}
			}
			node.addChild(newNode, beforeNode);
			
		}else{//edit
			node.fromDict(newNode);
		}
		
		this.copyData(htmlObject);
	}
	
	this.closeDialog = function(){
		$('#idDialog').dialog( "close" );
		$('#idDialog').remove();
	}
	
	this.attr = function(name, value){
		this.properties = setAttribute(this.properties, name, value);
	}

	this.getAttr = function(name){
		eval("ret = this.properties."+name);
		return ret;
	}
}
