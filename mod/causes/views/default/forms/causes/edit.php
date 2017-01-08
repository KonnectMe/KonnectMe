<?php
$causesid = get_input('causesid');
$causes = get_entity($causesid);

echo elgg_view('input/hidden', array('name' => 'access_id', 'value' => 2));
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $causesid));
?>

<div >
    <label class="label" ><?php echo elgg_echo("causes:name"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'title','id' => 'title', 'value' => $causes->title, 'class' => 'validate')); ?>
</div>

<div >
	<label class="label"><?php echo elgg_echo('causes:image'); ?></label><br />
	<?php echo elgg_view('input/file', array('name' => 'icon')); ?>
</div>


<div >
	<label class="label"><?php echo elgg_echo('causes:non-profit'); ?></label><br />
	<?php 
	$group = elgg_get_entities_from_relationship( array(
			'relationship' => 'causes_supported',
			'relationship_guid' => $causesid,
			'inverse_relationship' => FALSE
		));	

	$group_guid = (int)$group[0]->guid;	
	echo elgg_view('input/dropdown', array('name' => 'group', 'id' => 'group', 'class' => 'validate', 'options_values' => causes_groups(), "value" => $group_guid));  ?>
</div>

<div >
	<label class="label"><?php echo elgg_echo('event:event'); ?></label><br />
	<?php 
	$event = elgg_get_entities_from_relationship( array(
			'relationship' => 'causes_event_supported',
			'relationship_guid' => $causesid,
			'inverse_relationship' => FALSE
		));	

	$event_guid = (int)$event[0]->guid;	
	
	echo elgg_view('input/dropdown', array('name' => 'event', 'id' => 'event', 'options_values' => causes_events(), "value" => $event_guid));  ?>
</div>

<div >
    <label class="label"><?php echo elgg_echo("causes:description"); ?></label><br />
    <?php echo elgg_view('input/longtext',array('name' => 'description','id' => 'description', 'value' => $causes->description,)); ?>
</div>


<div >
    <label class="label"><?php echo elgg_echo("causes:brief"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'brief','id'=>'brief', 'value' => $causes->brief_description,	'class' => 'validate')); ?>
</div>

<div>
	<label><?php echo elgg_echo('causes:category'); ?></label>
	<?php  echo elgg_view("input/dropdown", array("name" => 'category', "options_values" => causes_category() ,"value" => $causes->category, 'class' => 'validate')); ?>
</div>


<div >
	<label class="label"><?php echo elgg_echo('causes:enddate'); ?></label><br />
	 <?php echo elgg_view('input/date',array('name' => 'enddate',"id" => 'enddate','value' => $causes->enddate, 'class' => 'validate')); ?>
</div>

<div >
    <label class="label"><?php echo elgg_echo("causes:location"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'location', 'id' => 'location', 'value' => $causes->location, 'class' => 'validate')); ?>
</div>



<div >
    <label class="label"><?php echo elgg_echo("causes:target"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'target', 'value' => $causes->target, 'class' => 'validate')); ?>
</div>

 
 <div>
	<label class="label"><?php echo elgg_echo('causes:tags'); ?></label> <br />
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'id' => 'tags', 'value' => $causes->tags)); ?>
</div>

 
<div>
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('event:save'),"onclick"=>"return validate_cause()")); ?>
    <?php

	$delete_url = 'action/causes/delete?guid=' . $causes->guid;
	echo elgg_view('output/confirmlink', array(
		'text' => elgg_echo('causes:delete'),
		'href' => $delete_url,
		'confirm' => elgg_echo('causes:deletewarning'),
		'class' => 'elgg-button elgg-button-delete float-alt',
	));

?>
</div>
