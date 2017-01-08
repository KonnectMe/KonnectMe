<?php
elgg_load_library('elgg:event');
$eventid = (int) get_input('eventid');
$event_metadata = get_events("guid=$eventid");
$event = get_entity($eventid);
elgg_set_page_owner_guid($event->owner_guid);

if(!$event){
	forward('event/all');
}
event_sidebar_navigation($event);
elgg_push_breadcrumb($event->title, "event/view/{$event->guid}/".elgg_get_friendly_title($event->title));
$title = elgg_echo('event:reports');
elgg_push_breadcrumb($title);
$content = elgg_view('event/reports', array('eventid' => $eventid));
$sidebar = elgg_view('event/sidebar/sidebar', array('entity' => $event,'event_metadata'=>$event_metadata));
$params = array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
	'sidebar' => $sidebar,
	);

$body = elgg_view_layout('content', $params);
echo elgg_view_page($title, $body);