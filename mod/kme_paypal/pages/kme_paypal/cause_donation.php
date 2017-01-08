<?php
	elgg_load_library('elgg:causes');
	$payPalURL = PAYPAL_URL;
	$p = new paypal_class;
	$p->paypal_url = $payPalURL;
	notify_paypal_transaction( serialize($_POST), "New donation");
	if ($p->validate_ipn()) {
		if($p->ipn_data['payment_status']=='Completed'){
			$amount = $p->ipn_data['mc_gross'];
			$donorname1 =  $p->ipn_data['first_name'];
			$donorname2 =  $p->ipn_data['last_name'];
			$real_name = $donorname2." ".$donorname1;
			$donoremail = $p->ipn_data['payer_email'];
			$paypal_id = $p->ipn_data['txn_id'];
			$custom = $p->ipn_data['custom'];
			$others['country'] = $p->ipn_data['address_country'];
			$others['city'] = $p->ipn_data['address_city'];
			$others['state']= $p->ipn_data['address_state'];
			$others['zip']= $p->ipn_data['address_zip'];
			$others['street']= $p->ipn_data['address_street'];
			$donation_date= $p->ipn_data['payment_date'];
			
			// Our API's will go here //
			// 44334/46859/46940/0/0/0
			// $eventguid.'/'.$groupguid.'/'.$causeguid.'/'.$konnector_id.'/'.$anonymous.'/'.$donor_guid;
			$guids = explode("/",$custom);
			$event_guid = $guids[0];
			$group_guid = $guids[1];
			$cause_guid = $guids[2];
			$konnector_id = $guids[3];
			$anonymous = $guids[4];
			$donorid = $guids[5];
			$transactionid = causes_donate( $group_guid, $event_guid, $cause_guid, $konnector_id, $donorid, $amount, $real_name, $donoremail, $anonymous, $paypal_id, $others);
			if($transactionid){
				causes_finish_payment($transactionid,$anonymous);
				system_message(elgg_echo("causes:paypal:save"));
			}else{
				notify_paypal_transaction( serialize($_POST), "Failed donation transaction");
				register_error(elgg_echo('causes:paypal:require'));
			}
		} 
	} 
?>