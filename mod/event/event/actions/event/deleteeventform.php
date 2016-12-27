<?php
/**
 * Action for deleting event form
 */

$guid = (int) get_input('guid');
$eventguid = (int) get_input('event');

$event = get_entity($guid);
if ($event->canEdit()) {
	$table = elgg_get_config('dbprefix')."events_customforms";
	$delete = delete_data("delete from $table where id=".$guid);
	if ($delete) {
		system_message(elgg_echo("event:deleted"));
	} else {
		register_error(elgg_echo("event:notdeleted"));
	}
	forward("event/registration/" . $eventguid);
}
