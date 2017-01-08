<?php
/**
 * Elgg footer
 * The standard HTML footer that displays across the site
 *
 * @package Elgg
 * @subpackage Core
 *
 */

// echo elgg_view_menu('footer', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));

$powered_url = IMG_PATH . "cards.png";

echo '<div class="mts clearfloat float-alt">';
echo elgg_view('output/url', array(
	'href' => false,
	'text' => "<img src=\"$powered_url\" class=\"bstooltip\" alt=\"Secure payment systems\" title=\"Secure payment systems\" width=\"215\" height=\"23\" />",
	'class' => '',
	'is_trusted' => true,
));
echo '</div>';
