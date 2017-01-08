<?php
	$guid = (int) get_input('eventid');
	if (!$guid) {
		forward('event/all');
	}

	// turn this into a core function
	global $autofeed;
	$autofeed = true;

	$event = get_entity($guid);
	$event_metadata = get_events("guid=$guid");
	if (!$event) {
		forward('event/all');
	}
	if(!isset($_COOKIE["forward_to_sevathon"]) && $guid == 926979){
		setcookie('forward_to_sevathon',true, 0, '/');
	}
	
	elgg_set_page_owner_guid($event->owner_guid);	

	elgg_push_breadcrumb($event->title);
	event_sidebar_navigation($event);
	$option['entity'] = $event;
	$option['event_metadata'] = $event_metadata;
	$content =  elgg_view('event/profile/layout', $option);
	$sidebar = elgg_view('event/sidebar/sidebar', $option);
		
	$params = array(
		'content' => $content,
		'sidebar' => $sidebar,
		'title' => $event->title,
		'filter' => '',
		'wrap' => false,
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($event->title, $body);

?>
