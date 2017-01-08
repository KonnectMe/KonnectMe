<?php
/**
 * Elgg messageboard widget view
 *
 */

$owner = elgg_get_page_owner_entity();

$num_display = $vars['entity']->num_display;

$url = "causes/owner/$owner->username";

echo elgg_view('output/url', array(
	'href' => $url,
	'text' => elgg_echo('causes:all'),
	'is_trusted' => true,
));