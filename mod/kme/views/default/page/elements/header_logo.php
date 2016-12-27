<?php
/**
 * Elgg header logo
 *
 */

$site = elgg_get_site_entity();
$site_name = $site->name;
$site_url = elgg_get_site_url();
?>
<div class="elgg-col-1of4 fleft">
	<a class="elgg-heading-site" href="<?php echo $site_url; ?>">
		<img src="<?php echo IMG_PATH;?>sitelogo.png">
	</a>
</div>

<div class="elgg-col-2of4 fright">
	<?php echo elgg_view_menu('righttop', array('sort_by' => 'priority'));?>
</div>

<?php
// navigation defaults to breadcrumbs
echo elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));
