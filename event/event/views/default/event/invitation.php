<?php
/**
 *  event request
 *
 * package event
 */
if (!empty($vars['invitations']) && is_array($vars['invitations'])) {
	
	$user = elgg_get_logged_in_user_entity();
	$groupguid = (int) get_input('groupguid');
	echo '<ul class="elgg-list">';
	foreach ($vars['invitations'] as $event) {
		$metadata = get_events("guid=".$event->guid);
		$icontime = $metadata[0]->icon_time;
		$url = eventCoverartURL($event->guid, 'tiny', $icontime);
		$icon = "<a href=\"{$event->getURL()}\"><img src='{$url}' alt='{$event->title}'/></a>";
		$event_title = elgg_view('output/url', array(
							'href' => $event->getURL(),
							'text' => $event->title,
							'is_trusted' => true,
						));

	$url = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/event/invite_accept?group_guid={$groupguid}&event_guid={$event->guid}");
	$accept_button = elgg_view('output/url', array(
						'href' => $url,
						'text' => elgg_echo('accept'),
						'class' => 'elgg-button elgg-button-submit',
						'is_trusted' => true,
					));
	$url = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/event/invite_kill?group_guid={$groupguid}&event_guid={$event->getGUID()}");
	$delete_button = elgg_view('output/url', array(
						'href' => $url,
						'text' => elgg_echo('delete'),
						'class' => 'elgg-button elgg-button-delete mlm',
					));
			
			$label = elgg_echo('event:reg_fee').' : '.$event->fee;
			$label .= "&nbsp;,&nbsp;";
			$label .= elgg_echo('event:revenue').' : '.$event->revenue;

			$body = <<<HTML
<h4>$event_title</h4>
<p class="elgg-subtext">$event->description</p>
<p class="elgg-subtext">$label</p>

HTML;
		$alt = $accept_button . $delete_button;
		echo '<li class="pvs">';
		echo elgg_view_image_block($icon, $body, array('image_alt' => $alt));
		echo '</li>';
		
	}
	echo '</ul>';
} else {
	echo '<p class="mtm">' . elgg_echo('event:noinvite') . "</p>";
}
