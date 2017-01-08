<?php
/**
 * Add bookmark page
 *
 * @package Bookmarks
 */

$page_owner_guid = (int) get_input('pageowner_guid');
if(!$page_owner_guid){
	forward();
}

$group = get_entity($page_owner_guid);
elgg_set_page_owner_guid($page_owner_guid);

if (!$group->canEdit()) {
	register_error('Sorry, you are not authorized for this');
	forward();
}

$title = elgg_echo('gallimassmail:mailall');
elgg_push_breadcrumb($group->name, $group->getURL());
elgg_push_breadcrumb($title);

set_input('gmm_container_guid', $page_owner_guid); 
$content = elgg_view('galliMassmail/galliMassmail');

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);