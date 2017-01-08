<?php
$entity = $vars['entity'];
if(!$entity){
	return;
}
$guid = $entity->guid;
set_input('guid',$guid);
if($entity->canEdit()){
	 $content = elgg_view_form('eventupdate/add', array("enctype" => "multipart/form-data"));
}
$content .= elgg_list_annotations(array(
	'annotation_names'=>'recent_update', 
	'guid' => array($guid), 
	'limit' => 2,
	'pagination' => false,
	'reverse_order_by' => true,
	));
echo $content;
?>	