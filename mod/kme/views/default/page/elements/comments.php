<?php
/**
 * List comments with optional add form
 *
 * @uses $vars['entity']        ElggEntity
 * @uses $vars['show_add_form'] Display add form or not
 * @uses $vars['id']            Optional id for the div
 * @uses $vars['class']         Optional additional class for the div
 */

$show_add_form = elgg_extract('show_add_form', $vars, true);

$id = '';
if (isset($vars['id'])) {
	$id = "id=\"{$vars['id']}\"";
}

$class = 'elgg-comments';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

// work around for deprecation code in elgg_view()
unset($vars['internalid']);

$body = "<div $id class=\"$class\">";

if (!elgg_is_logged_in()){
	$body .= '<p class="logintocomment">' . elgg_echo('kme:logintocomment' , array(SITE_URL.'login', SITE_URL.'register')) . '</p>';
}	

$options = array(
	'guid' => $vars['entity']->getGUID(),
	'annotation_name' => 'generic_comment'
);
$html = elgg_list_annotations($options);

if ($html) {
//	echo '<h3>' . elgg_echo('comments') . '</h3>';
	$body .= $html;
}

if ($show_add_form) {
	$form_vars = array('name' => 'elgg_add_comment');
	$body .= elgg_view_form('comments/add', $form_vars, $vars);
}

$body .= '</div>';

echo elgg_view_module('info', '<h3>' . elgg_echo('comments') . '</h3>', $body);