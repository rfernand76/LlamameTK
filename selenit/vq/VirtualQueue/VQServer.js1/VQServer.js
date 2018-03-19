var WebSocketServer = require('websocket').server;
var http       = require('http');
var HashMap    = require('hashmap');
var mysql      = require('mysql');
var url        = require('url');

var Fila       = require('./Fila');
var Mantenedorfila = require('./Mantenedorfila');

var rows       = new HashMap();
/*var connection = mysql.createConnection({
      host     : 'localhost',
      user     : 'root',
      password : '5566',
      database : 'ktto_vegueta'
    });*/

var connection = mysql.createConnection({
      host     : 'localhost',
      user     : 'root',
      password : '5566',
      database : 'selenit_vq'
    });
    
init();

var server = http.createServer(function(request, response) {
    // process HTTP request. Since we're writing just WebSockets server
    // we don't have to implement anything.
});
server.listen(1337, function() { });

// create the server
wsServer = new WebSocketServer({
    httpServer: server
});

// WebSocket server
wsServer.on('request', function(request) {
    var connection = request.accept(null, request.origin);
    console.log("connection...");
    
    // This is the most important callback for us, we'll handle
    // all messages from users here.
    connection.on('message', function(message) {
        newMessage(message, this);
    });

    connection.on('close', function(connection) {
        // close user connection
    });
});


function init(){
    console.log("init server");
    
    
    var sql = "select fil_codigo, fil_nombre, fil_nemo, eje_modulo, fil_ut, fil_ta from fila where fil_active = 1";
    var query = connection.query(sql);
    
    query
    .on('result', function(row, index) {
       var r = new Fila(row);
       rows.set(row.fil_nemo, r);
    });
    
}


function newMessage(message, socket){    
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
}

function observer(socket, data, ignoreObserver){
    if(data.codigoManual !== ""){
        //console.log("data.codigoManual:"+data.codigoManual);
        var arr = data.codigoManual.split("-");
        data.seg_codigo = arr[0];
        data.token = arr[1];
    }

    var obj =   
    {
        accion: "solicitar", 
        razon : "Código no encotrado, por favor ingrese nuevamente",
        codigo: data.codigoManual
    };
    
    //console.log("observer:start seg_codigo:"+data.seg_codigo + " token:"+data.token);
    var sql = "select seg_seguridad, fil_nemo, seg_numero, eje_modulo from seguimiento WHERE seg_codigo =? and seg_seguridad = ?";
    var query = connection.query(sql, [data.token,  data.seg_codigo],
    function(err, registros, fields) {
        if (err) colsole.log(err);
        var registro = registros[0];
        
        if(registro && registro.seg_seguridad == data.seg_codigo){
            //console.log("registro.seg_seguridad="+registro.seg_seguridad);

            var row = rows.get(registro.fil_nemo);
            if(row !== undefined){
                var a=registro.fil_nemo.split(".");

                obj = {
                    accion: "activar",
                    letra: a[a.length -1],
                    numero: row.data.fil_ta,
                    modulo: row.data.eje_modulo,
                    miNumero: registro.seg_numero,
                };
            }

            if(registro.seg_numero <= row.data.fil_ta){
                console.log("no observer:"+registro.seg_numero +" >= " + row.data.fil_ta);
                obj.miModulo = registro.eje_modulo;
            }else{
                if(ignoreObserver === true){
                    //console.log("addObserver...");
                    row.addObserver(socket);
                }
            }
        }
        
        var json = JSON.stringify(obj);
        //console.log("json observer"+json);
        socket.sendUTF(json);
    });

}

function update(socket, data){
    console.log("actualizando...");
    
    var p = url.parse(data.path, true);
    var queryObject = p.query;
    
    var row = rows.get(queryObject.nemo);
    if(row !== undefined){
        if((row.user === data.user && row.password === data.password)){
            var sql = "update fila set fil_ta = ?, eje_modulo = ?  where fil_nemo = ?";
            connection.query(sql, [queryObject.fil_ta, queryObject.eje_modulo, queryObject.nemo]);
            row.update(queryObject);
            
            sql = "update seguimiento set eje_modulo = ? where seg_numero = ? and fil_nemo = ?";
            connection.query(sql, [queryObject.eje_modulo, queryObject.fil_ta, queryObject.nemo]);
            
        }
    }else{
        console.log("Fila no encontrada...");
    }
    
    socket.sendUTF("OK");
}

function create(socket, data){
    var p = url.parse(data.path, true);
    var queryObject = p.query;
    console.log("create:start");
    
    var row = rows.get(queryObject.nemo);
    if(row !== undefined){
        console.log("create:start -> queryObject.nemo is register");
        
        if((row.data.user === queryObject.user && row.data.password === queryObject.password)){
            row.createTicket(queryObject);
            
            var sql = "update fila set fil_ut = ?, fil_ta = ? where fil_nemo = ?";
            connection.query(sql, [queryObject.fil_ut,  queryObject.fil_ta, queryObject.nemo]);
            
            var sql = "INSERT INTO seguimiento(fil_nemo, seg_numero, seg_fecha, seg_seguridad, fil_codigo, eje_modulo, seg_llamado, seg_seguimiento, seg_atendido) "
                    + "VALUES (?, ?, CURRENT_TIMESTAMP(), ?, ?, '-', 0, 0, 0)";
            
            connection.query(sql, [queryObject.nemo,  
                                   queryObject.fil_ut, 
                                   queryObject.seg_seguridad, 
                                   queryObject.fil_codigo], 
            function(err, info) {
                console.log("err-->"+err);
                socket.sendUTF(info.insertId);
            });
            
        }else{
            console.log("Error: Usuario "+queryObject.user+" no registrado");
            socket.sendUTF("Error: Usuario "+queryObject.user+" no registrado");
        }
    }else{
        console.log("Error: Clave nemo:"+queryObject.nemo+" no existe");
        socket.sendUTF("Error: Clave nemo:"+queryObject.nemo+" no existe");
    }
}

function consulta(socket, data){
    var p = url.parse(data.path, true);
    var queryObject = p.query;
    var data = JSON.parse(queryObject.data);
    
    observer(socket, data, false);
}


function actualizaParametro(socket, data){
    var p = url.parse(data.path, true);
    var queryObject = p.query;
    var data = JSON.parse(queryObject.data);
    var usuario = queryObject.usuario;
    var password = queryObject.password;
    var enterprisId = queryObject.enterprisId;
    
    var tabla = data.name;
    var mant = "Mantenedor" + tabla;
    var message = data.message.replace("/", "");
    var ret = "Error desconocido";
    eval("ret = (new "+mant+"(data, connection, rows, usuario, password, enterprisId))."+message+"();");

    socket.sendUTF(ret);
}
