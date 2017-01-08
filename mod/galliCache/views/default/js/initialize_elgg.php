<?php
	$page_owner = elgg_get_page_owner_entity();
	if ($page_owner instanceof ElggEntity) {
		$page_owner_json = array();
		foreach ($page_owner->getExportableValues() as $v) {
			$page_owner_json[$v] = $page_owner->$v;
		}
		
		$page_owner_json['subtype'] = $page_owner->getSubtype();
		$page_owner_json['url'] = $page_owner->getURL();
		
		echo 'elgg.page_owner =  ' . json_encode($page_owner_json) . ';'; 
	}
?>
