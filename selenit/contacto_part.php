	<script type="text/javascript">
		function ejecuta(){
			var contact = $("#idContact");
			var msg = $("#mensaje").val();
			var email = $("#email").val();
			var author = $("#author").val();
			var telefono = $("#telefono").val();

			if(valida()){
				$.ajax({
				  data: { author:author, email:email, mensaje:msg, telefono:telefono } ,
				  url: "contacto.do.php",
				  context: document.body
				}).done(function(msg) {
				  $("#mensaje").val("");
				  alert("Su mensaje fue enviado exitosamente, pronto nos pondremos en contacto con usted.");
				}).error(function(e) {
				  alert("El mensaje no pudo ser enviado correctamente, puede utilizar nuestro correo info@selenit.cl. Por favor disculpe las molestias");
				});
			}
		}
	
		function validar_email(valor){
		var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		if(filter.test(valor))
		    return true;
		else
		    return false;
	    }
	
		function valida(){
			var ret = true;
		
			$("#idErrorAuthor").css("display", "none");
			$("#idErrorEmail").css("display", "none");
			$("#idErrorMensaje").css("display", "none");
			if($("#author").val() == ''){
				$("#idErrorAuthor").css("display", "block");
				ret = false;
			}
		
			if($("#email").val() == ''){
				$("#idErrorEmail").html("<b>Ingrese un correo de contacto</b>");
				$("#idErrorEmail").css("display", "block");
				ret = false;
			}else if(!validar_email($("#email").val())){
				$("#idErrorEmail").html("<b>Debe ingresar un correo valido</b>");
				$("#idErrorEmail").css("display", "block");
				ret = false;
			}
		
		
			var msg = $("#mensaje").val();
			if(msg == ''){
				$("#idErrorMensaje").html("<b>Debe ingresar un mensaje</b>");
				$("#idErrorMensaje").css("display", "block");
				ret = false;
			}else if(msg.length>3000){
				$("#idErrorMensaje").html("<b>El mensaje no puede tener mas de 3000 caracteres</b>");
				$("#idErrorMensaje").css("display", "block");
				ret = false;
			}
		
			return ret;
		
		}
	</script>

	<h2 class="msgTitulo">Puede escribir su consulta directamente en el siguiente formulario</h2>
	</br>
		<form method="post" name="contact" id="idContact">
                        <div class="cleaner h10"></div>
						
                        <label for="author">Nombre:</label></br> 
                        <input type="text" maxlength="60" size="60" id="author" name="author" class="input_field" />
			<div id='idErrorAuthor' class='mensajeError'><b>Debe ingresar un nombre de contacto</b></div>
			</br>

			
                        <label for="email">Correo:</label></br>
                        <input type="text" maxlength="60" size="60" id="email" name="email" class="validate-email required input_field" />
			<div id='idErrorEmail' class='mensajeError'><b>Debe ingresar un correo</b></div>
                        </br>

                        <label for="email">Telefono:</label></br>
                        <input type="text" maxlength="60" size="60" id="telefono" name="telefono" class="input_field" />
                        </br>

                        <label for="text">Mensaje:</label></br>
                        <textarea maxlength="3000" cols="60" rows="5" name="mensaje" id="mensaje" rows="0" cols="0" class="required"></textarea>
			<div id='idErrorMensaje' class='mensajeError'><b>Debe ingresar un mensaje</b></div>
			</br>

			<input type="button" value="Enviar"  onclick='javascript:ejecuta();' class="col-btn"/>

            	</form>

