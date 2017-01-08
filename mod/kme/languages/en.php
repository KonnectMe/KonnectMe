<?php
$kme_english = array(
	/**
	 * Menu items and titles
	 */
	'kme:days' => "Days",
	'kme:hours' => "Hours",
	'kme:minutes' => "Minutes",
	'kme:seconds' => "Seconds",
	'kme:fundraised'=> "Fund raised :",
//	'kme:fundstill_needed'=> "Still needed :",
	'kme:fundstill_needed'=> "Target :",
	'kme:logintocomment' => "<a href='%s'>Login</a> or <a href='%s'>Register</a> to leave your comments.",
	'kme:loginreg' => "Login / Register",
	'kme:tools' => "Tools",
	'kme:ownerblock' => 'Owner',
	'kme:thingstodo' => 'Navigation',
	'kme:home' => "Home",
	'kme:nonprofits' => "Non profits",
	'kme:recentlycommented' => "Recently commented",
	'kme:advertisement' => "Advertisement",
	'causes:Dashboard' => "Edit cause",
	/*** GROUPS ***/
	'groups:tax' => 'Tax details',
	'groups:email' => 'Email',
	'groups:address' => 'Contact address',
	'groups:paypal' => "PayPal Id",
	'kme:adminvalidationneeded' => "Non profit account created sucessfully. It needs to be verified, before you can start raising funds.",
	'kme:groups:pendingapproval' => "Pending approval",
	'kme:approve' => "Approve",
	'kme:unapprove' => "Un approve",
	'kme:approved' => "Approved",
	'kme:unapproved' => "Un approved",
	'item:object:ticket' => 'Ticket',
	'user:password:lost' => 'Forgot your password?',
	'registrationterms:agree' => 'I have read and agree to the <a href="%s">Terms of Service</a>',
	'registrationterms:required' => "You must first agree to the terms",	
	'user:password:text' => 'To request a new password, enter your username or email address below and click the Request button. <br> We will send you a link to reset your password. If you are not seeing the mail in your inbox, please check your junk / spam box too.',

	'exception:title' => "We are on maintenance.",
	'exception:contact_admin' => 'We are on maintanece to serve you better. We will be back soon. Sorry for any inconvenience caused.',
	
);

add_translation('en', $kme_english);

global $CONFIG;
$np_language = array();	
$patterns = array('/group/', '/groups/','/Group/', '/Groups/');
$replacements = array('Non-Profit', 'Non-Profits', 'Non-Profit', 'Non-Profits');
foreach($CONFIG->translations[en] as $key => $val){
	$np_language[$key] = preg_replace($patterns, $replacements, $val);
}
add_translation('en', $np_language);