<?php
$guid = (int) get_input('causesid');
$causes= get_entity($guid);

if($causes){
	
	$content = elgg_view_form('causes/donation', array("enctype" => "multipart/form-data"));
}else{
	$content = elgg_echo('cause:nocause');
}

elgg_set_page_owner_guid($causes->owner_guid);	

$title = elgg_echo('causes:donate');
$sidebar =  elgg_view('causes/sidebar/sidebar', array('entity' => $causes));

$body = elgg_view_layout('content', array(
	'sidebar' => $sidebar,
	'filter_override' => elgg_view('causes/donate_tab',array('selected'=>'donation','causes' => $causes)),
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);