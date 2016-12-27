<?php
set_input('viewtype',1);
if(elgg_is_admin_logged_in()){
	elgg_register_title_button();
}
$user = elgg_get_logged_in_user_entity();

if($user){
	$content = elgg_view('event/myticket',array('user' => $user));
}else{
	$content = elgg_echo('event:noevent');
}

$title = elgg_echo('event:event');
elgg_push_breadcrumb($title);
$body = elgg_view_layout('content', array(
	'filter_override' => false,
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'wrap' => false,	
));

echo elgg_view_page($title, $body);