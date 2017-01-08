<?php
elgg_load_library('elgg:event');
$user = elgg_get_page_owner_entity();
$title = elgg_echo('event:invitations');
elgg_push_breadcrumb($title);
$groupguid = (int) get_input('groupguid');
if($groupguid){
	$invitations = event_get_invited_events($groupguid);
	$content = elgg_view('event/invitation', array('invitations' => $invitations));

}else{
	$content = elgg_echo('event:noinvite');
}

	$params = array(
	'content' => $content,
	'title' => $title,
	'filter' => '',	);

$body = elgg_view_layout('content', $params);
echo elgg_view_page($title, $body);

	

