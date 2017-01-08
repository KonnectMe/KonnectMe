<?php
/**
 * Causes Donate
 *
 * @package Causes
 */
$cause = $vars['cause'];
//$body = elgg_view_form('causes/donate', array('entity' => $cause));
$url = "payments/make_donation";
$body = elgg_view_form('causes/donate', array('entity' => $cause,'action'=>$url));
echo causes_view_module('aside', elgg_echo('causes:donate:togroup', array($cause->title)), $body);