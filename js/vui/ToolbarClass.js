function ToolbarClass(){
	this.width = 400;
	this.height = 48.7;

	this.properties = 
	{
		id:"idToolbarClass_" + iContadorObjeto,
		disabled:'',
		name:'',
		style:'',
		theClass:'ui-state-default ui-corner-all',
		mobile:{action:1,name:'Menu'},
		  
		bars: [
        {
			helpText:"File",
			id:"idBarFile",
			elements: [
				{type:"button", helpText:"New",   id:'idToolbar1', classIcon:'ui-icon-document'},
				{type:"button", helpText:"Save",  id:'idToolbar2', classIcon:'ui-icon-disk'},
				{type:"button", helpText:"Close", id:'idToolbar3', classIcon:'ui-icon-home'}
			]
		},
        {
			helpText:"Config",
			id:"idBarOther",
			elements: [
				{type: "button", helpText: "Preview",   id:'idToolbar4', classIcon:'ui-icon-search'},
				{type: "button", helpText: "Config",    id:'idToolbar5', classIcon:'ui-icon-gear'}
			]
		}
      ]
	};

	this.getHtml = function(){
		return this.__getHtml(0);
	}

	this.__getHtml = function(mode, isMobil){
		var html = 	'<div '+ getProperties(mode, this.properties) +'>\n';
		var bars = this.properties.bars;
		var toolbar = "toolbar";
		var toolbarPanel = "toolbarPanel";

		if(isMobil != undefined && isMobil){
			toolbar = "";
			toolbarPanel = "";
		}

		for(var i=0; i<bars.length; i++){
			html = html +'  <div class="'+toolbar+'">\n'
					    +'    <span id="'+bars[i].id+'" class="ui-widget-header ui-corner-all '+toolbarPanel+'">\n';
			var elements = bars[i].elements;
			for(var e=0; e<elements.length; e++){
				html = html + this.getHtmlElement(elements[e]);
			}
			
			html = html +'    </span>\n  </div>\n';
		}
		
		html = html +'</div>\n';
		return html;
	}
	
	this.getHtmlElement = function(element){
		var html = "";
		if(element.type ==='button'){
			html = '        <button id="'+element.id+'" title="'+element.helpText+'">'+element.helpText+'</button>\n';
		}else if(element.type === 'checkbox'){
			html = '        <input type="checkbox" id="'+element.id+'" /><label for="'+element.id+'" title="'+element.helpText+'">'+element.label+'</label>\n';
		}else if(element.type === 'select'){
                        html = '        <select id="'+element.id+'">';
                        for(var i=0; i<element.list.length; i++){
                            html = html + '           <option value="'+element.list[i].value+'">'+element.list[i].caption+'</option>';
                        }
                        
                        html = html +  '        </select>\n';
                }
                
		
		return html;
	}

	this.getJS = function(isMobil){
		var bars = this.properties.bars;
		var js = "";
			
		
		for(var i=0; i<bars.length; i++){
			var elements = bars[i].elements;
			for(var e=0; e<elements.length; e++){
				js = js + this.getJSElement(elements[e], isMobil);
				js = js +'\n';
			}
			js = js + 'var bs = $("#' +this.properties.id+ ' #'+bars[i].id+'" );\n';
			js = js +'bs.buttonset();\n';
			if(isMobil){
				js = js + "bs.css('width', '100%');\n";
			}
		}
		return js;
	}
	
	
	this.getJSElement = function(element, isMobil){
		var js = "";
		var label =     (element.label == undefined ?''  :',label:"'+element.label+'"\n');
		var icons = (element.classIcon == undefined ?''  :',icons: {primary: "'+element.classIcon+'"}\n');

		if(isMobil !== undefined && isMobil){
			element.text = true;
		}
		
		if(element.type === 'button'){
				js = 'var boton = $("#' +this.properties.id+ ' #'+element.id+'" );\n'
					+'boton.button({\n'
					+'text: '+(element.text==true)+'\n'
					+label
					+icons
					+'});\n';
				
		}else if(element.type === 'checkbox'){
				js = 'var boton = $("#' +this.properties.id+ ' #'+element.id+'" );\n'
					+'boton.button({\n'
					+'text: '+(element.text===true)+'\n'
					+label
					+icons
					+'});\n';		

		}else if(element.type === 'checkbox'){
				js = 'var boton = $("#' +this.properties.id+ ' #'+element.id+'" );\n'
					+'boton.button({\n'
					+'text: '+(element.text===true)+'\n'
					+label
					+icons
					+'});\n';
                }

		if(isMobil){
			js = js 
			+"boton.css('width', '100%');"
			+"boton.css('height', '60px');\n"

		}
		
		return js;
	}
	
	
	this.setEvents = function(){
		var bars = this.properties.bars;
			
		for(var i=0; i<bars.length; i++){
			var elements = bars[i].elements;
			for(var e=0; e<elements.length; e++){
				this.setEvent(elements[e]);
			}
		}
	}
	
	this.setEvent = function(element){
		if(element.events){
			for(var i=0; i<element.events.length; i++){
				var el = $("#"+element.id);
				var name  = element.events[i].name;
				var event = element.events[i].event;
				var me = this;
				el.on(name , function() {
					eval("me.properties.controller."+event+"()")
				});
			}
		}
	}

	this.create = function(padre, mode, isMobil){
		this.properties.id = generateID(mode, this.properties.id, 'idDynatree_');

		var html = this.__getHtml(mode, isMobil);
		var htmlObject = $(html);
		htmlObject.appendTo( padre );

		var jsonStr = JSON.stringify(this.properties);
		htmlObject.attr("VIU", jsonStr);
		htmlObject.attr("objectClass", "ToolbarClass");

		var js = this.getJS(isMobil);
		eval(js);
		this.setEvents();

		return htmlObject;
	}
	
	this.editDialog = function(){
        var mvc = {
                  view: {src: "form/toolbar/toolbar_view.js"},
            controller: {src: "form/toolbar/toolbar_controller.js", theClass: "VIUToolbarController"}, 
                    id: "VUI-TOOLBAR-CFG",
                 title: "Toolbar Configurations",
             parameter: this
        };
        
		var controller = new VUIController();
        controller.newMVCModel(mvc);
	}
	
	this.getFromDom = function(elementoSeleccionado){
		var jsonStr = elementoSeleccionado.attr("VIU");
		this.properties = jQuery.parseJSON(jsonStr);
	}

	this.resize = function(heightResize100, widthResize100){
		var domElement = $("#"+this.properties.id);
		
		if(heightResize100 !== undefined){
			domElement.css("height", (heightResize100-10)+"px");
		}
		
		if(widthResize100 !== undefined){
			domElement.css("width", (widthResize100-1)+"px");
		}
	}

	this.getPropertisList = function(){
		var ret = new Array();
		ret.push({name:'Mobile Version',attr:'mobile.action',   type:4, value:this.properties.mobile.action, list:getMobileList()});
		ret.push({name:'Mobile Name'   ,attr:'mobile.name',     type:0, value:this.properties.mobile.name});
		return ret;
	}
		
	this.attr = function(name, value){
		this.properties = setAttribute(this.properties, name, value);
	}

	this.getAttr = function(name){
		eval("ret = this.properties."+name);
		return ret;
	}
}
