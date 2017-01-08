<?php
/**
* Elgg event  Create new Event action
* @package Event
*/
gatekeeper();

$event_guid = get_input('event_guid');
$subject = get_input('subject');
$message = get_input('message');

elgg_make_sticky_form('event');

if (!$subject || !$message) {
	register_error('Please fill in all the fields');
	forward(REFERER);
}

if (!$event_guid){
	register_error('Unable to complete your request. Please try again later');
	forward(REFERER);
}

$site = elgg_get_site_entity();
if ($site && $site->email) {
	$from = $site->email;
} else {
	$from = 'noreply@' . get_site_domain($site->guid);
}

$users = elgg_get_entities_from_relationship(array(
	'relationship' => 'event_join',
	'relationship_guid' => $event_guid,
	'inverse_relationship' => false,
	'types' => 'user',
	'limit' => 0,
));

foreach($users as $user){
	$email = $user->email;
	if ($email && is_email_address($email)) {
		elgg_send_email($from, $email, $subject, $message);
	}
}	
elgg_clear_sticky_form('event');
system_message('Subscribers notified');
forward(REFERER);