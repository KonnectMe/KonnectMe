<?php
/**
 *	galliMassmail
 *	Author : Raez Mon | Team Webgalli
 *	Team Webgalli | Elgg developers and consultants
 *	Mail : info@webgalli.com
 *	Web	: http://webgalli.com
 *	Skype : 'team.webgalli'
 *	@package galliMassmail plugin
 *	Licence : GPLv2
 *	Copyright : Team Webgalli 2011-2015
 */

$email_field = get_input('email_field');
$subject = get_input('subject');
$message = get_input('message');
$append_ticket = get_input('append_ticket', 'yes');
$gmm_container_guid = (int) get_input('gmm_container_guid', 0);

if(!$email_field or !$subject or !$message){
	register_error('galliMassmail:neededfields');
	forward(REFERER);
}

$massmail = new ElggObject;
$massmail->subtype = "galliMassmail";
$massmail->title = $subject;
$massmail->description = $message;
$massmail->append_ticket = $append_ticket;
$massmail->container_guid = $gmm_container_guid;
$massmail->access_id = 2;
$massmail->complete = false;
$massmail->offset = 0;
if($email_field){
	$massmail->email_field = $email_field;
	// helps to differentiate between normal mass mail and event confirmation
	$massmail->mail_type = 'event_massmail';
}
if ($massmail->save()) {
	system_message(elgg_echo('galliMassmail:save:success'));
} else {
	register_error('galliMassmail:save:failed');
}

forward(REFERER);