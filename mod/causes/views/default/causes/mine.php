<?php
$user = elgg_get_logged_in_user_entity();
$offset = (int) get_input('offset');
$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'causes',
	'limit' => 9,
	'offset' => $offset,
	"owner_guid"=>$user->guid,
	'full_view' => false,
	'list_type' => 'gallery',
	'list_type_toggle' => true,
	'view_toggle_type' => false
));

if (!$content) {
	$content = elgg_echo('causes:none');
}

		
echo $content;







?>
