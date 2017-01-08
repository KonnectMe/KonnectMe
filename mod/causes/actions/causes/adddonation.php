<?php
/**
* Causes doante
*
* @package Causes
*/

elgg_load_library('elgg:causes');
$groupguid = (int)get_input('group');
$eventguid = (int )get_input('event_guid');
$causeid = (int)get_input('causesid');
$konnector = get_input('konnector');
$konnector_id = (int)get_input('konnector_id');
$donorid = 0;
$amount = (int) get_input('amount');
$customamount = (int) get_input('customamount');
if($customamount){
	$amount = $customamount;
}
$name = mysql_real_escape_string(get_input('name'));
$email = mysql_real_escape_string(get_input('email'));
$anonymous = get_input('anonymous');
$transaction_id = mysql_real_escape_string(get_input('paypal'));
if($amount){
	if($konnector == '0'){
		$konnector_id = 0;
	}
	if($anonymous != '0'){
		$anonymous = 1;
	}
	$donation_id = causes_donate($groupguid, $eventguid, $causeid, $konnector_id, $donorid, $amount, $name, $email, $anonymous,  $transaction_id);
	if($donation_id){
		system_message(elgg_echo("causes:paypal:save"));
	}else{
		register_error(elgg_echo('causes:paypal:require'));
	}
}else{
	register_error(elgg_echo('causes:paypal:require'));
}
forward(REFERRER);
	