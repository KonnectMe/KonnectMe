<?php
/**
 * Delete sponsership
 *
 * @package Event
 */

$group_guid = (int) get_input('group_guid');
$event_guid = (int) get_input('event_guid');
$group = get_entity($group_guid);
$event = get_entity($event_guid);

// If join request made
if (check_entity_relationship($event->guid, 'event_sponser', $group->guid)) {
	remove_entity_relationship($event->guid, 'event_sponser', $group->guid);
	system_message(elgg_echo("event:sponser:delete"));
}else{
	register_error(elgg_echo("event:sponser:delete:failed"));
}

forward(REFERER);