<?php
$causesid = (int) get_input('causesid');
$causes = get_entity($causesid);

elgg_set_page_owner_guid($causes->owner_guid);	

if (!elgg_instanceof($causes, 'object', 'causes') || !$causes->canEdit()) {
	register_error(elgg_echo('causes:unknown_causes'));
	forward(REFERRER);
}


if($causesid){
	$causes = get_entity($causesid);
	elgg_push_breadcrumb($causes->title, 'causes/view/'.$causes->guid.'/'.elgg_get_friendly_title($causes->title));
	elgg_push_breadcrumb(elgg_echo('causes:amount'));
	$content = elgg_view_form('causes/amount', array("enctype" => "multipart/form-data"));
}else{
	$content = elgg_echo('causes:nocauses');
}


$title = sprintf(elgg_echo('causes:amount_config'), $causes->title);

$sidebar =  elgg_view('causes/sidebar/sidebar', array('entity' => $causes));

$body = elgg_view_layout('content', array(
	'sidebar' => $sidebar,
	'filter_override' => elgg_view('causes/filter_tab_edit',array('selected'=>'amount','causes' => $causes)),
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);