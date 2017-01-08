<?php
$event = elgg_get_page_owner_entity();

$header = "<span class=\"groups-widget-viewall\">{$vars['all_link']}</span>";
$header .= '<h3>' . $vars['title'] . '</h3>';

echo '<li>';
echo elgg_view_module('info', '', $vars['content'], array(
	'header' => $header,
	'class' => 'elgg-module-group',
));
echo '</li>';
