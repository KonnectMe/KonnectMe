<?php
elgg_load_library('elgg:event');	
$event = elgg_extract('entity', $vars, FALSE);
$event_metadata = elgg_extract('event_metadata', $vars, FALSE);
$full_view = elgg_extract('full_view', $vars, FALSE);
if (!$event) {
	return;
}
$guid = $vars['entity']->guid;
if(!$event_metadata){
	$metadata = get_events("guid=$guid");
	$event_metadata[$guid] = $metadata[0];
}

$metadata = $event_metadata[$guid];
$icontime = $metadata->icon_time;
	
if (!$full_view) {
	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = elgg_view_friendly_time($vars['entity']->time_created);
	$url = eventCoverartURL($guid, 'medium', $icontime);
	$icon = "<a href=\"{$vars['entity']->getURL()}\"><img src='{$url}' alt='{$vars['entity']->title}'/></a>";
	$title = "<p><a href=\"{$vars['entity']->getURL()}\">{$vars['entity']->title}</a></p>";
	$info = "<p><a href=\"{$vars['entity']->getURL()}\">".elgg_get_excerpt($event->description,130)."</a></p>";
echo <<<HTML
<div class="event">
<div class="event_content">$title</div>
<div class="event_icon">$icon</div>
<div class="event_content">$info</div>
</div>
HTML;
			
}
		
		
if ($full_view) {	
	$poster = $event->getOwnerEntity();
	$group = $event->getContainerEntity();
	$eventdate = split("-", $event->period_from);
	$excerpt = elgg_get_excerpt($event->description,200);
	
	$poster_icon = elgg_view_entity_icon($poster, 'tiny');
	$poster_link = elgg_view('output/url', array(
		'href' => $poster->getURL(),
		'text' => $poster->name,
		'is_trusted' => true,
	));
	$poster_text = elgg_echo('groups:started', array($poster->name));
	
	$tags = elgg_view('output/tags', array('tags' => $event->tags));
	$date = elgg_view_friendly_time($event->time_created);
	// brief view
	$subtitle = "$poster_text $date $replies_link <span class=\"groups-latest-reply\">$reply_text</span>";
	
	$params = array(
			'entity' => $event,
			'subtitle' => $subtitle,
			'tags' => $tags,
			'content' => $excerpt,
		);
		
	$monthname = event_MonthName($eventdate[1]);
//	$poster_icon = '<div class="causes_img"><div>'.$monthname.'</div><div>'.$eventdate[0].'</div></div>';

	$guid = $vars['entity']->guid;
	$url = eventCoverartURL($guid,'tiny',$icontime);
	$poster_icon = "<a href=\"{$vars['entity']->getURL()}\"><img src='{$url}' alt='{$vars['entity']->title}'/></a>";


	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);
	echo elgg_view_image_block($poster_icon, $list_body);
	
} 
?>

