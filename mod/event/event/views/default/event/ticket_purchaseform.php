<?php
$event = $vars['event'];
$form = $vars['forms'];
$ticket = $vars['tickets'];
$purchased = $vars['purchase'];
$count = $vars['count'];
$i = $vars['index'];
$newticket = $vars['newticket'];

$free = $event->free;
$skip = $event->skip;
$divopen = '';
$hcc = '';
$acc_image = 'plus.gif';
if($newticket){
	$divopen = 'event_open';
	$hcc = ' elgg-state-active';
	$acc_image = 'minus.gif';
}


$viewform = elgg_view('event/form_template',array("entity" => $vars));
$tickets = elgg_view('event/ticket_template',array("entity" => $vars));
/*
checking is it purchased or not
*/	
$ispurchased = false;
$status = '';		
if($purchased){
	$status = elgg_echo('event:saved');
		if($purchased->status == 1){
			$status = elgg_echo('event:purchased');
			$ispurchased = true;
		}
}


$content = elgg_view('event/join_form',array(
				"event" => $event,
				'i'=>$i, 
				'form' => $viewform, 
				'ticket' => $tickets, 
				'form_data' => $purchased,
			));


$html = "<p class='fleft'>". $content."</p>";

$entity_guid = (int) $purchased->id;
$image = "";
$delete_url = "";
if(!$ispurchased){
	$delimage = '<img src="'.$vars['url'].'mod/event/graphics/delete.png">';
	if($i != 0){
		$delete_url = '<a   onclick="event_form_delete('.$i.')"  title="Delete">'.$delimage.'</a>';
	}
	if($purchased ){
		$url = elgg_get_site_url() . "action/event/delete_join_tickt?guid={$entity_guid}";
		$delete_url = elgg_view('output/confirmlink', array('text' => elgg_view_icon('delete'),'href' => $url,'confirm' => elgg_echo('delete:this'), 'title' => elgg_echo('delete:this')));
	}
}			

$no = $i+1;
$css = '';
if($count == $no){
	$css = 0;
	$acc_image = 'minus.gif';
	$hcc = ' elgg-state-active';
}
if($skip){
	$css = 0;
}

$plusimage = '<img src="'.$vars['url'].'mod/event/graphics/'.$acc_image.'" id="event_image_'.$i.'">';
$header_delete = '<span class="event_form_delete">'.$delete_url.'</span>';
$title = $plusimage.'&nbsp;'.elgg_echo('event:ticketform',array($no,$status)); 
$header = elgg_view('output/url', array('href' => "#$no",'rel' => 'toggle', 'onclick' => 'event_show_tab(this)', 'text' => $title, 'class' => 'fleft ticketno'.$hcc, 'alt' => $i,)).$header_delete;
if($skip){
	$header = '';
}
$content = elgg_view_image_block($image,$html, array('id' => $no, 'class' => 'hidden '.$divopen.' ticke_'.$css));
echo elgg_view('input/hidden', array('name' => 'entityguid_'.$i ,'id' => 'entity_guid_'.$i, 'value' => $entity_guid));	
if($i != 0 && $skip){
	return;
}

if(!$free){
	echo elgg_view_module('info', $header, $content,array('id'=>'event_info_'.$i));			
}else{
	echo $content;
}
?>
