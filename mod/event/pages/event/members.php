<?php
elgg_load_library('elgg:event');


$offset = (int) get_input('offset');
$eventid = (int) get_input('eventid');
$event = get_entity($eventid);
$event_metadata = get_events("guid=$eventid");
$owner_guid = $event->owner_guid;
$page_owner = get_entity($owner_guid);
elgg_set_page_owner_guid($owner_guid);	


if($eventid){
	
	elgg_push_breadcrumb($event->title,'event/view/'.$event->guid.'/'.elgg_get_friendly_title($event->title));
	elgg_push_breadcrumb(elgg_echo('event:members'));
	$content = event_get_members($event->guid, FALSE, FALSE, TRUE);
	
}else{
	$content = elgg_echo('event:nomember');
}

$sidebar = elgg_view('event/sidebar/sidebar', array('entity' => $event,'event_metadata'=>$event_metadata));

$title = sprintf(elgg_echo('event:member'), $event->title);
		$param = array(
			'filter_context' => 'all',
			'sidebar' => $sidebar,
			'content' => $content,
			'title' => $title,
		);
	/*	
if($event->canEdit()){
	$param['filter_override'] = elgg_view('event/filter_tab_edit',array('selected'=>'members','event' => $event));
}else{
	$param['filter'] = '';
}
 */
$body = elgg_view_layout('content', $param);
echo elgg_view_page($title, $body);
?>
