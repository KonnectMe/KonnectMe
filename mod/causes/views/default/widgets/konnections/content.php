<?php
elgg_load_library('elgg:causes');	
$owner = elgg_get_page_owner_entity();
$causes = causes_get_konnectors_causes($owner->guid);
if(!$causes){
	$all_causes_url = elgg_get_site_url()."causes/all/"; 
	echo elgg_echo('causes:notkonnectd', array($all_causes_url));
	return;
}

$selected_cause_guid = $vars['entity']->cause_guid;

$entity = $vars['entity'];
if(!$entity){
	return;
}

if($selected_cause_guid){
	$causesid = $selected_cause_guid;
	$raised = causes_payment_konnectors($causesid, $owner->guid);
	$percentage =  causes_target_percentage($causesid);
} else {
	return;
}	
$still_needed = "$".causes_amount_still_needed($causesid);

$user_goal = (int) $vars['entity']->goal;
if($user_goal > 0){
//	$raised = causes_payment_konnectors($causesid, $owner->guid);
	$percentage =  round($raised /$user_goal * 100,1);
	$still_needed = (int) $user_goal - $raised;
}
if($still_needed < 0){
	$still_needed = 0;
}

if(!$raised){
	$raised = 0;
}
$fundraised = "$".$raised;
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
echo $content;

if(check_entity_relationship($selected_cause_guid,'causes_konnector',$owner->guid)){
	$url = elgg_get_site_url()."payments/make_donation";
	echo elgg_view_form('causes/donate-widget', array('entity' => $vars['entity'],'action' => $url), array('cause_guid' => $selected_cause_guid, 'konnector_guid'=>$owner->guid));
}	