<?php
$event = $vars['entity'];
$event_metadata = $vars['event_metadata'][0];

if(!$event){
	return;
}	
$selected = get_input('filter', 'about');
$pages = array();
$pages['about'] = $event->getURL();
					
if(!$event_metadata->isfree){
	$pages['register'] = elgg_get_site_url()."event/join/".$event->guid;
}

$tabs = array();
foreach($pages as $k=>$v){
	$tabs[] = array('title' => ucfirst($k),
		'url' => $v,
		'selected' => $k == $selected,
	);
}
echo elgg_view('navigation/tabs',array('tabs'=>$tabs));
?>