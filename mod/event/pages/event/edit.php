<?php
$eventid = (int) get_input('eventid');
$table = elgg_get_config('dbprefix')."event";
$event = get_entity($eventid);
$event_metadata = get_events("guid=$eventid");
if (!$event) {
	register_error(elgg_echo('event:unknown_event'));
	forward(REFERRER);
}
elgg_set_page_owner_guid($event[0]->owner_guid);
if($eventid){
	event_sidebar_navigation($event);
	elgg_push_breadcrumb($event->title,'event/view/'.$event->guid.'/'.elgg_get_friendly_title($event->title));
	$content = elgg_view_form('event/edit', array("enctype" => "multipart/form-data"),array('event'=>$event, 'event_metadata'=>$event_metadata));
}else{
	$content = elgg_echo('event:noevent');
}

$title = elgg_echo('event:edit');
elgg_push_breadcrumb($title);
$sidebar = elgg_view('event/sidebar/sidebar', array('entity' => $event,'event_metadata'=>$event_metadata));

$body = elgg_view_layout('content', array(
	'filter_override' => elgg_view('event/filter_tab_edit',array('selected'=>'edit','event' => $event)),
	'filter_context' => 'all',
	'sidebar' => $sidebar,
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
