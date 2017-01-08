<?php
$eventid = get_input('eventid');
if (!$eventid) {
		forward('event/all');
	}
	
$tickets = $vars['ticket'];
										
foreach($tickets as $ticket){										
	$sold = $ticket->sold;
?>

	<div class="elgg-head">
	<div class="donate_radio"><input type="radio" name="ticket" id="ticket" class="elgg-input-radio"  value="<?php echo $ticket->id ?>" <?php if($ticket->seats <= $sold){ ?> disabled="disabled" <?php }?> /></div>
	<div class="donate_content" ><?php echo $ticket->title;?></div>
	<div class="donate_value">$<?php echo $ticket->price;?></div>
	<div class="clear" ></div>
	</div>
        
<?php } ?>

<div>
<label><?php echo elgg_echo('event:no_registrant') ?></label><br />
<input type="text" value="1" name="count" id="count" />
</div>

<div class="center elgg-foot mts">
<?php 
$btn = elgg_echo('event:buy');
if(event_already_join($eventid,elgg_get_logged_in_user_guid()) ){
	$btn = elgg_echo('event:buymore');
}
echo elgg_view('input/submit', array('value' => $btn));
?>
</div>
