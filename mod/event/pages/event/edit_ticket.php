<?php
$eventid = (int) get_input('eventid');
$guid = (int) get_input('guid');

$event = get_entity($eventid);
if (!elgg_instanceof($event, 'object', 'event') || !$event->canEdit()) {
	register_error(elgg_echo('event:unknown_event'));
	forward(REFERRER);
}

if($eventid && $guid){
	$title = elgg_get_friendly_title($event->title);
	elgg_push_breadcrumb($event->title, "event/view/{$eventid}/{$title}");
	elgg_push_breadcrumb(elgg_echo('event:editticket'));
	$content = elgg_view_form('event/edit_ticket', array('event' => $event));
}else{
	$content = elgg_echo('event:noevent');
}

$title = elgg_echo('event:editticket');
elgg_push_breadcrumb($title);
$body = elgg_view_layout('content', array(
	'filter_override' => elgg_view('event/filter_tab_edit',array('selected'=>'ticket','event' => $event)),
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
));


echo elgg_view_page($title, $body);