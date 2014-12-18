<?php
/**
 * File config.php
 * Is setting up define, session, timezone & load lib.php
 *
 * @author ofanebob
 * @copyright 2014
 */

/**
 * Time Zone setting
 * @since v1.0
 */
$timezone_q = 'Asia/Jakarta';
date_default_timezone_set( $timezone_q );

/**
 * Start Session Definition Variable
 * @since v1.0
 */
session_name('EBOBSESSID');
session_start();

$apiuserlog_session = isset($_SESSION['apiuserlog']) ? $_SESSION['apiuserlog'] : null;

$ofan_session = isset($_SESSION['ofansession']) ? $_SESSION['ofansession'] : null;

/**
 * Edit parameter database
 * Sesuaikan dengan nama host, username, password dan nama SQL
 */
define('DB_HOST', 'localhost');
define('DB_NAME', 'api_ofan');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('BASEDIR', dirname(__FILE__));
define('BASENAME', basename($_SERVER['REQUEST_URI']));
define('DIRNAME', dirname($_SERVER['REQUEST_URI']));
define('INCPATH', BASEDIR.'/inc');
define('LIB_PATH', BASEDIR.'/lib');

require_once(BASEDIR.'/lib.php');

$is_develop = developing_mode() == 0 ? '.min' : '';
define('IS_DEV', $is_develop);

get_logout_process();
?>