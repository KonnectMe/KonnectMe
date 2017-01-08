<?php
/**
 * Site navigation menu
 *
 * @uses $vars['menu']['default']
 * @uses $vars['menu']['more']
 */
$default_items = elgg_extract('default', $vars['menu'], array());
$more_items = elgg_extract('more', $vars['menu'], array()); 
$menu = array_merge($default_items, $more_items);
echo '<ul class="elgg-menu elgg-menu-site elgg-menu-site-default clearfix">';
	if ($menu) {
		echo '<li class="elgg-more">';

		$more = elgg_echo('kme:tools');
		echo "<a href=\"#\">$more</a>";
		
		echo elgg_view('navigation/menu/elements/section', array(
			'class' => 'elgg-menu elgg-menu-site elgg-menu-site-more', 
			'items' => $menu,
		));
		
		echo '</li>';
	}
echo '</ul>';