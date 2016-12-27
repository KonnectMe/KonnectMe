<?php
$tickets = $vars['entity']['tickets'];
$form_data = $vars['form'];
$purchased = $vars['entity']['purchase'];
$select_ticket = (int) get_input('ticket');
$status = 0;
$i = (int) $vars['entity']['index'];
if($purchased){
	$select_ticket = $purchased->ticket_guid;
}

foreach($tickets as $ticket){
	$ticketvalue = $ticket->title.'&nbsp;[$'.$ticket->price.']';
	$sold = (int)$ticket->sold ;
	$ticketguid = (int)$ticket->id;
	
	if($purchased && $select_ticket == $ticket->id){
		$prop = '';
	}
	
	$avilable = (int) $ticket->seats;
	$balance = $avilable - $sold;
	
	?>
	<div>
	<?php if($avilable > $sold ){ ?>
	<input type="radio" name="ticket_<?php echo $i?>" id="ticket_<?php echo $i?>" class="elgg-input-radio ticket_<?php echo $ticket->id ?>" onclick="event_have_ticket(this)" value="<?php echo $ticket->id ?>" <?php if($ticket->id == $select_ticket){?> checked="checked" <?php }   echo $prop;?> >  
	<?php }else{ ?>
	<input type="radio" name="ticket_<?php echo $i?>" id="ticket_<?php echo $i?>" class="elgg-input-radio" disabled="disabled" value="<?php echo $ticket->id ?>"  >
	[<span class="ticket_closed"><?php echo elgg_echo('event:ticketover') ?></span>]
	<?php } ?>
	<input type="hidden" id="bal_<?php echo $ticket->id ?>" class="bal_<?php echo $ticket->id ?>" value="<?php echo $balance ?>" />
	<?php 	echo $ticketvalue;?><br /><?php echo $ticket->description;?>
	</div>
	
<?php } ?>   
