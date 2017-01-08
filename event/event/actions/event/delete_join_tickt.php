<?php
/**
 * Action for deleting join ticket
 * 
 */
$guid = (int) get_input('guid');
$user = elgg_get_logged_in_user_entity();

if ($guid && $user->canEdit()) {
	$purchase_table = elgg_get_config('dbprefix')."events_purchase_info";
	$delete_data = delete_data("delete from $purchase_table where id=$guid");
	
	$table = elgg_get_config('dbprefix')."events_purchase_userinfo";
	$delete_data = delete_data("delete from $table where purchase_guid=$guid");
	system_message(elgg_echo("event:ticket:deleted"));
}
forward(REFERER);