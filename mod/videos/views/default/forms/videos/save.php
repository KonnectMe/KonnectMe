<?php
/**
 * Edit / add a video
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

// once elgg_view stops throwing all sorts of junk into $vars, we can use extract()
$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$video_url =  elgg_extract('video_url', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = elgg_extract('container_guid', $vars);
$guid = elgg_extract('guid', $vars, null);
?>


<div>
<?php echo $embed_url; ?>
	<label><?php echo elgg_echo('title'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title)); ?>
</div>
<?php if (!$guid) { ?>
<style type="text/css"> 
#embed, #upload { 
	display: none; 
} 
</style> 
<script type="text/javascript">
function Toggle(theDiv) {
document.getElementById("embed").style.display = "none";
document.getElementById("upload").style.display = "none";
document.getElementById(theDiv).style.display = "block";
}
</script>

<input type="radio" name="radios" onclick="Toggle('embed');" value="embed"/><?php echo elgg_echo('videos:embed');?> 
<input type="radio" name="radios" onclick="Toggle('upload');" value="upload"/><?php echo elgg_echo('videos:upload');?>
<div id="embed">
	<label><?php echo elgg_echo('videos:embedurl'); ?></label><br />
	<?php echo elgg_view('input/url', array('name' => 'video_url', 'value' => $video_url)); ?>
</div>
<div id="upload">
	<label><?php echo elgg_echo('videos:file'); ?></label><br />
	<?php echo elgg_view('input/file', array('name' => 'upload')); ?>
</div>

<?php }elseif ($guid) { ?>
<div id="embed">
	<label><?php echo elgg_echo('videos:embedurl'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'video_url', 'value' => $video_url)); ?>
</div>
<?php } ?>

<div>
	<label><?php echo elgg_echo('description'); ?></label>
	<?php echo elgg_view('input/plaintext', array('name' => 'description', 'value' => $desc)); ?>
</div>
<div>
	<label><?php echo elgg_echo('tags'); ?></label>
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => $tags)); ?>
</div>
<?php

$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}

?>
<div>
	<label><?php echo elgg_echo('access'); ?></label><br />
	<?php echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id)); ?>
</div>
<div>
<?php

echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
}

echo elgg_view('input/submit', array('value' => elgg_echo("save")));

?>
</div>