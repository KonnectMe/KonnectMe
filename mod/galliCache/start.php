<?php
/**
 *	galliCache
 *	Author : Mahin Akbar | Team Webgalli
 *	Team Webgalli | Elgg developers and consultants
 *	Mail : info@webgalli.com
 *	Web	: http://webgalli.com
 *	Skype : 'team.webgalli'
 *	@package galliCache plugin
 *	Licence : GPLV2
 *	Copyright : Team Webgalli 2011-2015
 */
 
// include galliCache lib
include 'lib/galliCache.php';
 
elgg_register_event_handler('init', 'system', 'galliCache_init');

function galliCache_init() {
	elgg_register_page_handler('galliCache_js', 'galliCache_js_page_handler');
	elgg_register_js('galliCache.js', elgg_get_site_url()."galliCache_js/");
	elgg_load_js('galliCache.js');	
	
	elgg_register_plugin_hook_handler('route', 'all', 'galliCache_route_hook', 0);	
	elgg_register_plugin_hook_handler('index', 'system', 'galliCache_route_hook', 0);
	elgg_register_plugin_hook_handler('cron', 'daily', 'galliCache_cron_jobs');	

	elgg_extend_view('page/default', 'galliCache/head', 1);
	elgg_extend_view('js/elgg', 'galliCache/initiate_galliCache', 500);
	elgg_extend_view('page/default', 'galliCache/footer', 1000);	
}

function galliCache_route_hook($hook, $entity_type, $returnvalue, $params){
	$context = elgg_get_context();
	$handler = $returnvalue['handler'];
	$url = current_page_url();
	if(!galliCache_is_excluded($context, $handler, $url)){
		set_input('galliCache_pageHandler', $handler);
		$version = GALLI_CACHE_VERSION;
		$cache = galliCache_cache_exists($url);
		if($cache){
			galliCache_read_cache($cache);
			echo "<!-- Static page served using Elgg-galliCache($version). Powered by Team Webgalli | http://www.webgalli.com/. -->";
			exit;
		}
	} else {
		return $returnvalue;
	}	
}

function galliCache_cron_jobs($hook, $entity_type, $returnvalue, $params){
	$directory = GALLI_CACHE_PATH;
	if( !$dirhandle = @opendir($directory) ){
		return;
	}	
	while( false !== ($filename = readdir($dirhandle)) ) {
		if( $filename != "." && $filename != ".." ) {
			$filename = $directory. "/". $filename;
			if( @filemtime($filename) < (time() - GALLI_CACHE_VALIDITY) ){
				@unlink($filename);
			}
		}
	}
	return $returnvalue;
}	

function galliCache_js_page_handler($page) {
	header("content-type: application/x-javascript");
	header("Cache-Control: no-cache, must-revalidate"); 
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
	echo elgg_view('galliCache/initiate_elgg');
	return true;
}