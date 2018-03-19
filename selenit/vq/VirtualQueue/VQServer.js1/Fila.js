function Fila(data) {
    this.data = data;
    this.sockets = new Array();
    this.data.user = "selenit";
    this.data.password = "sel1234";
    
    /*
        this.fil_codigo = null;
        this.fil_nombre = null;
        this.fil_nemo = null;
        this.eje_modulo = null;
        this.fil_ut = null;
        this.fil_ta = null;
     */
}

Fila.prototype.addObserver = function(socket) {
    this.sockets.push(socket);
}

Fila.prototype.update = function(queryObject) {
    this.data.fil_ta = queryObject.fil_ta;
    this.data.eje_modulo = queryObject.eje_modulo;
    
    this.notify();
}

Fila.prototype.createTicket = function(queryObject) {
    this.data.fil_ta = queryObject.fil_ta;
    this.data.fil_ta = queryObject.fil_ta;
}

Fila.prototype.notify = function() {
    console.log("client length:"+this.sockets.length);
    for(var i=0; i<this.sockets.length; i++){
        var socket = this.sockets[i];
        if(socket.connected){
            this.sendMessage(socket, 'update');
        }else{
            //console.log("client disconect");
            this.sockets.splice (i, 1);
            i--;
        }
    }
    console.log("update:"+this.sockets.length);
}

Fila.prototype.sendMessage = function(socket, accion) {
    var obj = {
        accion: accion,
        modulo: this.data.eje_modulo,
        miModulo: this.data.eje_modulo,
        numero: this.data.fil_ta
    };
    
    //console.log("accion:"+accion);
    var json = JSON.stringify(obj);
    socket.sendUTF(json);
}

module.exports = Fila;
