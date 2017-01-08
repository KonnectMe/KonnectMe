<?php
/**
* Elgg causes  amount configuration
*
* @package causes
*/
gatekeeper();

$guid = get_input('guid');
$amount = implode("|", get_input('amount'));
$amount_description = implode("|", get_input('amount_description'));
if($guid){
	$causes = get_entity($guid);
	if (!$causes->canEdit()) {
		register_error(elgg_echo('causes:save:failed'));
		forward(REFERRER);
	}
	
	$causes->amount = $amount;
	$causes->amount_description = $amount_description;
	system_message(elgg_echo('causes:save:amount'));
}else{
	register_error(elgg_echo('causes:save:failed'));
}
forward(REFERRER);