<?php
/**
 * Group Event
 */

set_input('viewtype', 2);

// Participating events
elgg_push_context('widgets');
elgg_load_library('elgg:event');


// All events
$event = $vars['entity'];
$all_link = elgg_view('output/url', array(
	'href' => "event/group/$event->guid/all",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));
elgg_push_context('widgets');
$options = array(
	'type' => 'object',
	'subtype' => 'event',
	'container_guid' => elgg_get_page_owner_guid(),
	'limit' => 6,
	'full_view' => false,
	'pagination' => false,
);
$content = elgg_list_entities($options);
elgg_pop_context();
if (!$content) {
	$content = '<p>' . elgg_echo('event:noevent') . '</p>';
}
$new_link = elgg_view('output/url', array(
	'href' => "event/add/$event->guid",
	'text' => elgg_echo('event:add'),
	'is_trusted' => true,
));
echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('event:groupevent'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));