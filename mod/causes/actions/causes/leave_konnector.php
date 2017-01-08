<?php
/**
 * Leave a konnector action.
 *
 * @package Causes
 */

elgg_load_library('elgg:causes');

$user_guid = get_input('user_guid', elgg_get_logged_in_user_guid());
$causes_guid = get_input('causes_guid');
$user = get_entity($user_guid);
$causes = get_entity($causes_guid);
if (($user instanceof ElggUser) && ($causes)) {

		if (causes_have_relation($causes->guid, 'causes_konnector', $user->guid)) {
			remove_entity_relationship($causes->guid, 'causes_konnector', $user->guid);
			system_message(elgg_echo("causes:leaved:konnectors"));
			forward($causes->getURL());
		} else {
			register_error(elgg_echo("causess:cantleave"));
		}
	 
	
} else {
	register_error(elgg_echo("causess:cantleave"));
}

forward(REFERER);

?>