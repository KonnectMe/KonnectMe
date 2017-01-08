<?php
if (!isset($vars['entity']) || !$vars['entity']) {
	echo elgg_echo('causes:notfound');
	return true;
}

$causes = $vars['entity'];
$owner = $causes->getOwnerEntity();

?>
<div class="groups-profile clearfix elgg-image-block">
	<div class="elgg-image">
		<div class="groups-profile-icon">
			<?php 	$url = causesCoverartURL($causes->guid,'large');
					echo $icon = "<img src='{$url}' alt='{$vars['entity']->title}'/>"; 
			 ?>
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

	<div class="groups-profile-fields elgg-body">
		<?php
			echo elgg_view('causes/fields', $vars);
		?>
	</div>
</div>
