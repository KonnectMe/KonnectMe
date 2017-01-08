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

// retreving event form data
$form_table = elgg_get_config('dbprefix')."events_customforms";
$event_form = get_data("select *from $form_table where event_guid=$eventguid order by item_order");

// retreving event ticket data
$ticket_table = elgg_get_config('dbprefix')."events_tickets";
$event_ticket = get_data("select *from $ticket_table where event_guid=$eventguid ");
// previous purchased data
$purchased = array();

$param['count'] = true;
$previous = 0;
if(!$count){
	$count = 1;
}
if(!elgg_is_logged_in()){
	echo elgg_view_module('info', '',  elgg_view('guest/login_prompt'));
}

?>
 
<form action="<?php echo $vars['url']; ?>action/event/guest_join" name="event_join" id="event_join" method="post">
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
echo elgg_view('input/hidden', array('name' => 'count' ,'id' => 'counter', 'value' => $count));

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
 
if(!$free){
	echo elgg_view('input/button', array('value' => elgg_echo('event:buymore'), 'name'=>$i, 'id' => 'event-submit-button','onclick'=>'return event_more_ticket(this)'));
}
echo elgg_view('input/submit', array('value' => 'Finish Registration',	'id' => 'event-submit-button','onclick'=>'return event_validate_join(1)'));

?>
</div>	
<div id="error"></div>
</form>