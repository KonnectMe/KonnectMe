<?php
/**
 *	Elgg Text Captcha
 *	Author : Raez | Team Webgalli
 *	Team Webgalli | Elgg developers and consultants
 *	Mail : info@webgalli.com
 *	Web	: http://webgalli.com
 *	Skype : 'team.webgalli'
 *	@package galliTextCaptcha plugin
 *	Licence : GNU2
 *	Copyright : Team Webgalli 2011-2015
 */
elgg_register_event_handler('init', 'system', 'galliTextCaptcha_init');

function galliTextCaptcha_init() {
	// Register a function that provides some default override actions
	elgg_register_plugin_hook_handler('actionlist', 'captcha', 'galliTextCaptcha_actionlist_hook');
	// Register actions to intercept
	$actions = array();
	$actions = elgg_trigger_plugin_hook('actionlist', 'captcha', null, $actions);
	if (($actions) && (is_array($actions))){
		foreach ($actions as $action){
			elgg_register_plugin_hook_handler("action", $action, "galliTextCaptcha_verify_action_hook");
		}
	}	
}
/**
* Generate a captcha
*/
function galliTextCaptcha_generate_captcha() {
	$salt = get_site_secret();
	$api_key = elgg_get_plugin_setting('api_key', 'galliTextCaptcha');
	$captcha = array();
	// load captcha using web service
	$url = "http://api.textcaptcha.com/".$api_key;
	try {
		$xml = @new SimpleXMLElement($url,null,true);
	} catch (Exception $e) {
	// if there is a problem, use static fallback..
	$fallback = '<captcha>'.
				'<question>Is ice hot or cold?</question>'.
				'<answer>'.md5('cold').'</answer></captcha>';
		$xml = new SimpleXMLElement($fallback);
	}
	// display question as part of form
	$captcha['question'] = (string) $xml->question;
	$answers = array();
	foreach ($xml->answer as $hash){
		array_push($answers,md5($hash.$salt));
	}
	$captcha['answer'] = $answers;
	return $captcha;	
}
/**
* Listen to the action plugin hook and verify the captcha.
* @param unknown_type $hook
* @param unknown_type $entity_type
* @param unknown_type $returnvalue
* @param unknown_type $params
*/
function galliTextCaptcha_verify_action_hook($hook, $entity_type, $returnvalue, $params){
	$salt = get_site_secret();
	$captcha_token = get_input('captcha_tok');
	$user_ans = get_input('captcha_ans'); 
	$user_ans = strtolower(trim($user_ans));
	$user_ans = md5(md5($user_ans).$salt);
	if (in_array($user_ans,$captcha_token)) {
		return true;	
	} else {
		register_error(elgg_echo('galliTextCaptcha:captchafail'));
		forward(REFERER);	
		return false;
	}
}
/**
* This function returns an array of actions the captcha will expect a captcha for, other plugins may
* add their own to this list thereby extending the use.
*
* @param unknown_type $hook
* @param unknown_type $entity_type
* @param unknown_type $returnvalue
* @param unknown_type $params
*/
function galliTextCaptcha_actionlist_hook($hook, $entity_type, $returnvalue, $params)	{
	if (!is_array($returnvalue))
		$returnvalue = array();
		$returnvalue[] = 'register';
		$returnvalue[] = 'user/requestnewpassword';
		return $returnvalue;
}