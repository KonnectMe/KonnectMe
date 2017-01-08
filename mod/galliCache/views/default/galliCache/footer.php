<?php 
	// Finish caching
	$version = GALLI_CACHE_VERSION;
	$time = date('l jS \of F Y h:i:s A');
	echo "<!-- Generated on $time .-->";
	galliCache_create_cache();
	echo "<!-- Dynamic page generated. Page not cached by Elgg-galliCache($version). Powered by Team Webgalli | http://www.webgalli.com/. -->";
?>