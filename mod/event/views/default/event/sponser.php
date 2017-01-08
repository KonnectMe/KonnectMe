<?php
/**
 * event sponsers
 *
 * package event
 */
$eventid = (int) get_input('eventid');
$event = get_entity($eventid);
if (!empty($vars['sponsers']) && is_array($vars['sponsers'])) {
	$user = elgg_get_logged_in_user_entity();
	echo '<ul class="elgg-list elgg-list-entity">';
	foreach ($vars['sponsers'] as $group) {
			$icon = elgg_view_entity_icon($group, 'tiny', array('use_hover' => 'true'));
			$group_title = elgg_view('output/url', array(
				'href' => $group->getURL(),
				'text' => $group->name,
				'is_trusted' => true,
			));
			if (elgg_is_logged_in() && $event->canEdit()) {
			$url = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/event/cancel_sponser?group_guid={$group->guid}&event_guid={$eventid}");
			$delete_button = elgg_view('output/url', array(
					'href' => $url,
					'text' => elgg_echo('event:sponser:cancel'),
					'class' => 'elgg-button elgg-button-delete mlm',
			));
			}
			$body = <<<HTML
<h4>$group_title</h4>
<p class="elgg-subtext">$group->briefdescription</p>
HTML;
			$alt = $delete_button;
			echo '<li class="elgg-item pvs">';
			echo elgg_view_image_block($icon, $body, array('image_alt' => $alt));
			echo '</li>';
	}
	echo '</ul>';
} else {
		echo '<p class="mtm">' . elgg_echo('event:sponsers:none') . "</p>";
}
echo elgg_view('navigation/pagination',array('count'=>$vars['count'], 'offset' => $vars['offset'], 'limit' => $vars['limit']  ));	
?>