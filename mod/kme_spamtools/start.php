<?php

elgg_register_event_handler('init', 'system', 'kme_spamtools_init');

function kme_spamtools_init() {
	elgg_register_admin_menu_item('administer', 'spammers', 'users');
	elgg_register_plugin_hook_handler('cron', 'fiveminute', 'kme_spamtools_cron');

	$action_path = dirname(__FILE__). "/actions/kme_spamtools";
	elgg_register_action('kme_spamtools/bulk_action', "$action_path/bulk_action.php");
	elgg_register_action('kme_spamtools/flag', "$action_path/flag.php");
}

/**
 * Cron job
 */
function kme_spamtools_cron($hook, $entity_type, $returnvalue, $params) {
	
	$site = elgg_get_site_entity();
	$count = 0;
	$limit = 5;
	
	$offset = (int) $site->kmespam_lastoffset + $limit;
	$ia = elgg_set_ignore_access(TRUE);
	$hidden_entities = access_get_show_hidden_status();
	access_show_hidden_entities(TRUE);

	$users = elgg_get_entities(array('type' => 'user', 'limit' => $limit, 'offset' => $offset, 'reverse_order_by' => true));
	if($users){
		foreach($users as $user){
			// Is this a manually verfied user?
			$safe_user = $user->kme_trusteduser;
			if(!$safe_user){
				// Has this user got any friends?
				$users_friends = get_user_friends($user->guid);
				if(!$users_friends){
					// Anybody added this user as a friend?
					$friends_of = get_user_friends_of($user->guid);
					if(!$friends_of){
						// Does this user is a member of any non profit / group?
						$groups = elgg_get_entities_from_relationship(array( 'type' => 'group', 'relationship' => 'member', 'relationship_guid' => $user->guid, 'inverse_relationship' => false));
						if(!$groups){
							// Does this user has purchased a ticket?
							$tickets = elgg_get_entities_from_relationship(array('type' => 'object', 'subtype' => 'event',  'relationship' => 'event_join', 'relationship_guid' => $user->guid, 'inverse_relationship' => true));
							if(!$tickets){
								// Does this user is a part of a cause?
								$owned_causes = elgg_get_entities(array( 'type' => 'object', 'subtype' => 'causes', 'owner_guid' => $user->guid));
								if(!$owned_causes){
									// Does this user is a konnector of any cause?
									$konnected = elgg_get_entities_from_relationship(array( 'relationship' => 'causes_konnector', 'relationship_guid' => $user->guid, 'inverse_relationship' => true));
									if(!$konnected){
										$user->kme_spamuser = true;
										$count++;
									} else {
										continue;
									}	
								}
							}
						}	
					}
				}	
			}	
		}
	}	
	
	$site->kmespam_lastoffset = $offset;	
	access_show_hidden_entities($hidden_entities);
	elgg_set_ignore_access($ia);
	echo "Marked $count users as spammers.";
}
