<?php
elgg_load_library('elgg:event');

$title = elgg_echo('event:report');
elgg_push_breadcrumb($title);
$groupguid = (int) get_input('groupguid');
if($groupguid){
	$sponsers = event_get_sponsers($groupguid);
	$content = elgg_view('event/report', array('sponsers' => $sponsers));
}else{
	$content = elgg_echo('event:noevent');
}
$params = array(
	'content' => $content,
	'title' => $title,
	'filter' => '',	);

$body = elgg_view_layout('content', $params);
echo elgg_view_page($title, $body);