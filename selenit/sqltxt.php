<?php  include("header.php"); ?>

	<script type="text/javascript">
		$(window).load(function() {
			$(".msgTitulo").css("display", "none");
		});
	</script>

        <section class="services">
          <div class="widget">
            <h3>SQLTXT</h3>
            <p>
		SQLTXT es una aplicación innovadora, que permite gestionar las consultas de archivos de texto de forma fácil y ordenada. Simplifica la tarea de lectura de archivo, ya que utiliza el estándar SQL como interfaz de consulta.

	    </p>
          </div>
          <?php  include("direccion.html"); ?>

          <div class="cl">&nbsp;</div>

        </section><!-- end of services -->
	<?php  include("sqltxt_part.php"); ?>

      <section class="box"> <span class="shadow-t" ></span>
          <h2>Algunas de sus caracteristicas son:</h2>

          <div class="entries">
            <div class="entry" style="height: 140px; width:280px;">
		<h2>F&aacute;cil definici&oacute;n</h2>
		<p>Proporciona un XML donde se configuran los archivos, modelándolos como si fueran tablas formales de una base de dato.</p>
		<span class="shadow" style="left:35px;"><span class="shadow"></span></span>
	    </div>

            <div class="entry" style="height: 140px; width:280px;">
		<h2>Funciones de usuario</h2>
		<p>Multiples funciones nativas, pero si eso no es suficiente cuenta con un mecanismo para programar funciones de usuario.</p>
		<span class="shadow" style="left:35px;"><span class="shadow"></span></span>
	    </div>

            <div class="entry" style="height: 140px; width:280px;">
		<h2>Integración JDBC</h2>
		<p>Proporciona un driver JDBC para clientes java lo que permite su integración con aplicaciones empresariales o clientes como “SQuirreL SQL Client” en forma nativa.</p>
		<span class="shadow" style="left:35px;"><span class="shadow"></span></span>
	    </div>
            <div class="cl">&nbsp;</div>

          <div class="entries">
            <div class="entry" style="height: 140px; width:280px;">
		<h2>Campos Tipados</h2>
		<p>Cada campo tiene un tipo, es es tratado como tal, de esta forma un operador "+" concatena si es string o suma si es un num&eacute;rico. </p>
		<span class="shadow" style="left:35px;"><span class="shadow"></span></span>
	    </div>

            <div class="entry" style="height: 140px; width:280px;">
		<h2>Linea de comando</h2>
		<p>Puede ser utilizado desde linea de comando, similar como se realiza una consulta en AWK, pero su lenguaje sigue siendo SQL</p>
		<span class="shadow" style="left:35px;"><span class="shadow"></span></span>
	    </div>

            <div class="entry" style="height: 140px; width:280px;">
		<h2>Lectua de archivos comprimidos</h2>
		<p>Empresas que utilizan archivos comprimidos pueden ejecutar las consultas sin descomprimirlo, lo que permite un ahorro de tiempo y espacio de disco. </p>
		<span class="shadow" style="left:35px;"><span class="shadow"></span></span>
	    </div>
            <div class="cl">&nbsp;</div>
	</section>
	<section class="cols">
	  <h2>Capacidad</h2>

          <div class="entries">
            <div class="entry" style="float: left; height: 200px; width: 320px; margin-right: 10px">
		<img src="images/sqltxt/particionar.jpg" style="height: 200px; width: 320px;" alt="">
		<span class="shadow" style="left:55px;"><span class="shadow"></span></span>
	    </div>

	    <div style="height: 200px;">

	    <p>
		Una de las prioridades es tener una herramineta que no tenga limite de registro o tamaño de lectura,

		SQLTXT puede manejar archivos tan grandes como lo permita el sistema operativo, pero si eso no es suficiente, tiene la capacidad 
		de particionar tablas mediante múltiples archivos lo que lo convierte en una solución escalable.
	     </p><br/>

	    <p>
		Permite relacionar dos o mas archivos de texto mediantes join de SQL, haciendo búsquedas mucho mas simples.
	     </p><br/>
	     <p>
		
	    </p>

           </div>

           <div class="cl">&nbsp;</div>
        </section>

 

	<section class="cols"><br>
	  <h2>
		Para mas información, escribanos y un ejecutivo se pondrá en contacto con usted a la brevedad.
	  </h2>

	   <?php  include("contacto_part.php"); ?>

          <div class="cl">&nbsp;</div>
        </section>

      </div><!-- end of main -->
    </div><!-- end of container -->





<?php  include("footer.php"); ?>




    
