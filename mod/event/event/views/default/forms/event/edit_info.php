<?php
elgg_load_library('elgg:event');
$user = elgg_get_logged_in_user_entity();
$eventid = (int)get_input('eventid');
$purchase_guid = (int)get_input('guid');

if(!$eventid && !$purchase_guid){
	forward('event/all');
}
$event = get_entity($eventid);	
set_input('viewtype',2);
set_input('eventguid', $eventid);
$count = 1;


$required = array();
$fields_array = array();
$fields = array();
$haveticket = false;
$haveform = false;
$free = $event->free; // checking if the event is free or not

// previous purchased data
$purchase_table = elgg_get_config('dbprefix')."events_purchase_info";
$purchased = get_data("select *from $purchase_table where id=$purchase_guid");

// retreving event form data
$form_table = elgg_get_config('dbprefix')."events_customforms";
$event_form = get_data("select *from $form_table where event_guid=$eventid order by item_order");
?>

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

$sponser = event_get_sponsers($eventid,false,true);
asort($sponser);
$sponser[0] = 'Select';
$selected_sponser = $purchased[0]->group_guid; 
											
?>

 <div><label><?php echo elgg_echo('event:sponser', array($event->title)); ?></label><br />
    <?php 
	echo elgg_view('input/dropdown', array(
							'name' => 'sponser_1' , 
							'id' => 'sponser_1', 
							'options_values' => $sponser, 
							'class' => 'form_select', 
							'value' => $selected_sponser
						));
	
	 ?>
    </div>


<div id="event_ticket">
<?php        
$vars['forms'] = $event_form;
$vars['purchase'] = $purchased[0];
echo $viewform = elgg_view('event/form_template',array("entity" => $vars));
?>
</div>


<div>
<?php
$fields_implode = implode(",",$fields_array);
$required_implode = implode(",",$required);
echo elgg_view('input/hidden', array('name' => 'field','value' => $fields_implode, 'id' => 'field'));
echo elgg_view('input/hidden', array('name' => 'required[]','value' => $required_implode,'id' => 'required'));
echo elgg_view('input/hidden', array('name' => 'free' , 'id' => 'free', 'value' => 1));
echo elgg_view('input/hidden', array('name' => 'eventid', 'id' => 'eventid', 'value' => $eventid));
echo elgg_view('input/hidden', array('name' => 'purchase_guid', 'id' => 'purchase_guid', 'value' => $purchase_guid));
echo elgg_view('input/hidden', array('name' => 'count' ,'id' => 'counter', 'value' => 1));

echo elgg_view('input/submit', array('value' => elgg_echo('event:save'), 'id' => 'event-submit-button','onclick'=>'return event_validate_join(1)'));
echo elgg_view('input/button', array('value' => elgg_echo('event:cancel'), 'id' => 'event-submit-button','onclick'=>'history.back()'));

?>
</div>	
<div id="error"></div>
</form>
