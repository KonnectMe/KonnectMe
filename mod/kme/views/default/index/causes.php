<?php
set_input('viewtype',1);
$category = strtolower(get_input('category', 'general'));

$param = array(
	'type' => 'object',
	'subtype' => 'causes',
	'limit' => 3,
	'full_view' => false,
	'list_type' => 'gallery',
	'view_toggle_type' => false,
	'metadata_name_value_pairs' => array('category' => $category),
	'pagination' => false,
);
$items = elgg_list_entities_from_metadata($param);
if($items){
	echo $items;
} else {
	echo "<div class='index_empty_list'>No items to show.</div>";
}	
?>
