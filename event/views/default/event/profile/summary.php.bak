<?php
if (!isset($vars['entity']) || !$vars['entity']) {
	echo elgg_echo('groups:notfound');
	return true;
}

$event = $vars['entity'];
$event_metadata = $vars['event_metadata'];
$owner = $event->getOwnerEntity();
if(!$owner){
	return;
}	
?>
<div class="groups-profile contentWrapper clearfix elgg-image-block">
	<?php echo elgg_view('event/filter_tab_event', $vars);?>
	<div class="elgg-image">
		<div class="groups-profile-icon">
			<?php $url = eventCoverartURL($event->guid, 'medium', $event_metadata[0]->icon_time);
			echo $icon = "<img src='{$url}' alt='{$vars['entity']->title}'/>";  ?>
		</div>
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
				<!-- AddThis Button BEGIN -->
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
				<!-- AddThis Button END -->			
			</p>	
		</div>
	</div>

	<div class="groups-profile-fields elgg-body">
		<?php
			echo elgg_view('event/profile/fields', $vars);
		?>
	</div>
</div>

