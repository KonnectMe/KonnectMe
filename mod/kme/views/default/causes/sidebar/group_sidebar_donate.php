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
$url = "payments/make_donation";
set_input('causesid', $cause->guid);
$body = elgg_view_form('causes/donate', array('entity' => $cause,'action'=>$url));
//$body = elgg_view_form('causes/donate', array('entity' => $cause));
echo causes_view_module('aside', $cause->title, $body);
