<?php
elgg_load_library('elgg:causes');


$causesid = (int) get_input('causesid');
$causes = get_entity($causesid);

$owner_guid = $causes->owner_guid;
$page_owner = get_entity($owner_guid);

elgg_push_breadcrumb($causes->title,'causes/view/'.$causes->guid.'/'.elgg_get_friendly_title($causes->title));
elgg_push_breadcrumb(elgg_echo('causes:comments'));
	
$content = elgg_view_entity($causes, array('full_view' => true));
$content .= elgg_view_comments($causes);

$title = sprintf(elgg_echo('causes:comment'), $causes->title);

$sidebar =  elgg_view('causes/sidebar/sidebar', array('entity' => $causes));

$body = elgg_view_layout('content', array(
	'sidebar' => $sidebar,
	'filter_override' => false,
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
?>
