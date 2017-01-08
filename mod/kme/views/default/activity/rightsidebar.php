<style type="text/css">
.elgg-sidebar {
	margin-top: 20px;
}
</style>
<?php
gatekeeper();
$loggedin_user = elgg_get_logged_in_user_entity();
$username = $loggedin_user->username;
$logged_in = false;
if(elgg_is_logged_in()){
	$logged_in = true;
}	

$title = "Register for featured events";

$date = array();
$date['name'] = 'period_to';
$date['value'] = date('Y-m-d');
$date['operand'] = '>';

$events = elgg_list_entities_from_metadata(array(
		'type' => 'object',
		'subtype' => 'event',
		'limit' => 3,
		'full_view' => false,
		'pagination' => false,
		'offset' => 0,
		'metadata_name_value_pairs' => $date,
));
echo elgg_view_module('featured', $title, $events);

$title = "Newest members";
$newest_members = elgg_list_entities_from_metadata(array(
		'types' => 'user',
		'metadata_name' => 'icontime',
		'limit' => 21,
		'list_type' => 'gallery',
		'gallery_class' => 'elgg-gallery-users',
		'full_view' => false,
		'pagination' => false,
		'offset' => 0,
));
echo elgg_view_module('featured', $title, $newest_members);
?>


<?php
	$online =  find_active_users(600, 10);
	$users = "";
	if ($online) {
		foreach($online as $member){
			$users .= elgg_view_entity_icon($member, 'small', array('class' => 'fleft'));
		}	
	}
	echo elgg_view_module('featured', elgg_echo('members:label:online'), $users);
?>	

<?php
/*
foreach($purchased_tickets as $t){
	$relationship = 'event_join_sponser_'.$t->container_guid;
	// event_join_sponser_44353
	$body .= elgg_list_entities_from_relationship(array(
						'relationship' => $relationship,
						'relationship_guid' => $t->guid,
						'inverse_relationship' => false,
						'full_view' => false,
						'pagination' => false,
						'offset' => 0,
				));
}
if($body){
	echo elgg_view_module('featured', 'Suggested causes' , $body);
}
*/
?>

<?php
//echo elgg_view_module('aside', elgg_echo("kme:advertisement"), elgg_view('ads/slot3'));

$comments = elgg_get_annotations(array(
	'annotation_name' => 'generic_comment',
	'reverse_order_by' => true,
	'limit' => 4,
	'type' => 'object',
	'pagination' => false,
));
if ($comments) {
	$body = elgg_view('page/components/list', array(
		'items' => $comments,
		'pagination' => false,
		'list_class' => 'elgg-latest-comments',
		'full_view' => false,
	));
} else {
	$body = '<p>' . elgg_echo('generic_comment:none') . '</p>';
}
echo elgg_view_module('featured',  elgg_echo('kme:recentlycommented'), $body);
?>