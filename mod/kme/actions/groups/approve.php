<?php	
/**
 * Approve a group
 *
 * @package ElggGroups
 */

$group_guid = get_input('group_guid');
$action = get_input('action_type');
$group = get_entity($group_guid);

//get the action, is it to feature or unfeature
if ($group) {
	if($action == 'approve'){
		$group->approved = 1;
		system_message(elgg_echo('kme:approved'));
	}	
	if($action == 'unapprove'){
		$group->approved = 0;
		system_message(elgg_echo('kme:unapproved'));
	}	
}

forward(REFERER);