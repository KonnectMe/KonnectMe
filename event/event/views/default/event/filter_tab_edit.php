<?php
$event = $vars['event'];
$selected = $vars['selected'];
$pages[] = 'edit';
$guid = (int) $event->guid;
$event_metadata = get_events("guid=$guid");
if(!$event_metadata[0]->isfree){
	$pages[] = 'ticket';
}
$pages[] = 'registration';
$pages[] = 'invite';

$tabs = array();
foreach($pages as $page){
	$tabs[] = array('title' => elgg_echo("event:tab:$page"),
		'url' => "event/$page/".$event->guid,
		'selected' => $page == $selected,
	);
}
echo elgg_view('navigation/tabs',array('tabs'=>$tabs));
?>