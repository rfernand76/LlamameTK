function Mantenedor(p){
    this.parametros = p;
    this.platilla =
    {
        "format": {
            "version": "1.0.3",
            "create": "2014-12-16T14:54:15.761Z",
            "cssFormat": "redmond"
        },
        "page": {
            "width": 953,
            "height": 383,
            "top": 0,
            "left": 0,
            "name": "",
            "mobilesupport": true
        },
        "fields": [
            {
                "subclass": "ToolbarClass",
                "parent": "droppable",
                "height": "50",
                "width": "953",
                "top": "0",
                "left": "0",
                "VIU": {
                    "id": "idToolbarClass_2",
                    "disabled": "",
                    "name": "",
                    "style": "",
                    "theClass": "ui-state-default ui-corner-all",
                    "mobile": {
                        "action": 1,
                        "name": "Menu"
                    },
                    "bars": [
                        {
                            "helpText": "File",
                            "id": "idBarFile",
                            "elements": [
                                {
                                    "type": "button",
                                    "helpText": "Nuevo",
                                    "id": "idToolbar1",
                                    "classIcon": "ui-icon-document"
                                },
                                {
                                    "type": "button",
                                    "helpText": "Modificar",
                                    "id": "idToolbar2",
                                    "classIcon": "ui-icon-pencil"
                                },
                                {
                                    "type": "button",
                                    "helpText": "Eliminar",
                                    "id": "idToolbar3",
                                    "classIcon": "ui-icon-close"
                                }
                            ]
                        }
                    ]
                }
            },
            {
                "subclass": "FlexiGridClass",
                "parent": "droppable",
                "height": "369",
                "width": "956",
                "top": "45.6",
                "left": "0",
                "VIU": {
                    "id": "idFlexiGrid_4",
                    "caption": "FlexiGrid",
                    "disabled": "",
                    "name": "",
                    "style": "",
                    "theClass": "",
                    "url": "Mantenedor.get.class.php",
                    "dataType": "json",
                    "usepager": true,
                    "useRp": true,
                    "rp": 20,
                    "showTableToggleBtn": true,
                    "resizable": false,
                    "singleSelect": false,
                    "striped": false,
                    "width": 795,
                    "height": 279,
                    "mobile": {
                        "action": 1,
                        "name": "Data"
                    }
                }
            }
        ]
    };


    this.create = function(p){
        dependence(this.platilla);//importa todos los js que necesita la pagina para funcionar
        addDependence({modulo_name:"jquery-ui", resource_name:"datepicker"});//importa todos los js que necesita la pagina para funcionar

        var jsonStr = JSON.stringify(this.parametros);
        var listaCampos = this.parametros.colModel;
        var flexiGrid = this.platilla.fields[1].VIU;

        flexiGrid.colModel = listaCampos;
        flexiGrid.searchitems = this.parametros.searchitems;
        flexiGrid.params = [{name:'jsonStr', value: jsonStr}];

        var toolbar = this.platilla.fields[0].VIU;
        if(this.parametros.button != undefined){
            toolbar.bars[1] = this.parametros.button;
        }


        $("#idMantenedor").run(this.platilla);
        var me = this;
        $("#idMantenedor #idToolbar1").click(function() {me.agregar()});
        $("#idMantenedor #idToolbar2").click(function() {me.modificar()});
        $("#idMantenedor #idToolbar3").click(function() {me.eliminar()});
        if(this.parametros.button != undefined){
            for(var i=0; i<this.parametros.button.elements.length; i++){
                var obj = $("#idMantenedor #"+this.parametros.button.elements[i].id);
                    obj.click(function(i) {me.ejecuta(i);
                });
            }
        }
    }

    this.ejecuta = function(element){
        var obj = undefined;
        var i=0;
        while(i<this.parametros.button.elements.length){
            if(this.parametros.button.elements[i].id == element.currentTarget.id){
                obj = this.parametros.button.elements[i];
            }
            i++;
        }
        if(obj != undefined){
            var registro = $('.bDiv .trSelected');
            var colModel = this.parametros.colModel;
            var valueList = "";
            var pk;
            for(var e=0; e<registro.length; e++){
                for(var i=0; i<colModel.length; i++){
                    if(colModel[i].pk === true){
                        valueList = valueList + registro[e].childNodes[i].childNodes[0].childNodes[0].textContent + ",";
                    }
                }
            }

            obj.onClick.call("", valueList);
        }
    }

    this.agregar = function(){
        this.agregaModifica(true);
    }
    
    this.onChange = function(url){
        var f = this.parametros.onChange;
        
        var a = url.split(".");
        var accion =  a[1];
        
        var me = this;
        if(f !== undefined && f !== null && f !== ""){
            me.ret = false;
            f.call("change", accion, me, me.parametros); 
        }else{
            me.ret = true;
        }
    }

    this.modificar = function(){
        this.agregaModifica(false);
    }

    this.eliminar = function(){
        var registro = $('.bDiv .trSelected');
        if(registro.length === 0){
            alert("Debe seleccionar un elemento");
            return;
        }

        var colModel = this.parametros.colModel;
        var valueList = "";
        var pk;
        for(var e=0; e<registro.length; e++){
            for(var i=0; i<colModel.length; i++){
                if(colModel[i].pk === true){
                    valueList = valueList + registro[e].childNodes[i].childNodes[0].childNodes[0].textContent + ",";
                    pk = colModel[i].name;
                }
                this.parametros.colModel[i].value = registro[e].childNodes[i].childNodes[0].childNodes[0].textContent;
            }
        }
        valueList = valueList.substring(valueList, valueList.length-1);
        

        var me = this;
        var accion = "Mantenedor.delete.php";
        this.parametros.valueList = valueList;
        if(me.onChange(accion)){
            var url = accion+'?name='+this.parametros.name+'&valueList='+valueList+'&pk='+pk;
            $.ajax(
            {
                url: url}).done(function(result) {
                    me.refresh();

                }
            );
        }

    }

    this.agregaModifica = function(agregar){
        var titulo = this.parametros.title + " [Modificar]";
        var accion = "Mantenedor.update.php";
        var idAccion = 0;
        if(agregar){
            titulo = this.parametros.title + " [Agregar]";
            accion = "Mantenedor.add.php";
            idAccion = 1;
        }

        $("#dialog").remove();
        var colModel = this.parametros.colModel;
        var registro = $('.bDiv .trSelected');
        if(!agregar && registro.length === 0){
            alert("Debe seleccionar un elemento");
            return;
        }

        var html =   '<div id="dialog" title="'+titulo+'"><table border=0>';
        for(var i=0; i<colModel.length; i++){
            var valueList = "";
            colModel[i].value = "";
            if(!agregar){
                valueList = registro[0].childNodes[i].childNodes[0].childNodes[0].textContent;
            }

            var disabled = " disabled ";
            if(!(colModel[i].isInput === false || (!agregar && colModel[i].noUpdate === true))){
                disabled = " ";
            }


            var size = (colModel[i].size > 0?" size="+colModel[i].size: "");
            var maxlength = (colModel[i].maxlength > 0?" maxlength="+colModel[i].maxlength: "");
            var id = 'mand_'+colModel[i].name;
            var value = (!agregar?valueList:"");

            var inputObject = "<input ttype='"+colModel[i].ttype+"' type='text' id='"+id+"' "+size+" "+maxlength+" value='"+value+"' "+disabled+">";
            var required = (colModel[i].required?"*":"");
            html = html + "<tr><td>"+required+"</td><td>"+colModel[i].display+"</td><td>"+inputObject+"</td></tr>";
        }
        html = html +'</table><div class="dialogInfo" id="dialogInfo"></div</div>';

        var obj = $(html);
        var me = this;
        obj.dialog(
        {
            resizable: true,
            modal: true,
            buttons: {
                "Aceptar": function() {
                    me.ejecutaAccion(agregar, accion, idAccion, this);
                },
                "Cancelar": function() {
                    $( this ).dialog( "close" );
                }
             }
        });

        $("#dialog input ").each( function( index2 ) {
            var obj = $(this);
            var ttype = obj.attr("ttype");
            if(ttype == "date"){
                obj.datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "yy-mm-dd",
                    yearRange: '1900:2020'
                });
            }
        });

    }

    this.refresh = function(){
         var idFlexiGridData = $('#idFlexiGrid_4').find('.tabla');

         idFlexiGridData.flexOptions(
             {onSuccess: function() {
                 //cargaGrid(idFlexiGridData)
             }
         }).flexReload();
    }

    this.ejecutaAccion = function(agregar, accion, idAccion, dialog){
        for(var i=0; i<this.parametros.colModel.length; i++){
            var id = 'mand_'+this.parametros.colModel[i].name;
            var value = $("#"+id).val();
            this.parametros.colModel[i].value = value;
        }
        var jsonStr = JSON.stringify(this.parametros);
        var f = this.parametros.valid;
        var me = this;
        if(f != undefined && f != null && f != ""){
            if(!f.call("valid", idAccion, me, me.parametros)){
                return;
            }
        }else{
            if(!this.valid(idAccion, me.parametros)){
                return;
            }
        }
        //dialogInfo
        var me = this;
        var url = accion+"?parametros="+jsonStr;
        
        me.onChange(accion);
        if(me.ret){
            $.ajax(
               {
                   url: url,
                   async:true
               }).done(function(result) {
                   var obj = jQuery.parseJSON(result);
                   if(obj.status === "OK"){
                       me.refresh();
                       $( dialog ).dialog( "close" );
                   }else{
                        me.dialogInfo("<b>Ocurrio un problema al realizar la accion:</b> <br/>"+obj.errdes);
                   }
               }
            );
        }
    }

    this.dialogInfo = function(msg){
        var obj = $("#dialogInfo");
        obj.html(msg);
        obj.css("display", "block");
    }


    this.valid = function(accion, p){
        var ret = true;
        var html = "";
        for(var i=0; i<p.colModel.length; i++){
            if(p.colModel[i].required && p.colModel[i].value == ''){
               ret = false; 
               html = html =  html + "<p>* El campo <b>" + p.colModel[i].display + "</b> es requerido</p>";
            }else{

            }
        }
        if(!ret){
            this.dialogInfo(html);
        }


        return ret;
    }
}

