	<?php
	$param = array(
		'types' => 'group',
		'metadata_name' => 'icontime',
		'limit' => 21,
		'full_view' => false,
		'pagination' => false,
		'list_type' => 'gallery',
		'gallery_class' => 'elgg-gallery-users',
		'offset' => 0,
		'size' => 'small',
	);
	echo elgg_view_module('aside', "KonnectMe Non Profits", elgg_list_entities_from_metadata($param));
	?>	