var http = require("http");
var url = require('url');
var WebSocketClient = require('websocket').client;

http.createServer(function (request, response) {
    response.writeHead(200, {"Content-Type": "text/html"});
    var p = url.parse(request.url, true);
    var no = new WebSocketClient();
    
    client.on('connectFailed', function (error) {
        console.log('Connect Error: ' + error.toString());
    });

    client.on('connect', function (connection) {

        connection.on('error', function (error) {
            response.write("");
            response.end();
            
            console.log("Connection Error: " + error.toString());
        });
        connection.on('close', function () {
            console.log("close event");
        });
        connection.on('message', function (message) {
            try{
                var json = JSON.stringify(message);
                console.log("new message"+json);

                if (message.type === 'utf8') {
                    console.log("caso1:"+message.utf8Data);
                    response.write(message.utf8Data);
                    response.end();
                    connection.close();
                }
            } catch(e) {
                console.log(e);
                response.write("Ocurrio un error interno");
            }
        });

        var msg = {
            message: p.pathname,
            date: Date.now(),
            path: p.path
        };

        var json = JSON.stringify(msg);
        connection.sendUTF(json);
    });

    client.connect('ws://localhost:1337');
}).listen(8888)
