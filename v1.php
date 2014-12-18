<?php
/**
 * v1.php Files
 * Handle direct request API Data with auth or session log users
 * This is port to call method ToJson class (lib/tojson.php)
 *
 * @since v1.0
 * @author Ofan Ebob
 * @copyright 2014
 *
 */

/* including config files for OOP method */
require_once(dirname(__FILE__).'/config.php');

if(empty($_GET['ids'])){
	/* Blocking request if paramater ID empty */
	load_error_template(true,true,true);
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
		header("HTTP/1.0 200 Successfully");
		header("Content-Type: application/json; charset=UTF-8");

		/* Additional header type content "Download" if parameter URL have download value */
		if(isset($_GET['download'])){
			$langs = isset($_GET['lang']) ? '_'.$_GET['lang'] : '';
			header("Content-Disposition: attachment; filename=\"auth_key_$idapi$langs.json\"");
		}

		/* Clear cache browser every request API */
		nocache_headers();

		/* Output API if retriving successed */
		echo json_encode($formatting_json_request);
	}
	else{
		/* Handle request with header HTTP code information if API request failed */
		header("HTTP/1.0 $json_code_respon $translate_response_code");
		echo $translate_response_code;
	}
}
?>