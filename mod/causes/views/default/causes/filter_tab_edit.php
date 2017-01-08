<?php
$causes = $vars['causes'];
$selected = $vars['selected'];
$pages = array('edit','amount','statistics','adddonation');
$tabs = array();
foreach($pages as $page){
	$tabs[] = array('title' => elgg_echo("causes:$page"),
		'url' => "causes/$page/".$causes->guid,
		'selected' => $page == $selected,
	);
}
echo elgg_view('navigation/tabs',array('tabs'=>$tabs));
?>