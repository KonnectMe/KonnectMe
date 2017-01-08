<?php
/**
 *	galliMassmail
 *	Author : Raez Mon | Team Webgalli
 *	Team Webgalli | Elgg developers and consultants
 *	Mail : info@webgalli.com
 *	Web	: http://webgalli.com
 *	Skype : 'team.webgalli'
 *	@package galliMassmail plugin
 *	Licence : GPLv2
 *	Copyright : Team Webgalli 2011-2015
 */
 // unset($vars['gmm_container_guid']);
$gmm_container_guid = (int) get_input('gmm_container_guid');

elgg_load_library('elgg:event');
$dropdown = event_ticket_form_fields($gmm_container_guid);

?>
<div>
	<?php
		echo 'Please select the email field';
		echo elgg_view('input/dropdown', array('name' => 'email_field', 'options_values' => $dropdown));
	?>
</div>

<div>
	<?php
		echo elgg_echo('galliMassmail:subject');
		echo elgg_view('input/text', array('name' => 'subject', 'value' => $name));
	?>
</div>

<div>
	<?php	
		echo 'Introductory text';
		echo elgg_view('input/longtext', array('name' => 'message', 'value' => $message));
	?>	
</div>	

<div>
	<?php	
		echo "Append ticket details to the mail?";
		$options = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));
		echo elgg_view('input/dropdown', array('name' => 'append_ticket', 'options_values' => $options));
	?>
</div>

<?php 
	if($gmm_container_guid){ 
		echo elgg_view('input/hidden', array('name' => 'gmm_container_guid', 'value' => $gmm_container_guid));
	}
?>	
<div>
	<?php
		echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('galliMassmail:submit')));
	?>
</div>	
