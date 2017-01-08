<?php
/**
 * Causes Donors
 *
 * @uses $vars['entity']
 */


$causes = $vars['entity'];


$all_link = elgg_view('output/url', array(
	'href' => "causes/donors/$causes->guid",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));

elgg_push_context('widgets');
$content = elgg_list_entities_from_relationship(array(
		'relationship' => 'causes_donor',
		'relationship_guid' => $causes->getGUID(),
		'inverse_relationship' => false,
		'limit' => 6,
	));

elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('causes:donor:none') . '</p>';
}
echo elgg_view('event/profile/module', array(
	'title' => elgg_echo('causes:donors'),
	'content' => $content,
	'all_link' => $all_link,
	
));