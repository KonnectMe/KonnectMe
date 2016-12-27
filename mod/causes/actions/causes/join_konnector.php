<?php
/**
 * Join as konnector
 *
 * @package Causes
 */

elgg_load_library('elgg:causes');

$user_guid = get_input('user_guid', elgg_get_logged_in_user_guid());
$causes_guid = get_input('causes_guid');

$user = get_entity($user_guid);

$causes = get_entity($causes_guid);

if (($user instanceof ElggUser) && ($causes)) {
	if (!causes_have_relation($causes->guid, 'causes_konnector', $user->guid)) {
		add_entity_relationship($causes->guid, 'causes_konnector', $user->guid);
	//	$widget_guid = elgg_create_widget($user->guid, 'konnections', 'profile', 2 );
	//	if($widget_guid){
	//		$widget = get_entity($widget_guid);
	//		$widget->cause_guid = $causes->guid;
	//		$widget->move(1, 0);			
	//		$widget->save();
	//	}	else {
	//		echo "0";
	//		die;
	//	}	
		system_message(elgg_echo("causes:joined:konnectors"));
		forward($causes->getURL());
	} else {
		register_error(elgg_echo("causess:cantjoin"));
	}
} else {
	register_error(elgg_echo("causess:cantjoin"));
}

forward(REFERER);
