<?php
/**
* Causes doante
*
* @package Causes
*/

elgg_load_library('elgg:causes');

$causesid = get_input('causesid');
$group = (int)get_input('group');
$eventguid = (int)get_input('event');
$causes = get_entity($causesid);
$amount = (int) get_input('amount');
$customamount = (int) get_input('customamount');
if($customamount){
	$amount = $customamount;
}

$konnector = get_input('konnector');
$anonymous = get_input('anonymous');
$konnector_id = get_input('konnector_id');
if($amount){
	$transactionid = causes_donate($causesid, $amount, $konnector, $anonymous, $konnector_id, $eventguid, $group);
		if($transactionid){
			$_SESSION['TransactionId'] = $transactionid;
			//redirect to paypal link
			causes_go_paypal_link($transactionid);
			//after finish trnsaction
			causes_finish_payment($transactionid,$anonymous);
			// update event guid
			system_message(elgg_echo("causes:paypal:save"));
		}else{
			register_error(elgg_echo('causes:paypal:require'));
		}
}else{
	register_error(elgg_echo('causes:paypal:require'));
}
forward(REFERRER);
	