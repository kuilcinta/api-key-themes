<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

/**
 * Load lib php function
 *
 * @since v1.0
 * @author Ofan Ebob
 * @copyright 2014 Ofan Ebob Studio Web & Design
 */

$libs = array(	'error',
				'db',
				'crud',
				'status',
				'headers',
				'curl',
				'options',
				'setting',
				'module',
				'email',
				'user',
				'key',
				'tojson'
			);

// Looping file lib
foreach($libs as $lib){
	$lib_data = LIB_PATH.'/'.$lib.'.php';
	if(file_exists($lib_data)) require_once($lib_data);
}

?>