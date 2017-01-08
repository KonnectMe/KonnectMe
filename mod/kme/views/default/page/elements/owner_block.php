<?php
/**
 * Elgg owner block
 * Displays page ownership information
 *
 * @package Elgg
 * @subpackage Core
 *
 */
//$context = elgg_get_context(); 
//$no = array('widgets', 'causes');
//if(!elgg_is_logged_in() && !in_array($context, $no)){
//	echo elgg_view_module('aside', '<h3>' . elgg_echo('Login') . '</h3>', elgg_view_form('login_sidebar', array('action' => 'action/login')));
//}	
elgg_push_context('owner_block');

// groups and other users get owner block
$owner = elgg_get_page_owner_entity();

if ($owner instanceof ElggGroup || ($owner instanceof ElggUser)) {
	
	$body = elgg_view_entity($owner, array('full_view' => false));
	
	if ($owner instanceof ElggGroup){
		$body .= elgg_view_menu('owner_block', array('entity' => $owner, 'class'=> 'owner-menu'));
	}
	
	$body .= elgg_view('page/elements/owner_block/extend', $vars);
	
	//echo elgg_view_module('aside', '<h3>' . elgg_echo('kme:ownerblock') . '</h3>', $body);
} 

elgg_pop_context();