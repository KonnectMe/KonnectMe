<?php
/**
* Causes payment
*
* @package Causes
*/

elgg_load_library('elgg:causes');

$transactionid = get_input('transactionid');
$causesid = get_input('causesid');
$causes = get_entity($causesid);
$card_type = get_input('card_type');
$card_no = get_input('card_no');
$card_no_verify = get_input('card_no_verify');
$card_expiry = get_input('card_expiry');
$name = get_input('name');
$email = get_input('email');
$country = get_input('country');
$address = get_input('address');

	if($card_type && $card_no){
		$table = CAUSES_DB_TABLE;
		$query = "update $table set name = '$name', email = '$email', country = '$country', address = '$address', card_type = '$card_type',
		card_no = '$card_no', card_expiry = '$card_expiry' where transactionid = $transactionid ";
		
		$lastid = update_data($query);	
		forward('causes/donation/'.$causesid.'/'.elgg_get_friendly_title($causes->title));
	}
	else{
		register_error(elgg_echo('causes:paypal:require'));
	}
	forward(REFERRER);
	