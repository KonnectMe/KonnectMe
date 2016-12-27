<?php
/**
 * causes profile fields
 */

$causes = $vars['entity'];

$profile_fields = array('description'=>'longtext', 'brief_description'=>'longtext', 'Target'=>'text', 'enddate'=>'text', 'tags'=>'tags');


if (is_array($profile_fields) && count($profile_fields) > 0) {

	$even_odd = 'odd';
	foreach ($profile_fields as $key => $valtype) {
		// do not show the name
		if ($key == 'name') {
			continue;
		}

		$value = $causes->$key;
		if (empty($value)) {
			continue;
		}

		$options = array('value' => $causes->$key);
		if ($valtype == 'tags') {
			$options['tag_names'] = $key;
		}

		echo "<div class=\"{$even_odd}\">";
		echo "<b>";
		echo elgg_echo("causes:$key");
		echo ": </b>";
		echo elgg_view("output/$valtype", $options);
		echo "</div>";

		$even_odd = ($even_odd == 'even') ? 'odd' : 'even';
	}
}

