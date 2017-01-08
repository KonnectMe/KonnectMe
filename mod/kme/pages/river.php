<?php
/**
 * Main activity stream list page
 */

$options = array();
$options['limit'] = 10;

$page_type = preg_replace('[\W]', '', get_input('page_type', 'all'));
$type = preg_replace('[\W]', '', get_input('type', 'all'));
$subtype = preg_replace('[\W]', '', get_input('subtype', ''));
if ($subtype) {
	$selector = "type=$type&subtype=$subtype";
} else {
	$selector = "type=$type";
}

if ($type != 'all') {
	$options['type'] = $type;
	if ($subtype) {
		$options['subtype'] = $subtype;
	}
}

switch ($page_type) {
	case 'mine':
		$title = elgg_echo('river:mine');
		$page_filter = 'mine';
		$options['subject_guid'] = elgg_get_logged_in_user_guid();
		break;
	case 'friends':
		$title = elgg_echo('river:friends');
		$page_filter = 'friends';
		$options['relationship_guid'] = elgg_get_logged_in_user_guid();
		$options['relationship'] = 'friend';
		break;
	default:
		$title = elgg_echo('river:all');
		$page_filter = 'all';
		break;
}
if($subtype) {
	elgg_push_breadcrumb($title, 'activity/'); 
	elgg_push_breadcrumb(ucfirst($subtype));
} else {
	elgg_push_breadcrumb($title); 
}	

$activity = elgg_list_river($options);
if (!$activity) {
	$activity = elgg_echo('river:none');
}
$content = elgg_view('kme/wirepost');
$content .= elgg_view('core/river/filter', array('selector' => $selector));

$sidebar = elgg_view('core/river/sidebar');
$sidebar .= elgg_view('activity/rightsidebar');

$params = array(
	'content' =>  $content . $activity,
	'sidebar' => $sidebar,
	'filter_context' => $page_filter,
	'filter' => '',
	'class' => 'elgg-river-layout',
	'sidebar_alt' => elgg_view('activity/leftsidebar'),
);

$body = elgg_view_layout('two_sidebar', $params);

echo elgg_view_page($title, $body);
