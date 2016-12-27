<?php
/**
 * Causes Donate
 *
 * @package Causes
 */
$date = $vars['entity']->enddate;
$end_ts = strtotime($date);
$url = "payments/make_donation";
if($end_ts < time()){
	$content = '<div class="cause_sup_np_info center">'.elgg_echo('cause:expired').'</div>';
	echo elgg_view_module('aside', $vars['entity']->title, $content);
} else {
	$body = elgg_view_form('causes/donate', array('entity' => $vars['entity'],'action'=>$url));
	echo elgg_view_module('aside', $vars['entity']->title, $body);
}