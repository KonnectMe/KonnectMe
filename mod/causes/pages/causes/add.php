<?php
$user_guid = (int) get_input('guid');
$user = get_entity($user_guid);
if($user_guid){
	$content = elgg_view_form('causes/add', array("enctype" => "multipart/form-data"));
}else{
	$content = elgg_echo('cause:nouser');
}

$title = elgg_echo('causes:new');

$body = elgg_view_layout('content', array(
	'filter_override' => elgg_view('causes/filter_tab',array('selected'=>'add','user' => $user)),
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);