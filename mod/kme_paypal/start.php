<?php

define('PAYPAL_URL', 'https://www.paypal.com/cgi-bin/webscr');
// define('PAYPAL_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');

elgg_register_event_handler('init', 'system', 'kme_paypal_init');

function kme_paypal_init() {
	elgg_register_library('kme:paypal', elgg_get_plugins_path() . 'kme_paypal/lib/paypal.php');
	elgg_register_page_handler('payments', 'kme_paypal_page_handler');
	run_function_once('alter_paypal_table');
	
}

function kme_paypal_page_handler($page) {
	if (!isset($page[0])) {
		return false;
	}
	elgg_load_library('kme:paypal');
	$dir = elgg_get_plugins_path() . 'kme_paypal/pages/kme_paypal';
	$page_type = $page[0];
	switch ($page_type) {
		case 'event_invitation':
			include "$dir/event_invitation.php";
			break;
		case 'ticket_purchase':
			include "$dir/ticket_purchase.php";
			break;
		case 'cause_donation':
			include "$dir/cause_donation.php";
			break;	
		case 'cause_donate':
			include "$dir/cause_donation.php";
			break;
		case 'ticket_purchase_guest':
			include "$dir/ticket_purchase_guest.php";
			break;				
		// Intermediate page for donation the donate button has to be posted to this page
		case 'make_donation':
			include "$dir/make_donation.php";
			break;	 		
		default:
			return false;
	}
	return true;
}

function alter_paypal_table(){
	$sql = "ALTER TABLE  `elgg_paypal` ADD  `country` VARCHAR( 255 ) NULL ,
	ADD  `city` VARCHAR( 255 ) NULL ,
	ADD  `state` VARCHAR( 255 ) NULL ,
	ADD  `zip` VARCHAR( 255 ) NULL ,
	ADD  `street` VARCHAR( 255 ) NULL ";
	mysql_query($sql) or die(mysql_error());
}

function generate_paypal_form($payPalURL, $itemname, $payPalemail, $custom_values, $return_url, $cancel_url, $notify_url, $amount, $button_title = false, $show_submit = false, $is_payment = false){
	$html = "<form method=\"post\" name=\"form\" action=\"".$payPalURL."\">\n";
	if($is_payment){
		$html .= "<input type=\"hidden\" name=\"cmd\" value=\"_xclick\" />";	
	} else {
		$html .= "<input type=\"hidden\" name=\"cmd\" value=\"_donations\" />";
	}
	$html .= "<input type=\"hidden\" name=\"rm\" value=\"2\" />" ;
    $html .= "<input type=\"hidden\" name=\"no_note\" value=\"1\" />";
    $html .= "<input type=\"hidden\" name=\"cbt\" value=\"Go Back To KonnectMe\" />";
    $html .= "<input type=\"hidden\" name=\"no_shipping\" value=\"1\" />";
    $html .= "<input type=\"hidden\" name=\"lc\" value=\"US\" />";
    $html .= "<input type=\"hidden\" name=\"currency_code\" value=\"USD\" />";
    $html .= "<input type=\"hidden\" name=\"item_name\" value=\"".$itemname."\" />";
    $html .= "<input type=\"hidden\" name=\"business\" value=\"".$payPalemail."\" />";
    $html .= "<input type=\"hidden\" name=\"custom\" value=\"".$custom_values."\" />";
    $html .= "<input type=\"hidden\" name=\"return\" value=\"".$return_url."\" />";
    $html .= "<input type=\"hidden\" name=\"cancel_return\" value=\"".$cancel_url."\" />";
    $html .= "<input type=\"hidden\" name=\"notify_url\" value=\"".$notify_url."\" />";
    $html .= "<input type=\"hidden\" name=\"amount\" value=\"".$amount."\" />";
	if($show_submit){
		$html .= "If you are not automatically redirected to paypal within 5 seconds...<br/><br/>\n";   
		$html .= "<input type=\"submit\" value=\"Click Here\">\n"; 	
	} else {
		$html .= "<input class='elgg-button' type=\"submit\" value=\"".$button_title."\">\n"; 	
	}
	$html .= "<input type='hidden' name='bn' value='KonnectMeLLC_Cart_PPS' />";
	$html .= "</form>\n";
	return $html;
}	

function notify_paypal_transaction($payment_details, $title = "New transaction at KonnectMe"){
	// pw :098765qwerty
	$to = 'payments.konnectme@gmail.com';
	$subject = $title;
	$message = "We have a new transaction with the data. $payment_details";
	$headers = 'From: payments.konnectme@gmail.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
	mail($to, $subject, $message, $headers);
}	