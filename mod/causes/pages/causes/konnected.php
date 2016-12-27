<?php
elgg_register_title_button();
set_input('viewtype',1);
$user = elgg_get_logged_in_user_entity();
$title = elgg_echo('causes:konnected');
$sidebar = elgg_view('causes/sidebar/category');

$content = elgg_list_entities_from_relationship(array(
			'relationship' => 'causes_konnector',
			'relationship_guid' => $user->guid,
			'inverse_relationship' => true,
			'limit' => 9,
			'list_type' => 'gallery',
		));
		
if(!$content){
	$all_causes_url = elgg_get_site_url()."causes/all/"; 
	$content = elgg_echo('causes:notkonnectd', array($all_causes_url));
}		

elgg_push_breadcrumb($title);
		
$param =  array(
	'filter_override' => false,
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
	'wrap' => false,
);

$body = elgg_view_layout('content', $param);
echo elgg_view_page($title, $body);