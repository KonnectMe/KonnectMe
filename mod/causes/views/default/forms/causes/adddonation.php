<?php
elgg_load_library('elgg:causes');
$guid = get_input('causesid');
$amount = causes_amounts($guid);

$konnectors = causes_get_konnectors_array($guid);
echo elgg_view('input/hidden', array('name' => 'causesid' ,'value' => $guid));


$group = elgg_get_entities_from_relationship( array(
			'relationship' => 'causes_supported',
			'relationship_guid' => $guid,
			'inverse_relationship' => FALSE
		));	
$group_guid = (int)$group[0]->guid;	
echo elgg_view('input/hidden', array('name' => 'group' ,'value' => $group_guid));

$event = elgg_get_entities_from_relationship( array(
			'relationship' => 'causes_event_supported',
			'relationship_guid' => $guid,
			'inverse_relationship' => FALSE
		));	
$event_guid = (int)$event[0]->guid;	
echo elgg_view('input/hidden', array('name' => 'event_guid' ,'value' => $event_guid));										
?>

<?php
if(count($amount) > 0){
	foreach($amount as $key => $value){ 
?>
	<div class="elgg-head">
	<div class="donateradio"> <input type="radio" name="amount" id="amount" value="<?php echo $key?>" onclick='empty_customamount()' /></div>
	<div class="donate_value">$<?php echo $key;?></div>
	<div class="donate_content" ><?php if($value !=1)echo $value;?></div>
	<div class="clear" ></div>
	</div>
<?php } 
}
?>

<div>
	<?php	
	echo '<label>'.elgg_echo("causes:custom_amount").'</label><br>';
	echo elgg_view('input/text', array('name' => 'customamount' , 'id' => 'customamount','onBlur' => 'empty_amount(this.value)'));
	?>
</div>

<div>
	<?php	
	echo '<label>'.elgg_echo("causes:name").'</label><br>';
	echo elgg_view('input/text', array('name' => 'name' , 'id' => 'name',));
	?>
</div>
<div>
	<?php	
	echo '<label>'.elgg_echo("causes:email").'</label><br>';
	echo elgg_view('input/text', array('name' => 'email' , 'id' => 'email',));
	?>
</div>

<div>
	<?php	
	echo '<label>'.elgg_echo("causes:transaction").'</label><br>';
	echo elgg_view('input/text', array('name' => 'paypal' , 'id' => 'paypal',));
	?>
</div>

<div>
 <?php 
	echo elgg_view('input/checkbox', array('name' => 'konnector' ,'id' => 'konnector','onchange' => 'open_konnector(this)'));
	echo elgg_echo('causes:select:konnector');
	echo "<br>";	
	echo elgg_view('input/checkbox', array('name' => 'anonymous' , 'id' => 'anonymous',));
	echo elgg_echo('causes:anonymous');
	echo "<br>";	
							
	?>
</div>

<div class="invisible_div" id="konnectordiv">
	<?php echo elgg_view('input/dropdown', array('name' => 'konnector_id' ,'id' => 'konnector_id', 'options_values' => $konnectors, 'class' => 'form_select', 'value' => 0)); ?>
</div>	    
    
<div>
    <?php echo elgg_view('input/submit', array('value' => 'Add to donations',"onclick"=>"causes_donate(this)")); ?>
</div>