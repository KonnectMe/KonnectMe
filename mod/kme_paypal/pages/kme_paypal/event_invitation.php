<?php
	elgg_load_library('elgg:event');
	$payPalURL = PAYPAL_URL;
	$p = new paypal_class;
	$p->paypal_url = $payPalURL;
	notify_paypal_transaction( serialize($_POST), "Event invitation purchase");
	if ($p->validate_ipn()) {
		if($p->ipn_data['payment_status']=='Completed'){
			$custom = $p->ipn_data['custom'];
			// Our API's will go here //
			$guids = explode("/",$custom);
			$event_guid = $guids[0];
			$group_guid = $guids[1];
			$group = get_entity($group_guid);
			$event = get_entity($event_guid);
			// If join request made
			if (check_entity_relationship($event->guid, 'event_invite', $group->guid)) {
				if(event_accept_invitation($event, $group)){
					remove_entity_relationship($event->guid, 'event_invite', $group->guid);
					event_create_default_cause($event, $group);
					system_message(elgg_echo("event:join:success"));
				}else{
					system_message(elgg_echo("event:join:failed"));	
				}
			} else {
				notify_failed_transaction( serialize($_POST), "Failed event invitation purchase");
				register_error(elgg_echo("event:join:failed"));
			}	
		}
	}
?>