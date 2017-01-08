<?php
elgg_load_library('elgg:event');
$user = elgg_get_logged_in_user_entity();
$event = $vars['event'];	
if(!$event){
	return;
}	
set_input('viewtype',4);
set_input('eventguid', $event->guid);
$eventid = $event->guid;
$userid = $user->guid;
$limit = 10;
$offset = (int) get_input('offset');

// retreving event form data
$form_table = elgg_get_config('dbprefix')."events_customforms";
$event_form = get_data("select *from $form_table where event_guid=$eventid order by item_order");

// previous purchased data
$purchase_table = elgg_get_config('dbprefix')."events_purchase_info";
$purchased = get_data("select *from $purchase_table where user_guid=$userid and event_guid=$eventid and status=1 order by time_created");

?>
<div class="event_share">
	<?php echo elgg_view('event/share_purchaseinfo', $vars); ?>
</div>

<div id="event_ticket">
<?php        
$i = $offset;
$option_data = array(
	"event" => $event, 
	'forms' => $event_form, 
	'newticket' => false,  
	'count' => 1
	);
foreach($purchased as $purchase){
	$option_data['index'] = $i;
	$option_data['purchase'] =$purchase;
	echo elgg_view('event/register_information',$option_data);
	$i++;
}
echo elgg_view('navigation/pagination', array( 'count' => $total, 'offset' => $offset ));
?>
</div>
