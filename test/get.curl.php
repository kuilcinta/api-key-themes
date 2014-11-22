<?php

require_once(dirname(__FILE__).'/../config.php');

//$data = array('url'=>'http://cdg.com', 'type'=>'domain');

$args = array('encod'=>'utf-8','refer'=>site_url(),'auth'=>'ofanebob:780170');
$data = array('url'=>'http://192.168.1.5/api.ofanebob.com/en/3281416413386.json', 'type'=>'data', 'args'=>$args);

$cURLs = new cURLs($data);

$result = $cURLs->access_curl();

if($result==null || $result==false){
	echo 'No data';
}
else{
	//is_string($result) ? header('Content-Type: application/json') : '';
	echo $result = is_string($result) ? $result : ($result == true ? $data['url'].' is Yes' : $data['type'].' is no');
}

?>