<?php
/**
 * Group Event
 */

set_input('viewtype', 3);

// Participating events
elgg_push_context('widgets');
elgg_load_library('elgg:event');

$event = featured_event_of_group(elgg_get_page_owner_guid());
elgg_pop_context();
if (!$event) {
	$content = '<p>' . elgg_echo('event:noevent') . '</p>';
}

echo elgg_view_module('aside', 'Participating events', elgg_view_entity($event));
