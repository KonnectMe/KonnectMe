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

$validity = elgg_get_plugin_setting('validity', 'galliCache');
 
define('GALLI_CACHE_VERSION', '1.4');
define('GALLI_CACHE_PATH',elgg_get_data_path()."html_cache");
define('GALLI_CACHE_VALIDITY', $validity); 

function galliCache_cache_exists($url = false){
	if(!$url){
		$url = current_page_url();
	}	
	$cache_filename = galliCache_filename($url);
	if (file_exists($cache_filename)){
		if ( galliCache_is_valid ($cache_filename)) {
			return $cache_filename;
		} else {
			unlink ($cache_filename);
		}	
	}
	return false;
}	

function galliCache_is_valid($cache_filename){
	$last_cache = (int) elgg_get_config('lastcache'); 
	$explode = explode("." , $cache_filename);
	$file_cache = $explode[1];
	if( ($last_cache == $file_cache) && ((time() - GALLI_CACHE_VALIDITY) < filemtime( $cache_filename )) && (filesize($cache_filename) > 0) ){
		return true;
	}
	return false;
}	

function galliCache_read_cache($cache){
	if(!$cache){
		$cache = galliCache_filename(current_page_url());
	}	
	$file_expire_time = GALLI_CACHE_VALIDITY;
	$file_last_change = filemtime( $cache );
	$headers = apache_request_headers();	
	header('Content-Type: text/html');
	header('Cache-Control: max-age=' . $file_expire_time);
	header('Expires: '.gmdate('D, d M Y H:i:s', time() + $file_expire_time).' GMT');
	header('Last-Modified: '.gmdate('D, d M Y H:i:s', $file_last_change).' GMT');
	if (isset($headers['If-Modified-Since']) && trim($headers['If-Modified-Since']) == $file_last_change) {
		header('HTTP/1.1 304 Not Modified');
	} else {
		header('HTTP/1.1 200 OK');
	}	
	include $cache;
}

function galliCache_filename($url){
	$last_cache = (int) elgg_get_config('lastcache'); 
	$filename = md5(elgg_get_friendly_title($url));
	return GALLI_CACHE_PATH . "/$filename" . "." . "$last_cache.php";
}	

function galliCache_create_cache($url = false){
	$context = elgg_get_context();
	$handler = get_input('galliCache_pageHandler');
	if(!$url){
		$url = current_page_url();
	}	
	if(!galliCache_is_excluded($context, $handler, $url)){
		$cache_filename = galliCache_filename($url);
		$buff = ob_get_contents(); 
		$dom = new DOMDocument;
		$dom->loadHTML($buff);
		$xpath = new DOMXPath($dom);
		$nodes = $xpath->query('//li[contains(@class,"elgg-message")]'); 
		foreach($nodes as $node) {
			$node->parentNode->removeChild($node);
		}
		$html = $dom->saveHTML();     
		$file = fopen( $cache_filename, "w" );
		fwrite( $file, $html );
		fclose( $file );
		ob_end_flush(); 
	}	
}	

function galliCache_is_excluded($context = false, $handler = false, $url = false){
	if( elgg_is_logged_in()){
		return true;
	}	
	if(in_array($context, galliCache_contexts_to_skip())){
		return true;
	}	
	if(in_array($handler, galliCache_handlers_to_skip())){
		return true;
	}
	if(in_array($url, galliCache_urls_to_skip())){
		return true;
	}
	return false;
}	

function galliCache_contexts_to_skip(){
	$return = array();
	$skipcontexts = elgg_get_plugin_setting('skipcontexts', 'galliCache');
	if($skipcontexts){
		$return = explode(",",$skipcontexts);
	}
	return $return;
}	

function galliCache_handlers_to_skip(){
	$return = array();
	$skiphandlers = elgg_get_plugin_setting('skiphandlers', 'galliCache');
	if($skiphandlers){
		$return = explode(",",$skiphandlers);
	}
	return $return;
}

function galliCache_urls_to_skip(){
	$return = array();
	$skipurls = elgg_get_plugin_setting('skipurls', 'galliCache');
	if($skipurls){
		$return = explode("\n",$skipurls);
	}
	return $return;
}	

// See http://php.net/manual/en/function.apache-request-headers.php
if( !function_exists('apache_request_headers') ) {
	function apache_request_headers() {
		$arh = array();
		$rx_http = '/\AHTTP_/';
		foreach($_SERVER as $key => $val) {
			if( preg_match($rx_http, $key) ) {
			$arh_key = preg_replace($rx_http, '', $key);
			$rx_matches = array();
			$rx_matches = explode('_', $arh_key);
			if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
				foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
					$arh_key = implode('-', $rx_matches);
			}
			$arh[$arh_key] = $val;
			}
		}
		return( $arh );
	}
}