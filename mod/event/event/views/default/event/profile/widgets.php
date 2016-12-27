<?php
/**
* Profile widgets/tools
* 
* @package event
*/ 
	
echo '<ul id="groups-tools" class="elgg-gallery elgg-gallery-fluid mtl clearfix">';
echo elgg_view("event/tool_latest", $vars);
echo "</ul>";