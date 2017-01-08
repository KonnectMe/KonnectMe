<?php
$page_owner = elgg_get_page_owner_entity();
if (!$page_owner) {
	forward('causes/all');
}

set_input('viewtype',1);
elgg_register_title_button();

$guid = (int) get_input('guid');
$offset = (int) get_input('offset');

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'causes',
	'container_guid' => $guid,
	'limit' => 10,
	'offset' => $offset,
	'full_view' => false,
	'list_type' => 'gallery',
	'list_type_toggle' => true,
	'view_toggle_type' => false
));

if(!$content){
	$content = elgg_echo('causes:nocauses');
}


$title = elgg_echo('causes:groupowner', array($page_owner->name));

elgg_push_breadcrumb($page_owner->name);

$sidebar = elgg_view('causes/sidebar/find');

$body = elgg_view_layout('content', array(
	'filter_override' => false,
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);