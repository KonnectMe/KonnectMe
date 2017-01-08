<?php
elgg_load_library('elgg:causes');	
$causes = elgg_extract('entity', $vars, FALSE);
//print_r($causes);
if (!$causes) {
	return;
}

$viewtype = get_input('viewtype');
if(!$viewtype){
	// brief view
	$excerpt = elgg_get_excerpt($causes->brief_description);
	if( elgg_get_context() == 'activity' ){
		$excerpt .= elgg_view('output/url', array('href' => $causes->getURL(), 'class' => 'elgg-button elgg-button-action fright', 'text' => 'Konnect'));
	}
	$params = array(
		'entity' => $causes,
		'content' => $excerpt,
		'tags' => false,
	);
	$params = $params + $vars;
	$body = elgg_view('object/elements/summary', $params);
	$cover_url = causesCoverartURL($causes->guid,'tiny');
	$cover_icon = "<a href=\"{$causes->getURL()}\"><img src='{$cover_url}' alt='{$causes->title}'/></a>";
	echo elgg_view_image_block($cover_icon, $body);
	return;
}


if ($viewtype == 1) {
	$causes = elgg_extract('entity', $vars, FALSE);
    $owner = $vars['entity']->getOwnerEntity();
	$friendlytime = elgg_view_friendly_time($vars['entity']->time_created);
	$guid = $vars['entity']->guid;
	$url = causesCoverartURL($guid,'medium');
	$icon = "<a href=\"{$vars['entity']->getURL()}\"><img src='{$url}' alt='{$vars['entity']->title}'/></a>";
	$title = elgg_get_excerpt($vars['entity']->title,30);
	$title = "<p><a href=\"{$vars['entity']->getURL()}\">{$title}</a></p>";
	$info = "<p class='eventwidgetdesc'>".elgg_get_excerpt($causes->brief_description,80)."</p>";
	$causesid = $vars['entity']->guid;		
	$percentage =  causes_target_percentage($causesid);
	$fundraised = "$".causes_amount_raised($causesid);
	$still_needed = "$".causes_amount_still_needed($causesid);
	$fundraised_text = elgg_echo('kme:fundraised');
	$still_needed_text = elgg_echo('kme:fundstill_needed');
	$content = "
	<div class='progress progress-striped active'>
	<div class='bar' style='width: {$percentage}%;'></div>
	<div class='fund-percentage'>{$percentage}%</div>
	</div>
	<div class ='fundstatus'>
	<div class='elgg-col-1of2 fundraised fleft'><p>{$fundraised_text}</p><span>{$fundraised}</span></div>
	<div class='elgg-col-1of2 fundremaining fright'><p>{$still_needed_text}</p><span>{$still_needed}</span></div>
	</div>
	";

echo <<<HTML
<div class="event">
<div class="event_content">$title</div>
<div class="event_icon">$icon</div>
<div class="event_content">$info</div>
<div class="div_booter">$content</div>
</div>
HTML;
}

if ($viewtype == 2) {	
	$poster = $causes->getOwnerEntity();
	$group = $causes->getContainerEntity();
	$excerpt = elgg_get_excerpt($causes->description,200);
	$poster_icon = elgg_view_entity_icon($group, 'tiny');
	$poster_link = elgg_view('output/url', array(
		'href' => $poster->getURL(),
		'text' => $poster->name,
		'is_trusted' => true,
	));
	
	$poster_text = elgg_echo('groups:started', array($poster->name));
	$tags = elgg_view('output/tags', array('tags' => $causes->tags));
	$date = elgg_view_friendly_time($causes->time_created);
	
	$subtitle = "$poster_text $date $replies_link <span class=\"groups-latest-reply\">$reply_text</span>";
	$params = array(
			'entity' => $causes,
			'subtitle' => $subtitle,
			'tags' => $tags,
			'content' => $excerpt,
	);
	
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);
	echo elgg_view_image_block($poster_icon, $list_body);	
}
?>