<?php
elgg_load_library('elgg:causes');
$owner = elgg_get_page_owner_entity();
$causes = causes_get_konnectors_causes($owner->guid);

$options = array();
if($causes){
	foreach($causes as $cause){
		$options[$cause->guid] = $cause->title;
	}
}	

if(!isset($vars['entity']->cause_guid) && count($options) > 0){
	$vars['entity']->cause_guid = current(array_keys($options));
}	

$params = array(
	'name' => 'params[cause_guid]',
	'value' => $vars['entity']->cause_guid,
	'options_values' => $options,
);
$dropdown = elgg_view('input/dropdown', $params);
?>
<div>
	<?php echo elgg_echo('konnections:widget:supp'); ?>:
	<?php echo $dropdown; ?>
</div>

<div>
	<?php echo elgg_echo('konnections:widget:goal'); ?>:
	<?php echo elgg_view('input/text', array('name' => 'params[goal]' , 'value' => $vars['entity']->goal));?>
</div>
