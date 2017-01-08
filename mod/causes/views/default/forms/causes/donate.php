<?php
$guid = get_input('causesid');

$cause = get_entity($guid);
$date = $cause->enddate;
$end_ts = strtotime($date);
if($end_ts < time()){
	echo '<div class="cause_sup_np_info center">'.elgg_echo('cause:expired').'</div>';
	return;
}

elgg_load_library('elgg:causes');
$amount = causes_amounts($guid);

$konnectors = causes_get_konnectors_array($guid);
echo elgg_view('input/hidden', array('name' => 'causesid' ,'value' => $guid));

$group = elgg_get_entities_from_relationship( array(
			'relationship' => 'causes_supported',
			'relationship_guid' => $guid,
			'inverse_relationship' => FALSE
		));	
if(!($group)){
	return;
}
	
$group_guid = (int)$group[0]->guid;	
echo elgg_view('input/hidden', array('name' => 'group' ,'value' => $group_guid));

$event = elgg_get_entities_from_relationship( array(
			'relationship' => 'causes_event_supported',
			'relationship_guid' => $guid,
			'inverse_relationship' => FALSE
		));	
$event_guid = (int) $event[0]->guid;	
echo elgg_view('input/hidden', array('name' => 'event' ,'value' => $event_guid));											

// $now = time();
?>

<div class="cause_sup_np_info">
<?php 
	$tax = $group[0]->tax;
	$url = "<a href='{$group[0]->getURL()}'>{$group[0]->name}</a>";
	echo elgg_echo('causes:supported',array($url));
	echo "<br>";
	echo elgg_echo('causes:tax')." : ".$tax;
?>
</div>

<?php
if(count($amount) > 0){
	foreach($amount as $key => $value){ 
?>
		<div class="elgg-head">
		<div class="donate_radio"> <input type="radio" name="amount" id="amount" value="<?php echo $key?>" onclick='empty_customamount()' /></div>
		<div class="donate_value">$<?php echo $key;?></div>
		<div class="donate_content" ><?php if($value !=1)echo $value;?></div>
		<div class="clear" ></div>
		</div>
<?php } 
}
?>

<div>
	<?php	
	echo '<label>'.elgg_echo("causes:customamount").'</label><br>';
	echo elgg_view('input/text', array('name' => 'customamount' , 'id' => 'customamount','onBlur' => 'empty_amount(this.value)'));
	?>
</div>

<div>
 <?php 
	echo elgg_view('input/checkbox', array('name' => 'konnector' , 
											'id' => 'konnector',
											'onchange' => 'open_konnector(this)'));
	echo elgg_echo('causes:select:konnector');
	echo "<br>";	
	echo elgg_view('input/checkbox', array('name' => 'anonymous' , 
											'id' => 'anonymous',));
	echo elgg_echo('causes:anonymous');
	echo "<br>";										
	?>
</div>

<div class="invisible_div" id="konnectordiv">
<?php echo elgg_view('input/dropdown', array(
										'name' => 'konnector_id' ,
										'id' => 'konnector_id', 
										'options_values' => $konnectors, 
										'class' => 'form_select',
										'value' => 0)); ?>
</div>	    
    
<div align="center">
	<?php echo $button = '<img src="'.$vars['url'].'mod/causes/graphics/btn_donate_LG.gif" onclick="causes_donate(this)">';?>
</div>