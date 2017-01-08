<?php
elgg_load_library('elgg:event');	
$event = elgg_extract('entity', $vars, FALSE);
if (!$event) {
	return;
}
$viewtype = get_input('viewtype');
$guid = $event->guid;
$event_url = $event->getURL();
$title = elgg_get_excerpt($event->title,30);
if(!$event_metadata){
	$metadata = get_events("guid=$guid");
	$event_metadata[$guid] = $metadata[0];
}

$metadata = $event_metadata[$guid];
$icontime = $metadata->icon_time;

if(!$viewtype){
	// brief view
	// echo $closedate = $event->end_date;
	$excerpt = elgg_get_excerpt($metadata->brief_description);
	if( elgg_get_context() == 'activity' ){
		if(event_closed($event)){
			$excerpt .= elgg_view('output/url', array('href' => $event->getURL(), 'class' => 'elgg-button elgg-button-action fright', 'text' => 'Registration closed'));
		} else {
			$excerpt .= elgg_view('output/url', array('href' => $event_url, 'class' => 'elgg-button elgg-button-action fright', 'text' => 'Register',));
		}
	}
	$params = array(
		'entity' => $event,
		'content' => $excerpt,
		'tags' => false,
	);
	$params = $params + $vars;
	$body = elgg_view('object/elements/summary', $params);
	$cover_url = eventCoverartURL($guid,'tiny',$icontime);
	$cover_icon = "<a href=\"{$event_url}\"><img src='{$cover_url}' alt='{$title}'/></a>";
	echo elgg_view_image_block($cover_icon, $body);
	return;
}
		
$title = "<p><a href=\"{$event_url}\">{$title}</a></p>";
$owner = $vars['entity']->getOwnerEntity();
$friendlytime = elgg_view_friendly_time($vars['entity']->time_created);
$eventCoverartURL = eventCoverartURL($guid,'medium',$icontime);
$icon = "<a href=\"{$event_url}\"><img src='{$eventCoverartURL}' alt='{$title}'/></a>";

$info = "<p class='eventwidgetdesc'>".elgg_get_excerpt($metadata->brief_description, 130)."</p>";

if ($viewtype == 1) {
	$progrees =   elgg_view('event/sidebar/progress', array('entity' => $event,'event_metadata'=>$metadata));
echo <<<HTML
<div class="event">
<div class="event_content">$title</div>
<div class="event_icon">$icon</div>
<div class="event_content">$info</div>
<div class="div_booter">$progrees</div>
</div>
HTML;
	return;
}
			
if ($viewtype == 2) {	
	$poster = $event->getOwnerEntity();
	$group = $event->getContainerEntity();
	$eventdate = split("-", $metadata->end_date);
	$excerpt = elgg_get_excerpt($metadata->description,200);
	$cover_url = eventCoverartURL($guid,'tiny',$icontime);
	$poster_icon = "<a href=\"{$event_url}\"><img src='{$cover_url}' alt='{$title}'/></a>";
	$poster_link = elgg_view('output/url', array(
		'href' => $event_url,
		'text' => $title,
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
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);
	echo elgg_view_image_block($poster_icon, $list_body);	
	return;
} 

// In group sidebar
if($viewtype == 3){
	$now = strtotime(date('Y-m-d'));
	$period_to = strtotime($event->period_to);
	// echo $event->period_to; 2013-07-14
	// brief view
	$event_url =  elgg_get_site_url()."event/join/{$event->guid}/";
	if($p_owner = elgg_get_page_owner_guid()){
		$event_url .= "?ref=$p_owner";
	}	
	// $excerpt = elgg_get_excerpt($event->brief_description);
	if(event_closed($event)){
		$excerpt = elgg_view('output/url', array('href' => $event->getURL(), 'class' => 'elgg-button elgg-button-action fright', 'text' => 'Registration closed'));
	} else {
		$excerpt = elgg_view('output/url', array('href' => $event_url, 'class' => 'elgg-button elgg-button-action fright', 'text' => 'Register',));
	}
	$params = array(
		'entity' => $event,
		'content' => $excerpt,
		'tags' => false,
	);
	$params = $params + $vars;
	$body = elgg_view('object/elements/summary', $params);
	$cover_url = eventCoverartURL($guid,'tiny',$icontime);
	$cover_icon = "<a href=\"{$event_url}\"><img src='{$cover_url}' alt='{$title}'/></a>";
	echo elgg_view_image_block($cover_icon, $body);
	return;
}
?>