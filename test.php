<?php

require_once(dirname(__FILE__) . "/engine/start.php");
// $admins = elgg_get_admins();
// login($admins[0]);
// forward();
return;
	$eventid = 926979;
	$ticket_table = elgg_get_config('dbprefix')."events_tickets";
	$ticket = get_data("select *from $ticket_table where event_guid=$eventid ");
	if($ticket){
		foreach($ticket as $event_ticket){
			print_r($event_ticket);
			echo "<br>||||||||";
		}
	}	