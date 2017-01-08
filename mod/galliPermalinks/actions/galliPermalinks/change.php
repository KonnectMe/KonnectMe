<?php

$guid = (int) get_input('guid');
$title = get_input('title');

if(!$guid or !$title){
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$existing = permalink_get_entity_from_title($title);
if($existing){
	register_error(elgg_echo('gp:existingentity'));
	forward(REFERER);
}

$pagehandlers = permalink_check_pagehandlers($title);
if($pagehandlers){
	register_error(elgg_echo('gp:existingentity'));
	forward(REFERER);
}

$entity = get_entity($guid);
if($entity){
	if(permalink_generate_title($entity, $title)){
		system_message(elgg_echo('gp:save:success'));
		$forward = elgg_get_site_url()."admin/administer_utilities/permalinks/?guid=$guid";
		forward($forward);		
	}
}

register_error(elgg_echo('error:default'));
forward(REFERER);