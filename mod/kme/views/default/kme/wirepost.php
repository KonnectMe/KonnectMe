<?php 
	echo "<h3>Welcome " . elgg_get_logged_in_user_entity()->name . ". Post an update..</h3>";
	echo elgg_view_form('thewire/add');
?>