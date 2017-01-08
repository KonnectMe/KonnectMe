<?php
$eventid = (int) get_input('eventid');
$event = get_entity($eventid);
$event_metadata = get_events("guid=$eventid");
elgg_set_page_owner_guid($event->owner_guid);

if(!$event){
	forward('event/all');
}
event_sidebar_navigation($event);
elgg_push_breadcrumb($event->title, "event/view/{$event->guid}/".elgg_get_friendly_title($event->title));
$content = elgg_view_form('event/edit_info',array("event"=>$event));
$sidebar = elgg_view('event/sidebar/sidebar', array('entity' => $event,'event_metadata'=>$event_metadata));

$title = elgg_echo('event:purchaseinfo');
elgg_push_breadcrumb($title);

$body = elgg_view_layout('content', array(
	'filter' => false,
	'filter_context' => 'all',
	'sidebar' => $sidebar,
	'content' => $content,
	'title' => $title,
	
));	
echo elgg_view_page($title, $body);	
