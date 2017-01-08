<?php
	$payPalURL = PAYPAL_URL;
	$img = elgg_get_site_url()."mod/kme_paypal/img/ajax_loader_bw.gif";
	
	$causeguid = get_input('causesid');
	$groupguid = (int)get_input('group');
	$eventguid = (int)get_input('event');
	$causes = get_entity($causeguid);
	$group = get_entity($groupguid);
	$amount = (int) get_input('amount');
	$customamount = (int) get_input('customamount');
	if($customamount){
		$amount = $customamount;
	}
	if(!$amount){
		register_error(elgg_echo('causes:amount:missing'));
		forward(REFERRER);
	}
	$anonymous = get_input('anonymous');
	$donor_id = elgg_get_logged_in_user_guid();
	$konnector_id = get_input('konnector_id');

	$payPalURL = PAYPAL_URL;
	$itemname = "Donation for ".$causes->title;
	$payPalemail = $group->paypal;
	if(!is_email_address($payPalemail)){
		register_error(elgg_echo('causes:unabletoacceptdonation'));
		forward(REFERRER);
	}
	$return_url = $causes->getURL();
	$cancel_url = $causes->getURL();
	$notify_url = elgg_get_site_url()."payments/cause_donation/";
	$custom_values = $eventguid.'/'.$groupguid.'/'.$causeguid.'/'.$konnector_id.'/'.$anonymous.'/'.$donor_id;
    echo "<html>\n";
    echo "<head><title>Processing Payment...</title></head>\n";
    echo "<body onLoad=\"document.form.submit();\">\n";
	echo "<style type='text/css'>
			body {
				background: #fff;
				font-size: 13px;
				font-family: 'Trebuchet MS',Arial,Tahoma,Verdana,sans-serif;
			}
		 </style>";
    echo "<center><h3>Please wait, your donation is being processed...</h3><img src='$img'>\n";
	echo generate_paypal_form($payPalURL, $itemname, $payPalemail, $custom_values, $return_url, $cancel_url, $notify_url, $amount, false, true);
    echo "</center></body></html>\n";	
?>

