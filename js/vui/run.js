(function($, undefined) {
$.widget("vui.run", {
	options:{},
	
	_create: function() {
		this.element.addClass("vui-contenedor");
		this.refresh();
	},
	
	destroy: function(){
		$.Widget.prototype.destroy.call(this);
	},
	
	refresh: function(){
		var zona = this.element.attr("id");
		var isMobil = getMobileVersion(this.options);
		

		if(this.options.emulaMobile){
			zona = emulaMobile(zona);
		}else{
			if(isMobil){
				screen_width = getWidth();
				screen_height = getHeight();

				this.element.css("width", (screen_width)+"px");
				this.element.css("height", (screen_height)+"px");
			}else{

				this.element.css("width", (this.options.page.width)+"px");
				this.element.css("height", (this.options.page.height)+"px");
				screen_width = this.options.page.width;
				screen_height = this.options.page.height;
			}
		}
		
		run(this.options, zona);
	}
});

$.widget("vui.controller", {
	options:{},
	
	_create: function() {
		alet(1);
	}
});

})(jQuery);



    var iContadorObjeto = randomId();
	var zoom = 100;
    var screen_width = 250;
    var screen_height = 400;
	var iheightPanel = 0;
	var theVentana = "";

	function emulaMobile(zona){
		//var html = "<div></div>"
		return zona;
	}

	function run(format, idVentana){
		theVentana = idVentana;
		var fields = format.fields;
		

		var objDestino = $("#"+idVentana);
		var isMobil = getMobileVersion(format);
		
		var manejaPanelControl = false;
		if(isMobil){
			manejaPanelControl = isManejaPanelControlMobil(format, "droppable");
			if(manejaPanelControl){
				createPanelControlHeader(isMobil, idVentana);
				iheightPanel = 54;
			}
		}

		if(format.emulaMobile){
			var element = $("#"+theVentana);
			element.css("width", screen_width+"px");
			element.css("height", screen_height+"px");
		}

		
		for(var i=0; i<fields.length; i++){
			var parent = fields[i].parent;
			if(parent != 'droppable'){
				objDestino = $("#"+parent);
			}else{
				objDestino = $("#"+idVentana);
			}

			var prop = getPropertiesForm(fields[i], isMobil);

			var objectClass = fields[i].subclass;
			var newDiv = "  <div class='campoInsertable "+prop.subClass+"' style='"
						   + "top: "          + prop.top        + "px;" 
						   + "left:"          + prop.left       + "px;" 
						   + "width:"         + prop.width      + "px;"
						   + "height:"        + prop.height     + "px;"
						   + prop.display
						   +"'>\n"
						   +"</div>\n";
						   
			htmlObject = $(newDiv);
			htmlObject.appendTo( objDestino );

			var objectControler=undefined;
			eval("objectControler = new " + objectClass +"();");
			var properties = eval(fields[i].VIU);
			properties.controller = format.controller;
			objectControler.properties = eval(fields[i].VIU);
			
			objectControler.create(htmlObject, 3, isMobil);
			objectControler.resize(prop.height, prop.width);

			iContadorObjeto = randomId();
		}

		if(isMobil && manejaPanelControl){
			$(".parentControl").css("display", "none");
			$("#"+fields[0].VIU.id).parent().css("display", "block");
		}
	}

	function getMobileVersion(format){
		var esMobile = isMobile();

		return format.page.mobilesupport && (esMobile || format.emulaMobile);
	}

	function isMobile(){
		var dispositivo = navigator.userAgent.toLowerCase();
		var isMobile = (dispositivo.search(/iphone|ipod|ipad|android|mobile/) > -1);
		return isMobile;
	}

	function getPropertiesForm(field, isMobil){

		var top = field.top;
		var left = field.left;
		var width = field.width;
		var height = field.height;

		var subClass = "";
		var display = "";

		if(isMobil){

			var ejecutar = undefined;
			ejecutar = field.VIU.mobile.action;
			if(ejecutar == 1){
				//crear en un panel
				addButtonPanelMobil(field, field.VIU.mobile.name);
				subClass = "parentControl";
				top = iheightPanel;
				left = "0";
				width = screen_width;
				height = screen_height;

			}else if(ejecutar == 2){
				//acoplar al maximo del objeto padre
				var parent = $("#"+getParent(field.parent));

				top = 0;
				left = "0";
				width = ((quitaPX(parent.css("width"))*1)+getWidthDif(parent));
				height = ((quitaPX(parent.css("height"))*1)+2);
				top = setTopAnt(parent, height);

			}else if(ejecutar == 3){
				//acoplar al maximo del objeto padre
				var parent = $("#"+getParent(field.parent));

				left = 0;
				width = ((quitaPX(parent.css("width"))*1)+getWidthDif(parent));
				height = 60;
				top = setTopAnt(parent, height);
				

			}else if(ejecutar == 4){
				//acoplar al maximo del objeto padre
				var parent = $("#"+getParent(field.parent));

				left = 0;
				width = ((quitaPX(parent.css("width"))*1)+getWidthDif(parent));
				
				top = setTopAnt(parent, height);

			}
		}

		var ret = {top:top, left:left, width:width, height:height, subClass:subClass, display:display};
		return ret;
	}

	function setTopAnt(parent,height){
		var topAnt = (parent.attr("topAnt"));
		if(topAnt == undefined || topAnt == ""){
			topAnt = 0;
		}
		topAnt = (topAnt *1) + 30;
		parent.attr("topAnt", topAnt+(height*1));
		return topAnt;
		
	}

	function getWidthDif(parent){
		var widthDif = (parent.attr("widthDif"));
		if(widthDif == undefined || widthDif == ""){
			return 20;
		}
		
		return widthDif*1;
	}

	function getParent(subId){
		if(subId == "droppable"){
			subId = theVentana;
		}
		return subId;
	}

	function isManejaPanelControlMobil(format, theParent){
		var ret = false;

		var fields = format.fields;
		var droppableCount = 0;
		if(getMobileVersion(format)){

			var i=0;
			while(!ret && i<fields.length){
				var parent = fields[i].parent;
				var action = fields[i].VIU.mobile.action;
				if(action == 1 && parent == theParent){
					droppableCount++;
					ret = droppableCount == 1;
				}
				i++;
			}
		}

		return ret;
	}

	function addButtonPanelMobil(field, name){
		var subId = field.parent;
		if(subId == "droppable"){
			subId = theVentana;
		}

		var idPanelControlHeader = $("#idPanelControlHeader_"+subId);
		var iParentPanel = (idPanelControlHeader.attr("buttons")*1);

		var newDiv = 
			"<div class='ui-state-hover ui-corner-all' style='position:static; width:60px; height: 50px; left:"
			+((iParentPanel*61))+"px; margin-left:0px; margin-right:0px;'>"+name+"</div>";
		idPanelControlHeader.attr("buttons", iParentPanel+1);

		var htmlObject = $(newDiv);
		htmlObject.appendTo( idPanelControlHeader );
		htmlObject.button({text:true});

		htmlObject.click(function() {
			$(".parentControl").css("display", "none");
			$("#"+field.VIU.id).parent().css("display", "block");
		});


	}

	function createPanelControlHeader(isMobil, idDestino){
		if(isMobil){
			var objDestino = $("#"+idDestino);
			var newDiv = 
				"<div id='idPanelControlHeader_"+idDestino+"' class='panelControlHeader ui-corner-all' style='width:100%;' buttons='0'></div>"

			var htmlObject = $(newDiv);
			htmlObject.appendTo( objDestino );

			//addButtonPanelMobil({parent:idDestino}, "Home");
		}
	}

	/*retorna el ancho de la pagina*/
	function getWidth()
	{
		var x = 0;
		if (self.innerHeight){
			x = self.innerWidth;
		}else if (document.documentElement && document.documentElement.clientHeight){
			x = document.documentElement.clientWidth;
		}else if (document.body){
			x = document.body.clientWidth;
		}
		return x;
	}

	/*retorna el alto de la pagina*/
	function getHeight()
	{
		var y = 0;
		if (self.innerHeight){
			y = self.innerHeight;
		}else if (document.documentElement && document.documentElement.clientHeight){
			y = document.documentElement.clientHeight;
		}else if (document.body){
			y = document.body.clientHeight;
		}

		return y;
	}
	
	function creteChildenTab(panelTab, objTab, mode){
		panelTab.children().each(function (index) {
			var obj = $(this);
			var children = obj.children();
			
			var height = quitaPX(obj.css("height"));
			var width = quitaPX(obj.css("width"))
			var top = quitaPX(obj.css("top"))
			var left = quitaPX(obj.css("left"))

			var htmlElement = "<div class='campoInsertable'"
							+ "style='width:" + (width) + "px;"
								  + "height:" + (height) + "px;"
									 + "top:" + top  + "px;"
									+ "left:" + left + "px;"
					+ "'></div>";
			var newElement = $(htmlElement);
			newElement.appendTo( objTab );
			
			var objectControler = getObjectFromDOM(children);
			iContadorObjeto = randomId();
			objectControler.create(newElement, mode);
			objectControler.resize(height, width);
		});
	}
	
	/*quita el string PX del parametro indicado*/
    function quitaPX(valorObj){
        var valor = valorObj.toString();
        valor = valor.substring(0,valor.length-2);
        return valor;
    }
	
	/*retorna el valor del zoom al valor aplicado(zoomAplica)*/
	function calculaZoom(valor, zAnt, zoomAplica){
		var propiedadNor = (valor * 100)/zAnt;
		valor	= (propiedadNor * zoomAplica )/100;
		return valor;
	}
	
	function randomId(){
		var r = Math.random()+"";
		r = r.replace(".", "");
		
		return r;
	}
    
	function generateID(mode, id, prefijo){
		if((mode*1) == 1){
			return  prefijo + iContadorObjeto;
		}
		return id;
	}
	
	function getProperties(mode, properties){
		var strProp = "disabled";
		if((mode*1) != 0){
			strProp = properties.disabled;
		}
		
		strProp = strProp + " id='" + properties.id + "' class='VUIObject " + properties.theClass +"' name='"+ properties.name +"' style='"+properties.style+"' "
		return strProp;
	}
	
	function getValueProperty(obj){
		return (obj == undefined || obj == null ?'' :obj);
	}
