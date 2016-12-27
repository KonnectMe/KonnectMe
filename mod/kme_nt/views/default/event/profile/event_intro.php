<?php
if (!isset($vars['entity']) || !$vars['entity']) {
	echo elgg_echo('event:notfound');
	return true;
}

$event = $vars['entity'];
$event_metadata = $vars['event_metadata'];
$owner = $event->getOwnerEntity();
if(!$owner){
	return;
}
?>
<div class="elgg-module elgg-module-group elgg-module-info">
	<div class="elgg-body">
		<div class="elgg-col-1of3 fleft">
			<div class="elgg-image">
				<div class="groups-profile-icon">
					<?php 
					$url = eventCoverartURL($event->guid, 'medium', $event_metadata[0]->icon_time);
					echo $icon = "<img src='{$url}' alt='{$vars['entity']->title}'/>";  ?>
				</div>
				<!--
				<div class="groups-stats">
					<p>
						<b><?php echo elgg_echo("event:owner"); ?>: </b>
						<?php
							echo elgg_view('output/url', array(
								'text' => $owner->name,
								'value' => $owner->getURL(),
								'is_trusted' => true,
							));
						?>
					</p>
					<p>
					<?php
						if($event_metadata[0]->isfree){
							$noofmember = event_count_relation($event->guid);
						}else{
							$noofmember = event_get_total_tickets_sold($event);
						}
						
						echo elgg_echo('event:members') . ": " . $noofmember;
					?>
					</p>
					<p>
						<div class="addthis_toolbox addthis_default_style ">
						<a class="addthis_button_preferred_1"></a>
						<a class="addthis_button_preferred_2"></a>
						<a class="addthis_button_preferred_3"></a>
						<a class="addthis_button_preferred_4"></a>
						<a class="addthis_button_compact"></a>
						<a class="addthis_counter addthis_bubble_style"></a>
						</div>
						<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
						<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515a856e156c427f"></script>		
					</p>	
				</div>
				-->
			</div>
		</div>	
		<div class="elgg-col-2of3 fright">
			<div class="groups-profile-fields elgg-body">
				<?php
					$guid = $event->guid;
					$data =  get_events("guid=$guid");
					$profile_fields = array('description'=>'longtext', 'brief_description'=>'longtext', 'venue'=>'text', 'location'=>'text', 'tags'=>'tags');
					if (is_array($profile_fields) && count($profile_fields) > 0) {
						$even_odd = 'odd';

						foreach ($profile_fields as $key => $valtype) {
							if ($key == 'name' || $key == 'description' ) {
								continue;
							}

							$value = $data[0]->$key;
							if (empty($value)) {
								continue;
							}

							$options = array('value' => $data[0]->$key);
							if ($valtype == 'tags') {
								$options['tag_names'] = $key;
							}

							echo "<div class=\"{$even_odd}\">";
							echo "<b>";
							echo elgg_echo("event:$key");
							echo ": </b>";
							echo elgg_view("output/$valtype", $options);
							echo "</div>";

							$even_odd = ($even_odd == 'even') ? 'odd' : 'even';
						}
					}

					echo "<div class=\"{$even_odd}\">";
					echo "<b>";
					echo elgg_echo("event:period");
					echo ": </b>";
					echo event_convert_date($data[0]->start_date);
					echo "&nbsp;".elgg_echo("event:to")."&nbsp;";
					echo event_convert_date($data[0]->end_date);
					echo "</div>";
				?>
			</div>	
		</div>		
	</div>
</div>	