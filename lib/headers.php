<?php
/**
 * @since v.1.0
 * get_nocache_headers()
 * Mengatasi cache pada header yang dikirm kepada client browser melalui ajax
 * Fungsi ini digunakan untuk nocache_headers()
 * @return $headers
 */ 
function get_nocache_headers(){
	$headers = array(
		'Expires' => 'Wed, 11 Jan 1984 05:00:00 GMT',
		'Cache-Control' => 'no-cache, must-revalidate, max-age=0',
		'Pragma' => 'no-cache',
	);

	$headers['Last-Modified'] = false;
	return $headers;
}


/**
 * @since v.1.0
 * nocache_headers()
 * Mengatasi cache pada header yang dikirm kepada client browser melalui ajax
 * @return headers()
 */ 
function nocache_headers(){
	$headers = get_nocache_headers();

	unset($headers['Last-Modified']);

	if (function_exists('header_remove')){
		@header_remove('Last-Modified');
	}
	else {
		foreach (headers_list() as $header){
			if (0 === stripos($header, 'Last-Modified' )){
				$headers['Last-Modified'] = '';
				break;
			}
		}
	}

	foreach( $headers as $name => $field_value )
		@header("{$name}: {$field_value}");
}

function autologin_header(){
	/* Cache Control dibuat private (untuk FIX IE 6) */
	header('Cache-Control: private');

    /* Selalu di modif/ada perubahan */
    header('Last-Modified: '.gmdate("D, d M Y H:i:s").' GMT');
    /* HTTP/1.1 */
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0',false);
    /* HTTP/1.0 */
    header('Pragma: no-cache');

    $coockie_name = 'apiuserlog';
    $coockie_time = (3600 * 24 * 30); /* berlaku 30 hari */  
}
?>