<?php
/**
 * Elgg delete like action
 *
 */

$likeid= (int) get_input('likeid');
$like=elgg_get_annotation_from_id($likeid);
if (!$like) {
	returnAjaxResult(false,elgg_echo("likes:notdeleted"));
	exit;	
}

$entity_guid =$like->entity_guid;
$entity = get_entity($like->entity_guid);
if (!$entity) {
	returnAjaxResult(false,elgg_echo("likes:notdeleted"),$entity);
	exit;
}

if (elgg_delete_annotation_by_id($likeid)) {
		returnAjaxResult(true,elgg_echo("likes:deleted"),$entity);
}
else 
	returnAjaxResult(false,elgg_echo("likes:notdeleted"),$entity);
exit;





