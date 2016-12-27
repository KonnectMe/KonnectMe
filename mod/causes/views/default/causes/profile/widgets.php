<?php
/**
* Profile widgets/tools
* 
* @package event
*/ 
	
// tools widget area
echo '<ul id="groups-tools" class="elgg-gallery elgg-gallery-fluid mtl clearfix">';

// ticket details
echo elgg_view("causes/tool_latest", $vars);

echo "</ul>";

