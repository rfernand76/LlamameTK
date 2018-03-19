<!DOCTYPE html>
<html lang="en">
<head>
<title>Virtual Queue - Autenticacion</title>
<meta name="description" content="Autenticacion"/>
<meta charset="utf-8">
<script src="/js/jquery-ui-1.9.1.custom/js/jquery-1.8.2.js"></script>
<script src="/js/jquery-ui-1.9.1.custom/development-bundle/ui/jquery.ui.core.js"></script>
<link rel="stylesheet" href="/css/jquiryui/normal/jquery-ui.css"/>
<script type='text/javascript'>
    function ejecuta(){
        var password_new = $("#password_new").val();
        var password_confirm = $("#password_confirm").val();
        if(password_new == password_confirm && password_new.length > 5){
            var idForm = $("#idForm");
            idForm.submit();
        }
    }

</script>

<link rel="stylesheet" href="../css/style.css" type="text/css" media="all">
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
                <p>Reseteo de password</p>
              </div>
              <div class="cl">&nbsp;</div>
            </section><!-- end of services -->

            <section class="box"> <span class="shadow-t"></span>
              <form method="post" id="idForm">
              <input type="hidden" name="accion" value="resetear">
              <p><p>Usuario:</p><input type="text" name="usuario" size="30" maxlength="15" value="<?php echo $usuario ?>"></p>
              <p><p>Password:</p><input type="password" name="password" size="30" maxlength="15"></p>
              <p><p>Nueva password:</p><input id="password_new" type="password" name="password_new" size="30" maxlength="15"></p>
              <p><p>Confirmar password:</p><input id="password_confirm" type="password" name="password_confirm" size="30" maxlength="15"></p>
              <p><input type="button" value="Aceptar" onClick="ejecuta()"/></p>
              </form>
            </section>

        </div>
      </div>
    </div>
</div>
</body>
</html>

