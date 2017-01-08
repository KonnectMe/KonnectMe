<?php

// Get the user
$user_guids = get_input('user_guids');
$deleted = false;

if(count($user_guids) > 0){
	foreach($user_guids as $guid){
		$user = get_entity($guid);
		if ($guid == elgg_get_logged_in_user_guid()) {
			register_error(elgg_echo('admin:user:self:delete:no'));
			forward(REFERER);
		}

		if (($user instanceof ElggUser) && ($user->canEdit())) {
			if ($user->delete()) {
				$deleted = true;
			}
		}
	}
	if($deleted){
		system_message('Deleted users');
	} else {
		register_error('Unable to delete users');
	}	
}	

forward(REFERER);