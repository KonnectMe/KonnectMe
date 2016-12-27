<?php
set_input('viewtype',1);
elgg_push_breadcrumb(elgg_echo('search'));
	$tag = get_input("tag");
	$title = elgg_echo('event:search:title', array($tag));
$opertor = 'LIKE';
$opt = array('tags'=>$tag);
	//search event by tag
	$params = array(
		'metadata_name_value_pairs' => $opt,
		'metadata_name_value_pairs_operator' => $opertor,
		'type' => 'object',
		'subtype' => 'event',
		'full_view' => false,
		'list_type' => 'gallery',
		'list_type_toggle' => true,
		'view_toggle_type' => false
	);
	$content = elgg_list_entities_from_metadata($params);
	if (!$content) {
		$content = elgg_echo('event:search:none');
	}
	$sidebar = elgg_view('event/sidebar/find');

	$params = array(
		'content' => $content,
		'sidebar' => $sidebar,
		'filter' => false,
		'title' => $title,
	);

	$body = elgg_view_layout('content', $params);
	echo elgg_view_page($title, $body);
?>