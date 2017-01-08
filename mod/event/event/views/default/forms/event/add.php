<?php
if (elgg_is_sticky_form('event')) {
	extract(elgg_get_sticky_values('event'));
	elgg_clear_sticky_form('event');
}
$container_guid = get_input('guid',elgg_get_logged_in_user_guid());
echo elgg_view('input/hidden', array('name' => 'access_id', 'value' => 2));
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => 0));
echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));
?>
<div >
    <label class="label" ><?php echo elgg_echo("event:name"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'title','id'=>'title', 'value' => $title)); ?>
</div>

<div >
	<label class="label"><?php echo elgg_echo('event:image'); ?></label><br />
	<?php echo elgg_view('input/file', array('name' => 'icon')); ?>
</div>

<div >
	<label class="label"><?php echo elgg_echo('event:startdate'); ?></label><br />
	 <?php echo elgg_view('input/date',array('name' => 'dfrom',"id"=>'dfrom','class'=>'txt', 'value' => $dfrom)); ?>
</div>

<div >
	<label class="label"><?php echo elgg_echo('event:enddate'); ?></label><br />
	 <?php echo elgg_view('input/date',array('name' => 'dto', "id"=>'dto','class'=>'txt', 'value' => $dto)); ?>
</div>

<div >
    <label class="label"><?php echo elgg_echo("event:description"); ?></label><br />
    <?php echo elgg_view('input/longtext',array('name' => 'description', 'id'=>'description', 'value' => $description)); ?>
</div>

<div >
    <label class="label"><?php echo elgg_echo("event:brief"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'brief','id'=>'brief', 'value' => $brief)); ?>
</div>

<div>
	<label><?php echo elgg_echo('causes:category'); ?></label>
	<?php  echo elgg_view("input/dropdown", array("name" => 'category', "options_values" => event_category() , 'value' => $name)); ?>
</div>


<div >
    <label class="label"><?php echo elgg_echo("event:venue"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'venue', 'value' => $venue)); ?>
</div>

<div >
    <label class="label"><?php echo elgg_echo("event:location"); ?></label><br />
    <?php echo elgg_view('input/location',array('name' => 'location', 'value' => $location)); ?>
</div>
<?php
$past_event = get_past_events();
if(count($past_event)>1){
?>
<div >
    <label class="label"><?php echo elgg_echo("event:pastevent"); ?></label><br />
    <?php 
	echo elgg_view('input/dropdown',array('name' => 'pastevent','options_values'=>$past_event, 'value' => $pastevent)); ?>
</div>
<?php } ?>

<div>
<label><?php echo elgg_echo('event:createcause'); ?></label>
<?php echo elgg_view('input/checkbox', array('name' => 'createcause', 'id'=>'createcause')); ?>
</div>

<div>
<label><?php echo elgg_echo('event:skip_registration'); ?></label>
 <?php 
 if(!isset($skip)){
	$skip = 1;
 }
 echo elgg_view('input/checkbox', array('value' => $skip,'name' => 'skip_registration','checked' => true,));
 ?>
   
</div>

<div>
<label><?php echo elgg_echo('event:freeevent'); ?></label>
 <?php 
 if(!isset($free)){
	$free = 1;
 }
 echo elgg_view('input/checkbox', array('value' => $free,'name' => 'free','checked' => true,'onClick' => 'view_ticket(this)',));
 ?>
   
</div>

<div id="ticket_div" style="display:none">
	<label class="label"><?php echo elgg_echo('event:paypal'); ?></label> <br />
	<?php echo elgg_view('input/tags', array('name' => 'paypal', 'id' => 'paypal', 'value' => $paypal)); ?>
</div>

<div>
	<label class="label"><?php echo elgg_echo('event:tags'); ?></label> <br />
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'id' => 'tags', 'value' => $tags)); ?>
</div>


<div>
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('event:save'),"onclick"=>"return validate_event()")); ?>
</div>
