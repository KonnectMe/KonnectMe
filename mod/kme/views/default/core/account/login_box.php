<?php
/**
 * Elgg login box
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['module'] The module name. Default: aside
 */

$module = elgg_extract('module', $vars, 'aside');

$login_url = elgg_get_site_url();
if (elgg_get_config('https_login')) {
	$login_url = str_replace("http:", "https:", $login_url);
}

$title = elgg_echo('login');

if (elgg_get_config('allow_registration')) {
	$body = elgg_view('account/reg_form_wrapper');
	echo elgg_view_module($module, 'New to KonnectMe? Register here', $body, array('class'=>'kmeloginbox fright'));
}

$body = elgg_view_form('login', array('action' => "{$login_url}action/login"));
echo elgg_view_module($module, 'Returning KonnectMe user? Login here', $body, array('class'=>'kmeloginbox fleft'));

if(elgg_is_active_plugin('social_connect')){
	$body = elgg_view('social_connect/connect');
	echo elgg_view_module($module, 'We recommend using one click Social login!', $body, array('class'=>'kmeloginbox fleft'));
}
