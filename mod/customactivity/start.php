<?php
/*
 *
 * Custom Activity
 *
 * @author RiverVanRain
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 * @copyright (c) subwebZ 2k13
 *
 * @link http://weborganizm.org/crewz/p/1983/personal-net
 *
 */
 
function customactivity_init() {

	elgg_extend_view('css/elgg', 'customactivity/css');
	elgg_extend_view('css/elgg', 'likes/css');
	elgg_extend_view('js/elgg', 'likes/js');
	
	elgg_register_plugin_hook_handler('register', 'menu:river', 'likes_river_menu_setup', 400);
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'likes_entity_menu_setup', 400);

	$actions_base = elgg_get_plugins_path() . 'customactivity/actions/likes';
	elgg_register_action('likes/add', "$actions_base/add.php");
	elgg_register_action('likes/delete', "$actions_base/delete.php");
	elgg_register_action('likes/deletebylikeid', "$actions_base/deletebylikeid.php");	
	
	elgg_register_plugin_hook_handler('register', 'menu:river', 'customactivity_river_menu_handler');
	
	elgg_extend_view('js/elgg', 'comments/js');
	elgg_register_ajax_view('comments/singleriver');	
	elgg_register_action('comments/add', elgg_get_plugins_path()."customactivity/actions/comments/add.php");	
	
	elgg_register_plugin_hook_handler('view', 'navigation/pagination', 'customactivity_view_paginator_hook');
	
	$pagination_js = elgg_get_simplecache_url('js', 'pagination');
	elgg_register_simplecache_view('js/pagination');
	elgg_register_js('elgg.pagination',$pagination_js);
	elgg_load_js('elgg.pagination');
}

function customactivity_river_menu_handler($hook, $type, $items, $params) {
	$item = $params['item'];

	$object = $item->getObjectEntity();
	if (!elgg_in_context('widgets') && !$item->annotation_id && $object instanceof ElggEntity) {
		
		if (elgg_is_active_plugin('likes') && $object->canAnnotate(0, 'likes')) {
			if (!elgg_annotation_exists($object->getGUID(), 'likes')) {
				// user has not liked this yet
				$options = array(
					'name' => 'like',
					'href' => "action/likes/add?guid={$object->guid}",
					'text' => elgg_view_icon('thumbs-up'),
					'title' => elgg_echo('likes:likethis'),
					'is_action' => true,
					'priority' => 100,
				);
			} else {
				// user has liked this
				$options = array(
					'name' => 'like',
					'href' => "action/likes/delete?guid={$object->guid}",
					'text' => elgg_view_icon('thumbs-up-alt'),
					'title' => elgg_echo('likes:remove'),
					'is_action' => true,
					'priority' => 100,
				);
			}
			
			$items[] = ElggMenuItem::factory($options);
		}

	}

	return $items;
}

function customactivity_view_paginator_hook($hook, $type, $return, $params) {
    if (!empty($return)) {
        return elgg_view('wmp/navigation/pagination', array_merge($params, array('hidden_paginator' => $return)));
    }
}

function likes_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];

	// likes button
	$options = array(
		'name' => 'likes',
		'text' => elgg_view('likes/button', array('entity' => $entity)),
		'href' => false,
		'priority' => 1000,
	);
	$return[] = ElggMenuItem::factory($options);

	// likes count
	$count = elgg_view('likes/count', array('entity' => $entity));
	if ($count || true) {
		$options = array(
			'name' => 'likes_count',
			'text' => $count,
			'href' => false,
			'priority' => 1001,
		);
		$return[] = ElggMenuItem::factory($options);
	}

	return $return;
}

/**
 * Add a like button to river actions
 */
function likes_river_menu_setup($hook, $type, $return, $params) {
	if (elgg_is_logged_in()) {
		$item = $params['item'];

		// only like group creation #3958
		if ($item->type == "group" && $item->view != "river/group/create") {
			return $return;
		}

		// don't like users #4116
		if ($item->type == "user") {
			return $return;
		}
		
		$object = $item->getObjectEntity();
		if (!elgg_in_context('widgets') && $item->annotation_id == 0) {
			if ($object->canAnnotate(0, 'likes')) {
				// like button
				$options = array(
					'name' => 'likes',
					'href' => false,
					'text' => elgg_view('likes/button', array('entity' => $object)),
					'is_action' => true,
					'priority' => 100,
				);
				$return[] = ElggMenuItem::factory($options);

				// likes count
				$count = elgg_view('likes/count', array('entity' => $object));
				if ($count) {
					$options = array(
						'name' => 'likes_count',
						'text' => $count,
						'href' => false,
						'priority' => 101,
					);
					$return[] = ElggMenuItem::factory($options);
				}
			}
		}
	}

	return $return;
}

/**
 * Count how many people have liked an entity.
 *
 * @param  ElggEntity $entity
 *
 * @return int Number of likes
 */
function likes_count($entity) {
	$type = $entity->getType();
	$params = array('entity' => $entity);
	$number = elgg_trigger_plugin_hook('likes:count', $type, $params, false);

	if ($number) {
		return $number;
	} else {
		return $entity->countAnnotations('likes');
	}
}

/**
 * Return the json result to front end AJAX call
 *
 * @param  bool $isSuccessful
 * @param  String $msg
 * @param  ElggEntity $entity
 *
 */
function returnAjaxResult($isSuccessful = true, $msg = "",$entity = null) {
	if ($entity) {
		$button = elgg_view('likes/button', array('entity' => $entity));
		$count = elgg_view('likes/count', array('entity' => $entity));
		$json = array('success' => $isSuccessful,'message'=>$msg,'guid'=>$entity->guid,'button'=>$button,'count'=>$count);
	}
	else
		$json = array('success' => $isSuccessful,'message'=>$msg);
	echo json_encode($json);
}

/**
 * Notify $user that $liker liked his $entity.
 *
 * @param type $user
 * @param type $liker
 * @param type $entity 
 */
function likes_notify_user(ElggUser $user, ElggUser $liker, ElggEntity $entity) {
	
	if (!$user instanceof ElggUser) {
		return false;
	}
	
	if (!$liker instanceof ElggUser) {
		return false;
	}
	
	if (!$entity instanceof ElggEntity) {
		return false;
	}
	
	$title_str = $entity->title;
	if (!$title_str) {
		$title_str = elgg_get_excerpt($entity->description);
	}

	$site = get_config('site');

	$subject = elgg_echo('likes:notifications:subject', array(
					$liker->name,
					$title_str
				));

	$body = elgg_echo('likes:notifications:body', array(
					$user->name,
					$liker->name,
					$title_str,
					$site->name,
					$entity->getURL(),
					$liker->getURL()
				));

	notify_user($user->guid,
				$liker->guid,
				$subject,
				$body
			);
}

elgg_register_event_handler('init','system','customactivity_init');