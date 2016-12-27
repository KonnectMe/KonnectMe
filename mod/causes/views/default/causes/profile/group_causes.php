<?php
/**
 * Group Causes
 *
 
 */

set_input('viewtype',2);
$causes = $vars['entity'];


$all_link = elgg_view('output/url', array(
	'href' => "causes/group/$causes->guid/all",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));

elgg_push_context('widgets');
$options = array(
	'type' => 'object',
	'subtype' => 'causes',
	'container_guid' => elgg_get_page_owner_guid(),
	'limit' => 6,
	'full_view' => false,
	'pagination' => false,
);
$content = elgg_list_entities($options);

elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('causes:nocauses') . '</p>';
}

$new_link = elgg_view('output/url', array(
	'href' => "causes/add/$causes->guid",
	'text' => elgg_echo('causes:add'),
	'is_trusted' => true,
));

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('causes:groupcauses'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
	
));