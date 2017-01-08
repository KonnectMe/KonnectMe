<?php
/**
 * Delete invitation
 *
 * @package Event
 */

$group_guid = get_input('group_guid');
$event_guid = get_input('event_guid');

$group = get_entity($group_guid);
$event = get_entity($event_guid);

// If join request made
if (check_entity_relationship($event->guid, 'event_invite', $group->guid)) {
	remove_entity_relationship($event->guid, 'event_invite', $group->guid);
	system_message(elgg_echo("event:join:delete"));
}else{
	register_error(elgg_echo("event:join:delete:failed"));
}

forward(REFERER);