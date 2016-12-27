<?php
/**
 * Action for deleting join ticket
 * 
 */
$guid = (int) get_input('guid');
$user = elgg_get_logged_in_user_entity();

if ($guid && $user->canEdit()) {
	$userguid = (int)$user->guid;
	$were = "user_guid=$userguid and event_guid=$guid and status=0 ";
	$purchase_table = elgg_get_config('dbprefix')."events_purchase_info";
	$delete_data = delete_data("delete from $purchase_table where $were ");
	system_message(elgg_echo("event:ticket:deleted"));
}
forward(REFERER);