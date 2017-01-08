<?php
/**
 * Event latest activity
 *
 * @todo add people joining event to activity
 * 
 * @package Event
 */

if ($vars['entity']->activity_enable == 'no') {
	return true;
}

$event = $vars['entity'];
if (!$event) {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "event/activity/$event->guid",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));


elgg_push_context('widgets');
$db_prefix = elgg_get_config('dbprefix');
$content = elgg_list_river(array(
	'limit' => 4,
	'pagination' => false,
	'joins' => array("JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid"),
	'wheres' => array("(e1.container_guid = $event->guid)"),
));
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('event:activity:none') . '</p>';
}

echo elgg_view('event/profile/module', array(
	'title' => elgg_echo('event:activity'),
	'content' => $content,
	'all_link' => $all_link,
));
