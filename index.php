<?php
//session_start();

require_once(dirname(__FILE__).'/config.php');

//echo $_SESSION['apiuserlog'];

if(isset($_GET['page']) AND $_GET['page']=='error'){
	get_header(false,true);
	get_template_php('includes/template','error');
	get_footer();
}
else{
	/* Set Global parameter URL */
	$idapi = isset($_GET['ids']) ? $_GET['ids'] : 0;
	$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

	/* Handle JSON formatting wit boolean condition */
	$formatting_json_request = formatting_json_request(array('id'=>$idapi,'lang'=>$lang));
	$json_code_respon = $formatting_json_request['status'];
	$translate_response_code = ucwords(statusCode($json_code_respon,'en'));

	/* Start define header() type for JSON files return */
	if($json_code_respon==200){
		header('Content-Type: application/json');

		if(isset($_GET['download'])){
			$langs = isset($_GET['lang']) ? '_'.$_GET['lang'] : '';
			header("Content-Disposition: attachment; filename=\"auth_key_$idapi$langs.json\"");
		}

		nocache_headers();

		echo json_encode($formatting_json_request);
	}
	else{
		header("HTTP/1.0 $json_code_respon $translate_response_code");
		echo $translate_response_code;
	}
}
?>