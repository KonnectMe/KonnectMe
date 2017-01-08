<?php
if(!$vars['entity']){
	return;
}
$event_metadata = $vars['event_metadata'];
$eventid = $vars['entity']->guid;
$total_user = event_get_total_tickets_sold($vars['entity']);
$totaluser_text = elgg_echo('event:totaluser');
$event_date_text = elgg_echo('event:date');
$period = date('d-m-Y',$event_metadata->end_date);
$content = "
<div class ='fundstatus'>
	<div class='elgg-col-1of2 fundraised fleft'><p>{$totaluser_text}</p><span>{$total_user}</span></div>
	<div class='elgg-col-1of2 fundremaining fright'><p>{$event_date_text}</p><span>{$period}</span></div>
</div>
";

echo $content;
?>
