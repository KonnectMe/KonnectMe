<?php
$form_data = $vars['form_data'];
$event = $vars['event'];
$user = elgg_get_logged_in_user_entity();
$eventid = $event->guid;
$free = $event->isfree;
$i = $vars['i'];
?>
<div class="ticket vidhi" >
<div align="right" style="display:<?php if($i==0){?> none <?php } ?>" >
<input type="hidden" id="event_form_<?php echo $i ?>" value="<?php echo $i ?>" onclick="sameasabove(this)" />
<span class="counter" id="<?php echo $i ?>"></span>
</div>
    
<?php
$ticket = $vars['ticket'];
if(!empty($ticket) && !$free){?>
    <div><label><?php echo elgg_echo('event:select_ticket'); ?></label><br />
    <?php echo $ticket; ?>
    <div id="ticket_div_<?php echo $i?>" class="ticket_closed"></div>
    </div>
<?php } ?>

<?php
$disabled = false;
$selected_sponser = NULL;
//---v Argus Changes
$val_sponser = (int)get_input('ref');

if($val_sponser>0){
	$selected_sponser = $val_sponser;
}
//--^ Argus changes ends here

$guid = (int)$form_data->id;
if($guid){
	$selected_sponser = $form_data->group_guid; 
	$status = $form_data->status;
		if($status == 1){
			//$disabled = true;
		}
}

$sponser = event_get_sponsers($eventid,false,true);
//print_r($sponser);
asort($sponser);
if(!$selected_sponser && count($sponser)==2){
	end($sponser);
	$selected_sponser = key($sponser); 
}
if(!empty($sponser)){
	$sponser[0] = elgg_echo('event:defaut_option');
	?>
    <div><label><?php echo elgg_echo('event:sponser', array($event->title)); ?></label><br />
    <?php echo elgg_view('input/dropdown', array(
							'name' => 'sponser_'.$i , 
							'id' => 'sponser_'.$i, 
							'options_values' => $sponser, 
							'class' => 'form_select', 
							'disabled' => $disabled, 
							'value' => $selected_sponser
						));
	 ?>
    </div>

<?php } ?>

<?php
$content = $vars['form'];
if(!empty($content)){
	 echo $content;
     $haveform = true;
}
?>
</div>
