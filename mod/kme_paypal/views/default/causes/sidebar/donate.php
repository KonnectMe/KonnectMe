<?php
/**
 * Causes Donate
 *
 * @package Causes
 */
$url = "payments/make_donation";
$body = elgg_view_form('causes/donate', array('entity' => $vars['entity'],'action' => $url));
echo causes_view_module('aside', $vars['entity']->title, $body);
