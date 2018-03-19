<?php
$per_nombre="ADMINISTRADOR";
include("../global/header.php"); 
if($login){
include("encabezado.php");
?>
<link rel="stylesheet" href="/js/vui/visualUI.css"/>
<script src='/js/jquery-ui-1.9.1.custom/js/jquery-1.8.2.js'></script>
<script src='/js/vui/dependence.js'></script>
<script src='../js/selenit/menu.js'></script>
<script type='text/javascript'>
        $(window).load(function() {
            addDependence({modulo_name:"jquery-ui", resource_name:"jquery-ui.css"});//importa todos los js que necesita la pagina para funcionar
            menu();
        });
</script>

        <section class="services">
          <div class="widget">
            <h3>Bienvenido</h3>
            <p>
                Bienvenido a al sistema de Administración de virtual Queue.  
                En esta zona encontrará todo lo necesario para administrar y configurar su sistema.
                Por razones de seguridad esta pagina está dirigida solo a un usuario con perfil de administrador.
	         </p>
          </div>
          <div class="widget">
            <h3>Servicio Postventas</h3>
            <ul>
              <li><strong>Sitio </strong><a href="http://www.selenit.cl" target="_new">http://www.selenit.cl</a></li>
              <li><strong>Tel&eacute;fono: </strong>(+56) 2 320 54 510</li>
              <li><strong>Email: </strong>postventas@selenit.cl</li>
            </ul>
          </div>

          <div class="cl">&nbsp;</div>
        </section><!-- end of services -->

<section class="services" align="left">
<h4>En la parte superior encontrará un menú donde aparecen las opciones de configuración:</h4>

<div id="menuindex">
    <nav>
       <ul>
            <?php  include("menu.php"); ?>
        </ul>
    </nav>
</div>
</section>

<?php  
}
include("footer.php"); 
?>



