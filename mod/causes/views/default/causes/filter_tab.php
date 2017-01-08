<?php
$user = $vars['user'];
$selected = $vars['selected'];
$pages = array('add','amount','statistics');
$tabs = array();
foreach($pages as $page){
	$tabs[] = array('title' => elgg_echo("causes:$page"),
		'url' => "#",
		'selected' => $page == $selected,
	);
}
echo elgg_view('navigation/tabs',array('tabs'=>$tabs));

?>