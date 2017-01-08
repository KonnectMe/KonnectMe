<?php
        elgg_load_library('elgg:event');
        notify_paypal_transaction(serialize($_POST),"New guest ticket sale");
        $payPalURL = PAYPAL_URL;
        $p = new paypal_class;
        $p->paypal_url = $payPalURL;
        if ($p->validate_ipn()) {
			if($p->ipn_data['payment_status']=='Completed'){
				$amount = $p->ipn_data['mc_gross'] - $p->ipn_data['mc_fee'];
				$donorname1 =  $p->ipn_data['first_name'];
				$donorname2 =  $p->ipn_data['last_name'];
				$donoremail = $p->ipn_data['payer_email'];
				$donor_address_address_country= $p->ipn_data['address_country'];
				$donor_address_city= $p->ipn_data['address_city'];
				$donor_address_state= $p->ipn_data['address_state'];
				$donor_address_zip= $p->ipn_data['address_zip'];
				$donor_address_street= $p->ipn_data['address_street'];
				$donation_date= $p->ipn_data['payment_date'];
				$payid = $p->ipn_data['txn_id'];
				$custom = $p->ipn_data['custom'];
				$ia = elgg_set_ignore_access(true);
				$paypalvalues = explode("/",$custom); // Format is tablerow
				$table_purchase_info = elgg_get_config('dbprefix')."events_purchase_info";
				$table_ticket = elgg_get_config('dbprefix')."events_tickets";
				$form_table = elgg_get_config('dbprefix')."events_customforms";
				$userinfo_table = elgg_get_config('dbprefix')."events_purchase_userinfo";
				$filed_name = array();
				$user_data = array();
				$notify = false;
			
				foreach($paypalvalues as $tableid){
					$data = get_data("select *from $table_purchase_info where id=$tableid");
					if($data){
						$notify = true;
						$ticket_guid = $data[0]->ticket_guid;
						$event_guid = $data[0]->event_guid;
						$event = get_entity($event_guid);
						$purchase_info['status'] = 1;
						saveArray($table_purchase_info,$purchase_info,$tableid,false);
						
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
						$userinfo = get_data("select *from $userinfo_table where purchase_guid=$tableid");
						foreach($userinfo as $info){
							$user_data[$info->form_guid] = $info->value;
						}
						$body .= '<h2>Ticket</h2><table width="100%" border="0" cellspacing="2" cellpadding="5" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">';
						foreach($filed_name as $form_guid=>$form_value){
							$body .= '<tr><td width="200">'.ucfirst($form_value).' : </td><td>'.$user_data[$form_guid].'</td></tr>';
						}
						$body .= '</table>';
					
					} // if close
			
			}// foreach close
			
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
				
				Thanks and Regards,
				KonnectMe Team";
				$mail = elgg_send_email($from, $donoremail, $subject, $mail_body);
				if(!$mail){
					notify_paypal_transaction(serialize($_POST),"Failed email alert");
				}
			}
		
		elgg_set_ignore_access($ia);
		//------------ end our api
    }
}
forward();
?>