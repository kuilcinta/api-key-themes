<?php
require_once(dirname(__FILE__).'/../config.php');

$dataslide = slide_home();

$data = array('tbl'=>'test',
			  'prm'=>array(	'name_test'=>'serialize',
			  				'desc_test'=>serialize($dataslide),
			  				'date_test'=>date('Y-m-d H:i:s'),
			  				'status_test'=>'Y'
						  )
			  );

$sql = 1;//Access_CRUD($data,'create');

if($sql){
	header("Content-Type: application/json");
	
	//print_r($dataslide);
	//echo '<br /><br />';
	echo json_encode($dataslide);
}
else{
	echo 'Not Save';
}
?>