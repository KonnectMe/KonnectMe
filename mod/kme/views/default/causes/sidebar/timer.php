<?php
/**
 * Causes Timer
 *
 * @package Causes
 *
 * @uses $vars['entity'] Causes entity
 * @uses $vars['limit']  The number of Konnectors to display
 */

$date = $vars['entity']->enddate;
$end_ts = strtotime($date);

$now = strtotime("now");
if( ($end_ts - $now) > 99 *86400 ){
	return;
}
	
if($end_ts > time()){
	$remaining = $end_ts - time();
	$date_format = get_count_dowm_values($remaining);
} else {
	$date_format = array(
		"d" => "00",
		"h" => "00",
		"m" => "00",
		"s" => "00",
	);
}	

$content = elgg_view('kme/timer', array('date_format'=>$date_format));

echo elgg_view_module('aside', elgg_echo('causes:countdown'), $content);
?>