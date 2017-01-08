<?php
/**
 * Layout for main column with one sidebar
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['content'] Content HTML for the main column
 * @uses $vars['sidebar'] Optional content that is displayed in the sidebar
 * @uses $vars['title']   Optional title for main content area
 * @uses $vars['class']   Additional class to apply to layout
 * @uses $vars['nav']     HTML of the page nav (override) (default: breadcrumbs)
 */

$class = 'elgg-layout elgg-layout-one-sidebar clearfix';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}
$content_wrapper_loaded = $vars['content_wrapper_loaded'];
if(isset($content_wrapper_loaded) && $content_wrapper_loaded == true){
	$cw_class = "";
} else {
	$cw_class = "contentWrapper";
}	
?>

<div class="<?php echo $class; ?>">
	<div class="elgg-sidebar">
		<?php
			echo elgg_view('page/elements/sidebar', $vars);
		?>
	</div>

	<div class="elgg-main elgg-body">
		<?php
			if (isset($vars['title'])) {
				echo elgg_view_title($vars['title']);
			}
		//	echo "<div class='{$cw_class}'>";
				// @todo deprecated so remove in Elgg 2.0
				if (isset($vars['area1'])) {
					echo $vars['area1'];
				}
				if (isset($vars['content'])) {
					echo $vars['content'];
				}
		//	echo "</div>";
		?>
	</div>
</div>
