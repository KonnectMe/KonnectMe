<?php

$pastevents = elgg_get_entities_from_relationship(array(
	'relationship' => 'past_event',
	'relationship_guid' => $vars['entity']->guid,
	'inverse_relationship' => false,
	'limit' => 1,
	'full_view' => false,
	'pagination' => false,
	'offset' => 0,
));

if($pastevents){
	$content = '<div class="center mts">';
	$content .= elgg_view('output/url', array( 'href' => 'event/dashboard/'.$pastevents[0]->guid, 'class'=>'elgg-button elgg-button-action', 'text'=>$pastevents[0]->title . ' dashboard'));
	$content .= "</div>";
	//echo elgg_view_module('aside', elgg_echo('event:pastevent'), $content);
}
?>