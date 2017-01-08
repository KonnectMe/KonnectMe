<?php
elgg_load_library('elgg:event');

$offset = (int) get_input('offset');
$causeid = (int) get_input('causesid');
$cause = get_entity($causeid);

$owner_guid = $cause->owner_guid;
$page_owner = get_entity($owner_guid);
elgg_set_page_owner_guid($owner_guid);	


if($causeid){

	elgg_push_breadcrumb($cause->title,'causes/view/'.$cause->guid.'/'.elgg_get_friendly_title($cause->title));
	elgg_push_breadcrumb(elgg_echo('event:update'));
	$content = elgg_list_annotations(array('annotation_names'=>'recent_update', 'guid' => $causeid, 'limit' => 10,'reverse_order_by' => true,));
	
}else{
	$content = elgg_echo('causes:nomember');
}

$sidebar = elgg_view('causes/sidebar/sidebar', array('entity' => $cause));

$title = sprintf(elgg_echo('causes:update'), $cause->title);
$param = array(
			'filter_context' => 'all',
			'sidebar' => $sidebar,
			'content' => $content,
			'title' => $title,
			'filter' => '',
		);
 
$body = elgg_view_layout('content', $param);
echo elgg_view_page($title, $body);
