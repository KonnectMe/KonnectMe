<?php
$counter = get_input('counter');

$content = elgg_view('importdb/event_purchase',array('counter'=>$counter));
$title = elgg_echo('Event Purchase');
$body = elgg_view_layout('content', array(
	'filter' => false,
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => "",
));
echo elgg_view_page($title, $body);	
?>

