<?php
/**
 * Event buy a Ticket
 * showing in sidebar
 * @package Event
 */

$eventguid = $vars['entity']->guid;
$title = $vars['entity']->title;
$event_metadata = $vars['event_metadata'][0];
$url = elgg_get_site_url() . "event/join/{$eventguid}/".elgg_get_friendly_title($title);

$table = elgg_get_config('dbprefix')."events_tickets";
$tickets = get_data("select *from $table where event_guid=".$eventguid);
$content .= elgg_view_form('event/join', array('action' => $url,'method' => 'get','disable_security' => true,), array('ticket' => $tickets));

if($tickets && !$event_metadata->isfree){
	echo elgg_view_module('aside', elgg_echo('event:buyTicket'), $content);
}
