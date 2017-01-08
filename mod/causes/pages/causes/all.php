<?php
elgg_register_title_button();

$category = get_input('category');
$user = elgg_get_logged_in_user_entity();
$content = elgg_view('causes/all',array('user' => $user));


if($category){
	$title = elgg_echo(elgg_echo('causes:searchby'), array(causes_category_title($category)));
}else{
	$title = elgg_echo('causes:causes');
}

$sidebar = elgg_view('causes/sidebar/category');


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