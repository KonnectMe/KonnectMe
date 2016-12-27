<?php
/**
 * Group profile fields
 */
 
$group = $vars['entity']; 
$filter = get_input('tab');
if(!$filter){
	$filter = 'about';
} 
$tabs = array(
	'about' => array(
		'text' => 'About Us',
		'href' => $group->getURL().'?tab=about',
		'priority' => 200,
	),
	'info' => array(
		'text' => "Contact Info",
		'href' => $group->getURL().'?tab=info',
		'priority' => 300,
	),
	'causes' => array(
		'text' => 'Our causes',
		'href' => $group->getURL().'?tab=causes',
		'priority' => 400,
	),
);

foreach ($tabs as $name => $tab) {
	$tab['name'] = $name;
	if ($filter == $name) {
		$tab['selected'] = true;
	}
	elgg_register_menu_item('filter', $tab);
}
echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));

$profile_fields = elgg_get_config('group');

if($filter == 'about'){
	$profile_fields = array_slice($profile_fields, 0, 1);
	if (is_array($profile_fields) && count($profile_fields) > 0) {
		$even_odd = 'odd';
		foreach ($profile_fields as $key => $valtype) {
			// do not show the name
			if ($key == 'name') {
				continue;
			}

			$value = $group->$key;
			if (empty($value)) {
				continue;
			}

			$options = array('value' => $group->$key);
			if ($valtype == 'tags') {
				$options['tag_names'] = $key;
			}

			echo "<div class=\"{$even_odd}\">";
			echo "<b>";
			echo elgg_echo("groups:$key");
			echo ": </b>";
			echo elgg_view("output/$valtype", $options);
			echo "</div>";

			$even_odd = ($even_odd == 'even') ? 'odd' : 'even';
		}
	}
} elseif($filter == 'info'){
	$profile_fields = array_slice($profile_fields, 2);
	if (is_array($profile_fields) && count($profile_fields) > 0) {
		$even_odd = 'odd';
		foreach ($profile_fields as $key => $valtype) {
			// do not show the name
			if ($key == 'name') {
				continue;
			}

			$value = $group->$key;
			if (empty($value)) {
				continue;
			}

			$options = array('value' => $group->$key);
			if ($valtype == 'tags') {
				$options['tag_names'] = $key;
			}

			echo "<div class=\"{$even_odd}\">";
			echo "<b>";
			echo elgg_echo("groups:$key");
			echo ": </b>";
			echo elgg_view("output/$valtype", $options);
			echo "</div>";

			$even_odd = ($even_odd == 'even') ? 'odd' : 'even';
		}
	}
} elseif($filter == 'causes'){
	set_input('viewtype',2);
	$causes = $vars['entity'];

	$options = array(
		'type' => 'object',
		'subtype' => 'causes',
		'container_guid' => elgg_get_page_owner_guid(),
		'limit' => 5,
		'full_view' => false,
		'pagination' => false,
	);
	$content = elgg_list_entities($options);


	if (!$content) {
		$content = '<p>' . elgg_echo('causes:nocauses') . '</p>';
	}
	
	echo $content;
}
