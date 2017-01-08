<?php
/**
* Profile widgets/tools
* 
* @package event
*/ 
echo elgg_view('kme/entitySocialshare', $vars);		
// tools widget area
echo '<ul id="groups-tools" class="elgg-gallery elgg-gallery-fluid mtl clearfix">';
echo elgg_view("causes/tool_latest", $vars);
echo "</ul>";