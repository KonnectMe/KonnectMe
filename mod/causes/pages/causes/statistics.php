<?php
elgg_load_library('elgg:causes');

$offset = (int) get_input('offset');
$causesid = (int) get_input('causesid');
$causes = get_entity($causesid);


elgg_set_page_owner_guid($causes->owner_guid);	

if (!elgg_instanceof($causes, 'object', 'causes') || !$causes->canEdit()) {
	register_error(elgg_echo('causes:unknown_causes'));
	forward(REFERRER);
}


$owner_guid = $causes->owner_guid;
$page_owner = get_entity($owner_guid);


if($causes){
	
	elgg_push_breadcrumb($causes->title, 'causes/view/'.$causes->guid.'/'.elgg_get_friendly_title($causes->title));
	elgg_push_breadcrumb(elgg_echo('causes:statistics'));
	causes_export_buttons($causes);
	$content =  causes_list_latest_donors($causes->guid, $offset, 20, true, true);

}else{
	$content = elgg_echo('causes:nocauses');
}


$sidebar =  elgg_view('causes/sidebar/sidebar', array('entity' => $causes));

$title = sprintf(elgg_echo('causes:statisticsof'), $causes->title);

$body = elgg_view_layout('content', array(
	'sidebar' => $sidebar,
	'filter_override' => elgg_view('causes/filter_tab_edit',array('selected'=>'statistics','causes' => $causes)),
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
?>
