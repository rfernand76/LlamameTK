<!DOCTYPE html>
<html lang="en">
<head>
<title>Selenit - Dispensador de numeros</title>
<meta name="description" content="Modulo de auto consulta"/>
<meta charset="utf-8">

<script src="/js/jquery-ui-1.9.1.custom/js/jquery-1.8.2.js"></script>


<script type="text/javascript">
    function abrir(){
        
        var cantidad = $("#cantidad").val()*1;
        a(0);
    }
    
    function a(n){
        alert(n);
        var cantidad = $("#cantidad").val()*1;
        var url = $("#url").val();
        
        var name = "n"+n;
        window.open(url, name);
        
        n++;
        if(n<cantidad){
            setTimeout(function(){a(n);},  1000);
        }
    }

</script>

</head>
<body>
    <form>
        <p>url: <input type="text" name="url" id="url"></p>
        <p>cantidad: <input type="text" name="cantidad" id="cantidad"><p/>
        <p><input type="button" onclick="javascript:abrir()" value="ejecutar"></p>
    </form>
</body>
</html>




    
