<?php
/**
 * Event search
 *
 * @package Event
 */
$url = elgg_get_site_url() . 'event/search';
$body = elgg_view_form('event/find', array(
	'action' => $url,
	'method' => 'get',
	'disable_security' => true,
));

echo elgg_view_module('aside', elgg_echo('event:searchtag'), $body);
