<?php
/**
 * Causes Donate
 *
 * @package Causes
 */
$cause = $vars['cause'];
if(!$cause){
	return;
}
set_input('causesid', $cause->guid);	
$url = "payments/make_donation";
$body = elgg_view_form('causes/donate', array('entity' => $vars['entity'],'action' => $url));
echo causes_view_module('aside', $cause->title, $body);