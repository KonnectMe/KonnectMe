<?php
/**
 * Event sponser sidebar
 *
 * @package Event
 *
 */

$limit = elgg_extract('limit', $vars, 10);

$all_link = elgg_view('output/url', array(
	'href' => 'event/sponser/' . $vars['entity']->guid,
	'text' => elgg_echo('event:sponser:more'),
	'is_trusted' => true,
	'class' => 'elgg-button elgg-button-action',
));
/*
$sponsers = elgg_get_entities_from_relationship(array(
	'relationship' => 'event_sponser',
	'relationship_guid' => $vars['entity']->guid,
	'inverse_relationship' => false,
	'limit' => $limit,
));
$content = '';

foreach($sponsers as $sponser){
	$icon = elgg_view_entity_icon($sponser, 'tiny', array('use_hover' => 'true'));
	$body =  elgg_view('output/url', array(
				'href' => $sponser->getURL(),
				'text' => $sponser->name,
				'is_trusted' => true,
			));
	
	$content .= elgg_view_image_block($icon, $body, array('image_alt' => $alt));		
}
*/
$content .= "<div class='center mts'>$all_link</div>";
echo elgg_view_module('aside', elgg_echo('event:sponser', array($vars['entity']->title)), $content);
?>

