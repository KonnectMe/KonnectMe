<?php
$eventid = (int) get_input('eventid');
$event = get_entity($eventid);
elgg_set_page_owner_guid($event->owner_guid);

if(!$event){
	forward('event/all');
}

elgg_push_breadcrumb($event->title, "event/view/{$event->guid}/".elgg_get_friendly_title($event->title));

$content = elgg_view('event/make_payment_guest',array("event"=>$event));
$sidebar = elgg_view('event/sidebar/sidebar', array('entity' => $event));

$title = elgg_echo('event:purchase_details');
elgg_push_breadcrumb($title);

$body = elgg_view_layout('content', array(
	'filter' => false,
	'filter_context' => 'all',
	'sidebar' => $sidebar,
	'content' => $content,
	'title' => $title,
	
));
echo elgg_view_page($title, $body);	

