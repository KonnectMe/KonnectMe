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
	if(!elgg_is_logged_in()){
		echo elgg_view_module('aside', elgg_echo("login"), elgg_view_form('login'));
	} else {
		$friends = elgg_list_entities_from_relationship(array(
			'relationship' => 'friend',
			'relationship_guid' =>elgg_get_logged_in_user_guid(),
			'inverse_relationship' => FALSE,
			'type' => 'user',
			'full_view' => FALSE,
			'limit' => 12,
			'list_type' => 'gallery',
			'gallery_class' => 'elgg-gallery-users',
			'size' => 'small',
		));
		echo elgg_view_module('aside',  elgg_echo('friends'), $friends);
	}
?>	

<?php
$groups = elgg_get_entities(array(
	'types' => 'group',
	'limit' => 10,
	'full_view' => FALSE,
	'limit' => 12,
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users',
	'size' => 'small',
));
if ($groups) {
	foreach($groups as $group){
		$group_icons .= elgg_view_entity_icon($group, 'small', array( 'class' => 'fleft with_border'));
	}	
}
echo elgg_view_module('aside', elgg_echo("linenElgg::newestgroups"), $group_icons);
?>

<?php
//	echo elgg_view_module('aside', elgg_echo("linenElgg:advertisement"), elgg_view('ads/slot1'));
?>	

<?php
	$online =  find_active_users(600, 10);
	$users = "";
	if ($online) {
		foreach($online as $member){
			$users .= elgg_view_entity_icon($member, 'small', array('class' => 'fleft'));
		}	
	}
	echo elgg_view_module('aside', elgg_echo('members:label:online'), $users);
?>	