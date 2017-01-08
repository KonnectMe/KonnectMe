	<?php
	$param = array(
		'type' => 'object',
		'subtype' => 'news',
		'limit' => 5,
		'full_view' => false,
		'pagination' => false,
	);
	echo elgg_view_module('aside', "KonnectMe News", elgg_list_entities($param));
	?>	