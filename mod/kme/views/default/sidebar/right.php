<?php
/**
 *	Linen Theme for Elgg - A 1.8 premium theme for Elgg
 *	Author : Mahin Akbar | Team Webgalli
 *	Team Webgalli | Elgg developers and consultants
 *	Mail : info@webgalli.com
 *	Web	: http://webgalli.com
 *	Skype : 'team.webgalli'
 *	@package linenElgg plugin
 *	Licence : GPLV2
 *	Copyright : Team Webgalli 2011-2015
 */
?>
<?php
//	echo elgg_view_module('aside', elgg_echo("kme:advertisement"), elgg_view('ads/slot2'));
?>	

<?php
$newest_members = elgg_list_entities_from_metadata(array(
	'metadata_names' => 'icontime',
	'types' => 'user',
	'limit' => 20,
	'full_view' => false,
	'pagination' => false,
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users',
	'size' => 'tiny',
));
echo elgg_view_module('aside',  elgg_echo('members:label:newest'), $newest_members);
?>

<?php
if(!elgg_get_config('tag_cloud_loaded')){
	echo elgg_view_module('aside',  elgg_echo('tagcloud'),  elgg_view('page/elements/tagcloud_block', array('nowrap' => true)));
}
?>

<?php
if(!elgg_get_config('comments_block_loaded')){
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
	echo elgg_view_module('aside',  elgg_echo('kme:recentlycommented'), $body);
}
?>
