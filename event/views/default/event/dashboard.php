<?php
/**
 * event dashboard
 *
 * package event
 */
elgg_load_css('tablesorter:css');
elgg_load_js('tablesorter:js');
$eventid = (int) get_input('eventid');
$event = get_entity($eventid);
if(!$event){
	return;
}	
$fn = $event->guid."_report";
$cache_filename = elgg_get_data_path()."html_cache/$fn.php";
$file_time = filemtime( $cache_filename );

if ($file_time && filesize($cache_filename) > 0){
	if( time() - $file_time > 3600){
		unlink($cache_filename);
	} else {
		include $cache_filename;
		return;
	}	
}	
ob_start();

$total_amount = 0;
$total_member = 0;
$total_runners = 0;
$site_url = elgg_get_site_url();
if (!empty($vars['sponsers']) && is_array($vars['sponsers'])) {
	$sponsor_count = count($vars['sponsers']);
	$user = elgg_get_logged_in_user_entity();
	$ticket_table = elgg_get_config('dbprefix')."events_tickets";
	$ticket = get_data("select *from $ticket_table where event_guid=$eventid ");

	?>
	<script type="text/javascript">
	$(function() {		
		$("#tablesorter-demo").tablesorter({sortList:[[0,0],[2,1]], widgets: ['zebra']});
		$("#options").tablesorter({sortList: [[0,0]], headers: { 3:{sorter: false}, 4:{sorter: false}}});
	});	
	</script>
	<div class="logintocomment">
		This report was generated on <?php echo date('l jS \of F Y h:i:s A');?><br>
		Next report will be generated one hour from now.
	</div>	
				<?php
					$total_sold = 0;
					$statistics = "
					<table width='100%' cellspacing='5' cellpadding='5' class='highlighted konnectorstable'>
						<tbody>
							<tr class='tableheader'>
								<td>Ticket types</td>
								<td>Tickets sold</td>
								<td>Fund raised</td>
							</tr>";
					if($ticket){
						foreach($ticket as $event_ticket){
							$g = $event_ticket->id;
							$count = (int) $event_ticket->sold;
							$total_sold_price = $count * $event_ticket->price;
							$total_runners += $count;
							$total_sold += $total_sold_price;
							$ticket_type = elgg_echo('event:runners', array(ucfirst($event_ticket->title)));
							$statistics .= "<tr>
												<td>$ticket_type</td>
												<td>$count</td>
												<td>$total_sold_price</td>
											</tr>";
						}
					}
					$statistics .= "<tr>
									<td>Total</td>
									<td>$total_runners</td>
									<td>$total_sold</td>
									</tr>";
									
					$statistics .= "</tbody></table>";				
					echo $statistics;
				?>
      
		<table id="tablesorter-demo" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
			<thead>
				<tr>
					<th><?php echo elgg_echo("event:non_profits") ?></th>
					<th><?php echo elgg_echo("event:runner") ?></th>
					<th><?php echo elgg_echo("event:raised") ?></th>
					<th><?php echo elgg_echo("event:donors") ?></th>
				</tr>
		</thead>
        
		<tbody>
        <?php
			foreach ($vars['sponsers'] as $group) {
			$icon = elgg_view_entity_icon($group, 'tiny', array('use_hover' => 'true'));
			$group_title = elgg_view('output/url', array(
				'href' => $group->getURL(),
				'text' => $group->name,
				'is_trusted' => true,
			));		
$body = <<<HTML
<h4>$group_title</h4>	
HTML;
			$alt = '';
 ?>
		  <tr>
			<td><?php echo elgg_view_image_block($icon, $body, array('image_alt' => $alt))?></td>
			<td><?php 
				echo $no = (int)event_total_participants($group->guid, $eventid);
			 	$total_member += $no;
			 ?></td>
			<td><?php 	
				$amount = (int) event_donation_raised_by_nonprofit($eventid,$group->guid);
				echo "$ ".$amount;
				$total_amount += $amount;
						
			 ?></td>
			<td><?php echo event_unique_donors($eventid,$group->guid); ?></td>
		  </tr>
		  <?php
		 }
		 ?>	
		</tbody>  
	  <tr >
		<td><?php echo elgg_echo("event:total") ?></td>
		<td><?php echo (int)$total_member;  ?></td>
		<td>$ <?php echo (int)$total_amount;?></td>
		<td>&nbsp;</td>
	  </tr>  
</table>
	
<?php
	// echo $statistics;
	echo "<div>Total Non-Profit partners : $sponsor_count</div>";
} else {
	$member = elgg_list_entities_from_relationship(array(
					'relationship' => 'event_join',
					'relationship_guid' => $eventid,
					'inverse_relationship' => false,
			));
	if($member){	
		event_sidebar_navigation($event);	
		echo $member;
	}else{
		echo '<p class="mtm">' . elgg_echo('event:sponsers:none') . "</p>";
	}
}

$buff = ob_get_contents(); 
$file = fopen( $cache_filename, "w" );
fwrite( $file, $buff );
fclose( $file );
ob_end_flush();