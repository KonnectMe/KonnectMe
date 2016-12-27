<?php
$user = elgg_get_logged_in_user_entity();	
$viewtype = get_input('viewtype');
$eventguid = get_input('eventguid');
$site_url = elgg_get_site_url();
$ticket = elgg_extract('entity', $vars, FALSE);
$owner_id = $trn->owner_guid;
$siturl = elgg_get_site_url();	

if($viewtype == 1){
	$content .= "<tr>";
	$content .= '<td>'.$ticket->ticket_type.'</td>';
	$content .= '<td>';
		if(!empty($ticket->description)) {
			$content .= $ticket->description;
		}else{
			$content .= "&nbsp;";	
		}
	$content .= "</td>";
	
	
	$link = "action/event/deleteticket?guid={$ticket->guid}&event={$eventguid}";
	$editlink = "event/editticket/{$eventguid}/{$ticket->guid}";
	$url = elgg_get_site_url().$link;
	$price = $ticket->price; 
		if(!$price){
			$price = 0;
		}
		
	$ticketno = $ticket->number;
		if(!$ticketno){
			$ticketno = 0;
		}
		
	$content .= '<td>'.$price.'</td>';
	$content .= '<td>'.$ticketno.'</td>';
	$content .= '<td>';
//	$content .=  (int)$ticket->sold;
	$content .= (int) elgg_get_entities_from_relationship(array('relationship' => "event_purchase_ticket_$eventguid", 'relationship_guid' => $ticket->guid, 'inverse_relationship' => true, 'count' => true));
				
	$content .= '</td>';
	$link =  elgg_view('output/url', array('href' => $editlink,'text' => elgg_echo('event:editlink'),'is_trusted' => true,));
	$link .= '&nbsp;&nbsp;';
	$link .= elgg_view('output/confirmlink', array('text' => elgg_view_icon('delete'),'href' => $url,'confirm' => elgg_echo('deleteconfirm'),));
	$content .= '<td>'.$link.'</td>';
	$content .= "</tr>";
	print_r($content);
}
	
/* ticket form 
*/
if($viewtype == 2){ 
	$status = 0;
	$select_ticket = (int) get_input('ticket');
	$i = $vars['counter'];
	$form_data = $vars['form_data'];
	$ticketvalue = $ticket->ticket_type.'&nbsp;[$'.$ticket->price.']';
	$sold = (int)$ticket->sold ;
	$ticketguid = (int)$form_data->guid;
		if($ticketguid){
			$status = $form_data->status;
			$relationship = 'event_join_ticket_'.$eventguid;
				if($status == 1){
					$prop = 'disabled="disabled"  ';
					$purchased = true;
					$relationship = 'event_purchase_ticket_'.$eventguid;
				}
			
			$saved_ticket = event_get_relationship($ticketguid, $relationship); 
		}
		if($saved_ticket){
			 $select_ticket = $saved_ticket;
		}
		
		if($purchased && $select_ticket == $ticket->guid){
			$prop = '';
		}
		
	$avilable = (int) $ticket->number;
	$balance = $avilable - $sold;
	
	?>
	<div>
	<?php if($avilable > $sold ){ ?>
		<input type="radio" name="ticket_<?php echo $i?>" id="ticket_<?php echo $i?>" class="elgg-input-radio ticket_<?php echo $ticket->guid ?>" onclick="event_have_ticket(this)" value="<?php echo $ticket->guid ?>" <?php if($ticket->guid == $select_ticket){?> checked="checked" <?php }   echo $prop;?> >  
	<?php }else{ ?>
		 <input type="radio" name="ticket_<?php echo $i?>" id="ticket_<?php echo $i?>" class="elgg-input-radio" disabled="disabled" value="<?php echo $ticket->guid ?>"  >
		[<span class="ticket_closed"><?php echo elgg_echo('event:ticketover') ?></span>]
	<?php } ?>
	<input type="hidden" id="bal_<?php echo $ticket->guid ?>" class="bal_<?php echo $ticket->guid ?>" value="<?php echo $balance ?>" />
	<?php 	echo $ticketvalue;?><br /><?php echo $ticket->description;?>
    </div>
        
<?php
}
	
/*
Widget 
*/	
if($viewtype == 3){
	$content = '<div>';
	$content .= $ticket->ticket_type;
	$content .= "<br>";
	$content .= $ticket->description;
	$content .= "<br>";
	$content .= elgg_echo('event:ticket_price').'&nbsp;'.$ticket->price;
	$content .= '</div>';
	print_r($content);
}
?>
