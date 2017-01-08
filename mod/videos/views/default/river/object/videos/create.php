<?php
/**
 * New videos river entry
 *	Author : Sarath C | Team Webgalli
 *	Team Webgalli | Elgg developers and consultants
 *	Mail : webgalli@gmail.com
 *	Web	: http://webgalli.com | http://plugingalaxy.com
 *	Skype : 'team.webgalli' or 'drsanupmoideen'
 *	@package Elgg-videos
 * 	Plugin info : Upload/ Embed videos. Save uploaded videos in youtube and save your bandwidth and server space
 *	Licence : GNU2
 *	Copyright : Team Webgalli 2011-2015
 */
elgg_load_library('elgg:videos:embed');

$object = $vars['item']->getObjectEntity();
$excerpt = elgg_get_excerpt($object->description);

$video_url = $object->video_url;
$guid = $object->getGUID();

echo elgg_view('river/item', array(
	'item' => $vars['item'],
	'message' => $excerpt,
	'attachments' => videoembed_create_embed_object($video_url, $guid, 400),
));
