	<?php
	$param = array(
		'types' => 'user',
		'metadata_name' => 'icontime',
		'limit' => 21,
		'full_view' => false,
		'pagination' => false,
		'list_type' => 'gallery',
		'gallery_class' => 'elgg-gallery-users',
		'offset' => 0,
		'size' => 'small',
		'use_hover' => false,
	);
	echo elgg_view_module('aside', "KonnectMe Members", elgg_list_entities_from_metadata($param));
	?>	