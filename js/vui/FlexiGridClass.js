function FlexiGridClass(){
	this.width = 250;
	this.height = 300;

	this.properties = 
	{
		id:"idFlexiGrid_" + iContadorObjeto,
		caption:'FlexiGrid',
		disabled:'',
		name:'',
		style:'',
		theClass:'',
		
		url: '',
		dataType: 'xml',
		title: 'FlexiGrid',
		usepager: true,
		useRp: true,
		rp: 20,
		showTableToggleBtn: true,
		resizable: false,
		singleSelect: false,
		
		sortname: "iso",
		sortorder: "asc",
		striped:false,
		
		width: this.width,
		height: this.height-90,	
		mobile:{action:1,name:'Data'},
		
		colModel : [
			{display: 'ISO', name : 'iso', width : 40, sortable : true, align: 'center'},
			{display: 'Name', name : 'name', width : 180, sortable : true, align: 'left'},
			],
		searchitems : [
			{display: 'ISO',  name : 'iso',  isdefault: false},
			]
	}
	
	this.create = function(padre, mode){
		this.properties.id = generateID(mode, this.properties.id, 'idFlexiGrid_');
	
		var html = "<div "+getProperties(mode, this.properties)+"></div>";
		
		var htmlObject = $(html);
		htmlObject.appendTo( padre );
	
		this.setAttrObject(htmlObject);
		this.refresh();	
		return htmlObject;
	}
	
	this.setAttrObject = function(htmlObject){
		var p = this.properties;
		p.controller = "";
		var jsonStr = JSON.stringify(p);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "FlexiGridClass");	
	}
	
	this.refresh = function(){
		var htmlObject = $("#"+this.properties.id);
		htmlObject.html("");
		
		var tabla = $("<div class='tabla'></div>");
		tabla.appendTo( htmlObject );
                
		var properties = this.properties;
        properties.width = "100%";
		tabla.flexigrid(properties);
	};
	
	
	this.getFromDom = function(elementoSeleccionado){
		var jsonStr = elementoSeleccionado.attr("VIU");
		this.properties = jQuery.parseJSON(jsonStr);
	};
	
	this.resize = function(heightResize100, widthResize100){
		var domElement = $("#"+this.properties.id);
		domElement.css("height", (heightResize100-20)+"px");
		domElement.css("width", (widthResize100-3)+"px");
		
		domElement.children().find(".bDiv").css("height", heightResize100-85+"px" );
		domElement.css("height", widthResize100+"px");
		
		this.setAttrObject(domElement);
		//this.refresh();	
	}
	
	
	
	
	this.editDialog = function(){
		$('#idFlexigrid').remove();
		
		var html = "<div id='idFlexigrid' title='Edit Flexigrid object'></div>";
		var htmlObject = $(html);

		var format = 
		{
			format:{version:"1.0.1",create:"2013-06-12T22:16:18.285Z"}
			,page: {width:542,height:450,top:0,left:0,name:""},
			fields:
			[	{subclass:"TabClass"    , parent:"droppable" , height:344,width:524, top:18,    left:19,  VIU:{"id":"idTab_9","tabs":
					[{"idLi":"tabLi_3","idDiv":"tabDiv_3","idPanelTab":"panelTab_3","text":"Principal","padre":"idTab_9"},
					 {"idLi":"tabLi_4","idDiv":"tabDiv_4","idPanelTab":"panelTab_4","text":"Columns","padre":"idTab_9"},
					 {"idLi":"tabLi_5","idDiv":"tabDiv_5","idPanelTab":"panelTab_5","text":"Rows","padre":"idTab_9"}],
				"disabled":"","idUl":"FlexiidTabUl_9","collapsible":"","event":"","name":"","style":"","sortable":"","theClass":"ui-corner-all"}},
				{subclass:"ComboClass"  , parent:"panelTab_4", height:"256",width:"350", top:"41",  left:"16",  VIU:{"id":"idSelect_31","size":"2","disabled":"","name":"","style":"","theClass":"ui-corner-all","elements":[],"selected":"0","multiple":""}},
				
				{subclass:"JQBotonClass", parent:"panelTab_4", height:"58", width:"120", top:"40",  left:"380", VIU:{"id":"idEditUp","maxLength":"","value":"0","disabled":"","theClass":"ui-corner-all","primary":"","secondary":"","text":"","caption":"Up","idCaption":"idCap_35"}},
				{subclass:"JQBotonClass", parent:"panelTab_4", height:"58", width:"120", top:"80",  left:"380", VIU:{"id":"idEditDown","maxLength":"","value":"0","disabled":"","theClass":"ui-corner-all","primary":"","secondary":"","text":"","caption":"Down","idCaption":"idCap_39"}},
				{subclass:"JQBotonClass", parent:"panelTab_4", height:"58", width:"120", top:"160", left:"380", VIU:{"id":"idNewRow","maxLength":"","value":"0","disabled":"","theClass":"ui-corner-all","primary":"","secondary":"","text":"","caption":"New","idCaption":"idCap_47"}},
				{subclass:"JQBotonClass", parent:"panelTab_4", height:"58", width:"120", top:"200", left:"380", VIU:{"id":"idEditRow","maxLength":"","value":"0","disabled":"","theClass":"ui-corner-all","primary":"","secondary":"","text":"","caption":"Edit","idCaption":"idCap_48"}},
				{subclass:"JQBotonClass", parent:"panelTab_4", height:"58", width:"120", top:"240", left:"380", VIU:{"id":"idRemove","maxLength":"","value":"0","disabled":"","theClass":"ui-corner-all","primary":"","secondary":"","text":"","caption":"Remove","idCaption":"idCap_41"}},
				
				{subclass:"JQBotonClass", parent:"droppable" , height:"58", width:"100", top:"388", left:"110", VIU:{"id":"idOkBox","maxLength":"","value":"0","disabled":"","theClass":"ui-corner-all","primary":"","secondary":"","text":"","caption":"OK","idCaption":"idCap_31"}},
				{subclass:"JQBotonClass", parent:"droppable" , height:"58", width:"100", top:"386", left:"340", VIU:{"id":"idCancelBox","maxLength":"","value":"0","disabled":"","theClass":"ui-corner-all","primary":"","secondary":"","text":"","caption":"Cancel","idCaption":"idCap_33"}}
			]
		};
		
		htmlObject.dialog({autoOpen: false, resizable: false, modal: true, width: (format.page.width+18), height: (format.page.height+45)});
		
		htmlObject.dialog( "open");
		$("#idFlexigrid").run(format);
		
		var datos =
		'<div style="overflow:auto;height:285px"><table id="idTableInfo" class="ui-state-default " border="1px" class="tabla" cellpadding="2" cellspacing="0" width="100%">'+
		'   <tr>'+
        '       <td class="ui-state-hover">Url</td>'+
        '       <td>'+
		'         <input class="ui-corner-all" style="width:370px;" type="text" id="idUrlBox"  onfocus="deshabilitaSuprime();" />'+
		'		</td>'+
        '   </tr>'+
		'   <tr>'+
        '       <td class="ui-state-hover">DataType</td>'+
        '       <td>'+
		'         <select class="ui-corner-all" style="width:370px;" name="campos" id="idDataTypeBox" >'+
		'            <option>xml</option>'+
		'            <option>json</option>'+
		'		  </select>	'+
		'		</td>'+
        '   </tr>'+
		'   <tr>'+
        '       <td class="ui-state-hover">Title</td>'+
        '       <td>'+
		'          <input class="ui-corner-all" style="width:370px;" type="text" id="idTitleBox"  onfocus="deshabilitaSuprime();"/>'+
		'		</td>'+
        '   </tr>'+
		'   <tr>'+
        '       <td class="ui-state-hover">Use pager</td>'+
        '       <td>'+
		'          <input class="ui-corner-all"  type="checkbox" id="idUsepagerBox" onfocus="deshabilitaSuprime();"/>'+
		'		</td>'+
        '   </tr>'+
		'   <tr>'+
        '       <td class="ui-state-hover">Use Rp</td>'+
        '       <td>'+
		'          <input class="ui-corner-all"  type="checkbox" id="idUseRpBox" onfocus="deshabilitaSuprime();"/>'+
		'		</td>'+
        '   </tr>'+
		'   <tr>'+
        '       <td class="ui-state-hover">Rp</td>'+
        '       <td>'+
		'         <select class="ui-corner-all" style="width:370px;" name="campos" id="idRPBox" >'+
		'            <option>10</option>'+
		'            <option>15</option>'+
		'            <option>20</option>'+
		'            <option>30</option>'+
		'            <option>50</option>'+
		'		  </select>	'+
		'		</td>'+
		'		</td>'+
        '   </tr>'+
		'   <tr>'+
        '       <td class="ui-state-hover">Show Table Toggle Btn</td>'+
        '       <td>'+
		'          <input class="ui-corner-all"  type="checkbox" id="idShowTable" onfocus="deshabilitaSuprime();"/>'+
		'		</td>'+
        '   </tr>'+
		'   <tr>'+
        '       <td class="ui-state-hover">Resizable</td>'+
        '       <td>'+
		'          <input class="ui-corner-all"  type="checkbox" id="idResizableBox" onfocus="deshabilitaSuprime();"/>'+
		'		</td>'+
        '   </tr>'+
		'   <tr>'+
        '       <td class="ui-state-hover">Single select</td>'+
        '       <td>'+
		'          <input class="ui-corner-all"  type="checkbox" id="idSingleSelBox" onfocus="deshabilitaSuprime();"/>'+
		'		</td>'+
        '   </tr>'+
		
		'   <tr>'+
        '       <td class="ui-state-hover">sortname</td>'+
        '       <td>'+
		'          <input class="ui-corner-all" style="width:370px;" type="text" id="idSortnameBox"  onfocus="deshabilitaSuprime();"/>'+
		'		</td>'+
        '   </tr>'+
		'   <tr>'+
        '       <td class="ui-state-hover">Sortorder</td>'+
        '       <td>'+
		'         <select class="ui-corner-all" style="width:370px;" name="campos" id="idSortorderBox" >'+
		'            <option>asc</option>'+
		'            <option>desc</option>'+
		'		  </select>	'+
		'		</td>'+
        '   </tr>'+
		'   <tr>'+
        '       <td class="ui-state-hover">Striped</td>'+
        '       <td>'+
		'          <input class="ui-corner-all" type="checkbox" id="idStripedBox" onfocus="deshabilitaSuprime();"/>'+
		'		</td>'+
        '   </tr>'+
		
		'</table><div>';

		
		var objDatos = $(datos);
		objDatos.appendTo( $("#panelTab_3") );
		
		var me = this;
		$("#idOkBox").click(function() {
			me.idOkBox_click();
		});
		
		$("#idCancelBox").click(function() {
			me.idCancelBox_click();
		});
		
		$("#idRemove").click(function() {
			me.idRemove_click();
		});
		
		$("#idNewRow").click(function() {
			me.idNewRow_click();
		});

		$("#idEditRow").click(function() {
			me.idEditRow_click();
		});
		
		$("#idEditUp").click(function() {
			me.idEditUp_click();
		});
		
		$("#idEditDown").click(function() {
			me.idEditDown_click();
		});
		
		this.load();
	}

	this.tmpSel = undefined;
	this.idRemove_click = function(){
		var me = this;
		
		var i =0;
		$("#idSelect_31 option").each(function(option){
			var selected = $(this).attr('selected');
			if(selected != undefined){
				$(this).remove();
				me.tmpSel.colModel.splice( i, 1 );
			}
			i++;
		});
	}
	
	this.getEditRowDialog = function() {
		var format = 
		{
			format:{version:"1.0.1",create:"2013-06-14T20:06:48.208Z"}
			,page:{width:260,height:400,top:10,left:0,name:""}
			,fields:
			[	
				{subclass:"FieldsetClass", parent:"droppable", height:193, width:275, top:0,   left:5, VIU:{"id":"idFieldset_17","idPanel":"idFS_17","idLegend":"idLegent_17","disabled":"","name":"","style":"","theClass":"","legend":"Columns Properties","legendAlign":"left"}},
				{subclass:"FieldsetClass", parent:"droppable", height:93, width:275, top:185, left:5, VIU:{"id":"idSearchItems","idPanel":"idFS_4","idLegend":"idLegent_4","disabled":"","name":"","style":"","theClass":"","legend":"Search Items","legendAlign":"left"}},
				{subclass:"JQBotonClass", parent:"droppable" , height:"58", width:"100", top:"310", left:"40", VIU:{"id":"idBoxNewOK","maxLength":"","value":"0","disabled":"","theClass":"ui-corner-all","primary":"","secondary":"","text":"","caption":"OK","idCaption":"idCap_31"}},
				{subclass:"JQBotonClass", parent:"droppable" , height:"58", width:"100", top:"310", left:"150", VIU:{"id":"idBoxNewCancel","maxLength":"","value":"0","disabled":"","theClass":"ui-corner-all","primary":"","secondary":"","text":"","caption":"Cancel","idCaption":"idCap_33"}}
			]
		};
	
		var html = 
		'<div id="idNewRowBox" title="New Row">'+
		'  <div id="maqueta"></div>'
		'</div>';
		
		$("#idNewRowBox").remove();
		var htmlObject = $(html);

		htmlObject.dialog({autoOpen: false, resizable: false, modal: true, width: (format.page.width+45), height: (format.page.height+45)});
		htmlObject.dialog( "open");
		$("#maqueta").run(format);
		
		
		html = '<br/><table id="idTableInfo" class="ui-state-default " border="1px" class="tabla" cellpadding="2" cellspacing="0" width="100%">'+
		'   <tr>'+
        '       <td class="ui-state-hover">Display</td>'+
        '       <td>'+
		'         <input class="ui-corner-all" style="width:170px;" type="text" id="idDisplayBox"  onfocus="deshabilitaSuprime();" />'+
		'		</td>'+
        '   </tr>'+
		
		'   <tr>'+
        '       <td class="ui-state-hover">Name</td>'+
        '       <td>'+
		'         <input class="ui-corner-all" style="width:170px;" type="text" id="idNameBox"  onfocus="deshabilitaSuprime();" />'+
		'		</td>'+
        '   </tr>'+
		
		'   <tr>'+
        '       <td class="ui-state-hover">Width</td>'+
        '       <td>'+
		'         <input class="ui-corner-all" value="180" style="width:170px;" type="text" id="idWidthBox"  onfocus="deshabilitaSuprime();" />PX'+
		'		</td>'+
        '   </tr>'+
		
		'   <tr>'+
        '       <td class="ui-state-hover">Sortable</td>'+
        '       <td>'+
		'          <input class="ui-corner-all"  type="checkbox" id="idSortableBox" onfocus="deshabilitaSuprime();"/>'+
		'		</td>'+
        '   </tr>'+
		
		'   <tr>'+
        '       <td class="ui-state-hover">Is Search</td>'+
        '       <td>'+
		'          <input class="ui-corner-all"  type="checkbox" id="idSearchBox" onfocus="deshabilitaSuprime();"/>'+
		'		</td>'+
        '   </tr>'+
		
		'   <tr>'+
        '       <td class="ui-state-hover">Align</td>'+
        '       <td>'+
		'         <select class="ui-corner-all" style="width:170px;" id="idAlignBox" >'+
		'            <option>Left</option>'+
		'            <option>Center</option>'+
		'            <option>Right</option>'+
		'		  </select>	'+
		'		</td>'+
        '   </tr>'+
		'</table>';
		
		
		var objDatos = $(html);
		objDatos.appendTo( $("#idFS_17") );
		
		html = '<br/><table id="idTableInfo" class="ui-state-default " border="1px" class="tabla" cellpadding="2" cellspacing="0" width="100%">'+
		'   <tr>'+
        '       <td class="ui-state-hover">Display</td>'+
        '       <td>'+
		'         <input class="ui-corner-all" style="width:170px;" type="text" id="idDisplayBox"  onfocus="deshabilitaSuprime();" />'+
		'		</td>'+
        '   </tr>'+
		
		'   <tr>'+
        '       <td class="ui-state-hover">Is default</td>'+
        '       <td>'+
		'          <input class="ui-corner-all"  type="checkbox" id="idSortableBox" onfocus="deshabilitaSuprime();"/>'+
		'		</td>'+
        '   </tr>'+
		'</table>';

		var objDatos = $(html);
		objDatos.appendTo( $("#idFS_4") );
		
		$("#idWidthBox").spinner({
			 step: 1
			,numberFormat:'C'
			,spin: function( event, ui ) 
			{
				if ( ui.value < 1 ) {	
					return false;
				}
			}
		});
		
		$("#idBoxNewCancel").button({text: "Cancel"});
		$("#idBoxNewCancel").click(function() {
			$('#idNewRowBox').dialog( "close" );
			$('#idNewRowBox').remove();
		});
	}
	
	this.idNewRow_click = function(){
		var me = this;
		this.getEditRowDialog();
		
		$("#idBoxNewOK").button({text: "OK"});
		$("#idBoxNewOK").click(function() {
			if(me.addValid()){
				me.addRow();
				$('#idNewRowBox').dialog( "close" );
				$('#idNewRowBox').remove();
			}
		});
	}
	
	this.idEditRow_click = function(){
		var i =this.getSelectedRow();
		if(i > -1){
			var me = this;
			this.getEditRowDialog();
		
			var obj = me.tmpSel.colModel[i];
			
			$("#idNameBox").val(obj.name);
			$("#idDisplayBox").val(obj.display);
			$("#idWidthBox").val(obj.width);
			$("#idAlignBox").val(obj.align);
			
			if(obj.sortable){
				$("#idSortableBox").attr("checked", "checked");
			}
			
			$("#idBoxNewOK").button({text: "OK"});
			$("#idBoxNewOK").click(function() {
				if(me.addValid()){
					me.updateRow();
					$('#idNewRowBox').dialog( "close" );
					$('#idNewRowBox').remove();
				}
			});
		}
	}
	
	
	this.idEditUp_click = function(){
		var posicion = this.getSelectedRow();

		var selected = $("#idSelect_31").find(":selected");
		var before = selected.prev();
		if (before.length > 0){
			selected.detach().insertBefore(before);
			
			var obj = this.tmpSel.colModel[posicion-1];
			this.tmpSel.colModel[posicion-1] = this.tmpSel.colModel[posicion];
			this.tmpSel.colModel[posicion] = obj;
		}
	}
	
	this.idEditDown_click = function(){
		var posicion = this.getSelectedRow();
		
		var selected = $("#idSelect_31").find(":selected");
		var next = selected.next();
		if (next.length > 0){
			selected.detach().insertAfter(next);
			
			var obj = this.tmpSel.colModel[posicion+1];
			this.tmpSel.colModel[posicion+1] = this.tmpSel.colModel[posicion];
			this.tmpSel.colModel[posicion] = obj;
		}
	}
	
	
	this.addValid = function(){
		var name = $("#idNameBox").val();
		var display = $("#idDisplayBox").val();
		var width = $("#idWidthBox").val();

		if(trim(display) == ""){
			alert("El campo display es requerido");
			return false;
		}		
		if(trim(name) == ""){
			alert("El campo name es requerido");
			return false;
		}
	
		if(trim(width) == ""){
			alert("El campo width es requerido");
			return false;
		}
		
		var val = (width*1);
		if(val == undefined || val == "" || isNaN(val)){
			alert("El campo width no es valido");
			return false;
		}
		
		return true;
	}
	
	
	this.updateRow = function(){
		var i =0;
		var posicion = this.getSelectedRow();
		
		var name = $("#idNameBox").val();
		var display = $("#idDisplayBox").val();
		var width = $("#idWidthBox").val();
		var sortable = true;
		var align = $("#idAlignBox").val();
		var sortable = ( $("#idSortableBox").attr("checked") == "checked");
		
		this.tmpSel.colModel[posicion] =
		{display: display, name : name, width :width, sortable : sortable, align: align};
		
		$("#idSelect_31["+posicion+"]").text(name);
		
		var x=document.getElementById("idSelect_31");
		x.options[posicion].text=name;
		x.options[posicion].value=name;
	}
	
	this.getSelectedRow = function(){
		var i =0;
		var posicion = -1;
		$("#idSelect_31 option").each(function(option){
			var selected = $(this).attr('selected');
			if(selected != undefined){
				posicion = i;
			}
			i++;
		});
		
		return posicion;
	}
	
	this.addRow = function(){
		var name = $("#idNameBox").val();
		var display = $("#idDisplayBox").val();
		var width = $("#idWidthBox").val();
		var sortable = true;
		var align = $("#idAlignBox").val();
		var sortable = ( $("#idSortableBox").attr("checked") == "checked");
		
		this.tmpSel.colModel[this.tmpSel.colModel.length] =
		{display: display, name : name, width :width, sortable : sortable, align: align};
		
		var sel = $('#idSelect_31');
		sel.append('<option value="'+name+'">'+name+'</option>');
	}
	
	
	this.idCancelBox_click = function(){
		this.closeDialog();
	}
	
	this.idOkBox_click = function(){
		
		this.asignaPropiedades();
		this.closeDialog();
		actualizaInfo();
	}
	
	this.load = function(){
		this.tmpSel = this.properties;
		
		$('#idUrlBox')      .val(this.properties.url);
		$('#idDataTypeBox') .val(this.properties.dataType);
		$('#idTitleBox')    .val(this.properties.title);
		$('#idSortnameBox') .val(this.properties.sortname);
		$('#idSortorderBox').val(this.properties.sortorder);
		$('#idRPBox')       .val(this.properties.rp);
		
		if(this.properties.usepager)           {$('#idUsepagerBox').attr("checked", "checked");}
		if(this.properties.useRp)              {$('#idUseRpBox').attr("checked", "checked");}
		if(this.properties.showTableToggleBtn) {$('#idShowTable').attr("checked", "checked");}
		if(this.properties.resizable)          {$('#idResizableBox').attr("checked", "checked");}
		if(this.properties.singleSelect)       {$('#idSingleSelBox').attr("checked", "checked");}
		if(this.properties.striped)            {$('#idStripedBox').attr("checked", "checked");}
		
		var sel = $('#idSelect_31');
		for(var i=0; i<this.properties.colModel.length; i++){
			var name = this.properties.colModel[i].display;
			sel.append('<option value="'+name+'">'+name+'</option>');
		}
	}
	
	this.asignaPropiedades = function(){
		this.properties.url                 =  $('#idUrlBox').val();
		this.properties.dataType            =  $('#idDataTypeBox').val();
		this.properties.title               =  $('#idTitleBox').val();
		this.properties.rp                  =  $('#idRPBox').val();
		this.properties.sortname            =  $('#idSortnameBox').val();
		this.properties.sortorder           =  $('#idSortorderBox').val();
		
		this.properties.striped             = ($('#idStripedBox'  ).attr("checked") == "checked");
		this.properties.usepager            = ($('#idUsepagerBox' ).attr("checked") == "checked");
		this.properties.useRp               = ($('#idUseRpBox'    ).attr("checked") == "checked");
		this.properties.showTableToggleBtn  = ($('#idShowTable'   ).attr("checked") == "checked");
		this.properties.resizable           = ($('#idResizableBox').attr("checked") == "checked");
		this.properties.singleSelect        = ($('#idSingleSelBox').attr("checked") == "checked");		
		this.properties.colModel = this.tmpSel.colModel;

		var domElement = $("#"+this.properties.id);
		this.setAttrObject(domElement);
		this.refresh();
	}
	
	this.closeDialog = function(){
		$('#idFlexigrid').dialog( "close" );
		$('#idFlexigrid').remove();
	}
	
	this.getPropertisList = function(){
		var ret = new Array();
		var domElement = $("#"+this.properties.id);
		
		var dataType = 
		[
			{name:'json', value:'json'},
			{name:'xml',  value:'xml'}
		];
		
		ret.push({name:'Title', attr:'title',   type:0, value:this.properties.title});
		ret.push({name:'Url', attr:'url',   type:0, value:this.properties.url});
		ret.push({name:'DataType', attr:'dataType',   type:4, value:this.properties.dataType, list:dataType});
		
		ret.push({name:'Usepager',attr:'usepager',   type:3, value:this.properties.usepager});
		ret.push({name:'UseRp',attr:'useRp',   type:3, value:this.properties.useRp});
		ret.push({name:'Rp', attr:'rp',   type:0, value:this.properties.rp});
		ret.push({name:'ShowTable',attr:'showTableToggleBtn',   type:3, value:this.properties.showTableToggleBtn});
		ret.push({name:'Resizable',attr:'resizable',   type:3, value:this.properties.resizable});
		ret.push({name:'SingleSelect',attr:'singleSelect',   type:3, value:this.properties.singleSelect});
		ret.push({name:'Striped',attr:'striped',   type:3, value:this.properties.striped});

		ret.push({name:'Mobile Version',attr:'mobile.action',   type:4, value:this.properties.mobile.action, list:getMobileList()});
		ret.push({name:'Mobile Name'   ,attr:'mobile.name',     type:0, value:this.properties.mobile.name});

		return ret;
	}
	
	this.attr = function(name, value){
		this.properties = setAttribute(this.properties, name, value);
		
		this.refresh();
		this.resize(this.properties.height+90, this.properties.width+3);
	}
	
	this.getAttr = function(name){
		var domElement = $("#"+this.properties.id);
		eval("ret = this.properties."+name);
		return ret;
	}
}
