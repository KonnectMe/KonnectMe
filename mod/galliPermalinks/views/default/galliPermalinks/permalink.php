<?php
	$entity = $vars['entity'];
	if(!$entity){
		$entity = $vars['user'];
	}
	if(!$entity){
		return;
	}
	$pl = permalink_get_title($entity); 
	if(!$pl){
		$pl = permalink_generate_title($entity);
	}	
	$url = elgg_get_site_url() .  $pl . "/";
	if (elgg_instanceof($entity, 'group') ) {
		$url .= "?ref=".$entity->guid;
	}
	echo $url;
?>	