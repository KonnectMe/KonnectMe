<?php
if(elgg_is_admin_logged_in()){
	elgg_register_title_button();
}
set_input('viewtype',1);
$category = get_input('category');
$user = elgg_get_logged_in_user_entity();
$title = elgg_echo('event:event');
$offset = (int) get_input('offset');

$table = elgg_get_config('dbprefix')."event"; 
$now = time();
$were = " end_date < '$now' ";
if($category){
	$were .= "and category = '$category' ";
	$title = elgg_echo('event:searchby', array(ucfirst($category)));
}

$events = get_events($were);
$guids = array();
$event_array = array();
foreach($events as $event){
	$guids[] = $event->guid;
	$event_array[$event->guid] = $event;
}

$option['guids'] = $guids;
$option['limit'] = 9;
$option['full_view'] = false;
$option['list_type'] = 'gallery';
$option['event_metadata'] = $event_array;

if($guids){
	$content = elgg_list_entities($option);
}else{
	$content = elgg_echo('event:noevent');
}

$sidebar = elgg_view('event/sidebar/category');

$body = elgg_view_layout('content', array(
	'filter_override' => false,
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
	'wrap' => false,
));

echo elgg_view_page($title, $body);