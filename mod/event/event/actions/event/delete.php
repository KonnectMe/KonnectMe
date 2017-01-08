<?php
/**
 * Delete a event
 *
 * @package Event
 */

gatekeeper();
$user = elgg_get_logged_in_user_entity();
$guid = (int) get_input('guid');
$event = get_entity($guid);

if ($event->getSubtype() == "event" && $event->canEdit()) {
	$container = get_entity($event->container_guid);
	$prefix = "event/" . $guid;
	$imagenames = array('.jpg', 'tiny.jpg', 'small.jpg', 'medium.jpg');
	$img = new ElggFile();
	$img->owner_guid = $owner_guid;
	foreach ($imagenames as $name) {
		$img->setFilename($prefix . $name);
		$img->delete();
	}				
	$rowsaffected = $event->delete();
	if ($rowsaffected > 0) {
		$table = elgg_get_config('dbprefix')."event";
		$delete_data = delete_data("delete from $table where guid=$guid");
		
		$table = elgg_get_config('dbprefix')."events_customforms";
		$delete_data = delete_data("delete from $table where event_guid=$guid");
		
		$table = elgg_get_config('dbprefix')."events_tickets";
		$delete_data = delete_data("delete from $table where event_guid=$guid");
		
		$table = elgg_get_config('dbprefix')."events_purchase_userinfo";
		$purchase_table = elgg_get_config('dbprefix')."events_purchase_info";
		$delete_data = delete_data("delete from $purchase_table where purchase_guid IN (select id from $purchase_table where event_guid=$guid)");
		$delete_data = delete_data("delete from $table where event_guid=$guid");
		
				
		system_message(elgg_echo("event:delete:success"));
	} else {
		register_error(elgg_echo("event:delete:failed"));
	}
	forward("event/mine/".$user->guid);
}
forward(REFERER);		
