<?php
$eventguid = get_input('eventid');
$event = get_entity($eventguid);
echo elgg_view('input/hidden', array('name' => 'eventid', 'value' => $eventguid));
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => 0));
?>
<div class='paddingtop_10'>
    <label class="label" ><?php echo elgg_echo("event:group"); ?></label><br />
    <?php 
	$option = array();
	$group = elgg_get_entities(array('type' => 'group','limit' => 0));
	
	foreach($group as $key => $value){
		$guid = $value->guid;
		$name = $value->name;
			if($name){
				$option[$guid] = $name;
			}
	}
	
	asort($option);
	echo elgg_view('input/dropdown', array(
					'name' => 'group[]',
					'id' => 'group',
					'options_values' => $option,
					'multiple' => true,
					));
	?>
</div>

<div class='paddingtop_10'>
    <label class="label"><?php echo elgg_echo("event:reg_fee"); ?></label><br />
     <?php echo elgg_view('input/text',array('name' => 'fee', 'value'=>$event->fee)); ?>
</div>

<!--
<div class='paddingtop_10'>
    <label class="label"><?php echo elgg_echo("event:revenue"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'revenue', 'value'=> $event->revenue)); ?>
</div>
-->
<?php 
 // Bypass the above revenue sytem for now
 echo elgg_view('input/hidden',array('name' => 'revenue', 'value'=> 1));
?> 

<div>
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('event:invitebtn'),"onclick"=>"return validate_invite()")); ?>
</div>
