<?php
elgg_load_library('elgg:event');	
$user = elgg_get_logged_in_user_entity();
$event = $vars['event'];
$event_guid = $event->guid;
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
	 $ticketguid = $purchase->ticket_guid;
	 $ticketArray[] = $ticketguid;
	 $priceArray[$ticketguid] = $purchase->price;
	 $nameArray[$ticketguid] = $purchase->title;
}

?>
<form action="<?php echo $vars['url']; ?>action/event/finish_payment" name="event_finish" id="event_finish" method="post">
<?php echo elgg_view('input/securitytoken'); ?>

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
<div>

<?php
foreach($purchased as $purchased_ticket){
	$purchased_ticketArray[] = $purchased_ticket->id;
}
$purchased_ticketguid = implode(",",$purchased_ticketArray);
$paypalvalues = $user->guid.'/'.$event->guid.'/'.$purchased_ticketguid;
$url = elgg_get_site_url() . "event/join/{$event->guid}/".elgg_get_friendly_title($event->title);
echo elgg_view('input/button', array('value' => 'Edit',	'id' => 'event-submit-button','onclick'=>'event_url("'.$url.'")'));
echo elgg_view('input/submit', array('value' => 'Finish',	'id' => 'event-submit-button',));
echo elgg_view('input/hidden', array('value' => $paypalvalues,	'name' => 'paypalvalues',));
?>
</div>
</form>

