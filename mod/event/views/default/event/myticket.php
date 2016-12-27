<?php
$user = elgg_get_logged_in_user_entity();
$offset = (int) get_input('offset');
$content = elgg_list_entities_from_relationship(array(
	'relationship' => 'event_join',
	'inverse_relationship' => true,
	'type' => 'object',
	'subtype' => 'event',
	'limit' => 9,
	'offset' => $offset,
	"relationship_guid"=>$user->guid,
	'full_view' => false,
	'list_type' => 'gallery',
	'list_type_toggle' => true,
	'view_toggle_type' => false
));

if (!$content) {
	$content = elgg_echo('event:none');
}

echo $content;
?>
