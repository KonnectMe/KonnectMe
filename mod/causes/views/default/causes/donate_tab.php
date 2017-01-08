<?php
$page_owner = elgg_get_page_owner_entity();
$causes = $vars['causes'];
$selected = $vars['selected'];
$pages = array('donate','payment','donation');
$tabs = array();



foreach($pages as $page){

		$title = elgg_get_friendly_title($causes->title);
		//$url = "causes/$page/".$causes->guid.'/'.$title;
		$url = '#';
		if($selected !=$page){
			$url = '#';
		}
		$tabs[] = array('title' => elgg_echo("causes:$page"),
						'url' => $url,
						'selected' => $page == $selected,
		);
}
echo elgg_view('navigation/tabs',array('tabs'=>$tabs));
?>