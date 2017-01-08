<?php
set_input('viewtype',1);
elgg_register_title_button();
$user = elgg_get_logged_in_user_entity();


if($user){
	$content = elgg_view('causes/mine',array('user' => $user));
}else{
	$content = elgg_echo('causes:nocauses');
}



$title = elgg_echo('causes:causes');
$sidebar = elgg_view('causes/sidebar/find');

$body = elgg_view_layout('content', array(
	'filter_override' => false,
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
	'wrap' => false,
));

echo elgg_view_page($title, $body);