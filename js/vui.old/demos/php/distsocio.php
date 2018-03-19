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
								  '26/09/2013'
								  ,'Aceituna ( Canasta Viva)'
								  ,'Frutas y verduras'
								  ,'Aceituna orgànica con certificaciòn participativa 5 regiòn'
								  ,'Canasta Viva'
								  ,'10'
								  ,'100'
								  ,'1000'
				                  )
				   ); 
	$jsonData['rows'][] = $entry;
	
	$entry = array('cell' => array(
								  '26/09/2013'
								  ,'Acelga (Tierra Viva)'
								  ,'Frutas y verduras'
								  ,'Acelga con certificaciòn Orgánica R M'
								  ,'Tierra Viva'
								  ,'10'
								  ,'200'
								  ,'2000'
				                  )
				   ); 
	$jsonData['rows'][] = $entry;
	
	$entry = array('cell' => array(
								  '26/09/2013'
								  ,'Huevos de campo (Ecotierra )'
								  ,'Huevos y lácteos'
								  ,'Huevos de campo de gallinas criadas libres alimentadas con grano, vegetales verdes y productos naturales)'
								  ,'Pablo Albarràn'
								  ,'10'
								  ,'300'
								  ,'3000'
				                  )
				   ); 
	$jsonData['rows'][] = $entry;
	
	$entry = array('cell' => array(
								  '26/09/2013'
								  ,'Mermelada de moras ( huertos caseros)'
								  ,'Mermeladas y conservas'
								  ,'Mermelada de moras, orgánica de la RM'
								  ,'Huertos Caseros'
								  ,'10'
								  ,'400'
								  ,'4000'
				                  )
				   ); 
	$jsonData['rows'][] = $entry;
	
	echo json_encode($jsonData); 
?>