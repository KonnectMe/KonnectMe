<?php
/**
 * Event members sidebar
 *
 * @package Event
 *
  */

$limit = elgg_extract('limit', $vars, 10);
$all_link = elgg_view('output/url', array(
	'href' => 'event/members/' . $vars['entity']->guid,
	'text' => elgg_echo('event:members:more'),
	'is_trusted' => true,
));

$body = elgg_list_entities_from_relationship(array(
	'relationship' => 'event_join',
	'relationship_guid' => $vars['entity']->guid,
	'inverse_relationship' => false,
	'types' => 'user',
	'limit' => $limit,
	'pagination' => false,
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users',
));

$body .= "<div class='center mts'>$all_link</div>";

//echo elgg_view_module('aside', elgg_echo('event:members'), $body);
