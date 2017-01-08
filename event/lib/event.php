<?php
	/*
	Event image
	*/
	function eventCoverartURL($guid, $size, $icontime = false){
		global $CONFIG;
		if($guid){
			if($icontime){
				$url = $CONFIG->url."mod/event/icon.php?guid={$guid}&size={$size}";
			}else{
				$url = $CONFIG->url."mod/event/graphics/default{$size}.png";
			}
			return $url;
		}
	}	

	/*
	* event invite
	* Creates a relatiionship called "event_invite" between event and group
	*/
	function event_invite($groupguid, $eventguid, $revenue = 0){
		global $CONFIG;
		$group_owner = get_entity($groupguid);
		$event = get_entity($eventguid);
		$user = elgg_get_logged_in_user_entity();
		$touser = get_user($group_owner->owner_guid);
		if (check_entity_relationship($event->guid, 'event_sponser', $groupguid)){
			return false;
		}	
		if (!check_entity_relationship($event->guid, 'event_invite', $groupguid)){
			add_entity_relationship($event->guid, 'event_invite', $groupguid);
			$url = "{$CONFIG->url}event/invitation/{$groupguid}";
			notify_user($touser->guid, $user->guid,
			elgg_echo('event:request:subject', array($user->name, $event->title)),
			elgg_echo('event:request:body', array( $touser->name, $user->name, $event->title, $user->getURL(), $url)),NULL);
		}
		return true;
	}	
	
	function event_get_invited_events($user_guid, $inverse = TRUE,  $return_guids = FALSE) {
		$events = elgg_get_entities_from_relationship(array(
			'relationship' => 'event_invite',
			'relationship_guid' => $user_guid,
			'inverse_relationship' => $inverse,
			'limit' => 0,
		));
		return $events;
 	}
	
	function event_non_profit_participating($np_guid = null, $options = array(), $list = true){
		$return = false;
		if($np_guid){
			$param = array(
				'relationship' => 'event_sponser',
				'relationship_guid' => $np_guid,
				'inverse_relationship' => true,
				'limit' => 5,
				'full_view' => false,
			);
			$param = array_merge($param, $options);
			if($list){
				$return = elgg_list_entities_from_relationship($param);
			}else{
				$return = elgg_get_entities_from_relationship($param);
			}
		}
		return $return;
	}
	
	/*
	All events of a group
	*/	
	function get_groups_events($group_guid = false){
		$return = false;
		if(!$group_guid){
			return $return;
		}	
		$options = array(
			'limit' => 0,
		);
		$events = event_non_profit_participating($group_guid, $options, false);	
		if($events){
			$return = array();
			foreach($events as $e){	
				$return[$e->guid] = $e->title;
			}	
		} 
		return $return;
	}	
	/*
	Get featured event for a non profit
	*/
	function featured_event_of_group($group_guid = false){
		$return = false;
		if(!$group_guid){
			return $return;
		}	
		$featured_event = elgg_get_entities_from_relationship(array(
			'relationship' => 'featured_event',
			'relationship_guid' => $group_guid,
			'inverse_relationship' => false,
			'limit' => 1,
		));
		if($featured_event){
			$return = $featured_event[0];
		} else {
			$events = event_non_profit_participating($group_guid, array('limit' => 1), false);
			$return = $events[0];
		} 
		return $return;
	}	
			
	function event_get_sponsers($guidone, $inverse = TRUE,  $return_guids = false, $offset = 0, $limit = 0) {
		$option = array(
			'relationship' => 'event_sponser',
			'relationship_guid' => $guidone,
			'inverse_relationship' => $inverse,
			'limit' => $limit,
		);
		if (!$return_guids ) {
			$option['offset'] = $offset;
			$option['limit'] = $limit;
		}
		$sponser = elgg_get_entities_from_relationship($option);
		if(empty($sponser)){
			return NULL;
		}
		if ($return_guids) {
			$guids = array();
			$guids[0] = '';
			foreach ($sponser as $sp) {
				$guid = $sp->getGUID(); 
				$guids[$guid] = $sp->name;
			}
			return $guids;
		}
		return $sponser;
	}
 
	 /*
	 Join Members
	 */
	function event_get_members($even_guid, $inverse = TRUE,  $return_guids = FALSE, $list = false) {
		$option = array(
			'relationship' => 'event_join',
			'relationship_guid' => $even_guid,
			'inverse_relationship' => $inverse,
			'limit' => 0,
		);
		if($list){
			$option['limit'] =10;
			return elgg_list_entities_from_relationship($option); 		
		}
		return elgg_get_entities_from_relationship($option);
	}
	
	/*
	Total relation
	*/
	function event_count_relation($guid, $relationship = 'event_join', $inverse = false) {
		$events = elgg_get_entities_from_relationship(array(
			'relationship' => $relationship,
			'relationship_guid' => $guid,
			'inverse_relationship' => $inverse,
			'count' => true,
		));
		return $events;
	}
	
	function event_get_relationship($guidone, $relationship,$inverse = false) {
		$events = elgg_get_entities_from_relationship(array(
			'relationship' => $relationship,
			'relationship_guid' => $guidone,
			'inverse_relationship' => $inverse,
			'limit' => 0,
		));
		if($events[0]->guid){
			return $events[0]->guid;
		}
	}

 
 	/*
	event invite
	*/
	function event_accept_invitation($event, $group){
		global $CONFIG;
		if (!check_entity_relationship($event->guid, 'event_sponser', $group->guid)){
			add_entity_relationship($event->guid, 'event_sponser', $group->guid);
			return true;
		}
		$to_user = $group->owner_guid;
		$from_user = 1;
		if($to_user && $event){
			$user = get_user($to_user);
			$np_url = $group->getURL()."?ref=$group->guid";
			notify_user($to_user, $from_user,
			elgg_echo('event:invitation:accept:subject', array($event->title)),
			elgg_echo('event:invitation:accept:body', array( $event->title, $event->title, $np_url)),	NULL);
		}		
	}	

	/*
	export registration data
	*/
	function event_get_relationship_export($userguid, $relationship, $return = 'name'){
		$sponser = event_get_relationship($userguid, $relationship);
		$data = get_entity($sponser);
		return $data->$return;
	}
	
	/*
	event user relationship
	*/
	function event_create_user_relationship($event_guid, $userguid){
		if (!check_entity_relationship($event_guid, 'event_join', $userguid)){
			add_entity_relationship($event_guid, 'event_join', $userguid);
		}
		event_join_notification($event_guid, $userguid, 1);
	}
	
	/*
	user join notification
	1 as from user means the site
	*/
	function event_join_notification($event_guid, $to_user = null, $from_user = 1){
		$event = get_entity($event_guid);
		if($to_user && $event){
			$user = get_user($to_user);
			$url = elgg_get_site_url()."event/purchaseinfo/{$event_guid}/{$event->title}";
			notify_user($to_user, $from_user,
			elgg_echo('event:payment:subject', array($event->title)),
			elgg_echo('event:payment:body', array( $user->name, $event->title, $url)),	NULL);
		}
	}
	
	
	/*
	* Events a user is participating
	*/
	
	function event_partcipating_list($ownerguid, $options = array()){
		$param['relationship'] = 'event_join';
		$param['relationship_guid'] = $ownerguid;
		$param['inverse_relationship'] = true;
		$param = array_merge($param, $options);
		return elgg_list_entities_from_relationship($param);
	}

	/*
	check already join
	*/
	function event_already_join($event_quid,$owner_guid){
		if (check_entity_relationship($event_quid, 'event_join', $owner_guid))	{
			return true;
		}
	}
	
	function event_sidebar_navigation($event) {
		$event_guid = $event->getGUID();
		$title = elgg_get_friendly_title($event->title);
		$user = elgg_get_logged_in_user_entity();
		$actions = array();
		if($event->canEdit()){
			$url = elgg_get_site_url() . "event/edit/{$event_guid}/{$title}";
			$actions[$url] = 'event:edit';
			
			$url = elgg_get_site_url() . "event/reports/{$event_guid}/{$title}";
			$actions[$url] = 'event:reports';
			
			if(elgg_is_active_plugin('galliMassmail')){
			//	$url = elgg_get_site_url() . "massmail/events/{$event_guid}/{$title}";
			//	$actions[$url] = 'gallimassmail:mailall';			
				$url = elgg_get_site_url() . "massmail/event_confirmation/{$event_guid}/{$title}";
				$actions[$url] = 'gallimassmail:mailall';			
			}
			
			$url = elgg_get_site_url() . "event/manage-tickets/{$event_guid}";
			$actions[$url] = 'event:managetickets';						
		}
	
		if($user){
			$url = elgg_get_site_url() . "event/purchaseinfo/{$event_guid}/{$title}";
			$actions[$url] = 'event:myticket';
			
			if(!event_closed($event)){
				$url = elgg_get_site_url() . "event/join/{$event_guid}/{$title}";
				$actions[$url] = 'event:join';	
			}
		}
		
		$i = 1;
		if ($actions) {
			foreach ($actions as $url => $text) {
				elgg_register_menu_item('page', array(
					'name' => $text,
					'href' => $url,
					'text' => elgg_echo($text),
					'priority' => $i,
				));
				$i++;
			}
		}

		elgg_register_menu_item('title', array(
			'name' => 'event:dashboard',
			'href' => elgg_get_site_url() . "event/dashboard/{$event_guid}/{$title}",
			'text' => elgg_echo('event:dashboard'),
			'link_class' => 'elgg-button elgg-button-action',
			'priority' => $i,
		));
		
	}
	/*
	Edit event link
	*/
	function event_edit_buttons($event) {
		$event_guid = $event->getGUID();
		if($event->canEdit()){
			elgg_register_menu_item('title', array(
					'name' => elgg_echo('event:edit'),
					'href' => elgg_get_site_url() . "event/edit/{$event_guid}",
					'text' => elgg_echo('event:edit'),
					'link_class' => 'elgg-button elgg-button-action',
			));
		}
	}
	
	/*
	Form 
	*/
	function event_replace_string($string = NULL)	{
		return  strtolower(preg_replace("/[^a-zA-Z0-9]/", "", $string)); 	
	}
	
	function event_radio_option($values = array()){
		$newArray = array();
		for($i = 0; $i < count($values); $i++)	{
			$value = trim($values[$i]);	
			if($value == 'Select'){
				$newArray[NULL] = ucfirst($value);
			}else{
				$newArray[$value] = ucfirst($value);
			}
		}	
		return $newArray;	
	}

	/*
	Event Category
	*/
	function event_category($null = true){
		$category = elgg_get_plugin_setting('category','event');
		$fields = explode(",", $category);
		if($null){
			$field_values[NULL] = "Select";
		}
		foreach ($fields as $val){
			$key = elgg_get_friendly_title($val);
			if($key){
				$field_values[$key] = $val;
			}
		}
		return $field_values;
	}
	
	// month name
	function event_MonthName($Month){ 
		$strTime = mktime(1,1,1,$Month,1,date("Y")); 
		return substr(date("F",$strTime),0,3); 
	} 
	
	//form type
	function event_formtype(){	
		$typeArray = array(1 => elgg_echo('event:text'),
				   		   2 => elgg_echo('event:area'),
						   3 => elgg_echo('event:select'),
						   4 => elgg_echo('event:radio'),
						   5 => elgg_echo('event:check'),
						   6 => elgg_echo('event:phone'),
						   7 => elgg_echo('event:email'),
						   8 => elgg_echo('event:url'),
						   9 => elgg_echo('event:date_picker'),
						   10 => elgg_echo('event:terms'),
					);
		return $typeArray;			   
	}
	
	/*
	Save a metadata on an entity by ignoring access
	*/
	function event_save_md_ignoring_access($entity, $md_n, $md_v){
		if($entity && $md_n && $md_v){
			$ia = elgg_set_ignore_access(true);
			$entity->$md_n = $md_v;
			$entity->save();
			elgg_set_ignore_access($ia);
		}
	}	
	
	function event_get_total_tickets_sold($event){
		if($event->free){
			return event_count_relation($event->guid);
		}
		$table = elgg_get_config('dbprefix')."events_tickets"; 
		$data = get_data("select sum(sold) as sold from $table where event_guid=".$event->guid);
		return (int)$data[0]->sold;
	}
	
	function event_closed($event){
		$guid = $event->guid;
		$event = get_events("guid=$guid");
		if($event[0]->blocked){
			return true;
		}	
		$closedate = $event[0]->end_date;
		$now = time();
		if($closedate > $now){
			return false;
		}
		return true;
	}
	
	function event_convert_date($date){
		if($date){
			return date('d-M-Y',$date);
		}
		return NULL;	
	}
	
	
	function event_total_participants($groupguid = 0, $eventguid = 0){
		if($groupguid && $eventguid){
			$table = elgg_get_config('dbprefix')."events_purchase_info";
			$data = get_data("select count(id) as total from $table where group_guid=$groupguid and event_guid=$eventguid and status=1");
			return (int)$data[0]->total;
		}
	}
	
        function event_start_date($date, $type = NULL){
            $gobalvar = '';
            if(!empty($type) && isset($type)){
                if($type == 'day')
                    $gobalvar = date('j', strtotime($date));
                if($type == 'suffix')
                    $gobalvar = date('S', strtotime($date));
                if($type == 'date_suffix')
                    $gobalvar = date('jS', strtotime($date));
                if($type == 'month')
                    $gobalvar = date('M', strtotime($date));
            }
            return $gobalvar;
        }
	function event_donation_raised_by_nonprofit($eventguid, $groupguid){
		$table = CAUSES_DB_TABLE;
		$query = "select sum(amount) as amount from $table where eventguid = $eventguid and groupguid = $groupguid";
		$data = get_data($query);
		return $amount = (int) $data[0]->amount;
	}
	
	function event_unique_donors($eventguid, $groupguid){
		$table = CAUSES_DB_TABLE;
		$query = "select donorid from $table where eventguid = $eventguid and groupguid = $groupguid";
		$data = get_data($query);
		return count($data);
	}
	
	function file_get_contents_curl($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch, CURLOPT_URL, $url);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	function event_create_default_cause($event, $group){
		if($event && $group){
			if($group->approved != 1){
				return true;
			}
			$event_metadata = get_events("guid=".$event->guid);
			if($event_metadata[0]->fundraising){
				$amount = "50|100|200";
				$causes = new ElggObject;
				$causes->subtype = "causes";
				$causes->container_guid = $group->guid;
				$causes->owner_guid = $group->owner_guid;
				$causes->category = $event_metadata[0]->category;
				$causes->title = $group->name." at ".$event_metadata[0]->title;
				$causes->description = $event_metadata[0]->description;
				$causes->brief_description = $event_metadata[0]->brief_description;
				$causes->enddate = date('Y-m-d',$event_metadata[0]->end_date);
				$causes->location = $event_metadata[0]->location;
				$causes->target = 1000;
				$causes->amount = $amount;
				$causes->access_id = 2; // Hard code it to public
				if ($causes->save()){
					add_entity_relationship($causes->guid, 'causes_konnector', elgg_get_logged_in_user_guid());
					add_entity_relationship($causes->guid, 'causes_supported', $group->guid);
					add_entity_relationship($causes->guid, 'causes_event_supported', $event->guid);
					add_to_river('river/object/causes/create','create', elgg_get_logged_in_user_guid(), $causes->getGUID());
					$icontime = $group->icontime;	
					//upload image
						if($icontime){
							$size = 'large';
							$group_guid = $group->guid;
							$tempfile = elgg_get_config('dataroot').$group_guid.'.jpg';
							$site_url = elgg_get_site_url();
							$url = $site_url."groupicon/$group_guid/large/$icontime.jpg";
							$imgContent = file_get_contents_curl($url);
							if($imgContent && $icontime){
								$fp = fopen($tempfile, "w");
								fwrite($fp, $imgContent);
								fclose($fp);
								$newimage = get_resized_image_from_existing_file($tempfile,180,150, false);
								$tiny = get_resized_image_from_existing_file($tempfile, 25, 25, true);
									if ($newimage) {
										$prefix = "causes/".$causes->guid;
										$thumb = new ElggFile();
										$thumb->owner_guid = $causes->owner_guid;
										$thumb->setMimeType('image/jpeg');
										$thumb->setFilename($prefix."medium.jpg");
										$thumb->open("write");
										$thumb->write($newimage);
										$thumb->close();
										$thumb->setFilename($prefix."tiny.jpg");
										$thumb->open("write");
										$thumb->write($tiny);
										$thumb->close();									
										$causes->icontime = time();
									}
								unlink($tempfile);	
							}
						}						
					return true;
				}
			}
		}
		return false;
	}
	
	function get_past_events($to_unset = null){
		$return = array('' => 'Please select');
		$time = time();
		$events = get_events("end_date<$time"); 
		if($events){
			foreach($events as $e){
				$return[$e->guid] = $e->title;
			}
		}
		unset($return[$to_unset]);
		return $return;
	}	
		
	function get_events($were = NULL){
		$table = elgg_get_config('dbprefix')."event"; 
		if($were){
			return get_data("select *from $table where $were ");
		}
		return get_data("select *from $table ");
		
	}
	
	function event_ticket_form_fields($event_guid){
		if(!(int)$event_guid){
				return;
		}
		$field_name = array();
		$form_table = elgg_get_config('dbprefix')."events_customforms";
		$event_form = get_data("select *from $form_table where event_guid=$event_guid and type!=10  order by item_order");
		foreach($event_form as $form){
				$field_name[$form->id] = $form->title;
		}
		return $field_name;
	}
	
	function event_ticket_info($event_guid, $formguid = array(), $limit = 10, $offset = 0){
        if(!(int)$event_guid){
			echo "no event";
			return;
        }
        $filed_name = array();
		
        $prefix = elgg_get_config('dbprefix');
        $form_guid = implode(",", $formguid);
        $form_table = $prefix."events_customforms";
        $userinfo_table = $prefix."events_purchase_userinfo";
        $purchase_table = $prefix."events_purchase_info";
        $ticket_table = $prefix."events_tickets";
        $groups_table = $prefix."groups_entity";

        $event_form = get_data("select * from $form_table where event_guid=$event_guid and type!=10  order by item_order");
        foreach($event_form as $form){
            $filed_name[$form->id] = $form->title;
        }

        $returnArray = array();

        $purchased_tickets = get_data("select p.id,g.name,t.title as ticket_name from $purchase_table p,  $groups_table g, $ticket_table t where g.guid=p.group_guid and  t.id = p.ticket_guid and p.event_guid =
										$event_guid and p.status = 1 order by time_created LIMIT $offset, $limit");
        $n = 0;

        foreach($purchased_tickets as $ticket){
			$user_data = array();
			$purchased_id = (int) $ticket->id;
			$userinfo = get_data("select * from $userinfo_table where purchase_guid=$purchased_id");
			foreach($userinfo as $info){
				$user_data[$info->form_guid] = $info->value;
			}
			foreach($filed_name as $form_guid=>$form_value){
				$user_data['ticket_data'][] = array(ucfirst($form_value) => $user_data[$form_guid]);
			}

			$user_data['ticket'] = $ticket->ticket_name;
			$user_data['supports'] = $ticket->name;
			$returnArray[$n] = $user_data;
			$n++;
        }
        return $returnArray;
	}
?>