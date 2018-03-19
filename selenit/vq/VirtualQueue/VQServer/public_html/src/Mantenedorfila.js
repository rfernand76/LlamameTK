var Fila = require('./Fila');

function Mantenedorfila(parametros, connection, rows, usuario, password, enterprisId) {
    this.parametros = parametros;
    this.connection = connection;
    this.rows = rows;
    this.usuario = usuario;
    this.password = password;
    this.enterprisId = enterprisId;
}

Mantenedorfila.prototype.update = function () {
    var nemo = this.enterprisId + "." + this.parametros.fil_nemo;

    var row = this.rows.get(nemo);
    if (row !== undefined) {
        if (row.data.user === this.usuario && row.data.password === this.password) {
            row.fil_nombre = this.parametros.fil_nombre;
            var sql = "update fila set fil_nombre = ? where fil_nemo = ?";

            this.connection.query(sql, [row.fil_nombre, nemo]);
            return "OK";
        } else {
            return "Usuario o password no coinciden";
        }
    } else {
        return "Fila no encontrada:" + nemo;
    }
}


Mantenedorfila.prototype.isAutorizado = function () {
    return true;
}
Mantenedorfila.prototype.delete = function () {
    console.log("lista a eliminar: "+this.parametros.valueList);
    
    if (this.isAutorizado()) {
        var r = this.parametros.valueList.split(",");

        var valueList = "";
        for (i = 0; i < r.length; i++) {
            var nemo = this.enterprisId + "." + r[i] ;
            valueList = valueList + "'"+nemo + "',";
        }
        
        valueList = valueList.substring(valueList, valueList.length - 1);
        console.log("valueList..." + valueList);

        var sql = "update fila set fil_active = 0 where fil_nemo in ("+valueList+")";
        this.connection.query(sql, []);

        return "OK";
    } else {
        return "Usuario o password no coinciden";
    }

}

Mantenedorfila.prototype.add = function () {
    var nemo = this.enterprisId + "." + this.parametros.fil_nemo;
    var sql = "delete FROM fila where fil_nemo = ?";
    this.connection.query(sql, [nemo]);

    sql = "INSERT INTO fila (fil_codigo, fil_nombre, fil_nemo, eje_modulo, fil_active, fil_ut, fil_ta) " +
            "VALUES (NULL, ?, ?, '--', '1', 0, 0);";

    this.connection.query(sql, [this.parametros.fil_nombre, nemo]);

    var n = {
        fil_codigo: null,
        fil_nombre: this.parametros.fil_nombre,
        fil_nemo: nemo,
        eje_modulo: null,
        fil_ut: null,
        fil_ta: null
    };

    var row = this.rows.get(nemo);
    if (row === undefined) {
        var r = new Fila(n);
        this.rows.set(n.fil_nemo, r);
    } else {
        row.data.fil_ut = 0;
        row.data.fil_ta = 0;
        row.data.eje_modulo = '--';
    }

    return "OK";
}


module.exports = Mantenedorfila;