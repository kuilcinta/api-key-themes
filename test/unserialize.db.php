<?php
require_once(dirname(__FILE__).'/../config.php');

$dataslide = slide_home();

$data = array('tbl'=>'*',
			  'from'=>'test',
			  'prm'=>"WHERE name_test='serialize'"
			  );

$sql = auto_fetch_db($data,'read');

if($sql){
	$s = unserialize($sql['desc_test']);
	echo $s['path'];

	echo '<ul>';
	foreach($s['data'] as $esdata){
		echo '<li>'.$esdata[0].' ('.$esdata[1].')</li>';
	}
	echo '</ul>';

	echo json_encode($s);
}
else{
	echo 'Not Save';
}
?>