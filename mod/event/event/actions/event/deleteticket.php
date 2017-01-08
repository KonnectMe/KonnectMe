<?php
/**
 * Action for deleting ticket
 */

$guid = (int) get_input('guid');
$eventguid = (int) get_input('event');
$event = get_entity($eventguid);

if ($event->canEdit()) {
	$table = elgg_get_config('dbprefix')."events_tickets";
	$delete = delete_data("delete from $table where id=".$guid);
	if ($delete) {
		system_message(elgg_echo("event:ticket:deleted"));
	} else {
		register_error(elgg_echo("event:notdeleted"));
	}
	forward("event/ticket/" . $eventguid);
}
