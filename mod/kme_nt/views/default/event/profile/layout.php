<?php
/**
 * Layout of the event profile page
 *
 * @uses $vars['entity']
 */
echo elgg_view('event/profile/event_intro', $vars);
echo elgg_view('event/profile/summary', $vars);
echo elgg_view('event/profile/widgets', $vars);