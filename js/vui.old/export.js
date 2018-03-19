	function ejecutaFileExport(){
		var page = getPageSAVE();
		var listCampoInsertable = getFieldsSAVE();
		
		var format = {version:version, create:new Date()};
		
		var diseno = {format:format, page: page, fields: listCampoInsertable};
		var jsonStr = JSON.stringify(diseno);
		//alert(diseno);
		//sendFile(diseno);
		
		$("#objJson").val(jsonStr);
		var form = $('#send');
		form.attr('action', 'export.php');

		validaSalir = false;
		form.submit();
	}
	
	function sendFile(data){
		/*$.ajax({
			type: "POST",
			url: "export.php",
			data: diseno
		}).done(function( msg ) {
			alert( "Data Saved: " + msg );
		});*/
		
		jQuery.ajax({
			url:'login.php',
			async:true,
			service:'login',
			type:'post',
			dataType:'json',
			data:data
		});
	
	
	}
	