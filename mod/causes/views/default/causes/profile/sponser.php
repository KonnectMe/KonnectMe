<?php
/**
 * Event sponsers
 *
 * @uses $vars['entity']
 */

if ($vars['entity']->forum_enable == 'no') {
	return true;
}

$event = $vars['entity'];


$all_link = elgg_view('output/url', array(
	'href' => "event/sponser/$event->guid",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));

elgg_push_context('widgets');
$content = elgg_list_entities_from_relationship(array(
		'relationship' => 'event_sponser',
		'relationship_guid' => $event->getGUID(),
		'inverse_relationship' => false,
		'limit' => 0,
	));

elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('event:sponser:none') . '</p>';
}
echo elgg_view('event/profile/module', array(
	'title' => elgg_echo('event:sponser'),
	'content' => $content,
	'all_link' => $all_link,
	
));