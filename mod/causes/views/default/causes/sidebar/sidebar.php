<?php
/**
 * Causes sidebar
 *
 * @package Causes
 *
 * @uses $vars['entity'] Causes entity
  */
elgg_get_context();
$guid =  $vars['entity']->guid;
$causes = get_entity($guid);
$sidebar = '';
if(!get_input('payment')){
	$sidebar .= elgg_view('causes/sidebar/donate', array('entity' => $causes));
}
$sidebar .= elgg_view('causes/sidebar/timer', array('entity' => $causes));
$sidebar .= elgg_view('causes/sidebar/progress', array('entity' => $causes));

$sidebar .= elgg_view('causes/sidebar/konnectors', array('entity' => $causes));
$sidebar .= elgg_view('causes/sidebar/donors', array('entity' => $causes));
echo $sidebar .= elgg_view('causes/sidebar/update', array('entity' => $causes));
// $sidebar .= elgg_view('causes/sidebar/gmap', array('entity' => $causes));