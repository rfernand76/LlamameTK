<!DOCTYPE html>
<html lang="en">
<head>
<title>Virtual Queue - Autenticacion</title>
        <meta name="description" content="Autenticacion"/>
        <meta charset="utf-8">
        <meta name="viewport" content="width=500, initial-scale=1">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <meta name="viewport" content="width=device-width, user-scalable=no">

<script src="/js/jquery-ui-1.9.1.custom/js/jquery-1.8.2.js"></script>
<script src="/js/jquery-ui-1.9.1.custom/development-bundle/ui/jquery.ui.core.js"></script>
<link rel="stylesheet" href="/css/jquiryui/normal/jquery-ui.css"/>

<script type='text/javascript'>
    $(window).load(function() {
        $("body").css("overflow-x", "hidden");
    });


    function ejecuta(){
        $("#accion").val("resetear");
        $("#idForm").submit();
    }

</script>

<link rel="stylesheet" href="../css/style.css?a=3" type="text/css" media="all">
</head>
<body>
    <div id="wrapper">
      <div class="shell">
        <div class="container">
            <header class="header">
              <h1 id="logo"></h1>
              <div class="cl">&nbsp;</div>
            </header>
            <section class="services">
              <div class="widget">
                <p>Autenticación de usuario</p>
              </div>
              <div class="cl">&nbsp;</div>
            </section><!-- end of services -->

            <section class="box"> <span class="shadow-t"></span>
              <form method="post" id="idForm">
              <input type="hidden" id="accion" name="accion" value="">
              <p><p>Usuario:</p> <input class="inputClass ui-corner-all" type="text"  name="usuario" size="30" maxlength="15"></p>
              <p><p>Password:</p><input class="inputClass ui-corner-all" type="password" name="password" size="30" maxlength="15"></p>
              <br/>
                <input type="submit" class="ui-button ui-widget ui-state-default ui-corner-left" value="Aceptar"/> 
                <input type="button" class="ui-button ui-widget ui-state-default ui-corner-right input" value="Password" onClick="ejecuta()"/></p>
              </form>
            </section>

        </div>
      </div>
    </div>
</div>
</body>
</html>

