<?php
/**
 * package event
 */
$groupguid = (int) get_input('groupguid');
$user = elgg_get_logged_in_user_entity();
foreach ($vars['sponsers'] as $event) {
	$group[$event->guid] =  $event->title;
}
if($group){
?>
<div>
	<label><?php echo elgg_echo('event:eventreport'); ?></label>
	<p>
		<?php  echo elgg_view("input/dropdown", array("name" => 'event', 'id' => 'event', "options_values" => $group ,"value" => '')); ?>
	</p>
</div>
<br>
<div>
	<p>
		<?php echo elgg_view('input/button', array('value' => elgg_echo('event:report'),"onclick"=>"return event_generate_report($groupguid)")); ?>
	</p>
</div>
<?php } ?>