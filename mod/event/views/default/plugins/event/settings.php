<?php
$category = $vars['entity']->category;

?>	
<p>
	<?php echo elgg_echo('causes:settings:category'); ?>
	<?php echo elgg_view('input/plaintext', array('name' => 'params[category]','value' => $category));?>
</p>