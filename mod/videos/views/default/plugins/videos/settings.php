<?php
/**
 * Videos plugin settings
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

// set default value
if (!isset($vars['entity']->default_tag)) {
	$vars['entity']->default_tag = strtolower($vars['config']->site->name);
}
if (!isset($vars['entity']->source)) {
	$vars['entity']->source = strtolower($vars['config']->site->name);
}
if (!isset($vars['entity']->service)) {
	$vars['entity']->service = 'youtube';
}
if (!isset($vars['entity']->application_id)) {
	$vars['entity']->application_id = 'Elgg Videos Plugin';
}

?>
<p>
	<h4><?php echo elgg_echo('Enter the licence key of this product. You can get the licence key from <a href="http://webgalli.com/pg/groups/2831/videos-plugin-for-elgg-18/">here</a>'); ?>: </h4>
	<?php
		echo elgg_view('input/text', array('name' => 'params[elgg_videos_licencekey]', 'value' => $vars['entity']->elgg_videos_licencekey ));
	?>
</p>
<p>
	<h4><?php echo elgg_echo('video:label:youtubeusername'); ?>: </h4>
	<?php
		echo elgg_view('input/text', array('name' => 'params[username]', 'value' => $vars['entity']->username ));
	?>
</p>


<p>
	<h4><?php echo elgg_echo('video:label:password'); ?>: </h4>
	<?php
		echo elgg_view('input/password', array('name' => 'params[password]', 'value' => $vars['entity']->password ));
	?>
</p>

<p>
	<h4><?php echo elgg_echo('video:label:developer_key'); ?>: </h4>
	<?php
		echo elgg_view('input/text', array('name' => 'params[developer_key]', 'value' => $vars['entity']->developer_key ));
	?>
</p>

<p>
	<h4><?php echo elgg_echo('video:label:service'); ?>: </h4>
	<?php
		echo elgg_view('input/text', array('name' => 'params[service]', 'value' =>  'youtube' ));
	?>
</p>

<p>
	<h4><?php echo elgg_echo('video:label:application_id'); ?>: </h4>
	<?php
		echo elgg_view('input/text', array('name' => 'params[application_id]', 'value' =>  'Elgg Videos plugin' ));
	?>
</p>

<p>
	<h4><?php echo elgg_echo('video:label:source'); ?>: </h4>
	<?php
		echo elgg_view('input/text', array('name' => 'params[source]', 'value' =>  'Elgg' ));
	?>
</p>

<p>
	<h4><?php echo elgg_echo('video:label:default_tag'); ?>: </h4>
	<?php
		echo elgg_view('input/text', array('name' => 'params[default_tag]', 'value' =>  $vars['entity']->default_tag ));
	?>
</p>