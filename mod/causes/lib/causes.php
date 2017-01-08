<?php
	/*
	Causes image
	*/
	function causesCoverartURL($guid,$size){
		global $CONFIG;
		if($guid){
			$causes = get_entity($guid);
			$icontime =  $causes->icontime;
			if($icontime){
				$url = $CONFIG->url."mod/causes/icon.php?guid={$guid}&size={$size}";
			}else{
				$url = $CONFIG->url."mod/causes/graphics/default{$size}.png";
			}
			return $url;
		}
	}	
	/*
	Edit causes link
	*/
	function causes_register_profile_buttons($causes) {
		$causes_guid = $causes->getGUID();
		$user = elgg_get_logged_in_user_entity();
		if ($causes->canEdit()) {
			// edit causes
			$url = elgg_get_site_url() . "causes/edit/{$causes->getGUID()}";
			elgg_register_menu_item('title', array(
				'name' => 'causes:dashboard',
				'href' => $url,
				'text' => elgg_echo('causes:dashboard'),
				'link_class' => 'elgg-button elgg-button-action',
			));
		}
		if(causes_have_relation($causes_guid ,'causes_konnector',$user->guid)){
			$url = elgg_add_action_tokens_to_url( elgg_get_site_url() . "action/causes/leave_konnector?causes_guid={$causes_guid}" );
			elgg_register_menu_item('title', array(
				'name' => 'causes:leave:konnectors',
				'href' => $url,
				'text' => elgg_echo('causes:leave:konnectors'),
				'link_class' => 'elgg-button elgg-button-action',
			));
		}else{
			$url = elgg_add_action_tokens_to_url( elgg_get_site_url() . "action/causes/join_konnector?causes_guid={$causes_guid}" );
			elgg_register_menu_item('title', array(
				'name' => 'causes:join:konnectors',
				'href' => $url,
				'text' => elgg_echo('causes:join:konnectors'),
				'link_class' => 'elgg-button elgg-button-action',
				'title' => 'Connect with the cause and help fundraise for the cause',
			));
		}
	}
	
	/*
	Get featured cause for a non profit
	*/
	function featured_cause_of_group($group_guid = false){
		$return = false;
		if(!$group_guid){
			return $return;
		}	
		$featured_cause = elgg_get_entities_from_relationship(array(
			'relationship' => 'featured_cause',
			'relationship_guid' => $group_guid,
			'inverse_relationship' => false,
			'limit' => 1,
		));
		if($featured_cause){
			$return = $featured_cause[0];
		} else {
			$return = get_groups_last_cause($group_guid);
		} 
		return $return;
	}
	
	/*
	Last cause of a group
	*/
	function get_groups_last_cause($group_guid = false){
		$return = false;
		if(!$group_guid){
			return $return;
		}	
		$options = array(
			'type' => 'object',
			'subtype' => 'causes',
			'container_guid' => $group_guid,
			'owner_guid' => get_entity($group_guid)->owner_guid,
			'limit' => 1,
			'full_view' => false,
			'pagination' => false,
		);
		$latest_cause_for_group = elgg_get_entities($options);	
		if($latest_cause_for_group){
			$return = $latest_cause_for_group[0];
		} 
		return $return;
	}	
	/*
	All causes of a group
	*/
	function get_groups_causes($group_guid = false){
		$return = false;
		if(!$group_guid){
			return $return;
		}	
		$options = array(
			'type' => 'object',
			'subtype' => 'causes',
			'container_guid' => $group_guid,
			'owner_guid' => get_entity($group_guid)->owner_guid,
			'limit' => 0,
			'full_view' => false,
			'pagination' => false,
		);
		$causes = elgg_get_entities($options);	
		if($causes){
			$return = array();
			foreach($causes as $c){	
				$return[$c->guid] = $c->title;
			}	
		} 
		return $return;
	}	
	/*
	Konnectors of causes
	*/
	 function causes_get_konnectors($guid, $inverse = TRUE,  $return_guids = FALSE) {		
		$db_prefix = elgg_get_config('dbprefix');
		return elgg_get_entities_from_relationship(array(
			'relationship' => 'causes_konnector',
			'relationship_guid' => $guid,
			'inverse_relationship' => $inverse,
			'limit' => 0,
			'joins' => array("JOIN {$db_prefix}users_entity u on e.guid = u.guid"),
			'order_by' => "u.name ASC",
		));
	 }
	/*
	Causes of a konnector
	*/
	function causes_get_konnectors_causes($konnector_guid) {		
		return elgg_get_entities_from_relationship(array(
			'relationship' => 'causes_konnector',
			'relationship_guid' => $konnector_guid,
			'inverse_relationship' => true,
			'limit' => 0,
		));	
	}
 	/*
	Total relation
	*/
	function causes_count_relation($guid, $relationship = 'causes_konnector', $inverse = false) {	
		return elgg_get_entities_from_relationship(array(
			'relationship' => $relationship,
			'relationship_guid' => $guid,
			'inverse_relationship' => $inverse,
			'count' => true,
		));
		
	}	
	/*
	have relation
	*/
	function causes_have_relation($guid1, $relation = 'causes_konnector', $guid2){		
		if (check_entity_relationship($guid1, $relation, $guid2))	{
			return true;
		}
	}	
	/*
	Causes Amount Array
	*/
	function causes_amounts($guid){
		$amount_array = array();
		$causes = get_entity($guid);
		$amount = explode("|", $causes->amount);
		$amount_description = explode("|",  $causes->amount_description);
		for($i = 0; $i<count($amount);$i++){
			$description = $amount_description[$i];
			if(!$description){
				$description = 1;
			}
			if($amount[$i]){
				$amount_array[$amount[$i]] = $description;
			}
		}
		return array_filter($amount_array);
	}	
	/*
	Return as konnector as array
	*/
	function causes_get_konnectors_array($guidone, $relation = 'causes_konnector', $inverse = false) {
		$db_prefix = elgg_get_config('dbprefix');
		$causes = elgg_get_entities_from_relationship(array(
			'relationship' => $relation,
			'relationship_guid' => $guidone,
			'inverse_relationship' => $inverse,
			'limit' => 0,
			'joins' => array("JOIN {$db_prefix}users_entity u on e.guid = u.guid"),
			'order_by' => "u.name ASC",
		));
		if(empty($causes)){
			return NULL;
		}
		$option = array();
		$option[0] = elgg_echo('causes:defaut_option');
		foreach ($causes as $cause) {
			$guid = $cause->getGUID(); 
			$option[$guid] = $cause->name;
		}
		return $option;
	}
	/*
	Paypal
	*/
	function causes_donate($groupguid = 0, $eventguid = 0, $causeid = 0, $konnector_id = 0, $donorid = 0, $amount = 0, $real_name = "Unknown", $email = "someone@somewhere.com", $anonymous = 0, $paypal = 0, $others=array() ){
		$paypaltime = time();
		if($anonymous != '0'){
			$anonymous = 1;
		}
		$country = '';
		$state = '';
		$city = '';
		$zip = '';
		$street = '';
		if($others['country']){
			$country = $others['country'];
		}
		if($others['state']){
			$state = $others['state'];
		}
		if($others['city']){
			$city = $others['city'];
		}
		if($others['zip']){
			$zip = $others['zip'];
		}
		if($others['street']){
			$street = $others['street'];
		}

		$table = CAUSES_DB_TABLE;
		$lastid = insert_data("INSERT INTO $table(groupguid, eventguid, causeid,  konnectorid,  donorid,  amount,  realname,  email,  anonymous,  paypal,  paypaltime, country, city, state, zip, street ) 
							VALUES ('$groupguid', '$eventguid', '$causeid', '$konnector_id', '$donorid', '$amount', '$real_name', '$email', '$anonymous', '$paypal', '$paypaltime', '$country', '$city', '$state', '$zip', '$street')");		
			
		if($lastid){
			causes_notify_donor($causeid, $real_name, $email);
			causes_notify_cause_owner($causeid, $amount);
		}		
		return $lastid;	
	}
	/*
	Send donation notification to donor
	*/
	function causes_notify_donor($causeid, $realname, $email){
		if($realname && $email){
			if(is_email_address($email)){
				$cause = get_entity($causeid);
				if($cause){
					$cause_title = $cause->title;
					$cause_url = $cause->getURL();
					$subject = "Thanks for the donation";
					$from = "support@konnectme.org";
					$message = elgg_echo('causes:notifydonor', array($realname, $cause_title, $cause_url));
					elgg_send_email($from, $email, $subject, $message);
				}
			}	
		}
	}
	/*
	Send donation notification to cause owner
	*/
	function causes_notify_cause_owner($causeid, $amount){
		if($causeid && $amount){
			$cause = get_entity($causeid);
			if($cause){
				$cause_title = $cause->title;
				$cause_url = $cause->getURL();
				$owner = get_entity($cause->owner_guid);
				$to_email = $owner->email;
				if(is_email_address($to_email)){
					$subject = "You received a donation";
					$from = "support@konnectme.org";
					$message = elgg_echo('causes:notifycauseowner', array($amount, $cause_title, $cause_url));
					elgg_send_email($from, $to_email, $subject, $message);
				}
			}			
		}
	}
	/*
	Redirection to paypal site
	*/
	function causes_go_paypal_link($transactionid){
	}
	/*
	after finish payment
	*/
	function causes_finish_payment($transactionid = 0, $anonymous = NULL){		
		$table = CAUSES_DB_TABLE;
		$query = "select *from $table where id = $transactionid";
		$data = get_data($query);
		$causeid = $data[0]->causeid;
		$email = $data[0]->email;
		
		if($email){
			// notification
			causes_payment_notification($email,$causeid);
		}
	}
	/*
	Causes payment notification
	*/
	function causes_payment_notification($email, $causes_quid){
		global $CONFIG;
		$causes = get_entity($causes_quid);
		if($email && $causes){
			$url = "{$CONFIG->url}causes/{$causes_quid}/{$causes->title}";
			$subject = elgg_echo('causes:payment:subject', array($causes->title));
			$body = elgg_echo('causes:payment:body', array($user->name, $causes->title, $url));		
			$site = elgg_get_site_entity();
				if ($site && $site->email) {
					$from = $site->email;
				} else {
					$from = 'noreply@' . get_site_domain($site->guid);
				}	
			elgg_send_email($from, $email, $subject, $body);
		}
	}
	/*
	Causes get annotation value
	*/
	function causes_payment_konnectors($cause_guid, $konnector){
		$return = 0;
		$table = CAUSES_DB_TABLE;
		$query = "select sum(amount) as amount from $table where causeid = $cause_guid and konnectorid = $konnector ";
		$data = get_data($query);
		$amount = $data[0]->amount;
		if( $amount > 0){
			$return = $amount;
		}
		return $return;
	}
	/*
	Target Percentage
	*/
	function causes_target_percentage($causesid){
		$return = 0;
		$causes = get_entity($causesid);
		$amount = (int) $causes->target;
		if($amount > 0){
			$raised = causes_amount_raised($causesid);
			$return = round($raised /$amount * 100,1);
		}	
		return $return;
	}
	/* 
	Fund raised
	*/
	function causes_amount_raised($causesid){
		$table = CAUSES_DB_TABLE;
		$query = "select sum(amount) as amount from $table where causeid = $causesid  ";
		$data = get_data($query);
		$raised = $data[0]->amount;
		if(!$raised){
			$raised = 0;
		}	
		return $raised;
	}	
	/* 
	Fund still needed
	*/
	function causes_amount_still_needed($causesid){
		$causes = get_entity($causesid);
	//	$raised = causes_amount_raised($causesid);
		$target = $causes->target;
		return $target;		// Fix for showing the total goal instead of fund needed.
	}
	/*
	function causes_amount_still_needed($causesid){
		$causes = get_entity($causesid);
		$raised = causes_amount_raised($causesid);
		$target = $causes->target;
		return $target;		// Fix for showing the total goal instead of fund needed.
		$needed = $target - $raised;
		if($needed < 0){
			$needed = 0;
		}
		return $needed ;
	}	
	*/
	/*
	View module
	*/
	function causes_view_module($type, $title, $body, $vars = array()) {
		$vars['class'] = elgg_extract('class', $vars, '') . " elgg-module-$type";
		$vars['title'] = $title;
		$vars['body'] = $body;
		return elgg_view('causes/module', $vars);
	}
	/*
	Category Title
	*/
	function causes_category_title($title){
		$return = NULL;
		$category = elgg_get_plugin_setting('category','causes');
		$fields = explode(",", $category);
		foreach ($fields as $val){
			$key = elgg_get_friendly_title($val);
			if($title == $key){
				$return = ucfirst($val);
				
			}
		}
		return $return;
	}
	/*
	Causes Category
	*/
	function causes_category($null = true){
		$category = elgg_get_plugin_setting('category','causes');
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
	/*
	export cv link
	*/
	function causes_export_buttons($causes) {
		$causes_guid = $causes->getGUID();
		if($causes->canEdit()){
			elgg_register_menu_item('title', array(
					'name' => elgg_echo('event:export'),
					'href' => elgg_get_site_url() . "causes/export/{$causes_guid}",
					'text' => elgg_echo('causes:export'),
					'link_class' => 'elgg-button elgg-button-action',
				)
			);
		}
	}
	
	function causes_anonymous_guid(){
		$site = get_config('site');
		$site_guid = $site->guid;
		$user = elgg_get_entities_from_relationship(array(
			'relationship' => 'anonymous_user',
			'relationship_guid' => $site_guid,
			'inverse_relationship' => false,
			
		));
		return $user[0]->guid;
	}
	
	
	function causes_list_latest_donors($guid, $offset = 0, $limit = 10, $pagination = false, $fullview = false){
		$table = CAUSES_DB_TABLE;
		if($pagination){
			$query = " select count(id) as cnt from $table where causeid = $guid ";
			$data = get_data($query);
			$count = $data[0]->cnt;
		}
		$query = " select * from $table where causeid = $guid order by id desc limit $offset,$limit ";
		$data = get_data($query);
		if($fullview){
			return elgg_view('causes/statistics',array('offset' => $offset, 'limit' => $limit, 'data' => $data, 'count' => $count, 'pagination' => $pagination));
		}else{
			return elgg_view('causes/donors_list',array('offset' => $offset, 'limit' => $limit, 'data' => $data, 'count' => $count, 'pagination' => $pagination));
		}
	}
	
	function causes_groups(){
		$option = array();
		$were['name'] = 'approved';
		$were['value'] = 1;
		$group = elgg_get_entities_from_metadata(array('type' => 'group', 'limit' => 0, 'metadata_name_value_pairs'=>$were));
		$option[NULL] = elgg_echo('causes:defaut_option');
		foreach($group as $key => $value){
			$guid = $value->guid;
			$name = $value->name;
			if($name){
				$option[$guid] = ucwords($name);
			}
		}
		return $option;
	}
	
	function causes_events(){
		$option = array();
		$were['name'] = 'period_to';
		$were['value'] = date('Y-m-d');
		$were['operand'] = '>';
		$events = elgg_get_entities_from_metadata(array('type' => 'object',	'subtype' => 'event', 'limit' => 0 ));
		foreach($events as $key => $value){
			$guid = $value->guid;
			$name = $value->title;
			if($name){
				$option[$guid] = ucwords($name);
			}
		}
		asort($option);
		$new_array = array(0 => elgg_echo('causes:defaut_option')) + $option;
		return $new_array;
	}
	
	function causes_convert_date($date){
		$dateis = split("-",$date);
		if($dateis){
			return $dateis[1].'-'.$dateis[2].'-'.$dateis[0];
		}
		return NULL;	
	}
	
	function causes_new_konnector_relation($event_guid = 0, $group_guid = 0, $user_guid = 0){
		$table = elgg_get_config('dbprefix') . 'entity_relationships';
		$query = "select guid_one from $table where relationship LIKE  'causes_event_supported' and guid_two = $event_guid order by id desc ";
		$data = get_data($query);
		foreach($data as $relation){
			$guid_one = $relation->guid_one;
			$query = "select guid_one from $table where relationship LIKE  'causes_supported' and guid_two =  $group_guid and guid_one = $guid_one  ";
			$relation_data = get_data($query);
			if($relation_data){
				add_entity_relationship($guid_one, 'causes_konnector', $user_guid);
				add_entity_relationship($user_guid, 'member', $guid_one);
				return;
			}
		}
	}
	
?>