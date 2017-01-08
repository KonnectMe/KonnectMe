<?php
/**
* Causes donation
* Final step for donation
* @package Causes
*/

elgg_load_library('elgg:causes');

$transactionid = get_input('transactionid');
$causesid = get_input('causesid');


			if($transactionid){
				
				//redirect to paypal link
				causes_go_paypal_link($transactionid);
				//after finish trnsaction
				causes_finish_payment($transactionid);
				
				// chnage status
				$table = CAUSES_DB_TABLE;
				$query = "update $table set status = '1' where transactionid = $transactionid ";
				$lastid = update_data($query);	
				
				//
				system_message(elgg_echo("causes:paypal:save"));
				session_unregister('TransactionId');
				forward('causes/all');
					
			}
			else{
				register_error(elgg_echo('causes:donation_uncomplete'));
			}
			
		forward(REFERRER);
	