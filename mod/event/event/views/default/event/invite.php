<?php
/**
 *  event invitations
 *
 * package event
 */

$eventid = (int) get_input('eventid');

if (!empty($vars['invitations']) && is_array($vars['invitations'])) {
	echo "<h3>Pending invitations</h3>";
	$user = elgg_get_logged_in_user_entity();
	echo '<ul class="elgg-list">';
	foreach ($vars['invitations'] as $group) {
		$icon = elgg_view_entity_icon($group, 'tiny', array('use_hover' => 'true'));
		$group_title = elgg_view('output/url', array(
				'href' => $group->getURL(),
				'text' => $group->name,
				'is_trusted' => true,
		));

		$url = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/event/invite_kill?group_guid={$group->guid}&event_guid={$eventid}");
		$delete_button = elgg_view('output/url', array(
					'href' => $url,
					'text' => elgg_echo('delete'),
					'class' => 'elgg-button elgg-button-delete mlm',
		));

			$body = <<<HTML
<h4>$group_title</h4>
<p class="elgg-subtext">$group->briefdescription</p>
HTML;
		$alt = $delete_button;
		echo '<li class="pvs">';
		echo elgg_view_image_block($icon, $body, array('image_alt' => $alt));
		echo '</li>';
	}
	echo '</ul>';
} else {
		echo '<p class="mtm">' . elgg_echo('event:noinvite') . "</p>";
}
