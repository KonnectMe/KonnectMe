<?php
echo elgg_view_form('event/ticket');
set_input('viewtype',1);
$event = $vars['event'];
set_input('eventguid',$event->guid);
$user = elgg_get_logged_in_user_entity();
$table = elgg_get_config('dbprefix')."events_tickets";
$tickets = get_data("select *from $table where event_guid=".$event->guid);
			
$ticketclass = '';
if($event->isfree){ 
	$ticketclass = 'undisply';
}

if($tickets){
	$content .= '<div id="ticket_div_list" class="noul '.$ticketclass.'">';
	$content .= '<table width="100%" border="0" cellspacing="2" cellpadding="5" class="highlighted">
					<tr class="tableheader">';
	$content .=		 	'<td >'.elgg_echo("event:ticket_type").'</td>';				
	$content .= 		'<td >'.elgg_echo("event:description").'</td>';				
	$content .= 		'<td >'.elgg_echo("event:ticket_price").'</td>';				
	$content .= 		'<td >'.elgg_echo("event:avail_number").'</td>';				
	$content .= 		'<td >'.elgg_echo("event:sold").'</td>';				
	$content .= 		'<td >'.elgg_echo("edit").'</td>';				
	$content .= 	'</tr>';
	
	foreach($tickets as $ticket){
		$link = "action/event/deleteticket?guid={$ticket->id}&event={$event->guid}";
		$editlink = "event/editticket/{$event->guid}/{$ticket->id}";
		$url = elgg_get_site_url().$link;
		$link =  elgg_view('output/url', array('href' => $editlink,'text' => elgg_echo('event:editlink'),'is_trusted' => true,));
		$link .= '&nbsp;&nbsp;';
		$link .= elgg_view('output/confirmlink', array('text' => elgg_view_icon('delete'),'href' => $url,'confirm' => elgg_echo('deleteconfirm'),));
	
		$content .=		 	'<tr><td >'.$ticket->title.'</td>';				
		$content .= 		'<td >'.$ticket->description.'</td>';				
		$content .= 		'<td >'.$ticket->price.'</td>';				
		$content .= 		'<td >'.$ticket->seats.'</td>';				
		$content .= 		'<td >'.$ticket->sold.'</td>';				
		$content .= 		'<td >'.$link.'</td>';				
		$content .= 	'</tr>';
	}
	$content .= '</table>';
	$content .= '</div>';	
	echo $content;
}

?>
