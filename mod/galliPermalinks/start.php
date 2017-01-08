<?php
elgg_register_event_handler('init', 'system', 'permalink_init');

function permalink_init() {	
	elgg_register_plugin_hook_handler('forward', '404', 'permalink_url_router', 0);
	elgg_register_admin_menu_item('administer', 'permalinks', 'administer_utilities');
	
	elgg_register_action('galliPermalinks/change', elgg_get_plugins_path()."galliPermalinks/actions/galliPermalinks/change.php", 'admin');
}

function permalink_url_router($hook, $type, $return, $params) {	
	$base_path = parse_url(elgg_get_site_url(), PHP_URL_PATH);	
	$current_path = parse_url($params['current_url'], PHP_URL_PATH);	
	$current_path = ($base_path == '/') ? substr($current_path,1) : str_replace($base_path, '', $current_path);	
	$parts = explode('/', $current_path);	
	if($user = get_user_by_username(str_replace('-', '.', $parts[0]))){		
		elgg_set_context('profile');		
		if (profile_page_handler(array($user->username))) {			
			exit;		
		}	
	}	
	if($entity = permalink_get_entity_from_title($parts[0])){		
		forward($entity->getURL());	
	}	
	return $return;
}

function permalink_get_entity_from_title($title = false){	
	if($title){		
		$title = elgg_get_friendly_title($title);		
		$entity = elgg_get_entities_from_metadata(array(		
						'metadata_name' => 'perma_title',			
						'metadata_value' => $title,			
						'limit' => 1,		
				));
		if($entity){			
			return $entity[0];		
		}		
	}	
	return false;
}	

function permalink_get_title($entity = null){	
	if($entity){		
		$perma_title = $entity->perma_title;
		if($perma_title){			
			return $perma_title;		
		}			
	}		
	return false;	
} 

function permalink_generate_title($entity = null, $title = false){	
	$perma_title = false;	
	if($entity){		
		if(elgg_instanceof($entity, 'user') ) {				
			$title = $entity->username;			
		} 			
		if(!$title){				
			$title = $entity->name;			
		}				
		if(!$title){				
			$title = $entity->title;			
		}				
		$title = elgg_get_friendly_title($title);			
		if( !$title or permalink_check_pagehandlers($title) or permalink_get_entity_from_title($title) ){				
			$title = $entity->getGUID();			
		}			
		$ia = elgg_set_ignore_access(true);			
		$entity->perma_title = $title;			
		$entity->save();			
		$perma_title = $entity->perma_title;		
		elgg_set_ignore_access($ia);		
	}		
	return $perma_title;
}

function permalink_check_pagehandlers($title = false) {	
	$title = elgg_get_friendly_title($title);		
	return in_array($title, elgg_get_config('pagehandler'));
}
