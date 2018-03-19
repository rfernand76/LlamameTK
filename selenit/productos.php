<?php  include("header.php"); ?>
	<script type="text/javascript">
		$(window).load(function() {
			$(".vermasdesc").css("display", "block");
		});

		$(window).load(function() {
			$(".oculto").css("display", "none");
		});
	</script>

        <section class="services">
          <div class="widget">
            <h3>Productos</h3>
            <p>
		Todos nuestros productos cuentan con una garantía de satisfacción en la cual su negocio estará protegido. 
		Le ayudamos a integrar y si requiere hacer un requerimiento especial, puede solicitarlo para hacer una evaluación.
	    </p>
          </div>
          <?php  include("direccion.html"); ?>

          <div class="cl">&nbsp;</div>

        </section><!-- end of services -->


	<?php  include("sqltxt_part.php"); ?>
	<?php  include("visualui_part.php"); ?>
	<?php  include("monitoreo_part.php"); ?>
	<?php  include("encuestas_part.php"); ?>
	

	</section>

      </div><!-- end of main -->
    </div><!-- end of container -->


<?php  include("footer.php"); ?>




    
