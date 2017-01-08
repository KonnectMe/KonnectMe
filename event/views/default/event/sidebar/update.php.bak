<?php
/**
 * Event update
 * showing in sidebar
 * @package Event
 */
$all_link = elgg_view('output/url', array(
	'href' => 'event/update/' . $vars['entity']->guid,
	'text' => elgg_echo('eventupdate:more:all'),
	'is_trusted' => true,
));

$content = elgg_view('eventupdate/update', $vars);
$content .= "<div class='center mts'>$all_link</div>";
										
echo elgg_view_module('aside', elgg_echo('event:update'), $content);


