<?php
$user_guid = (int) get_input('guid');

if($user_guid){
	$user= get_entity($user_guid);
	$content = elgg_view_form('event/add', array("enctype" => "multipart/form-data"));

}else{
	$content = elgg_echo('event:nouser');
}

$title = elgg_echo('event:new');
elgg_push_breadcrumb($title);
$body = elgg_view_layout('content', array(
	'filter_override' => elgg_view('event/filter_tab',array('selected'=>'add','user' => $user)),
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('event/sidebar/category'),
));

echo elgg_view_page($title, $body);