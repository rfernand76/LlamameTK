/**
Clase que se encarga de manipular el flujo de eventos para la vista proyecto.  
Es implementada a traves de un modelo MVC de VisualUI por lo que extiende de la clase VUIController

@author Ricardo Fernandez
@version 1.0
**/

function LoginController(){
	this.viewPath = "forms/";

	this.webSocketManager = null;
	this.websocketParam = {
		url: "ws://localhost:9999",
		timeout:1000,
    	ajax: {
    		supper: true,
    		url: "localhost/ajax",
    		refresh: 2000

    	}
    };

	//this.serverSocket = "ws://localhost:9999";
	//this.serverAjax = "localhost/ajax"
    this.view_load = function(){
    	//this.webSocketControl(this.websocketParam);
    	//this.webSocketManager = new WebSocketManager();
    }

    this.WebSocket_onOpen = function(data){
    }

    this.WebSocket_onMessage = function(){
    	alert('WebSocket_onMessage');
    }

    this.WebSocket_onClose = function(){
    	alert('WebSocket_onClose');
    }

    this.WebSocket_onError = function(err){
    	alert('WebSocket_onError:'+err.message);
    }
    
}