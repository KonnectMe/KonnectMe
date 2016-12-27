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
if (!isset($vars['entity']->api_key)) {
	$vars['entity']->api_key = 'demo';
}
echo '<div>';
echo elgg_echo('galliTextCaptcha:captchaapi');
echo ' ';
echo elgg_view('input/text', array('name' => 'params[api_key]','value' => $vars['entity']->api_key,));
echo '</div>';