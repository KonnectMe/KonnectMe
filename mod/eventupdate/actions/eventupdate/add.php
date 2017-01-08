<?php
/**
* Elgg event  Create new Event action
* @package Event
*/
gatekeeper();

$guid = get_input('guid');
$description = get_input('description');
$userguid = elgg_get_logged_in_user_guid();

if($guid && $description){
	$annotate = "recent_update";
	$annotatedid = create_annotation($guid, $annotate, $description, '' ,$userguid ,ACCESS_PUBLIC);	
	system_message(elgg_echo('event:save:success'));
	forward(REFERER);
	
}else{
	register_error(elgg_echo('event:save:failed'));
	forward(REFERER);
}


?>