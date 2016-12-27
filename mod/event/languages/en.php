<?php
/**
 *	Elgg event plugin
 *	Author : Mohammed Aqeel | Team Webgalli
 *	Team Webgalli | Elgg developers and consultants
 *	Mail : info@webgalli.com
 *	Web	: http://webgalli.com | http://plugingalaxy.com
 *	Skype : 'team.webgalli'
 *	@package Elgg event
 * 	Plugin info : Event Management
 *	Licence : Commercial
 *	Copyright : Team Webgalli 2011-2015
 */
	$english = array(
		'event:event' => "Events",
		'event:new' => "Create new event",
		'event:noevent' => "No events to show",
		'event:groupowner' => "%s's events",
		'event:searchby' => "%s events",
		'event:groupevent' => "Group events",	
		'event:tab:add' => "Create event",
		'event:add' => "Create event",
		'event:tab:ticket' => "Add tickets",
		'event:tickets' => "Tickets",
		'event:ticket' => "Ticket",
		'event:registration' => "User registration",
		'event:tab:registration' => "User registration",
		'event:tab:invite' => "Invite Non-Profits",
		'event:name' => "Name",
		'event:description' => "Description",
		'event:brief' => 'Brief description',
		'event:brief_description' => 'Brief description',
		'event:period' => "Period",
		'event:image' => "Image (leave blank to keep old)",
		'event:venue' => "Venue",
                'event:time' => "Time",
		'event:location' => "Location",
		'event:tags' => "Tags",
		'event:save' => "Save",
		'event:saved' => "[Saved]",
		'event:save:failed' => "Posting failed",
		'event:save:success' => "Successfully saved",
		'event:invite:success' => "Successfully invited the Non-profit",
		'event:invite:failed' => "Invitation failed",
		'event:ticket_type' => 'Type',
		'event:ticket_price' => 'Price',
		'event:avail_number' => 'Seats',
		'event:edit' => 'Edit event',
		'event:tab:edit' => 'Edit event',
		'event:form_label' => 'Field',
		'event:form_type' => 'Type',
		'event:form_values' => 'Values',
		'event:form_label_values' => 'Values [eg:demo1,demo2...]',
		'event:invitebtn' => 'Invite',
		'event:reg_fee' => 'Registration fee',
		'event:group' => 'Group',
		'event:revenue' => 'Revenue',
		'river:create:object:event' => '%s created a new event %s',	
		'river:comment:object:event' => '%s commented on a event %s',
		'river:create:object:ticket' => '%s purchased tickets  for the event  %s',	
		'event:reviews' => 'event',
		'event:delete' => 'Delete',
		'event:none' => 'No Event',
		'event:request:subject' => "%s has invited you to join %s event",
		'event:request:body' => "Hi %s,

%s has requested your partnership for %s. Click below to view their profile:

%s

This event will enable you to promote your cause and fundraise for your Non-profit. We look forward to your particpation in this event. 

Please click on the link below to accept the link and join the event.

%s",

	'event:invitation:accept:subject' => "Congrats! Your Non-Profit has been approved to Fundraise.",
	'event:invitation:accept:body' => "Dear Non-Profit admin!

Your Non-Profit has been approved to register runners for %s on KonnectMe.  

I have attached the detail instructions on how to complete setup of you Non-profit page.  

Here is the link you can promote to register runners for your Non-Profit for %s

%s

Your Non-profit will be pre-selected.  

Post the link to your non-profit page on Facebook, twitter and you can also send emails to your friends about it. You are then ready to begin fund raising.   

KonnectMe.org creates an echo system for Non-Profits and helps promote their cause and raise donation. The transaction is between the donor and the PayPal payment gateway for the Non-Profit. KonnectMe.org does not keep any percentage or keep any financial information on the site. It does keep donor information and the amount they have contributed to the Non-Profit. There is a PayPal charge of 2% that PayPal holds for the transaction which is a PayPal fee. Please let me know if you have any further question.

Thanks,
support@KonnectMe.org
http://www.KonnectMe.org",

		'event:addticket' => 'Add ticket',
		'event:invitenp' => 'Invite Non-profit',
		'event:text' => 'Text',
		'event:area' => 'Text area',
		'event:select' => 'Select box',
		'event:defaut_option' => 'Select',
		'event:radio' => 'Radio',
		'event:check' => 'Check box',
		'event:phone' => 'Number only',
		'event:email' => 'Email',
		'event:url' => 'URL',
		'event:none' => 'No upcoming events',
		'event:startdate' => 'Start date',
		'event:enddate' => 'End date',
		'event:id' => 'ID',
		'event:noinvite' => 'No pending invitations to show',
		'event:request' => 'Event request',
		'event:sponser' => '%s Non-Profit partners',
		'event:nppartners' => 'Non-Profit partners',
		'event:nosponser' => 'Have no partner',
		'event:ticket:deleted' => 'The ticket successfully deleted.',
		'event:deleted' => 'Successfully deleted.',
		'event:notdeleted' => 'Sorry. We could not delete this.',
		'event:unknown_event' => 'Unknown event.',
		'event:delete:success' => 'The event successfully deleted.',
		'event:invitations' => 'Event invitations',
		'event:invite:remove:check' => 'Are you sure you want to remove this join request?',
		'event:join:save' => "Successfully saved the information.",
		'event:join:success' => "Successfully joined event!",
		'event:join:delete' => "Successfully deleted invitation!",
		'event:join:delete:failed' => "Can not delete invitation!",
		'event:join:failed' => "Can not join event",
		'event:sponser:cancel' => 'Cancel partnership',
		'event:sponser:remove:check' => 'Are you sure you want to cancel this Non-Profit partnership?',
		'event:sponser:delete' => "Successfully deleted the partner!",
		'event:sponser:delete:failed' => "Can not delete the partner!",
		'event:sponsers:none' => 'Have no partners',
		'event:mine' => 'Events I own',
		'event:all' => 'All site events',
		'event:joined' => 'Already joined',
		'event:join' => 'Register for event',
		'event:select_ticket' => 'Select ticket',
		'event:noform' => 'Sorry! Have no registartion option',
		'event:payment:subject' => "Registration confirmation for %s",
		'event:payment:body' => "Greetings %s,	
		
Thank you for registering for %s. 

Click below to view the ticket purchase details

%s

",
		'event:sold' => 'Sold',
		'event:members' => 'Event members',
		'event:member' => 'Members of %s',
		'event:nomember' => 'Empty member list',
		'event:ticketover' => 'Ticket closed',
		'event:export' => 'Export details',
		'event:freeevent' => 'Free registration',
		'event:slno' => 'Slno',
		'event:form_required' => 'Required',
		'event:join:select_ticket' => 'Please select ticket',
		'event:editlink' => 'Edit',
		'event:editticket' => 'Edit ticket',
		'event:edittfrom' => 'Edit registration form',
		'event:owner' => 'Owner',
		'event:members:more' => 'View all members',
		'event:sponser:more' => 'View all Non-Profit Partners',
		'event:to' => 'To',
		'event:activity' => 'Event Activity',
		'event:activity:none' => 'There are no event activities yet',
		'event:search_in_event' => 'Search in this event',
		'event:searchtag' => 'Search for events by tag',
		'event:search:title' => "Search for events tagged with '%s'",
		'event:search:none' => "No matching events were found",
		'event:sponser:none' => "No Non-Profit Partners",
		'event:buy' => "Register for the event",
		'event:leave' => "Leave",
		'event:leaved' => 'Successfully left the event',
		'event:cantleave' => 'Can not leave',
		'event:comments' => 'Comments',
		'event:buyTicket' => 'Register for the event',
		'event:location' => 'Location',
		'event:settings:category' => 'Category (enter as comma seperated)',
		'event:filterby' => 'Filter by category',
		'event:totaluser' => 'Total users',
		'event:date' => 'Date',
		'event:deletewarning' => "Are you sure you want to delete this event? There is no undo!",
		'event:tab:members' => 'Members',
		'event:chnageorder' => 'Drag and drop to change the order',
		'event:order_changed' => 'Order has been changed',
		'event:dashboard' => 'Event dashboard',
		'event:dashboard:title' => '%s dashboard',
		'event:total_member' => 'Total registrants',
		'event:runners' => 'Registrants for the %s ',
		'event:total' => 'Total',
		'event:required' => 'required!',
		'event:valid:email' => 'Valid email required!',
		'event:valid:phone' => 'Valid phone required!',
		'events:logintobuy' => "<a href='%s'>Login</a> or <a href='%s'>Register</a> to get your tickets.",
		'event:non_profits' => 'Non-profits',
		'event:runner' => 'Participants', 
		'event:raised' => 'Donations raised',
		'event:donors' => 'Unique donors',
		'event:date_picker' => 'Date picker',
		'event:ticketform' => 'Registrant %s %s',
		'event:purchase_details' => 'Make the payment',
		'event:validate:msg' => 'Please fill out all form and form details',
		'event:purchased' => '[completed]',
		'event:update' => 'Recent updates',
		'event:closed' => 'Registration for this event is closed.',
		'event:paypal' => 'Paypal Id',
		'event:past' => 'Past Event',
		'item:object:event_join' => 'Tickets booked',
		'item:object:eventform' => 'Event forms',
		'item:object:event' => 'Events',
		'event:terms' => 'Terms & Conditions',
		'event:agree' => 'I agree to the terms and conditions',
		'event:agree_msg' => 'Please agree to the terms and conditions',
		'event:proceed' => 'Proceed to payment',
		'event:finish' => "Complete Payment",
		'eventupdate:more:all' => 'View all',
		'event:buymore' => "Add more registrants",
		'event:no_registrant' => 'No of registrants',
		'event:purchaseinfo' => 'Registration confirmation',
		'event:report' => 'Generate Report',
		'event:eventreport' => "Select the participating event for which you want to generate the report",
		'event:save:failed:paypalmissing' => "Please provide your paypal ID",
		'event:save:failed:titlemissing' => "Please provide the event title",
		'event:save:failed:noaccess' => "You dont have enough access to edit this event",
		'event:myticket' => 'My registration for this event',
		'event:ticket:no' => 'Sorry! you have to first purchase tickets for the event.',
		'event:cancel' => 'Cancel',
		'event:iamparticipating' => "Participating events",
		'event:widget:desc' => "Shows a list of events you are participating",
		'event:createcause' => "Would you like to have fundraising for this events?",
		'event:validate:header' => 'Please fill out registrant ',
		'event:missing' => 'is missing',
		'event:pastevent' => 'Related events',
		'event:reports' => 'Generate reports',
		'event:managetickets' => 'Manage tickets',
		'event:skip_registration' => 'Would you like to skip the registration',
	);
					
	add_translation("en",$english);

?>