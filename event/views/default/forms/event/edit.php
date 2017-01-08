<?php
$eventid = get_input('eventid');
$event = $vars['event_metadata'][0];

echo elgg_view('input/hidden', array('name' => 'access_id', 'value' => 2));
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $eventid));
?>


<div >
    <label class="label" ><?php echo elgg_echo("event:name"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'title','id'=>'title', 'value' => $event->title)); ?>
</div>

<div >
	<label class="label"><?php echo elgg_echo('event:image'); ?></label><br />
	<?php echo elgg_view('input/file', array('name' => 'icon')); ?>
</div>

<div >
	<label class="label"><?php echo elgg_echo('event:startdate'); ?></label><br />
	<?php echo elgg_view('input/date',array('name' => 'dfrom',"id"=>'dfrom','class'=>'txt', 'value' => $event->start_date)); ?>
 
</div>

<div >
	<label class="label"><?php echo elgg_echo('event:enddate'); ?></label><br />
    <?php echo elgg_view('input/date',array('name' => 'dto',"id"=>'dto','class'=>'txt', 'value' => $event->end_date)); ?>
</div>

<div >
    <label class="label"><?php echo elgg_echo("event:time"); ?></label><br />
    <?php echo elgg_view('input/time',array('name' => 'time', 'value' => $event->time)); ?>
</div>
<div >
    <label class="label"><?php echo elgg_echo("event:description"); ?></label><br />
    <?php echo elgg_view('input/longtext', array('name' => 'description','id'=>'description', 'value' => $event->description)); ?>
</div>

<div >
    <label class="label"><?php echo elgg_echo("event:brief"); ?></label><br />
    <?php echo elgg_view('input/text', array('name' => 'brief','id'=>'brief', 'value' => $event->brief_description)); ?>
</div>

<div>
	<label><?php echo elgg_echo('causes:category'); ?></label>
	<?php  echo elgg_view("input/dropdown", array("name" => 'category', "options_values" => event_category() ,"value" => $event->category)); ?>
</div>

<div >
    <label class="label"><?php echo elgg_echo("event:venue"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'venue', 'value' => $event->venue)); ?>
</div>

<div >
    <label class="label"><?php echo elgg_echo("event:location"); ?></label><br />
    <?php echo elgg_view('input/location',array('name' => 'location', 'value' => $event->location)); ?>
</div>
<?php
$past_event = get_past_events($eventid);
if(count($past_event)>1){
?>
    <div >
        <label class="label"><?php echo elgg_echo("event:pastevent"); ?></label><br />
        <?php 
         echo elgg_view('input/dropdown',array('name' => 'pastevent','options_values'=>$past_event, 'value' => $event->related_event_guid)); 
		?>
    </div>
<?php } ?>

<div>
<label><?php echo elgg_echo('event:createcause'); ?></label>
<?php 
$checked = false;
if($event->fundraising){
	$checked = true;
}
echo elgg_view('input/checkbox', array('name' => 'createcause', 'id'=>'createcause', 'checked'=>$checked )); ?>
</div>

<div>
<label><?php echo elgg_echo('event:skip_registration'); ?></label>
 <?php 
 $checked = false;
 if($event->skip){
	$checked = true;
 }
 echo elgg_view('input/checkbox', array('name' => 'skip_registration','checked' => $checked,));
 ?>
   
</div>

 
<div>
<label><?php echo elgg_echo('event:freeevent');  ?></label>
<?php 
$checked = false;
if($event->isfree){
	$checked = true;
}
echo elgg_view('input/checkbox', array('value' => 1,'name' => 'free','checked' => $checked , 'onClick' => 'view_ticket(this)',));?>
</div>

<div id="ticket_div" style="display:<?php if($event->isfree) echo "none"; ?>">
	<label class="label"><?php echo elgg_echo('event:paypal'); ?></label> <br />
	<?php echo elgg_view('input/tags', array('name' => 'paypal', 'id' => 'paypal', 'value' => $event->paypal)); ?>
</div>

<div>
	<label class="label"><?php echo 'Close registrations for this event?'; ?></label>  
	<?php
	$checked = false;
	if($event->blocked){
		$checked = true;
	}
	echo elgg_view('input/checkbox', array('name' => 'eventclosed', 'id'=>'eventclosed', 'checked'=>$checked ));
	?>
</div>

<div>
	<label class="label"><?php echo elgg_echo('event:tags'); ?></label> <br />
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'id' => 'tags', 'value' => $event->tags)); ?>
</div>

 
<div>
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('event:save'),"onclick"=>"return validate_event()")); ?>
     <?php

	$delete_url = 'action/event/delete?guid=' . $event->guid;
	echo elgg_view('output/confirmlink', array(
		'text' => elgg_echo('event:delete'),
		'href' => $delete_url,
		'confirm' => elgg_echo('event:deletewarning'),
		'class' => 'elgg-button elgg-button-delete float-alt',
	));

?>
</div>
