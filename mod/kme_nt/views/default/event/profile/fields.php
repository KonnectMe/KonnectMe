<?php
/**
 * Event profile fields
 */

$event = $vars['entity'];
$guid = $event->guid;
$data =  get_events("guid=$guid");
$profile_fields = array('description'=>'longtext', 'brief_description'=>'longtext', 'venue'=>'text', 'location'=>'text', 'tags'=>'tags');
if (is_array($profile_fields) && count($profile_fields) > 0) {
	$even_odd = 'odd';

	foreach ($profile_fields as $key => $valtype) {
		if ($key == 'description') {
			$value = $data[0]->$key;
			if (empty($value)) {
				continue;
			}

			$options = array('value' => $data[0]->$key);

			echo "<div>";
				echo "<b>";
				echo elgg_echo("event:$key");
				echo ": </b>";
				echo elgg_view("output/$valtype", $options);
			echo "</div>";

			$even_odd = ($even_odd == 'even') ? 'odd' : 'even';
		}
	}	
}
/*
		echo "<div class=\"{$even_odd}\">";
		echo "<b>";
		echo elgg_echo("event:period");
		echo ": </b>";
		echo event_convert_date($data[0]->start_date);
		echo "&nbsp;".elgg_echo("event:to")."&nbsp;";
		echo event_convert_date($data[0]->end_date);
		echo "</div>";
*/