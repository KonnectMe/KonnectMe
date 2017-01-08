<?php
elgg_load_library('elgg:event');	
$user = elgg_get_logged_in_user_entity();
$event = $vars['event'];
$event_guid = $event->guid;
$event_metadata = get_events("guid=$event_guid");
$user_guid = $user->guid;

$table_purchase_info = elgg_get_config('dbprefix')."events_purchase_info";
$table_ticket = elgg_get_config('dbprefix')."events_tickets";
$purchased = get_data("select p.*, t.title, t.price from $table_purchase_info p, $table_ticket t where p.ticket_guid=t.id and p.user_guid=$user_guid and p.event_guid=$event_guid and p.status=0");	

if(!$purchased){
	forward('event/all');
}

	
$ticketArray = array();	
$priceArray = array();	
$nameArray = array();	

foreach($purchased as $purchase){
	 $ticketguid = $purchase->id;
	 $ticketArray[] = $ticketguid;
	 $priceArray[$ticketguid] = $purchase->price;
	 $nameArray[$ticketguid] = $purchase->title;
}

?>
<table width="100%" cellspacing="5" cellpadding="5" class="highlighted konnectorstable">
	<tbody><tr class="tableheader">
	<td><?php echo elgg_echo('event:ticket_type'); ?></td>
	<td><?php echo elgg_echo('event:ticket_price'); ?></td>
	<td><?php echo elgg_echo('event:avail_number'); ?></td>
	<td><?php echo elgg_echo('event:total'); ?> <?php echo elgg_echo('event:ticket_price'); ?></td>
	</tr>
	<?php

	foreach(array_count_values($ticketArray) as $key => $value){
	?>
	<tr>
	<td><?php echo $nameArray[$key]; ?></td>
	<td><?php echo $price = $priceArray[$key]; ?></td>
	<td><?php echo $total_seats[] = (int)$value; ?></td>
	<td><?php echo $total_amount[] = (int)$price * $value; ?></td>
	</tr>    
	 <?php
	}
	?>
	<tr>
	<td><?php echo elgg_echo('event:total'); ?></td>
	<td></td>
	<td><?php echo array_sum($total_seats);  ?></td>
	<td><?php echo array_sum($total_amount);  ?></td>
	</tr>  
	</tbody>
</table>

<div style="overflow:auto;">
	<?php
	foreach($purchased as $purchased_ticket){
		$purchased_ticketArray[] = $purchased_ticket->id;
	}
	$purchased_ticketguid = implode(",",$purchased_ticketArray);
	$paypalvalues = $user->guid.'/'.$event->guid.'/'.$purchased_ticketguid;
	$url = elgg_get_site_url() . "event/join/{$event->guid}/".elgg_get_friendly_title($event->title);
	echo elgg_view('input/button', array('value' => 'Edit',	'id' => 'event-submit-button', 'class' => 'fleft', 'onclick'=>'event_url("'.$url.'")'));
	if($event->canEdit()){
		$tc = base64_encode($purchased_ticketguid);
		echo elgg_view('output/url',array('text'=>'Approve without payment', 'href' => "action/event/approve_ticket?tc=$tc&eg={$event->guid}", 'class' => 'elgg-button fright','is_action'=>true));
	}
	echo "<div class='fright'>";
	
	$button_title = 'Complete payment';
	$payPalURL = PAYPAL_URL;
	$item_name = "Purchasing ticket for the event ".$event->title;
	$payPalemail = $event_metadata[0]->paypal;
	$custom_values = $paypalvalues;
	$return_url = $event->getURL();
	$cancel_url = $event->getURL();
	$notify_url = elgg_get_site_url()."payments/ticket_purchase/";
	$amount = (int) array_sum($total_amount);
	echo $accept_button = generate_paypal_form($payPalURL, $item_name, $payPalemail, $custom_values, $return_url, $cancel_url, $notify_url, $amount, $button_title, false, true);

	
	echo elgg_view('input/hidden', array('value' => $paypalvalues,	'name' => 'paypalvalues',));
	echo "</div>";
	?>
</div>
