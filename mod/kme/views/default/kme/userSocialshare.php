<?php
	$url_text = "Share your profile";
	$url = elgg_view('input/text', array('value' => elgg_view('galliPermalinks/permalink', array('entity' => elgg_get_page_owner_entity())), 'class' => 'getShortlink'));
	$s_media = "Share this page on social media";
	$icons = elgg_view('kme/entitySocialshareIcons');
	$content = "
	<div>
		<div class='elgg-col-1of2 fleft'><p>{$s_media}<br>{$icons}</p></div>
		<div class='elgg-col-1of2 fright'><p>{$url_text}<br>{$url}</p></div>
	</div>
	";	
	echo elgg_view_module('aside', "Share your profile", $content);
?>	