<?php
	$totalRegistros = 75;

	$page = isset($_POST['page']) ? $_POST['page'] : 1; 
	$rp = isset($_POST['rp']) ? $_POST['rp'] : 10; 
	$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'cif'; 
	$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc'; 
	$query = isset($_POST['query']) ? $_POST['query'] : false; 
	$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : false; 
	
	$pageStart = ($page-1)*$rp; 
	$jsonData = array('page'=>$page,'total'=>$totalRegistros,'rp'=>$rp,'rows'=>array());
	
	/*for ( $counter = 1; $counter <= $rp; $counter++) {
		$entry = array('cell' => array($page, ($page*10)+$counter)); 
		$jsonData['rows'][] = $entry;
	}*/
	
	$entry = array('cell' => array(
								   '<input type="text" class="spinner" size="1" maxlength="2" value="1"/>'
								  ,'<input type="button" value="Agregar" class="button"/>'
								  ,'Aceituna ( Canasta Viva)'
								  ,'Frutas y verduras'
								  ,'Aceituna orgánica con certificación participativa 5 región'
								  ,'Canasta Viva'
								  ,'250GRs'
				                  )
				   ); 
	$jsonData['rows'][] = $entry;
	
	$entry = array('cell' => array(
	                               '<input type="text" class="spinner" size="1" maxlength="2" value="1"/>'
								  ,'<input type="button" value="Agregar" class="button"/>'
								  ,'Acelga (Tierra Viva)'
								  ,'Frutas y verduras'
								  ,'Acelga con certificación Orgánica R M'
								  ,'Tierra Viva'
								  ,'1'
				                  )
				   ); 
	$jsonData['rows'][] = $entry;
	
	$entry = array('cell' => array(
	                               '<input type="text" class="spinner" size="1" maxlength="2" value="1"/>'
								  ,'<input type="button" value="Agregar" class="button"/>'
								  ,'Huevos de campo (Ecotierra )'
								  ,'Huevos y lácteos'
								  ,'Huevos de campo de gallinas criadas libres alimentadas con grano, vegetales verdes y productos naturales)'
								  ,'Pablo Albarràn'
								  ,'30'
				                  )
				   ); 
	$jsonData['rows'][] = $entry;
	
	$entry = array('cell' => array(
		                           '<input type="text" class="spinner" size="1" maxlength="2" value="1"/>'
								  ,'<input type="button" value="Agregar" class="button"/>'
								  ,'Mermelada de moras ( huertos caseros)'
								  ,'Mermeladas y conservas'
								  ,'Mermelada de moras, orgánica de la RM'
								  ,'Huertos Caseros'
								  ,'450GRs'
				                  )
				   ); 
	$jsonData['rows'][] = $entry;
	
	echo json_encode($jsonData); 
?>

