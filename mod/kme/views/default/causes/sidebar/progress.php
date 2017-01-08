<?php
$causesid = $vars['entity']->guid;
$percentage =  causes_target_percentage($causesid);
$raised = causes_amount_raised($causesid);
if(!$raised){
	$raised = 0;
}
$fundraised = "$".$raised;
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
echo elgg_view_module('aside', elgg_echo('causes:raise'), $content);
?>