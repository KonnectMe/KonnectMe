<?php
/**
 *	Elgg Business theme
 *	Author : Mohammed Aqeel | Team Webgalli
 *	Team Webgalli | Elgg developers and consultants
 *	Mail : info@webgalli.com
 *	Web	: http://webgalli.com
 *	Skype : 'team.webgalli'
 *	@package galliBusinesstheme plugin
 *	Licence : Commercial
 *	Copyright : Team Webgalli 2011-2015
 */
if(elgg_is_logged_in()){
	forward('activity/');
}	
$body = elgg_view_layout('kmet_index', array());
// no RSS feed with a "widget" front page
global $autofeed;
$autofeed = FALSE;
echo elgg_view_page("", $body);
