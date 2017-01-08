<?php
	elgg_load_library('elgg:causes');
	$guid = get_input('causesid');
	$causes = get_entity($guid);
	if (!$causes) {
		forward('causes/all');
	}

	causes_register_profile_buttons($causes);
	elgg_push_breadcrumb($causes->title);
	
	elgg_set_page_owner_guid($causes->owner_guid);	
	$content =  elgg_view('causes/profile/layout', array('entity' => $causes));
	$comments =  elgg_view('causes/profile/widgets', array('entity' => $causes));
	$sidebar =  elgg_view('causes/sidebar/sidebar', array('entity' => $causes));	

	$params = array(
		'sidebar' => $sidebar,
		'filter_override' => false,
		'filter_context' => 'all',
		'title' => $causes->title,
		'content' => $content,
		'comments' => $comments,	
		'wrap' => false,
	);

	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($causes->title, $body);
?>