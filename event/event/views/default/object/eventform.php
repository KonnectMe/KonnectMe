<?php
$user = elgg_get_logged_in_user_entity();
$typeArray = event_formtype();
$viewtype = get_input('viewtype');
$event = elgg_extract('entity', $vars, FALSE);
$owner_id = $event->owner_guid;

$siturl=elgg_get_site_url();	
$eventguid = get_input('eventguid');
if($viewtype == 1){
	$content .= '<div class="div_content_large">'.$event->fieldname.'</div>';
	$content .= '<div class="div_content_large">'.$typeArray[$event->fieldtype].'</div>';
	$content .= '<div class="div_content_large">';
	if(!empty($event->fieldvalues)) {
		$content .= $event->fieldvalues; 
	} else { 
		$content .= '&nbsp;'; 
	}
	$content .= '</div>';
		
	$link = "action/event/deleteeventform?guid={$event->guid}&event={$eventguid}";
	$editlink = "event/editform/{$eventguid}/{$event->guid}";
	$url = elgg_get_site_url().$link;
		
	$link =  elgg_view('output/url', array('href' => $editlink,'text' => elgg_echo('event:editlink'),'is_trusted' => true,));
	$link .= '&nbsp;&nbsp;';
	$link .= elgg_view('output/confirmlink', array('is_action'=>true, 'name' => 'delete','text' => elgg_view_icon('delete'),'title' => elgg_echo('delete:this'),'href' => $url,'confirm' => elgg_echo('deleteconfirm'),'is_trusted' => true,));
	$content .= '<div class="div_content_medium">'.$link.'</div>';
	$content .= '<div style="clear:both;"></div>';
	print_r($content);
}


	//registration form
if($viewtype == 2){
	$class = '';
	$form = elgg_extract('entity', $vars, FALSE);
	$i = $vars['counter'];
	$form_data = $vars['form_data'];
	$label = $form->fieldname;
	$required = $form->required;
	$formtype = $form->fieldtype;
	$values = $form->fieldvalues;
	$fieldname = event_replace_string($label).'_'.$i;
	$fieldid = event_replace_string($label).'_'.$i;
	$field = $form->guid;
	$value = $form_data->$field; 
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

//registration information
if($viewtype == 4){
	$form = elgg_extract('entity', $vars, FALSE);
	$form_data = $vars['form_data'];
	$label = $form->fieldname;
	$values = $form->fieldvalues;
	$field = $form->guid;
	$value = $form_data->$field; 
	$formtype = $form->fieldtype;
		
	
?>
<div><label><?php	echo $label; ?></label>&nbsp;:&nbsp;
<?php	if($formtype != 10){ 
			echo $value; 
		}else{
			echo "Yes";
		}
?></div>
<?php 
}
 ?>