<?php
/**
 * Event profile summary
 *
 * @uses $vars['event']
 */

if (!isset($vars['entity']) || !$vars['entity']) {
	echo elgg_echo('causes:notfound');
	return true;
}

$causes = $vars['entity'];
$owner = $causes->getOwnerEntity();

?>
<div class="elgg-module elgg-module-group elgg-module-info">
	<div class="groups-profile clearfix elgg-image-block">
		<div class="groups-profile-fields elgg-body">
			<?php
				echo elgg_view('causes/profile/fields', $vars);
			?>
		</div>
	</div>
</div>	
<?php
?>

