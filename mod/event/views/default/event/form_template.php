<?php
$class = '';
$form_data = $vars['entity']['forms'];
$i = (int)$vars['entity']['index'];
$purchased = $vars['entity']['purchase'];
$saved_data = array();

if($purchased){
	$purchased_id = (int)$purchased->id;
	$userinfo_table = elgg_get_config('dbprefix')."events_purchase_userinfo";
	$userinfo = get_data("select *from $userinfo_table where purchase_guid=$purchased_id");
	foreach($userinfo as $info){
		$saved_data[$info->form_guid] = $info->value;
	}
}

foreach($form_data as $form){
	$form_data = $vars['form_data'];
	$label = $form->title;
	$required = $form->required;
	$formtype = $form->type;
	$values = $form->default_values;
	$fieldname = event_replace_string($label).'_'.$i;
	$fieldid = event_replace_string($label).'_'.$i;
	$field = $form->id;
	$value = $saved_data[$field]; 
		if($required == 1){
				$class = 'validate '.$i;
		}
	$labelid = "label_".event_replace_string($label);	
	
	?>
	<?php if($formtype == 1){  ?>
	<div class="event_field_half_width"><label id="<?php echo $labelid ?>"><?php echo $label; ?></label><br />
	<?php echo elgg_view('input/text', array('name' => $fieldname , 'id' => $fieldid, 'value' => $value, 'class' => $class));?></div>
	<?php } ?>
	
	<?php if($formtype == 2){ ?>
	<div class="event_field_half_width"><label id="<?php echo $labelid ?>"><?php	echo $label; ?></label><br />
	<?php echo elgg_view('input/plaintext', array('name' => $fieldname , 'id' => $fieldid, 'value' => $value, 'class' => $class));?></div>
	<?php } ?>
	
	<?php if($formtype == 3){ 
	$optionvalue = 'Select,'.$values;
	$option = event_radio_option(split(",", $optionvalue));?>
	<div class="event_field_half_width"><label id="<?php echo $labelid ?>"><?php	echo $label; ?></label><br />
	<?php echo elgg_view('input/dropdown', array('name' => $fieldname , 'id' => $fieldid, 'options_values' => $option, 'class' => "form_select $class", 'value' => $value));?></div>
	<?php } ?>
	
	<?php if($formtype == 4){
		$option = event_radio_option(split(",",$values));
		?>
	<div><label id="<?php echo $labelid ?>"><?php	echo $label; ?></label><br />
	<?php echo elgg_view('input/radio', array('name' => $fieldname,'id' => $fieldid,'value' => $value,'options' => $option, 'checked'=>$value, 'class' =>  $class, 'align' => 'horizontal',));?></div>
	<?php } ?>
	 
	<?php if($formtype == 5){
		$option = event_radio_option(split(",",$values));
		?>
	<div><label id="<?php echo $labelid ?>"><?php	echo $label; ?></label><br />
	<?php 
	$selected_values = split(",", $value);
	echo elgg_view('input/checkboxes', array(
			'options' => $option,
			'value' => $selected_values,
			'name' => $fieldname,
			'id' => $fieldid,
			'align' => 'horizontal',
			'class' => $class
		));
	?>
	
	</div>
	<?php } ?>
	
	<?php if($formtype == 6){  ?>
	<div class="event_field_half_width"><label id="<?php echo $labelid ?>"><?php	echo $label; ?></label><br />
	<?php echo elgg_view('input/text', array('name' => $fieldname , 'id' => $fieldid, 'value' => $value, 'class' => $class));?></div>
	<?php } ?>
	
	
	<?php if($formtype == 7){  ?>
	<div class="event_field_half_width"><label id="<?php echo $labelid ?>"><?php	echo $label; ?></label><br />
	<?php echo elgg_view('input/text', array('name' => $fieldname , 'id' => $fieldid, 'value' => $value, 'class' => $class));?></div>
	<?php } ?>
	
	<?php if($formtype == 8){  ?>
	<div class="event_field_half_width"><label id="<?php echo $labelid ?>"><?php	echo $label; ?></label><br />
	<?php echo elgg_view('input/text', array('name' => $fieldname , 'id' => $fieldid, 'value' => $value, 'class' => $class));?></div>
	<?php } ?>
	
	<?php if($formtype == 9){  ?>
	<div class="event_field_half_width"><label id="<?php echo $labelid ?>"><?php	echo $label; ?></label><br />
	<?php echo elgg_view('input/date', array('name' => $fieldname , 'id' => $fieldid, 'value' => $value, 'class' => $class));?></div>
	<?php } ?>
<?php 
}
?>
