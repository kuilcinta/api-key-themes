<?php

/**
 * @author ofanebob
 * @copyright 2014
 */
$timezone_q = 'Asia/Jakarta';
date_default_timezone_set( $timezone_q );

//
session_start();

$apiuserlog_session = isset($_SESSION['apiuserlog']) ? $_SESSION['apiuserlog'] : false;

$ofan_session = isset($_SESSION['ofansession']) ? $_SESSION['ofansession'] : false;

$io_mode = false;
$is_develop = $io_mode == true ? 'min' : '';

/**
 * Edit parameter database
 * Sesuaikan dengan nama host, username, password dan nama SQL
 */
define('DB_HOST', 'localhost');
define('DB_NAME', 'api_ofan');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('BASEDIR', dirname(__FILE__));
define('LIB_PATH', BASEDIR.'/lib');
define('IS_DEV', $is_develop);

require_once(BASEDIR.'/lib.php');
?>