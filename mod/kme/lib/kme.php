<?php

	////////////////////////////////////////////////// SET REFERRER ///////////////////////////////////////////
	kme_set_refering_nonprofit();
	
	function kme_set_refering_nonprofit(){
		$ref = get_input('ref');
		if($ref){
			setcookie('refnp',$ref, 0, '/');
		}
	}

	////////////////////////////////////////////////// BLOGS //////////////////////////////////////////////////
	elgg_register_plugin_hook_handler('route', 'blog', 'kme_blog_pagehandler_override');
	
	function kme_blog_pagehandler_override($hook, $type, $return, $params) {
		$tobe_rerouted = array('read','view');
		if(in_array($return['segments'][0], $tobe_rerouted)){
			if (blog_page_handler_override($return['segments'])) {
				exit;
			}
		} 		
		return $return;
	}

	function blog_page_handler_override($page) {
		elgg_load_library('elgg:blog');
		blog_url_forwarder($page);
		elgg_push_breadcrumb(elgg_echo('blog:blogs'), "blog/all");
		if (!isset($page[0])) {
			$page[0] = 'all';
		}
		$page_type = $page[0];
		switch ($page_type) {
			case 'view':
			case 'read': // Elgg 1.7 compatibility
				$params = kme_blog_get_page_content_read($page[1]);
				break;
			default:
				return false;
		}
		if (isset($params['sidebar'])) {
			$params['sidebar'] .= elgg_view('blog/sidebar', array('page' => $page_type));
		} else {
			$params['sidebar'] = elgg_view('blog/sidebar', array('page' => $page_type));
		}
		$body = elgg_view_layout('content', $params);
		echo elgg_view_page($params['title'], $body);
		return true;
	}
	
	function kme_blog_get_page_content_read($guid = NULL) {
		$return = array();
		$blog = get_entity($guid);
		// no header or tabs for viewing an individual blog
		$return['filter'] = '';
		if (!elgg_instanceof($blog, 'object', 'blog')) {
			register_error(elgg_echo('noaccess'));
			$_SESSION['last_forward_from'] = current_page_url();
			forward('');
		}
		$return['title'] = $blog->title;
		$container = $blog->getContainerEntity();
		$crumbs_title = $container->name;
		if (elgg_instanceof($container, 'group')) {
			elgg_push_breadcrumb($crumbs_title, "blog/group/$container->guid/all");
		} else {
			elgg_push_breadcrumb($crumbs_title, "blog/owner/$container->username");
		}
		elgg_push_breadcrumb($blog->title);
		$return['content'] = elgg_view_entity($blog, array('full_view' => true));
		//check to see if comment are on
		if ($blog->comments_on != 'Off') {
			$return['comments'] .= elgg_view_comments($blog);
		}
		return $return;
	}

	////////////////////////////////////////////////// GROUPS //////////////////////////////////////////////////
	elgg_register_plugin_hook_handler('route', 'groups', 'kme_groups_pagehandler_override');
	
	function kme_groups_pagehandler_override($hook, $type, $return, $params) {
		if($return['segments'][0] == 'profile') {
			group_page_handler_override($return['segments'][1]);
			exit;
		} if($return['segments'][0] == 'pendingapproval') {
			kme_groups_pending_approval();
			exit;
		} if($return['segments'][0] == 'all') {
			kme_groups_handle_all_page();
			exit;
		} else {	
			return $return;
		}
	}
	
	function kme_groups_pending_approval(){
		$page_owner = elgg_get_page_owner_entity();
		$title = elgg_echo('kme:groups:pendingapproval');
		elgg_push_breadcrumb(elgg_echo('groups'), 'groups');
		elgg_push_breadcrumb($title);
		elgg_register_title_button();
		$options = array(
			'type' => 'group',
			'full_view' => false,
			'metadata_name' => 'approved',
			'metadata_value' => 0,
		);
		$content = elgg_list_entities_from_metadata($options);
		if (!$content) {
			$content = elgg_echo('groups:none');
		}
		$params = array(
			'content' => $content,
			'title' => $title,
			'filter' => '',
		);
		$body = elgg_view_layout('content', $params);
		echo elgg_view_page($title, $body);
	}
	
	function group_page_handler_override($guid) {
		elgg_load_library('elgg:groups');
		elgg_set_page_owner_guid($guid);
		// turn this into a core function
		global $autofeed;
		$autofeed = true;
		$group = get_entity($guid);
		if (!$group) {
			forward('groups/all');
		}
		elgg_push_breadcrumb(elgg_echo('groups'), 'groups/all/');
		elgg_push_breadcrumb($group->name);
		$content = elgg_view('groups/profile/layout', array('entity' => $group));
		
		elgg_load_library('elgg:causes');	
		$latest_cause_for_group = featured_cause_of_group($group->guid); 
		if($latest_cause_for_group){
			$sidebar = elgg_view('causes/sidebar/group_sidebar_donate', array('cause' => $latest_cause_for_group));
		}
		
		if (group_gatekeeper(false)) {
			$sidebar .= '';
			if (elgg_is_active_plugin('search')) {
				$sidebar .= elgg_view('groups/sidebar/search', array('entity' => $group));
			}
			$sidebar .= elgg_view('groups/sidebar/members', array('entity' => $group));
		} else {
			$sidebar .= '';
		}
		groups_register_profile_buttons($group);
		$params = array(
			'content' => $content,
			'sidebar' => $sidebar,
			'title' => $group->name,
			'filter' => '',
			'wrap' => false,
		);
		$body = elgg_view_layout('content', $params);
		echo elgg_view_page($group->name, $body);
	}
	
	function kme_groups_entity_menu_setup($hook, $type, $return, $params) {
		if (elgg_in_context('widgets')) {
			return $return;
		}
		$entity = $params['entity'];
		$handler = elgg_extract('handler', $params, false);
		if ($handler != 'groups') {
			return $return;
		}
		foreach ($return as $index => $item) {
			if (in_array($item->getName(), array('membership', 'feature'))) {
				unset($return[$index]);
			}
		}		
		if (elgg_is_admin_logged_in()) {
			if ($entity->approved == "1") {
				$url = "action/groups/approve?group_guid={$entity->guid}&action_type=unapprove";
				$wording = elgg_echo("kme:unapprove");
			} else {
				$url = "action/groups/approve?group_guid={$entity->guid}&action_type=approve";
				$wording = elgg_echo("kme:approve");
			}
			$options = array(
				'name' => 'approve',
				'text' => $wording,
				'href' => $url,
				'priority' => 900,
				'is_action' => true
			);
			$return[] = ElggMenuItem::factory($options);
			$options = array(
				'name' => 'admin_delete',
				'text' => elgg_view_icon('delete'),
				'title' => elgg_echo('delete:this'),
				'href' => "action/$handler/admin_delete?guid={$entity->getGUID()}",
				'confirm' => elgg_echo('deleteconfirm'),
				'priority' => 990,
			);
			$return[] = ElggMenuItem::factory($options);		
		}
		return $return;
	}	

	function kme_groups_handle_all_page() {
		// all groups doesn't get link to self
		elgg_pop_breadcrumb();
		elgg_push_breadcrumb(elgg_echo('groups'));
		if (elgg_get_plugin_setting('limited_groups', 'groups') != 'yes' || elgg_is_admin_logged_in()) {
			elgg_register_title_button();
		}
		$selected_tab = get_input('filter', 'newest');
		switch ($selected_tab) {
			case 'popular':
				$content = elgg_list_entities_from_relationship_count(array(
					'type' => 'group',
					'relationship' => 'member',
					'inverse_relationship' => false,
					'full_view' => false,
				));
				if (!$content) {
					$content = elgg_echo('groups:none');
				}
				break;
			case 'alphabetic':
				$db_prefix = elgg_get_config('dbprefix');
				$content = elgg_list_entities(array(
					'type' => 'group',
					'full_view' => false,
					'joins' => array("JOIN {$db_prefix}groups_entity g on e.guid = g.guid"),
					'order_by' => "g.name ASC",
				));
				if (!$content) {
					$content = elgg_echo('groups:none');
				}
				break;
			case 'discussion':
				$content = elgg_list_entities(array(
					'type' => 'object',
					'subtype' => 'groupforumtopic',
					'order_by' => 'e.last_action desc',
					'limit' => 40,
					'full_view' => false,
				));
				if (!$content) {
					$content = elgg_echo('discussion:none');
				}
				break;
			case 'newest':
			default:
				$content = elgg_list_entities(array(
					'type' => 'group',
					'full_view' => false,
				));
				if (!$content) {
					$content = elgg_echo('groups:none');
				}
				break;
		}
		$filter = elgg_view('groups/group_sort_menu', array('selected' => $selected_tab));
		$sidebar = elgg_view('groups/sidebar/find');
		$sidebar .= elgg_view('groups/sidebar/featured');
		$params = array(
			'content' => $content,
			'sidebar' => $sidebar,
			'filter' => $filter,
		);
		$body = elgg_view_layout('content', $params);
		echo elgg_view_page(elgg_echo('groups:all'), $body);
	}


	////////////////////////////////////////////////// MISCALLEANEOUS //////////////////////////////////////////////////
	function get_count_dowm_values($seconds){
		$total_days = $seconds / 86400;
		$days = (int) floor($total_days);
		$remaining_seconds = ($total_days - $days)*86400;
		$remainingHour = (int) floor($remaining_seconds/3600);
		$remainingMinute = (int) floor(($remaining_seconds-($remainingHour*60*60))/60);
		$remainingSecond = (int) floor(($remaining_seconds-($remainingHour*60*60))-($remainingMinute*60));
		$obj = array(
			"d" => str_pad($days, 2, "0", STR_PAD_LEFT),
			"h" => str_pad($remainingHour, 2, "0", STR_PAD_LEFT),
			"m" => str_pad($remainingMinute, 2, "0", STR_PAD_LEFT),
			"s" => str_pad($remainingSecond, 2, "0", STR_PAD_LEFT),
		);
		return $obj;
	}
