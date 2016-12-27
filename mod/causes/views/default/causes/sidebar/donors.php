<?php
/**
 * Causes Konnectors sidebar
 *
 * @package Causes
 *
 * @uses $vars['entity'] Causes entity
 * @uses $vars['limit']  The number of Konnectors to display
 */

$limit = elgg_extract('limit', $vars, 10);

$all_link = elgg_view('output/url', array(
	'href' => 'causes/donors/' . $vars['entity']->guid.'/'.elgg_get_friendly_title($vars['entity']->title),
	'text' => elgg_echo('causes:donors:more'),
	'is_trusted' => true,
));

/*
$body = elgg_list_entities_from_relationship(array(
	'relationship' => 'causes_donor',
	'relationship_guid' => $vars['entity']->guid,
	'inverse_relationship' => false,
	'types' => 'user',
	'limit' => $limit,
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users',
));
*/
$body = causes_list_latest_donors($vars['entity']->guid);
$body .= "<div class='center mts'>$all_link</div>";

echo elgg_view_module('aside', elgg_echo('causes:donors:latest'), $body);
