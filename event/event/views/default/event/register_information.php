<?php
$event = $vars['event'];
$form = $vars['forms'];
$purchased = $vars['purchase'];
$i = $vars['index'];
$acc_image = 'plus.gif';

$ticket_guid = (int)$purchased->ticket_guid;
$group_guid = $purchased->group_guid;
$info_id = $purchased->id;

$viewform = elgg_view('event/form_template',array("entity" => $vars));
$content = '';

if($ticket_guid){
	$ticket_table = elgg_get_config('dbprefix')."events_tickets";
	$event_ticket = get_data("select *from $ticket_table where id=$ticket_guid");
	$content .= "<div><label>".elgg_echo('event:ticket')."</label> : ".$event_ticket[0]->title."</div>";
}
/*
sponser
*/
if($group_guid){
	$group_table = elgg_get_config('dbprefix')."groups_entity";
	$group = get_data("select name from $group_table where guid=$group_guid");
	$content .= "<div><label>".elgg_echo('event:nppartners')."</label> : ".$group[0]->name."</div>";
}



/*
checking is it purchased or not
*/	
$content .= $viewform;
$html = "<p class='fleft'>". $content."</p>";
$entity_guid = (int) $purchased->id;
$no = $i+1;
$css = '';
$plusimage = '<img src="'.$vars['url'].'mod/event/graphics/'.$acc_image.'" id="event_image_'.$i.'">';
$edit_url = elgg_get_site_url() . "event/edit_info/{$event->guid}/{$entity_guid}";
$header_edit = '<span class="event_form_delete"><a href="'.$edit_url.'">'.elgg_echo('event:editlink').'</a></span>';
$title = $plusimage.'&nbsp;'.elgg_echo('event:ticketform',array($no,$status)); 
$header = elgg_view('output/url', array('href' => "#$no",'rel' => 'toggle', 'onclick' => 'event_show_tab(this)', 'text' => $title, 'class' => 'fleft ticketno'.$hcc, 'alt' => $i,)).$header_edit;
$content = elgg_view_image_block($image,$html, array('id' => $no, 'class' => 'hidden '.$divopen.' ticke_'.$css));
echo elgg_view_module('info', $header, $content,array('id'=>'event_info_'.$i));			
?>
