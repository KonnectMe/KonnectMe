<?php
/**
 * Causes Category
 *
 * @package Cuases
 */


$body = '';
$category = causes_category(false);
	foreach($category as $k=>$v){
		$body .=  elgg_view('output/url', array(
				'href' => "causes/all/".$k,
				'text' => $v,
				'is_trusted' => true,
		))."<br>";
	}
echo elgg_view_module('aside', elgg_echo('causes:filterby'), $body);
