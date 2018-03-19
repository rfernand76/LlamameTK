function getInfoList(){
    var lista = [
            {
                text: '¿Sabias que?',
                width: '250',

                list: [
                    {
                        text: 'Puedes sincronizar tu smartphone con la fila de este local:',
                        list:[
                            {
                                text: 'Utiliza el código de barra que aparece en el ticket. Este cogido te llevara a una pagina donde puedes realizar el seguimiento en linea.',
                                height:90,
                                width:90,
                                time: 10
                            }

                            ,{
                                text: 'Si posees un scaner de código QR, apuntalo hacia tu ticket y ya lo tendras sincronizado</br>'+
                                      'O puedes sincronizarlo ingresando el codigo de fila en llamame.tk directamente desde el navegador de tu telefono.'
                                ,
                                height:90,
                                width:180,
                                time: 20
                            }
                        ]
                    }
                ]
            },

            {
                text: 'LLamame.tk',
                width: '230',

                list: [
                    {
                        text: 'La manera inteligente de esperar:',
                        list:[
                            {
                                text: 'En un sistema gratuito de manejo de filas de espera, crea una cuenta y da un mejor servicio a tus clientes.',
                                height:90,
                                width:90,
                                time: 16
                            }

                            ,{
                                text: 'Evita fugas de cliente haciendo una mejor gestión de los tiempos de espera.',
                                height:90,
                                width:90,
                                time: 14
                            }

                            ,{
                                text: 'Si nesitas ayuda, nos puedes escribir a contacto@llamame.tk y reciviras acesoria completamente gratuita.',
                                height:90,
                                width:90,
                                time: 14
                            }
                            ,
                        ]
                    }

                    ,{
                        text: 'Por que es importante:',
                        list:[
                            {
                                text: 'Las personas con smartphone que sincrinicen su ticket podrá esperar remotamente, mucho mas comodas.',
                                height:90,
                                width:90,
                                time: 14
                            }

                            ,{
                                text: 'Un establecimiento con menos personas precenciales proporciona una mejor apariencia, con espacios mas seguros y limpios.',
                                height:90,
                                width:90,
                                time: 14
                            }

                            ,{
                                text: 'Al tener menos personas puedes re distribuir tu negocio, aumentando así tus ganancias.',
                                height:90,
                                width:90,
                                time: 14
                            }

                            ,{
                                text: 'Las personas tienden a fidelizar establecimientos con mejor servicio.',
                                height:90,
                                width:90,
                                time: 14
                            }

                        ]
                    }
                ]

            }
    ];

    return lista;
}


    function creaSabiasQue(lista, x,i, z){
        var sabiasque = $("#sabiasque");
        sabiasque.html("");

        //alert(" x:"+x+" i:"+i+" z:"+z);

        var obj = { 
                 width: lista[x].width, 
                    t1: lista[x].text, 
                    t2: lista[x].list[i].text, 
                    t3: lista[x].list[i].list[z].text,
                    img: lista[x].list[i].list[z].img,
                    heightImg: lista[x].list[i].list[z].height,
                    widthImg: lista[x].list[i].list[z].width,
                    time: lista[x].list[i].list[z].time
                };

        var htmlSabiasQue = 
        "<h1 class='ui-state-default ui-corner-all' style='width:"+obj.width+"px;'>"+obj.t1+"</h1>"+
        "<h2>"+obj.t2+"</h2>"+
        "<h3>"+obj.t3+"</h3>"+
        //"<img src='img/"+obj.img+"' height='"+obj.heightImg+"px' width='"+obj.widthImg+"'/>"+
        "";

        var objHtml = $(htmlSabiasQue);
        objHtml.appendTo(sabiasque);

        siguiente(lista, x,i, z, obj.time);
    }

    function siguiente(lista, x, i, z, time){



        if(z < lista[x].list[i].list.length-1){
            z++;
        }else{
            z = 0;
            if(i < lista[x].list.length-1){
                i++;
            }else{
                i=0;
                if(x < lista.length-1){
                    x++;
                }else{
                    x=0;
                }
            }
        }

        setTimeout(function(){creaSabiasQue(lista, x,i, z);},  time*1000);
    }