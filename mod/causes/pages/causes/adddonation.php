<?php
$causesid = (int) get_input('causesid');
$causes = get_entity($causesid);
elgg_set_page_owner_guid($causes->owner_guid);	

if (!elgg_instanceof($causes, 'object', 'causes') || !$causes->canEdit()) {
	register_error(elgg_echo('causes:unknown_causes'));
	forward(REFERRER);
}


elgg_push_breadcrumb($causes->title, 'causes/view/'.$causes->guid.'/'.elgg_get_friendly_title($causes->title));
elgg_push_breadcrumb(elgg_echo('causes:adddonation'));
$content = elgg_view_form('causes/adddonation', array("enctype" => "multipart/form-data"));
$title = elgg_echo('causes:adddonation');

$body = elgg_view_layout('content', array(
	'filter_override' => elgg_view('causes/filter_tab_edit',array('selected'=>'adddonation','causes' => $causes)),
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);