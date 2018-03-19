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
								  ,'13.254.658-4'
								  ,'Daniela Fernandez Bustamante'
								  ,'10'
								  ,'100'
								  ,'1000'
				                  )
				   ); 
	$jsonData['rows'][] = $entry;
	
	$entry = array('cell' => array(
								  '26/09/2013'
								  ,'15.254.657-8'
								  ,'Valentina Javiera'
								  ,'10'
								  ,'200'
								  ,'2000'
				                  )
				   ); 
	$jsonData['rows'][] = $entry;
	
	$entry = array('cell' => array(
								  '26/09/2013'
								  ,'12.657.268-8'
								  ,'Gustavo Alonso'
								  ,'10'
								  ,'300'
								  ,'3000'
				                  )
				   ); 
	$jsonData['rows'][] = $entry;
	
	
	echo json_encode($jsonData); 
?>