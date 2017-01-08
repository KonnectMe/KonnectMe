<?php
/**
 * event members
 *
 * package event
 */
$eventid = (int) get_input('eventid');

if (!empty($vars['members']) && is_array($vars['members'])) {
	$user = elgg_get_logged_in_user_entity();
	echo '<ul class="elgg-list">';
	foreach ($vars['members'] as $member) {
		$icon = elgg_view_entity_icon($member, 'tiny', array('use_hover' => 'true'));
		$member_title = elgg_view('output/url', array(
				'href' => $member->getURL(),
				'text' => $member->name,
				'is_trusted' => true,
		));
	
$body = <<<HTML
<h4>$member_title</h4>

HTML;
			

		echo '<li class="pvs">';
		echo elgg_view_image_block($icon, $body);
		echo '</li>';
		
	}
	echo '</ul>';
} else {
	echo '<p class="mtm">' . elgg_echo('event:nomember') . "</p>";
}
