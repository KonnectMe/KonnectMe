<?php
/**
 * Causes search
 *
 * @package Event
 */
$url = elgg_get_site_url() . 'causes/search';
$body = elgg_view_form('causes/find', array(
	'action' => $url,
	'method' => 'get',
	'disable_security' => true,
));

echo elgg_view_module('aside', elgg_echo('causes:searchtag'), $body);
