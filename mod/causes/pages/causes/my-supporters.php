<?php
set_input('viewtype',1);
$guid = (int) get_input('guid');
if(!$guid){
	forward();
}	
elgg_register_title_button();
$user = get_user($guid);
$offset = (int) get_input('offset');
$limit = 20;

if($user){
	$table = CAUSES_DB_TABLE;
	$query = " select count(id) as cnt from $table where konnectorid = $guid ";
	$data = get_data($query);
	$count = $data[0]->cnt;

	$query = " select * from $table where konnectorid = $guid order by id desc limit $offset,$limit ";
	$data = get_data($query);
	$content = elgg_view('causes/my-supporters',array('offset' => $offset, 'limit' => $limit, 'data' => $data, 'count' => $count, 'pagination' => true));
} else {
	$content = 'No users found';
}

$sidebar = elgg_view('causes/sidebar/find');

$body = elgg_view_layout('content', array(
	'filter_override' => false,
	'filter_context' => 'all',
	'content' => $content,
	'title' => 'My supporters',
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);