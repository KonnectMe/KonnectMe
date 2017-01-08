<?php
elgg_load_library('elgg:causes');

$offset = (int) get_input('offset');
$causesid = (int) get_input('causesid');
$causes = get_entity($causesid);

$owner_guid = $causes->owner_guid;
$page_owner = get_entity($owner_guid);
elgg_set_page_owner_guid($causes->owner_guid);	

if($causes){
	elgg_push_breadcrumb($causes->title,'causes/view/'.$causes->guid.'/'.elgg_get_friendly_title($causes->title));
	elgg_push_breadcrumb(elgg_echo('causes:donors'));
	
	
	$content =  causes_list_latest_donors($causes->guid, $offset, 20, true);


}else{
	$content = elgg_echo('causes:nodonors');
}

$title = sprintf(elgg_echo('causes:donor'), $causes->title);

$sidebar =  elgg_view('causes/sidebar/sidebar', array('entity' => $causes));

$body = elgg_view_layout('content', array(
	'sidebar' => $sidebar,
	'filter_override' => false,
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
?>
