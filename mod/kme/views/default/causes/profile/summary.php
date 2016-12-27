<?php
/**
 * Event profile summary
 *
 * @uses $vars['event']
 */

if (!isset($vars['entity']) || !$vars['entity']) {
	echo elgg_echo('groups:notfound');
	return true;
}

$causes = $vars['entity'];
$owner = $causes->getOwnerEntity();

?>
<div class="groups-profile clearfix elgg-image-block">
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
			echo elgg_view('causes/sidebar/progress',array('entity'=> $causes));
			echo elgg_view('causes/profile/fields', $vars);
		?>
	</div>
</div>