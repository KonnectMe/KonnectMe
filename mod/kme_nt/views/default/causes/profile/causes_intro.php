<?php
if (!isset($vars['entity']) || !$vars['entity']) {
	echo elgg_echo('causes:notfound');
	return true;
}

$causes = $vars['entity'];
$owner = $causes->getOwnerEntity();
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
					$url = causesCoverartURL($causes->guid,'large');
							echo $icon = "<img src='{$url}' alt='{$vars['entity']->title}'/>";   ?>
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
						
						$noofmember = causes_count_relation($causes->guid);
						echo elgg_echo('causes:konnectors') . ": " . $noofmember;
					?>
					</p>
				</div>				
			</div>
		</div>	
		<div class="elgg-col-2of3 fright">
			<?php echo elgg_view('causes/sidebar/progress',array('entity'=> $causes));?>
		</div>		
	</div>
</div>	