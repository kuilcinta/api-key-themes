<?php
require_once(dirname(__FILE__).'/../config.php');

$prm = array('user_status'=>'Y');
$data = array(  'tbl'=>'users',
                'prm'=>$prm,
                'con'=>"WHERE user_id=20"
            );

$sql = Access_CRUD($data,'update');

if($sql){
	echo 'Sukses';
}
else{
	echo 'Gagal';
}
?>