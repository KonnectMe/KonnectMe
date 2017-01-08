<?php
	$url_text = "Or share this link";
	$url = elgg_view('input/text', array('value' => elgg_view('galliPermalinks/permalink', $vars), 'class' => 'getShortlink'));
	$s_media = "Share this page on social media";
	$icons = elgg_view('kme/entitySocialshareIcons');
	$content = "
	<div>
		<div class='elgg-col-1of2 fleft'><p>{$s_media}<br>{$icons}</p></div>
		<div class='elgg-col-1of2 fright'><p>{$url_text}<br>{$url}</p></div>
	</div>
	";	
	echo elgg_view_module('aside', "Spread the word", $content);
?>	