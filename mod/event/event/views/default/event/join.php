<?php
elgg_load_library('elgg:event');
$user = elgg_get_logged_in_user_entity();
$event = $vars['event'];
$event_metadata = $vars['event_metadata'];	
$eventguid = $event->guid;
$userguid = $user->guid;
set_input('eventguid', $eventguid);
$count = get_input('count', 1);

$required = array();
$fields_array = array();
$fields = array();
$haveticket = false;
$haveform = false;
$free = $event_metadata[0]->isfree; // checking if the event is free or not
$skip = $event_metadata[0]->skip; // checking, skip registration

// retreving event form data
$form_table = elgg_get_config('dbprefix')."events_customforms";
$event_form = get_data("select *from $form_table where event_guid=$eventguid order by item_order");

if($free){
	if(event_already_join($eventguid, $userguid)){
		system_message(elgg_echo("event:joined"));
		forward(REFERER);
		return;
	}
	if(!$event_form && !event_already_join($eventguid, $userguid)){
		event_create_user_relationship($eventguid, $userguid);
  		system_message(elgg_echo("event:join:success"));
	    forward(REFERER);
		return;
	}
}

// retreving event ticket data
$ticket_table = elgg_get_config('dbprefix')."events_tickets";
$event_ticket = get_data("select *from $ticket_table where event_guid=$eventguid ");
// previous purchased data
$purchase_table = elgg_get_config('dbprefix')."events_purchase_info";
$purchased = get_data("select *from $purchase_table where user_guid=$userguid and event_guid=$eventguid order by time_created");
$count = count($purchased) + $count;
if(!$count){
	$count = 1;
}
$total_ticket = $count;
if($skip){
	//$count = 1;
}
if( count($purchased) > 0) {
	$purchase_count = count($purchased);
	$url = elgg_get_site_url()."event/purchaseinfo/$eventguid/";
	echo "<p class='logintocomment'>You have already purchased $purchase_count ticket(s). You can purchase new tickets using the form below. <br> You can view or edit your <a href='$url'>tickets here.</a></p>";
}
?>
    
<form action="<?php echo $vars['url']; ?>action/event/join" name="event_join" id="event_join" method="post">
<?php echo elgg_view('input/securitytoken'); ?>

<?php
foreach($event_form as $form){
	$label = $form->title;	
    $quid = $form->id;
    $require = $form->required;
    $fieldname = event_replace_string($label);
	$formtype = $form->type;
	if($require == 1 && $formtype != 10){
		$fields_array[] = $fieldname;
		$required[] = $form->type;	
	}
	echo elgg_view('input/hidden', array('name' => 'fields[]','value' => $fieldname,'id' => 'fields','class'=>'form_fields'));
	echo elgg_view('input/hidden', array('name' => 'guids[]','value' => $quid,'id' => 'guids'));
}										
?>

<div id="event_ticket">
<?php        
for($i=0; $i<$count; $i++){ 	
	$form_option = array(
		"event" => $event_metadata[0], 
		'index' => $i,
		'purchase' => $purchased[$i], 
		'forms' => $event_form,
		'tickets' => $event_ticket,
		'count' => $count);
		echo elgg_view('event/ticket_purchaseform',$form_option);
}
?>
</div>


<div>
<?php
$fields_implode = implode(",",$fields_array);
$required_implode = implode(",",$required);
echo elgg_view('input/hidden', array('name' => 'field','value' => $fields_implode, 'id' => 'field'));
echo elgg_view('input/hidden', array('name' => 'required[]','value' => $required_implode,'id' => 'required'));
echo elgg_view('input/hidden', array('name' => 'free' , 'id' => 'free', 'value' => $free));
echo elgg_view('input/hidden', array('name' => 'eventid', 'id' => 'eventid', 'value' => $eventguid));
echo elgg_view('input/hidden', array('name' => 'count' ,'id' => 'counter', 'value' => $total_ticket));

foreach($event_form as $form){	
	$formtype = $form->type;
	if($formtype == 10){
		?>
         <div class="event_terms_class">
         <label><?php	echo $form->title; ?></label><br />
         <div class="event_terms"><?php echo $form->default_values; ?></div>
         <div class="event_agree"><?php echo elgg_view('input/checkbox', array('name'=>'agree','id'=>'agree')); ?> <?php echo elgg_echo('event:agree'); ?></div>
         <span id="event_agree" class="error_msg"></span>
         </div>
        <?php
		
	}
}
 
echo elgg_view('input/submit', array('value' => elgg_echo('event:proceed'),	'id' => 'event-submit-button','onclick'=>'return event_validate_join(1)'));
if(!$free && !$skip){
	echo elgg_view('input/button', array('value' => elgg_echo('event:buymore'), 'name'=>$i, 'id' => 'event-submit-button','onclick'=>'return event_more_ticket(this)'));
}
?>
</div>	
<div id="error"></div>
</form>