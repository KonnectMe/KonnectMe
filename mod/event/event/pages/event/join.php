<?php
$user = elgg_get_logged_in_user_entity();
$eventid = (int) get_input('eventid');
$event = get_entity($eventid);
$event_metadata = get_events("guid=$eventid");
elgg_set_page_owner_guid($event->owner_guid);

if(!$event || event_closed($event_metadata[0])){
	forward('event/all');
}

elgg_push_breadcrumb($event->title, "event/view/{$event->guid}/".elgg_get_friendly_title($event->title));

if($user){
	$content = elgg_view('event/join',array("event"=>$event, 'event_metadata'=>$event_metadata));
}else{
	$content = elgg_view('guest/join',array("event"=>$event, 'event_metadata'=>$event_metadata));
}

$sidebar = elgg_view('event/sidebar/sidebar', array('entity' => $event, 'event_metadata'=>$event_metadata));
$title = elgg_echo('event:join');

$body = elgg_view_layout('content', array(
	'filter' => false,
	'filter_context' => 'all',
	'sidebar' => $sidebar,
	'content' => $content,
	'title' => $title,
	
));
echo elgg_view_page($title, $body);	

