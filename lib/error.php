<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

/**
 * @since v.1.0
 * ajaxError()
 * Menangani Error respon dengan metode manual dari permintaan client
 * @return $return
 */ 
function ajaxError($fn,$code=false,$timeout=0,$color='danger',$tojson=false,$print=false){

	/* Condition $timeout untuk inject class "clear_timeout"
	 * jika respon harus berupa manipulasi DOM jQuery.appendTo()
	 */
	if($timeout==1){
		$clear_timeout = 'clear_timeout';
	}
	else{
		$clear_timeout = '';
	}

	/* Condition $fn untuk memberikan class khusus sesuai nama fungsi yang digunakan
	 * Tujuan nya untuk membedakan beberapa manipulasi DOM lainnya
	 */
	if($fn!=''){
		$fn = 'alert_'.$fn;
	}
	
	/* PENTING!
	 * Condition nilai variable $code
	 * Jika angka & bukan boolean maka data respon dibuat format JSON
	 */
	if(is_numeric($code) && !is_bool($code)){
		$data = '<div class="'.$fn.' alert alert-'.$color.' '.$clear_timeout.'">'.statusCode($code).'</div>';
		if($tojson==true){
			$return = json_encode(array('status'=>$code,'data'=>$data));
		}
		else{
			$return = $data;
		}
	}
	else{
		/* Jika berisi boolean respon dibuat format text/html */
		//$code = is_string($code) ? 'ya' : 'tidak';
		$return = '<div class="'.$fn.' alert alert-'.$color.' '.$clear_timeout.'">'.$code.'d</div>';
    }

    /* PENTING!
     * Pengaturan ifelse condition berisi nila boolean
     * Untuk menyatakan bahwa output harus di echo (untuk hasil langsung)
     * atau output return untuk digunakan di fungsi lain
     */
    if($print==false){
    	return $return;
    }
    else{
    	echo $return;
    }
}


/**
 * @since v.1.0
 * Fungsi customError
 * Mengatasi ERROR dengan fungsi custom
 */
set_error_handler("customError",E_ALL);
function customError($str){
	echo $str;
	die();
}
error_reporting(E_ALL);

/**
 * @since v.1.0
 * Fungsi redirError
 * Mengatasi ERROR dengan mengalihkan halaman sesuai kode "redirect"
 */
function redirError($args=false){
	$msg = isset($args['msg']) ? urlencode($args['msg']) : (is_numeric($args) ? $args : 0);
	$uri = isset($args['uri']) ? $args['uri'] : site_url();
	$url = preg_match('/\?/', $uri) ? "&page=error&msg=$msg" : "?page=error&msg=$msg";
	header("Location:$uri$url");
	//header("refresh: 5; $uri$url");
}

/**
 * @since v.1.0
 * Fungsi redir
 * Mengalihkan halaman secara umum dengan penambahan parameter URL dynamic
 */
function redir($url=null){
	$url = $url == null ? site_url() : $url;
	header("Location:$url");
}
?>