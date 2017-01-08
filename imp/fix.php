<?php
set_time_limit(1000000000000000000);

require_once(dirname(dirname(__FILE__)) . "/engine/start.php");
	$site = elgg_get_site_entity();

	if ($site && $site->email) {
		$from = $site->email;
	} else {
		$from = 'noreply@' . get_site_domain($site->guid);
	}
	
elgg_send_email($from, 'info@webgalli.com', 'sub', 'message');


die;
//print_r(get_user_by_email('saratogasudha@gmail.com'));
$adminuser = get_user_by_username('bharad');
// login($adminuser);
//$e = get_entity(51376);
//print_r($e);
forward('http://konnectme.org/event/edit_info/44334/53259');
//validate_username('dfsd fsd sd sf');
// ,48039,48038
// 59/44334/48047,48048
/*
elgg_load_library('elgg:event');
$custom = "50366/44334/53259";
// Our API's will go here //
$paypalvalues = explode("/",$custom); // Format is PURCHASED_USER_GUID/ EVENT_GUID / PURCHASED_TICKETS_GUID
$user_guid = (int) $paypalvalues[0];
$user = get_user($user_guid);
$event_guid = (int) $paypalvalues[1];
$event = get_entity($event_guid);
$purchased_ticketArray = split(",", $paypalvalues[2]);			
if($user && $event && $purchased_ticketArray){
	$index = 0;
	foreach($purchased_ticketArray as $ticket){
		$data = get_entity($ticket);
		$guid = $data->guid;
		$price = 0;
		event_save_md_ignoring_access($data, 'status', 1);
		// VIP, BALCONY etc
		$relationship = 'event_join_ticket_'.$event_guid;
		$tickets = elgg_get_entities_from_relationship( array(
						'relationship' => $relationship,
						'relationship_guid' => $guid,
						'inverse_relationship' => FALSE
					));
		$ticket_guid = $tickets[$index]->guid;
		if($ticket_guid){
			//delete current relation
			remove_entity_relationship($guid, $relationship, $ticket_guid);
			// create new relation
			$relationship = 'event_purchase_ticket_'.$event_guid;
			event_register_relationship($guid, $ticket_guid, $relationship);							
			$ticketType = $tickets[$index];
			$price = (int) $ticketType->price;
			$sold = (int) $ticketType->sold + 1;;
			event_save_md_ignoring_access($ticketType, 'sold', $sold);						
		}
		$relationship = 'event_join_sponser_'.$event_guid;
		$sponser = elgg_get_entities_from_relationship( array(
						'relationship' => $relationship,
						'relationship_guid' => $guid,
						'inverse_relationship' => FALSE
					));
		$sponser_guid = $sponser[$index]->guid;
		if($sponser_guid){
			$relationship = 'event_nonprofit_'.$event_guid;
			event_register_relationship($guid, $sponser_guid, $relationship);
		}
	}
} else {
	notify_paypal_transaction( serialize($_POST), "Failed ticket sale");
}	
//create new river
add_to_river('river/object/event/ticket','create', $user_guid, $event_guid);
event_create_user_relationship($event_guid, $user_guid);
//------------ end our api
*/










/* 
// ticket approval guest/

elgg_load_library('elgg:event');
$custom = "375/376";
$ia = elgg_set_ignore_access(true);
$paypalvalues = explode("/",$custom); // Format is tablerow
foreach($paypalvalues as $tableid){
	$table = elgg_get_config('dbprefix').'events';
	$sql = "select *from $table where id = '$tableid' ";
	$data = get_data($sql);
	if($data){
		$eventguid = $data[0]->event_guid;
		$ticket_guid = $data[0]->ticket_guid;
		$np_guid = $data[0]->np_guid;
		$ticket_data = unserialize($data[0]->ticket_data);
		$event = get_entity($eventguid);
		$ticket = get_entity($ticket_guid);
		//new ticket  entity
		$join = new ElggObject;
		$join->subtype = "event_join";
		$join->owner_guid = $event->owner_guid;
		$join->container_guid = (int)$eventguid;
		$join->access_id = 2;
		$join->status = 1;
		foreach($ticket_data as $key=>$value){
			$join->$key = $value;
		}
		$guid = $join->save();
		// create new relation
		$relationship = 'event_purchase_ticket_'.$eventguid;
		event_register_relationship($guid, $ticket_guid, $relationship);
		$price = (int) $ticket->price;
		$sold = (int) $ticket->sold + 1;
		event_save_md_ignoring_access($ticket, 'sold', $sold);
		if($np_guid){
				$relationship = 'event_nonprofit_'.$eventguid;
				event_register_relationship($guid, $np_guid, $relationship);
				$relationship = 'event_join_sponser_'.$eventguid;
				event_register_relationship($guid, $np_guid, $relationship);
		}
		$subject = "Confirmation of your Ticket purchase for $event->title";
		$event_url = $event->getURL();
					$body = "
					Hi,

					This is an acknowledgement for the purchase of your ticket for $event->title

					To learn more about the event, visit $event_url

					Thanks and Regards,
					KonnectMe Team";
				//	if(!elgg_send_email('support@konnectme.org', $donoremail, $subject, $body)){
					if(!mail($donoremail,$subject, $body)){
						notify_paypal_transaction(serialize($_POST),"Failed email alert");
					}
					mail('info@webgalli.com',$subject, $body);
					$deletQuery = "delete from $table where id=$tableid";
	//				delete_data($deletQuery);
	} // if close
}// foreach close
elgg_set_ignore_access($ia);
*/
















/*
$tickets = elgg_get_entities(array('type' => 'object', 'subtype' =>'event_join', 'limit'=>0, 'container_guid' => 44334));
$i = 0;
foreach($tickets as $t){
	$user = get_user($t->owner_guid);
	echo $i .")". $t->guid ." : ".$user->username;
	echo "<br>";
	$i++;
}	
*/








/*
$name = 'amrita';
$username = 'amritashas3';
$pw = '3292850d41104b687148f2d31f0252be';
$email = 'amrita@gmail.com';
$salt = '750c0744';
$og = '47782';
$guid = register_user($username, $pw, $name, $email, TRUE);
$owner = get_user($guid); 
$owner->salt = $salt;
$owner->password = $pw;
$owner->old_guid = $og;
$owner->save();
$pre = elgg_get_config('dbprefix');
$query = "UPDATE {$pre}users_entity set password='$pw', salt='$salt' where guid=$guid";		
$result = update_data($query);
*/











/*
elgg_load_library('elgg:event');

$param['type' ] = 'object';
$param['subtype' ] = 'event_join';
$param['limit' ] = 0;
$param['container_guid' ] = 44334;
$param['owner_guid' ] = $adminuser->guid;
$param['metadata_name_value_pairs' ] = array('status' => 1);
$param['order_by' ] = 'guid asc';
$purchased = elgg_get_entities_from_metadata($param);	
$relationship = 'event_nonprofit_44334';
foreach($purchased as $t){
	echo $t_guid = $t->guid;
	$np = elgg_get_entities_from_relationship(array('relationship_guid'=>$t_guid, 'relationship'=>$relationship));
	foreach($np as $p){
		echo " | $p->name";
		echo " | $p->guid";
		$p_guid = $p->guid;
		$relationship2 = 'event_join_sponser_44334';
		
		if (!check_entity_relationship($t_guid, $relationship2, $p_guid)){
			add_entity_relationship($t_guid, $relationship2, $p_guid);
		} else {
			echo " | relation exists";
		}	
	}	
	echo"<br>";
}	
*/

// SELECT * FROM `elgg_entity_relationships` WHERE relationship ='event_purchase_ticket_44334' and guid_one not in (select guid_one from elgg_entity_relationships where relationship ='event_nonprofit_44334' )