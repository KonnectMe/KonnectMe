<?php
	$guid = (int) get_input('guid', null);
	if($guid){
		$entity = get_entity($guid);
		$title = permalink_get_title($entity);
	}
?>	
<div>
	<?php
		echo "<label>".elgg_echo('gp:guidvalue')."</label>";
		echo elgg_view('input/text', array('name' => 'guid', 'value' => $guid));
	?>
</div>
	
<div>
	<?php
		echo "<label>".elgg_echo('gp:newpermalink')."</label><br>";
		echo "<i>" . elgg_get_site_url(). elgg_echo('gp:newpermalinktitle') . "</i><br>";
		echo elgg_view('input/text', array('name' => 'title', 'value' => $title));
	?>
</div>	
<div>
	<?php
		echo elgg_view('input/submit', array('name' => 'submit', 'value' => 'Change'));
	?>
</div>	
