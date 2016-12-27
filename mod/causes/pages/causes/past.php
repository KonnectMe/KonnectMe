<?php
elgg_register_title_button();
$category = get_input('category');
$user = elgg_get_logged_in_user_entity();
$content = elgg_view('causes/all', array('user' => $user, 'operand' => '<'));

if($category){
	$title = elgg_echo('event:searchby', array(ucfirst($category)));
}else{
	$title = elgg_echo('causes:causes');
}

$sidebar = elgg_view('causes/sidebar/category');
$body = elgg_view_layout('content', array(
	'filter_override' => false,
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
	'wrap' => false,
));

echo elgg_view_page($title, $body);