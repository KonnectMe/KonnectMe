<?php
	$url_text = "Or you can";
	$pledge_page = elgg_view('output/url' , array('text' => 'Set up your pledge page', 'href' => elgg_get_logged_in_user_entity()->getURL(), 'is_safe' => true, 'target'=>'_blank'));
//	$start_fundraising = elgg_view('output/url' , array('text' => 'Start fundraising for a cause of your Non-Profit', 'href' => elgg_get_site_url()."causes/add/".elgg_get_logged_in_user_guid(), 'is_safe' => true, 'target'=>'_blank'));
	$start_donation = elgg_view('output/url' , array('text' => 'Make a donation to a Non-Profit', 'href' => elgg_get_site_url(). "event/dashboard/". $vars['event']->guid, 'is_safe' => true, 'target'=>'_blank'));
	$s_media = "Share about this event on social media";
	$icons = elgg_view('kme/entitySocialshareIcons', array('share_url' => $vars['event']->getURL()));
	$content = "
	<div>
		<div class='elgg-col-1of2 fleft'><p>{$s_media}<br>{$icons}</p></div>
		<div class='elgg-col-1of2 fright'><p>{$url_text}<br>{$pledge_page}<br>
		{$start_donation}
		</p></div>
	</div>
	";	
	echo elgg_view_module('aside', "Here is how you can further help:", $content);
?>	