<?php
/**
 * Elgg add like action
 *
 */

$entity_guid = (int) get_input('guid');

//check to see if the user has already liked the item
if (elgg_annotation_exists($entity_guid, 'likes')) {
	returnAjaxResult(false,elgg_echo("likes:alreadyliked"),$entity);
	exit;
}
// Let's see if we can get an entity with the specified GUID
$entity = get_entity($entity_guid);
if (!$entity) {
	returnAjaxResult(false,elgg_echo("likes:notfound"),$entity);
	exit;
}

// limit likes through a plugin hook (to prevent liking your own content for example)
if (!$entity->canAnnotate(0, 'likes')) {
	// plugins should register the error message to explain why liking isn't allowed
	returnAjaxResult(false);
	exit;
}

$user = elgg_get_logged_in_user_entity();
$annotation = create_annotation($entity->guid,
								'likes',
								"likes",
								"",
								$user->guid,
								$entity->access_id);

// tell user annotation didn't work if that is the case
if (!$annotation) {
	returnAjaxResult(false,elgg_echo("likes:failure"),$entity);
	exit;
}

// notify if poster wasn't owner
if ($entity->owner_guid != $user->guid) {
	likes_notify_user($entity->getOwnerEntity(), $user, $entity);
}

//system_message(elgg_echo("likes:likes"));
returnAjaxResult(true,elgg_echo("likes:likes"),$entity);
exit;





