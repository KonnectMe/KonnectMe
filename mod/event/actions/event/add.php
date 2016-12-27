<?php
/**
* Elgg event  Create new Event action
* @package Event
*/
gatekeeper();
$table = elgg_get_config('dbprefix')."event";
$free = (int) get_input('free');
$event_array['isfree'] = $free;
$skip = 0;
if(get_input('skip_registration')){
	$skip = 1;
}
$event_array['skip'] = $skip;

$event_array['paypal'] = get_input('paypal');
$event_array['category'] = get_input('category');
$event_array['title'] = strip_tags(get_input('title'));
$event_array['description'] = get_input('description');
$event_array['brief_description'] = get_input('brief');
$event_array['start_date'] = strtotime(get_input('dfrom'));
$event_array['end_date'] = strtotime(get_input('dto'));
$event_array['time'] = get_input('time');
$event_array['access_id'] = get_input('access_id');
$event_array['venue'] = get_input('venue');
$event_array['location'] = get_input('location');
$event_array['related_event_guid'] = (int)get_input('pastevent');
$fundraising = 0;
if(get_input('createcause')){
	$fundraising = 1;
}
$event_array['fundraising'] = (int)$fundraising;
$event_array['tags'] = get_input('tags');
$tags = get_input('tags');
$guid = get_input('guid');
$createcause = get_input('createcause');
$eventclosed = get_input('eventclosed');
elgg_make_sticky_form('event');

if (!$event_array['title']) {
	register_error(elgg_echo('event:save:failed:titlemissing'));
	forward(REFERER);
}

if (!$event_array['isfree']) {
	if(!$event_array['paypal'] or !is_email_address($event_array['paypal'])){
		register_error(elgg_echo('event:save:failed:paypalmissing'));
		forward(REFERER);
	}	
}

if ($guid == 0) {
	$event = new ElggObject;
	$event->subtype = "event";
	$event->container_guid = (int)get_input('container_guid', $_SESSION['user']->getGUID());
	$new = true;
	$event_array['time_created'] = time();
	$event_array['owner_guid'] = $_SESSION['user']->getGUID();
} else {
	$event = get_entity($guid);
	if (!$event->canEdit()) {
		system_message(elgg_echo('event:save:failed:noaccess'));
		forward(REFERRER);
	}
	$eventclosed = 0;
	if(get_input('eventclosed')){
		$eventclosed = 1;
	}
	$event_array['blocked'] = (int)$eventclosed;
}


$tagarray = string_to_tag_array($tags);

$event->title = $event_array['title'];
$event->description = $event_array['description'];
$event->access_id = 2;
$event->time = get_input('time');

;

$event_guid = $event->save();
if ($event_guid) {
	if($event_array['related_event_guid']){
		if(!check_entity_relationship($event_guid, 'past_event', $event_array['related_event_guid'])){
			// this may be related with another past_event
			remove_entity_relationships($event_guid, 'past_event');
			add_entity_relationship($event_guid, 'past_event', $event_array['related_event_guid']);
		}
	}
	if ((isset($_FILES['icon'])) && (substr_count($_FILES['icon']['type'],'image/'))) {
		$prefix = "event/".$event_guid;
		$filehandler = new ElggFile();
		
		$filehandler->owner_guid = $event->owner_guid;
		$filehandler->setFilename($prefix . ".jpg");
		$filehandler->open("write");
		$filehandler->write(get_uploaded_file('icon'));
		$filehandler->close();
		$thumb_big = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),180,150, false);
		$tiny = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), 40, 40, true);
		if ($thumb_big) {
			$thumb = new ElggFile();
			$thumb->owner_guid = $event->owner_guid;
			$thumb->setMimeType('image/jpeg');
			
			$thumb->setFilename($prefix."medium.jpg");
			$thumb->open("write");
			$thumb->write($thumb_big);
			$thumb->close();
		
			$thumb->setFilename($prefix."tiny.jpg");
			$thumb->open("write");
			$thumb->write($tiny);
			$thumb->close();
			//$event->icontime = time();
			$event_array['icon_time'] = time();
		}
	}
	
	$event_array['guid'] = $event_guid;
	$event_id = saveArray($table,$event_array,$guid);
	elgg_clear_sticky_form('event');
	system_message(elgg_echo('event:save:success'));
	if ($new) {
		add_to_river('river/object/event/create','create', elgg_get_logged_in_user_guid(), $event_guid);
	}
	if(!$free){
		forward("event/ticket/".$event_guid);
	}else{
		forward("event/registration/".$event_guid);
	}
	
} else {
	register_error(elgg_echo('event:save:failed'));
	forward("event");
}