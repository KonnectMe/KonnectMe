<?php
elgg_load_library('elgg:causes');
$offset = (int) get_input('offset');
$causesid = (int) get_input('causesid');

$causes = get_entity($causesid);

$owner_guid = $causes->owner_guid;
$page_owner = get_entity($owner_guid);
elgg_set_page_owner_guid($causes->owner_guid);	

if($causes){
	elgg_push_breadcrumb($causes->title,'causes/view/'.$causes->guid.'/'.elgg_get_friendly_title($causes->title));
	elgg_push_breadcrumb(elgg_echo('causes:konnectors'));
	$members = causes_get_konnectors($causes->guid, FALSE);
	$content ='<table width="100%" cellspacing="5" cellpadding="5" class="highlighted konnectorstable">
					<tr class="tableheader">
						<td>Konnectors</td>
						<td>Amount</td>
						<td>Percentage of goal</td>
					</tr>';
	$content .= elgg_view('causes/konnectors', array('members' => $members));
	$content .='</table>';

}else{
	$content = elgg_echo('causes:nocauses');
}

$title = sprintf(elgg_echo('causes:konnectorsof'), $causes->title);
$sidebar =  elgg_view('causes/sidebar/sidebar', array('entity' => $causes));

$body = elgg_view_layout('content', array(
	'sidebar' => $sidebar,
	'filter_override' => false,
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
?>
