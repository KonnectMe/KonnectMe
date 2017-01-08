<?php

elgg_register_event_handler('init', 'system', 'galliMassmail_init');

function galliMassmail_init() {
	elgg_register_admin_menu_item('administer', 'galliMassmail', 'administer_utilities');

	$base = elgg_get_plugins_path() . "galliMassmail/actions/galliMassmail";
	elgg_register_action('galliMassmail/compose', "$base/compose.php");
	elgg_register_action('galliMassmail/delete', "$base/delete.php");
	elgg_register_action('galliMassmail/event_confirmation', "$base/event_confirmation.php");

	if(elgg_get_plugin_setting('enable_massmail', 'galliMassmail') == 'yes'){
		elgg_register_plugin_hook_handler('cron', 'minute', 'galliMassmail_send_mails');
		elgg_register_plugin_hook_handler('cron', 'minute', 'galliMassmail_send_event_confirmation');
	}
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'galliMassmail_entity_menu_setup');

	elgg_register_event_handler('pagesetup', 'system', 'galliMassmail_setup_sidebar_menus',1000);	
	elgg_register_page_handler('massmail', 'galliMassmail_page_handler');		
}	

function galliMassmail_setup_sidebar_menus() {
	$page_owner = elgg_get_page_owner_entity();
	if ($page_owner && $page_owner instanceof ElggGroup) {
		if (elgg_is_logged_in() && $page_owner->canEdit() ) {
			$url = elgg_get_site_url() . "massmail/groups/{$page_owner->getGUID()}";
			elgg_register_menu_item('page', array(
				'name' => 'gallimassmail:mailall',
				'text' => elgg_echo('gallimassmail:mailall'),
				'href' => $url,
			));						
		}
	}
}

function galliMassmail_page_handler($page){
	$pages = dirname(__FILE__) . '/pages/galliMassmail';
	switch ($page[0]) {
		case "groups":
			set_input('pageowner_guid', $page[1]);
			include "$pages/groups.php";
			break;
		case "events":
			set_input('event_guid', $page[1]);
			include "$pages/events.php";
			break;
		case "event_confirmation":
			set_input('event_guid', $page[1]);
			include "$pages/event_confirmation.php";
			break;
		default:
			return false;
	}
	return true;	
}

function galliMassmail_send_mails($hook, $entity_type, $returnvalue, $params){
	$mails = elgg_get_entities_from_metadata(array('types' => 'object', 'subtypes' => 'galliMassmail', 'metadata_name_value_pairs' => array('mail_type' => 'regular_massmail', 'complete' => false), 'limit' => 1 ));
	$site = elgg_get_site_entity();
	if ($site && $site->email) {
		$from = $site->email;
	} else {
		$from = 'noreply@' . get_site_domain($site->guid);
	}
	$limit = 25;
	if($mails){
		foreach($mails as $mail){
			$subject = $mail->title;
			$message = $mail->description;
			$offset = (int) $mail->offset;
			$increment = (int) $limit + $offset;
			$container_guid = (int) $mail->container_guid;
			$container = get_entity($container_guid);
			if($container_guid && $container){
				if($container instanceof ElggGroup){
					$relation = "member";
					$inverse = true;
				} else {
					$relation = false;
					$inverse = true;
				}	
			} else {
				$relation = false;
				$inverse = true;
			}	
			$emails = galliMassmail_select_emails($limit, $offset, $container_guid, $relation, $inverse);
			if($emails){
				foreach ($emails as $email) {
					$to = $email->email;
					if ($to && is_email_address($to)) {
						elgg_send_email($from, $to, $subject, $message);
					}
				}
				galliMassmail_set_metadata($mail, 'offset', $increment);
			} else {
				galliMassmail_set_metadata($mail, 'complete', true);
			}
		}	
	}
}	
 
function galliMassmail_send_event_confirmation($hook, $entity_type, $returnvalue, $params){
	// Get all mass mails for event notifications
	$events_mail = elgg_get_entities_from_metadata(array('types' => 'object', 'subtypes' => 'galliMassmail', 'metadata_name_value_pairs' => array('mail_type' => 'event_massmail', 'complete' => false), 'limit' => 10 ));
//	print_r($events_mail);
//	die;
	$site = elgg_get_site_entity();
	if ($site && $site->email) {
		$from = $site->email;
	} else {
		$from = 'noreply@' . get_site_domain($site->guid);
	}
	if($events_mail){
		foreach($events_mail as $mail){
			$subject = $mail->title;
			$message = $mail->description;
			$container_guid = $mail->container_guid;
			$container = get_entity($container_guid);
			if($container_guid && $container){
//				echo "container present<br>";
				if( $container->getSubtype() == "event" ){
				//	echo "$container_guid present<br>";
					$email_field = (int) $mail->email_field;
					if ($email_field) {
//						echo "$email_field present<br>";
						$offset = (int) $mail->offset;
						elgg_load_library('elgg:event');
						$ticket_data = event_ticket_info($container_guid, array($email_field), 5, $offset);
//						print_r($ticket_data);
						if($ticket_data){
//							echo "Ticketdata present<br>";
							foreach($ticket_data as $data){
								$to_address = $data[$email_field];
								$purchased_ticket_type = $data['ticket'];
								if($to_address  && is_email_address($to_address)) {
//									echo "Email address present<br>";
									// Get the ticket type
									if($purchased_ticket_type){
										$append = "";
										if($mail->append_ticket == "yes"){
											$append .= "
											
											Following is your ticket information for $container->title
											";
											$ticket_info = $data['ticket_data'];
											$append .= '<table width="100%" border="0" cellspacing="2" cellpadding="5">';
											$append .= "<tr><td width='50%'>Ticket : </td><td>$purchased_ticket_type.</td></tr>";
											foreach($ticket_info as $datas){
												foreach($datas as $k => $v){
													$append .= '<tr><td width="50%">'.ucfirst($k).' : </td><td>'.$v.'</td></tr>';
												}
											}
											$append .= '</table>';	
										}	
										if(elgg_send_email($from, $to_address, $subject, $message.$append)) {
											echo "Mail send to $to_address <br>";
										}										
									}								
								} else {
									echo "$to_address is not an email<br>"; 
								}
							}	
							$incr = (int) $offset + 5;
						 	galliMassmail_set_metadata($mail, 'offset', $incr);						
						} else {
							echo "No tickets<br>";
							galliMassmail_set_metadata($mail, 'complete', true);
						}						
					} else {
						echo "No email field<br>";
					}
				} else {
					echo "container not an event<br>";
				}
			} else {
				echo "No container<br>";
			}
		}
	}		
}	

function galliMassmail_select_emails($limit = 10, $offset = 0, $container_guid = 0 , $relation = false, $inverse = true){
	$dbPrefix = elgg_get_config('dbprefix');
	if($container_guid && $relation && $inverse){
		// this is a group mass mail
		$query = "SELECT email from {$dbPrefix}users_entity JOIN {$dbPrefix}entity_relationships ON {$dbPrefix}entity_relationships.guid_one = {$dbPrefix}users_entity.guid WHERE {$dbPrefix}entity_relationships.guid_two = {$container_guid} ORDER BY {$dbPrefix}users_entity.guid ASC LIMIT $offset, $limit";
	} else {
		// this is a site mass mail
		$query = "SELECT email from {$dbPrefix}users_entity ORDER BY {$dbPrefix}users_entity.guid ASC LIMIT $offset, $limit";
	}
	return get_data($query);
}

function galliMassmail_set_metadata($entity, $md_name, $md_value, $delete = false){
	$ia = elgg_set_ignore_access(true);
	if($delete){
		$entity->delete();
	} else {
		$entity->$md_name = $md_value;
		$entity->save();
	}
	elgg_set_ignore_access($ia);
}

function galliMassmail_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}
	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'galliMassmail') {
		return $return;
	} 
	foreach ($return as $index => $item) {
		if (($item->getName() == 'edit') or ($item->getName() == 'access')) {
			unset($return[$index]);
		}
	}
	if($entity->complete != true){
		$status = elgg_echo('galliMail:status:incomplete');
	} else {
		$status = elgg_echo('galliMail:status:complete');
	}
	$options = array(
		'name' => 'status',
		'text' => $status,
		'href' => false,
		'priority' => 200,
	);
	$return[] = ElggMenuItem::factory($options);
	return $return;
}
