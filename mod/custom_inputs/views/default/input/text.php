<?php

jquery_ui_validate();

if (isset($vars['class'])) {
    $vars['class'] = "elgg-input-text {$vars['class']}";
} else {
    $vars['class'] = "elgg-input-text";
}

$defaults = array(
    'value' => '',
    'disabled' => false,
    'type' => 'text'
);

$vars = array_merge($defaults, $vars);

?>
<input <?php echo elgg_format_attributes($vars); ?> />