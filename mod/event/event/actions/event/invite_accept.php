<?php
/**
 * Accept invitation.
 *
 * @package Event
 */

elgg_load_library('elgg:event');
$group_guid = get_input('group_guid');
$event_guid = get_input('event_guid');

$group = get_entity($group_guid);
$event = get_entity($event_guid);

// If join request made
if (check_entity_relationship($event->guid, 'event_invite', $group->guid)) {
	if(event_accept_invitation($event, $group)){
		remove_entity_relationship($event->guid, 'event_invite', $group->guid);
		event_create_default_cause($event, $group);
		system_message(elgg_echo("event:join:success"));
	}else{
		system_message(elgg_echo("event:join:failed"));	
	}
}else{
	register_error(elgg_echo("event:join:failed"));
}
forward(REFERER);