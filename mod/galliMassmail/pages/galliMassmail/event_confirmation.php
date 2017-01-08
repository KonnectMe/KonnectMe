<?php
/**
 * Add bookmark page
 *
 * @package Bookmarks
 */
elgg_load_library('elgg:event');
$event_guid = (int) get_input('event_guid');
if(!$event_guid){
	forward();
}

$event = get_entity($event_guid);
if (!$event->canEdit()) {
	register_error('Sorry, you are not authorized for this');
	forward();
}

$page_owner_guid = $event->owner_guid;
elgg_set_page_owner_guid($page_owner_guid);

event_sidebar_navigation($event);
set_input('eventid', $event->guid);

$title = elgg_echo('gallimassmail:mailall');
elgg_push_breadcrumb($event->title, $event->getURL());
elgg_push_breadcrumb($title);

set_input('gmm_container_guid', $event_guid); 
// $content = elgg_view('galliMassmail/galliMassmail');

$content = elgg_view_module('inline',elgg_echo('galliMassmail:compose'), elgg_view_form('galliMassmail/event_confirmation')); 

$sidebar = elgg_view('event/sidebar/sidebar', array('entity' => $event));

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'sidebar' => $sidebar,
	'title' => $title,
));

echo elgg_view_page($title, $body);