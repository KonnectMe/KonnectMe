<?php
$user = $vars['user'];
$selected = $vars['selected'];
$pages = array('add','ticket','registration','invite');
$tabs = array();
foreach($pages as $page){
	$tabs[] = array('title' => elgg_echo("event:tab:$page"),
		'url' => "#",
		'selected' => $page == $selected,
	);
}
echo elgg_view('navigation/tabs',array('tabs'=>$tabs));

?>