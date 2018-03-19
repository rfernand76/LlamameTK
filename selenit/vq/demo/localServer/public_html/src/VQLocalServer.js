var WebSocketServer = require('websocket').server;
var http = require('http');
var sockets = new Array();
 
var server = http.createServer(function(request, response) {
    console.log((new Date()) + ' Received request for ' + request.url);
    response.writeHead(404);
    response.end();
});
server.listen(9999, function() {
    console.log((new Date()) + ' Server is listening on port 9999');
});
 
wsServer = new WebSocketServer({
    httpServer: server,
    autoAcceptConnections: false
});
 
function originIsAllowed(origin) {
  return true;
}
 
wsServer.on('request', function(request) {
    var ws = request.accept(null, request.origin);
    console.log("connection..." + request);
    
    // This is the most important callback for us, we'll handle
    // all messages from users here.
    ws.on('message', function(message) {
        newMessage(message, this);
    });
    
    ws.on('close', function(ws) {
        //console.log("La conexion se cerro");
    });
});


function newMessage(message, socket){    
    try {
        if (message.type === 'utf8') {

            try {
                //console.log(">>"+message.utf8Data);
                var data = JSON.parse(message.utf8Data);
                data.message = data.message.replace("//", "/");

                if(data.message === "/observer"){
                    observer(socket, data, true);
                }else if(data.message === "/update"){
                    update(socket, data);
                }else if(data.message === "/create"){
                    create(socket, data);
                }else if(data.message === "/consulta"){
                    consulta(socket, data);
                }else if(data.message === "/actualizaParametro"){
                    actualizaParametro(socket, data);
                }else{
                    console.log("data.message:"+data.message);
                    socket.sendUTF("Mensaje ["+data.message+"] no encontrado ");
                }


            } catch(e) {
                console.log(e);
                socket.sendUTF("Error, compruebe que el mensaje este bien formado:");
            }
        }
    } catch(e) {
        console.log("Ocurrio un error en el proceso ");
        console.log(e);
    }
}