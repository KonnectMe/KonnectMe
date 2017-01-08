<?php
	$event_guid = (int) get_input('eventid', null);
	if(!$event_guid){
		return;
	}	

	$event = get_entity($event_guid);
	if(!$event->canEdit()){
		return;
	}
	elgg_load_library('elgg:event');
	
	$field_id = (int) get_input('field_id', null);
	$q = sanitise_string(get_input('q', null));
	
	$action = elgg_get_site_url()."event/manage-tickets/$event_guid/";
	echo "<form method='get' action='{$action}' class='mtl mbm'>";
		echo "<label>Select field name</label><br>";
		$dropdown = event_ticket_form_fields($event_guid);
		echo elgg_view('input/dropdown', array('name' => 'field_id', 'options_values' => $dropdown, 'value' => $field_id));
		
		echo "<label>Enter search term</label><br>";
		echo elgg_view('input/text', array('name' => 'q', 'value' => $q, 'class'=>'mbs'));
		
		echo elgg_view('input/submit', array('value' => elgg_echo('Find tickets')));
	echo "</form>";
	
	if($field_id && $q){
		echo "<div class='mtl'>";
		
		$prefix = elgg_get_config('dbprefix');
	//	$table_ticket = $prefix."events_purchase_info";
		$table_userinfo = $prefix."events_purchase_userinfo";
		
		$sql = "select * from $table_userinfo where form_guid='$field_id' and value like '%$q%'";
	//	$sql = "select * from $table_ticket where event_guid = '$event_guid' and id IN(select purchase_guid from $table_userinfo where form_guid ='$field_id' and value like '%$q%' ) ";
		$tickets = get_data($sql);
	//	print_r($tickets);
		$total = count($tickets);
		if($total < 1){
			echo "<h3>$total tickets found</h3><br>";
			return;
		} else {
			echo "<h3>$total tickets found</h3><br>";
			echo "<ul class='mtl'>";
			foreach($tickets as $ticket){
				$purchase_guid = $ticket->purchase_guid;
				echo "<li>". elgg_view('output/url', array('href' => "event/edit_info/$event_guid/$purchase_guid", 'text' => "Ticket No: $purchase_guid")) ."</li>";
			}
			echo "</ul>";
		}

		echo "</div>";
	}	
?>