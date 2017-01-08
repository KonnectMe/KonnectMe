<?php
/**
 * Causes update
 * showing in sidebar
 * @package Causes
 */
$all_link = elgg_view('output/url', array(
	'href' => 'causes/update/' . $vars['entity']->guid,
	'text' => elgg_echo('eventupdate:more:all'),
	'is_trusted' => true,
));

$content = elgg_view('eventupdate/update', $vars);
$content .= "<div class='center mts'>$all_link</div>";
										
echo elgg_view_module('aside', elgg_echo('causes:update'), $content);


