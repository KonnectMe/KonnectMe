<?php

// set default value
if (!isset($vars['entity']->enable_massmail)) {
	$vars['entity']->enable_massmail = 'no';
}

echo '<div>';
echo elgg_echo('gallimassmail:enable_massmail');
echo ' ';
echo elgg_view('input/dropdown', array(
	'name' => 'params[enable_massmail]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes')
	),
	'value' => $vars['entity']->enable_massmail,
));
echo '</div>';