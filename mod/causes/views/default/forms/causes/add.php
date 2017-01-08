<?php
$container_guid = get_input('guid',elgg_get_logged_in_user_guid());
echo elgg_view('input/hidden', array('name' => 'access_id', 'value' => 2));
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => 0));
echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));
?>

<div >
    <label class="label" ><?php echo elgg_echo("causes:name"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'title','id' => 'title', 'class' => 'validate')); ?>
</div>

<div >
	<label class="label"><?php echo elgg_echo('causes:image'); ?></label><br />
	<?php echo elgg_view('input/file', array('name' => 'icon', )); ?>
</div>



<div >
	<label class="label"><?php echo elgg_echo('causes:non-profit'); ?></label><br />
	<?php echo elgg_view('input/dropdown', array('name' => 'group', 'id' => 'group', 'class' => 'validate', 'options_values' => causes_groups(),));  ?>
</div>

<div >
	<label class="label"><?php echo elgg_echo('event:event'); ?></label><br />
	<?php echo elgg_view('input/dropdown', array('name' => 'event', 'id' => 'event',  'options_values' => causes_events(),));  ?>
</div>



<div >
    <label class="label"><?php echo elgg_echo("causes:description"); ?></label><br />
    <?php echo elgg_view('input/longtext',array('name' => 'description','id'=>'description', )); ?>
</div>


<div >
    <label class="label"><?php echo elgg_echo("causes:brief"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'brief','id'=>'brief', 'class' => 'validate')); ?>
</div>

<div>
	<label><?php echo elgg_echo('causes:category'); ?></label>
	<?php  echo elgg_view("input/dropdown", array("name" => 'category', "options_values" => causes_category() ,"value" => '', 'class' => 'validate')); ?>
</div>


<div >
	<label class="label"><?php echo elgg_echo('causes:enddate'); ?></label><br />
	 <?php echo elgg_view('input/date',array('name' => 'enddate',"id"=>'enddate', 'class' => 'validate')); ?>
</div>

<div >
    <label class="label"><?php echo elgg_echo("causes:location"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'location', 'id' => 'location')); ?>
</div>


<div >
    <label class="label"><?php echo elgg_echo("causes:target"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'target', 'class' => 'validate')); ?>
</div>

<div>
	<label class="label"><?php echo elgg_echo('causes:tags'); ?></label> <br />
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'id' => 'tags')); ?>
</div>

 
<div>
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('event:save'),"onclick"=>"return validate_cause(this)")); ?>
</div>
