<?php

jquery_ui_load_time_picker();

if (isset($vars['class'])) {
    $vars['class'] = "jquery_ui-timepicker {$vars['class']}";
} else {
    $vars['class'] = "jquery_ui-timepicker";
}

$defaults = array(
    'value' => '',
    'disabled' => false,
);

$vars = array_merge($defaults, $vars);

// convert timestamps to text for display
if (is_numeric($vars['value'])) {
    //$vars['value'] = gmdate('Y-m-d', $vars['value']);
}

$attributes = elgg_format_attributes($vars);
echo "<input type=\"text\" $attributes />";

?>