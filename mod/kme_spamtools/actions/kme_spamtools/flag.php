<?php

// Get the user
$guid = get_input('guid');
$user = get_entity($guid);
if (($user instanceof ElggUser) && ($user->canEdit())) {
	$user->kme_trusteduser = true;
	$user->kme_spamuser = false;
	system_message('Flagged the user as a trusted one.');
	forward(REFERER);
} else {
	register_error('Unable to unflag the user.');
}	
