<?php
	elgg_load_library('elgg:event');
	$payPalURL = PAYPAL_URL;
	$p = new paypal_class;
	$p->paypal_url = $payPalURL;
	notify_paypal_transaction( serialize($_POST), "New ticket sale");
	if ($p->validate_ipn()) {
		if($p->ipn_data['payment_status']=='Completed') {
			$custom = $p->ipn_data['custom'];
			$donoremail = $p->ipn_data['payer_email'];
			// Our API's will go here //
			$paypalvalues = explode("/",$custom); // Format is PURCHASED_USER_GUID/ EVENT_GUID / PURCHASED_TICKETS_GUID
			$user_guid = (int) $paypalvalues[0];
			$user = get_user($user_guid);
			$event_guid = (int) $paypalvalues[1];
			$event = get_entity($event_guid);
			$purchased_ticketArray = split(",", $paypalvalues[2]);	
			$table_purchase_info = elgg_get_config('dbprefix')."events_purchase_info";
			$table_ticket = elgg_get_config('dbprefix')."events_tickets";
			
			$form_table = elgg_get_config('dbprefix')."events_customforms";
			$userinfo_table = elgg_get_config('dbprefix')."events_purchase_userinfo";
			$filed_name = array();
			$user_data = array();
			$notify = false;
			$body = '';
			if($user && $event && $purchased_ticketArray){
				$index = 0;
				$notify = true;
				foreach($purchased_ticketArray as $ticket){
					$data = get_data("select *from $table_purchase_info where id=$ticket");
					$ticket_guid = $data[0]->ticket_guid;
					$event_guid = $data[0]->event_guid;
					$event = get_entity($event_guid);
					$purchase_info['status'] = 1;
					saveArray($table_purchase_info,$purchase_info,$ticket,false);
					
					//update ticket 
					$tickets = get_data("select *from $table_ticket where id=$ticket_guid");
					$ticket_array['sold'] = $tickets[0]->sold+1;
					saveArray($table_ticket,$ticket_array,$ticket_guid,false);
					
					//notification
					if(empty($fieldname)){
						$event_form = get_data("select *from $form_table where event_guid=$event_guid and type!=10 order by item_order");
						foreach($event_form as $form){
							$column = $form->title;	
							$fieldname = event_replace_string($column);
							$filed_name[$form->id] = $column;
						}	
					}
					$userinfo = get_data("select *from $userinfo_table where purchase_guid=$ticket");
					foreach($userinfo as $info){
						$user_data[$info->form_guid] = $info->value;
					}
					$body .= '<h2>Ticket</h2><table width="100%" border="0" cellspacing="2" cellpadding="5" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">';
					foreach($filed_name as $form_guid=>$form_value){
						$body .= '<tr><td width="200">'.ucfirst($form_value).' : </td><td>'.$user_data[$form_guid].'</td></tr>';
					}
					$body .= '</table>';
					
					$sponser_guid = $data[0]->group_guid;
					if($sponser_guid){
						$np_group = get_entity($sponser_guid);
						$ti_user = get_user($user_guid);
						if (($ti_user instanceof ElggUser) && ($np_group instanceof ElggGroup)) {
							if (!$np_group->isMember($ti_user)) {
								if (groups_join_group($np_group, $ti_user)) { 
									// send welcome email to user
									notify_user($ti_user->getGUID(), $np_group->owner_guid,
											elgg_echo('groups:welcome:subject', array($np_group->name)),
											elgg_echo('groups:welcome:body', array(
												$ti_user->name,
												$np_group->name,
												$np_group->getURL())
											));
								}
							}
						}	
						elgg_load_library('elgg:causes');
						$featured_cause_for_sponsor = featured_cause_of_group($sponser_guid);
						if($featured_cause_for_sponsor){
							if (!check_entity_relationship($featured_cause_for_sponsor->guid, 'causes_konnector', $user_guid)){
								add_entity_relationship($featured_cause_for_sponsor->guid, 'causes_konnector', $user_guid);
							}
						}
						causes_new_konnector_relation($event_guid, $sponser_guid, $user_guid);
					}
					
				}//end foreach
				
				if($notify){
					$site = elgg_get_site_entity();
					// create the from address
					$site = get_entity($site->guid);
					if ($site && $site->email) {
						$from = $site->email;
					} else {
						$from = 'noreply@' . get_site_domain($site->guid);
					}			
					$subject = "Confirmation of your Ticket purchase for ".$event->title;
					$event_url = $event->getURL();
					$mail_body = "
					Hi,
					
					This is an acknowledgement for the purchase of your ticket for ".$event->title."
					
					To learn more about the event, visit ".$event_url." <br> ".$body."<br>
					
					Thank you for the registering for the event.
                                        Regards,
					KonnectMe Team";
					$mail = elgg_send_email($from, $donoremail, $subject, $mail_body);
					if(!$mail){
						notify_paypal_transaction(serialize($_POST),"Failed email alert");
					}					
				}
				
				
			} else {
				notify_paypal_transaction( serialize($_POST), "Failed ticket sale");
			}	
			//create new river
			add_to_river('river/object/event/ticket','create', $user_guid, $event_guid);
			event_create_user_relationship($event_guid, $user_guid);
			//------------ end our api
		}
	}
?>