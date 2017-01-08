<?php
/**
 * event category
 *
 * @package Event
 */

$body = '';
$category = event_category(false);
foreach($category as $cat){
	$body .=  elgg_view('output/url', array(
				'href' => "event/all/".elgg_get_friendly_title($cat),
				'text' => ucfirst($cat),
				'is_trusted' => true,
			))."<br>";;	
	}
echo elgg_view_module('aside', elgg_echo('event:filterby'), $body);
