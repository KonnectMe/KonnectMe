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

$content = '
	<div class="elgg-message elgg-state-success">
		If you are happy with this plugin, you can buy us a coffee ;)
	</div>
	<div class="elgg-col-1of3 float center">
		<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CW52HPC5RVNQ2">
			<img alt="" class="elgg-border-plain pam" src="https://www.paypalobjects.com/en_GB/i/btn/btn_buynowCC_LG.gif">
		</a>
	</div>	
	<div class="elgg-col-2of3 float-alt ptl">
		<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Ffacebook.com%2Fteam.webgalli&amp;width=150&amp;height=21&amp;colorscheme=light&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;send=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:150px; height:21px;" allowTransparency="true"></iframe>
	</div>		
	'
;
echo elgg_view_module('inline',elgg_echo('galliCache:support'),$content);
 
// set default values
if (!isset($vars['entity']->validity)) {
	$vars['entity']->validity = 86400;
}

$content = "<div class='elgg-message elgg-state-success'>
				Need help in configuring the plugin? See <a href='http://www.webgalli.com/blog/elgg-gallicache-plugin-a-performance-booster-for-your-elgg-websites/'>galliCache Tutorials</a>.
			</div>";

$content .= '<div>';
$content .= elgg_echo('galliCache:validity');
$content .= elgg_view('input/text', array( 'name' => 'params[validity]', 'value' => $vars['entity']->validity));
$content .= '</div>';

$content .= '<div>';
$content .= elgg_echo('galliCache:skipcontexts');
$content .= elgg_view('input/text', array( 'name' => 'params[skipcontexts]', 'value' => $vars['entity']->skipcontexts));
$content .= '</div>';

$content .= '<div>';
$content .= elgg_echo('galliCache:skiphandlers');
$content .= elgg_view('input/text', array( 'name' => 'params[skiphandlers]', 'value' => $vars['entity']->skiphandlers));
$content .= '</div>';

$content .= '<div>';
$content .= elgg_echo('galliCache:skipurls');
$content .= elgg_view('input/plaintext', array( 'name' => 'params[skipurls]', 'value' => $vars['entity']->skipurls));
$content .= '</div>';

echo elgg_view_module('inline',elgg_echo('galliCache:header'),$content);