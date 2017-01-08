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
<div class="groups-profile contentWrapper clearfix elgg-image-block">
	<?php echo elgg_view('event/filter_tab_event', $vars);?>
	<div class="groups-profile-fields elgg-body">
		<?php
			echo elgg_view('event/profile/fields', $vars);
		?>
	</div>
</div>

