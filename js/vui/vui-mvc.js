//var objController = null;

function Delegate(){
	this.url = "";
	
	this.setUrl = function(url){
		this.url = url;
	}
	
	this.execute = function(method, params){
        var jsonStr = "";
        
        if(params !== "" && params !== undefined){
            jsonStr = JSON.stringify(params);
        }

        var d = new Date();
        var n = d.getTime();
		var url = this.url+"?method="+method+"&params="+jsonStr+"&time="+n;
		var ret;
		$.ajax({
          async:false,    
          cache:false,   
          dataType:"json",
          type: 'GET',   
          url: url,
          success: function(respuesta){  
              ret = respuesta;
          },
          error:function(objXMLHttpRequest){
          		var c = new VUIController();
          		c.alert({title:"Error", 
          			    alert: "<h1>Ocurrio un error al ejecutar el servicio</h1>"+objXMLHttpRequest.responseText, 
          			    more: {button:"Ver mas", text: objXMLHttpRequest}});
			  	throw objXMLHttpRequest;
		  }
        });
		
		return ret;
	}
}

function MVCControl(){
	this.setSize = function(size){
		if(size == undefined){size = {}};
		var obj = $("#"+this.properties.id);

		if(size.height == undefined) {size.height = quitaPX(obj.css("height"))*1;}
		if(size.width  == undefined) {size.width  = quitaPX(obj.css("width"))*1;}
		
		this.resize(size.height, size.width);
		obj.css("height", size.height);
		obj.css("width", size.width);

		return $("#"+this.properties.id);
	}
	
	this.getSize = function(){
		var size = {height: 0, width:0};
		size.height = quitaPX($("#"+this.properties.id).css("height"))*1;
		size.width = quitaPX($("#"+this.properties.id).css("width"))*1;

		return size;
	}
	
	this.setPosition = function(position){
		if(position.left == undefined){position.left = this.left;}
		if(position.top == undefined){position.top = this.top;}
		
		var obj = $("#"+this.properties.id);
		obj.parent().css("left", position.left);
		obj.parent().css("top", position.top);
	}
}

function VUIController(){
	this.mvc = null;
	this.model = null;
	this.model_url = "";
	this.view = null;
	this.delegate = new Delegate();
	
	this.setModelUrl = function(model_url){
		this.model_url = model_url;
	}
	
	this.getModel = function(){
		return this.model;
	}
	
	this.setView = function(view){
		this.view = view;
	}
	
	this.viewClose = function(view){
		var win = $("#"+this.mvc.id);
		win.dialog( "close" );
	}

	this.alert = function(params){
		var id = "vui_id_alert";
			var win = $("#"+id);
			win.dialog( "close" );

			var me = this;
			me.closeDialog(id);
			var html = "<div id='"+id+"'><div class='vui_alert-text'>"+params.alert+"</div></div>";
			var win = $(html);
			win.css("overflow", "hidden");

			if(!params.width){params.width = 600};
			if(!params.height){params.height = 250};
			if(!params.title){params.title = ""};
			if(!params.modal){params.modal = true};
			if(!params.resizable){params.resizable = false};

			params.title = '<span class="ui-icon ui-icon-alert"></span> ' + params.title;
			params.buttons = {ok: function() {$( this ).dialog( "close" );}};
			
			win.dialog(params);
			win.dialog("open");
	}
	
	this.updateModel = function(model){
		this.model = model;
		this.__activeModel();
	}
	
	this.loadModel = function(){
		var me = this;

		if(this.model_url !== undefined){
			$.ajax({
					type: "GET", 
					url: this.model_url.src, 
					dataType: "json"
					
			}).done( function(model) {
				me.model = model;
				me.__activeModel();

				setTimeout(function(){ me.view_resize(); }, 100);	
			}).error(function(objXMLHttpRequest, status, text){
				setTimeout(function(){ me.view_resize(); }, 100);
          		me.alert({title:"Error", 
          			    alert: "<h1>Ocurrio un problema al cargar el modelo de la pagina</h1>"+objXMLHttpRequest.responseText, 
          			    more: {button:"Ver mas", text: objXMLHttpRequest}});

			});
		}else{
			setTimeout(function(){ me.view_resize(); }, 100);
			
		}
	}
	
	this.newMVCModel= function(mvc){
		var modeluUI = {
			modulo_name: "jquery-ui",
			resource_name: "dialog"
		}
		addDependence(modeluUI);
		var me = this;
		$.ajax({
				type: "GET", 
				url: mvc.view.src, 
				dataType: "json"
			}).done( function(format) {

				mvc.format = format;
				me.__newMVCModel(mvc, me, "windows");
				
				
			}).error(function(objXMLHttpRequest){
          		me.alert({title:"Error interno", 
          			      alert: "<h1>No se pudo cargar la pagina solicitada:</h1>["+mvc.view.src+"]", 
          			       more: {button:"Ver mas", text: objXMLHttpRequest}});
			});
	}
	
	this.view_resize = function(){
	}

	this.view_load = function(){
	}
	
	this.closeDialog = function(id){
		$("#"+id).dialog( "close" );
		$("#"+id).remove();
	}
	
	this.__newMVCModel = function(mvc, parent, type){
		if(mvc.controller.src){
			loadFile(mvc.controller.src);
		}
		
		eval(mvc.controller.theClass+".prototype = new VUIController();");
		mvc.objController = eval("new "+mvc.controller.theClass+"()");
		mvc.objController.setModelUrl(mvc.model);
		mvc.objController.delegate.setUrl(mvc.delegate);
		 
		mvc.format.controller = mvc.objController;
		dependence(mvc.format);
		
		if(type == "windows"){
			var me = this;
			me.closeDialog(mvc.id);
			var html = "<div id='"+mvc.id+"' title='"+mvc.title+"' class='ui-state-default ui-corner-all'></div>";
			var win = $(html);
			win.css("overflow", "hidden");
			
			var params = mvc.format.page;
			params.resize = function(event, ui) {
				var height = $("#"+mvc.id).css("height");
				var width = $("#"+mvc.id).css("width");
				var win = $("#"+mvc.id).children();
				
				win.css({"height": height, "width": width});
						
				mvc.objController.view_resize();
			};
			win.dialog(params);
			win.dialog("open");
		}
		
		
		$("#"+mvc.id).run(mvc.format);
		
		mvc.format.type = type;
		mvc.objController.setView(mvc.format);
		mvc.objController.parameter = mvc.parameter;
		
		mvc.objController.mvc = mvc;
		mvc.objController.parent = parent;
		
		if(mvc.objController){
			mvc.objController.view_load();
		}
	}
	
	this.__activeModel = function(){
		 for(var i=0; i<this.view.fields.length; i++){
			 var objectClass = this.view.fields[i].subclass;
			 var objectControler=undefined;
			 eval("objectControler = new " + objectClass +"();");
			 
			 if(objectControler.setModel){
				 objectControler.properties = this.view.fields[i].VIU;
				 objectControler.setModel(this.model);
			 }
		 }
	}	
	
	
	this.getObject = function(id){
		var obj = $(id);
		var objectClass = obj.attr("objectClass")
		
		var objectControler=undefined;
		eval(objectClass+".prototype = new MVCControl();");
		eval("objectControler = new " + objectClass +"();");
		
		var jsonStr = obj.attr("VIU");
		var properties = jQuery.parseJSON(jsonStr);
		
		properties.controller = this.mvc.format.controller;
		objectControler.properties = properties;
		
		return objectControler;
	}
	
	this.getHeight = function(){
		
		if(this.mvc.format.type == "windows"){
			var height = quitaPX($("#"+this.mvc.id).css("height"));
			return height*1;
		}else{
			return getHeight()*1;
		}
	}
	
	this.getWidth = function(){
		if(this.mvc.format.type == "windows"){
			var height = quitaPX($("#"+this.mvc.id).css("width"));
			return height*1;
		}else{
			return getWidth()*1;
		}
	}

    this.getCookie = function (cname) {
      var name = cname + "=";
      var ca = document.cookie.split(';');
      for(var i=0; i<ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0)==' ') c = c.substring(1);
          if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
      }
      return "";
    }

     this.setCookie = function(cname, cvalue) {
        var proyectListStr = JSON.stringify(cvalue);
        document.cookie = cname + "=" + proyectListStr + ";"
    }
}

 $(window).load(function() {
	 var app = $("vui-app");
	 var path = app.attr("vui-path");
	 var html="<script src='"+path+"dependence.js'></script>";
	 var head = $("head");
	 var importJs = $(html);
	 importJs.appendTo(head);
	 
	 var base = new VUIController();
	 
	 app.each(function(){
		 var obj = $(this);
		 var id = obj.attr("id");
		 if(!id){
			 id = "vuiId"+ String(Math.random()).replace(".", "");
			 obj.attr("id", id);
		 }
		 
		 var mvc = {
			model:      {src: obj.find("vui-model")     .attr("src")},
			view:       {src: obj.find("vui-view")      .attr("src")},
			controller: {src: obj.find("vui-controller").attr("src"),    theClass: obj.find("vui-controller").attr("theClass")},
			delegate:    obj.find("vui-delegate")       .attr("src"),
			id:          id,
		 };
		 
		 $.ajax({
				type: "GET", 
				url: mvc.view.src, 
				dataType: "json",
				async:true, 
                cache:false
			}).done( function(format) {
				mvc.format = format;
				base.__newMVCModel(mvc, null, "page");
				var objController = mvc.objController;
				var me = objController;

				$( window ).resize(function() {
					me.view_resize();
				});
			
			}).error(function(objXMLHttpRequest){
				var vista = new VUIController();
				vista.alert({title:"Error interno", 
          			    alert: "<h1>No se pudo cargar la vista de la pagina</h1>["+mvc.view.src+"]", 
          			    more: {button:"Ver mas", text: objXMLHttpRequest}});
			});
	 });
 });
 