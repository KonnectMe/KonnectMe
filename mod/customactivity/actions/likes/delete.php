<?php
/**
 * Elgg delete like action
 *
 */

$entity_guid = (int) get_input('guid');
$entity = get_entity($entity_guid);
if (!$entity) {
	returnAjaxResult(false,elgg_echo("likes:notdeleted"),$entity);
	exit;
}


$likes = elgg_get_annotations(array(
	'guid' => (int) get_input('guid'),
	'annotation_owner_guid' => elgg_get_logged_in_user_guid(),
	'annotation_name' => 'likes',
));
if ($likes) {
	if ($likes[0]->canEdit()) {
		$likes[0]->delete();
		//system_message(elgg_echo("likes:deleted"));
		returnAjaxResult(true,elgg_echo("likes:deleted"),$entity);
		exit;
	}
}

returnAjaxResult(false,elgg_echo("likes:notdeleted"),$entity);
exit;






