<?php
/**
 *	galliMassmail
 *	Author : Raez Mon | Team Webgalli
 *	Team Webgalli | Elgg developers and consultants
 *	Mail : info@webgalli.com
 *	Web	: http://webgalli.com
 *	Skype : 'team.webgalli'
 *	@package galliMassmail plugin
 *	Licence : GPLv2
 *	Copyright : Team Webgalli 2011-2015
 */
 
$gmm_container_guid = (int) get_input('gmm_container_guid');

echo elgg_view_module('inline',elgg_echo('galliMassmail:compose'), elgg_view_form('galliMassmail/compose')); 

if(elgg_get_context() == 'admin'){
	if(elgg_get_plugin_setting('enable_massmail', 'galliMassmail') != 'yes'){
		register_error(elgg_echo('gallimassmail:massmailwarning'));
	}
	$list = elgg_list_entities(array('types' => 'object', 'subtypes' => 'galliMassmail', 'full_view' => false));
} else {
	$list = elgg_list_entities(array('types' => 'object', 'subtypes' => 'galliMassmail', 'full_view' => false, 'container_guid' => $gmm_container_guid));
}

if (!$list) {
	$list = '<p class="mtm">' . elgg_echo('gallimassmail:none') . '</p>';
}

echo elgg_view_module('inline',elgg_echo('galliMassmail:archive'), $list); 