<?php
 /**
 * Elgg event
 */
define('CAUSES_DB_TABLE', elgg_get_config('dbprefix') . 'paypal');
elgg_register_event_handler('init', 'system', 'event_init');
require("functions.php");
function event_init() {

	elgg_extend_view('css/elgg','event/css');
	elgg_extend_view('js/elgg', 'event/js');
	elgg_extend_view('groups/tool_latest', 'event/profile/group_event');
	elgg_extend_view('causes/sidebar/group_sidebar_donate', 'event/sidebar/group_sidebar_event', 499);
	elgg_extend_view('event/tool_latest', 'event/profile/comments');

	elgg_register_css('tablesorter:css', 'mod/event/vendors/tablesort/themes/blue/style.css');
	elgg_register_js('tablesorter:js', 'mod/event/vendors/tablesort//jquery.tablesorter.js');

	$root = dirname(__FILE__);
	elgg_register_library('elgg:event', "$root/lib/event.php");
	elgg_register_ajax_view('event/newticket');
	
	$user = elgg_get_logged_in_user_entity();
	elgg_register_menu_item('site',array(
						'name' => 'event',
						'text' => elgg_echo('event:event'),
						'href' => "event/all/",
						'priority'=>1000
					));
	elgg_register_page_handler('event', 'event_page_handler');		
	
	elgg_register_event_handler('pagesetup', 'system', 'event_setup_sidebar_menus');
	elgg_register_ajax_view('event/changeorder');	
	elgg_register_widget_type('event', elgg_echo("event:iamparticipating"), elgg_echo("event:widget:desc"), "profile");
	
	//Action Register
	$path = elgg_get_plugins_path();
	elgg_register_action("event/add", $path . "event/actions/event/add.php", 'admin');
	elgg_register_action("event/edit", $path . "event/actions/event/add.php");
	elgg_register_action("event/edit_info", $path . "event/actions/event/edit_info.php");
	elgg_register_action("event/ticket", $path . "event/actions/event/ticket.php");
	elgg_register_action("event/edit_ticket", $path . "event/actions/event/edit_ticket.php");
	elgg_register_action("event/registration", $path . "event/actions/event/registration.php");
	elgg_register_action("event/edit_form", $path . "event/actions/event/edit_form.php");
	elgg_register_action("event/invite", $path . "event/actions/event/invite.php");
	elgg_register_action('event/deleteticket', $path . "event/actions/event/deleteticket.php");
	elgg_register_action('event/delete', $path . "event/actions/event/delete.php");
	elgg_register_action('event/deleteeventform', $path . "event/actions/event/deleteeventform.php");
	elgg_register_action('event/invite_accept', $path . "event/actions/event/invite_accept.php");
	elgg_register_action('event/invite_kill', $path . "event/actions/event/invite_kill.php");
	elgg_register_action('event/cancel_sponser', $path . "event/actions/event/cancel_sponser.php");
	elgg_register_action('event/join', $path . "event/actions/event/join.php");
	elgg_register_action('event/guest_join', $path . "event/actions/event/guest_join.php", 'public');
	elgg_register_action("event/leave", $path . "event/actions/event/leave.php");
	elgg_register_action("event/delete_join_tickt", $path . "event/actions/event/delete_join_tickt.php");
	elgg_register_action("event/finish_payment", $path . "event/actions/event/finish_payment.php");
	elgg_register_action("event/approve_ticket", $path . "event/actions/event/approve_ticket.php");
	
	//Event Url
	elgg_register_entity_url_handler('object', 'event', 'event_url');
	
	run_function_once('import_events_database');
	run_function_once('alter_table_events');
	//alter_table_events();
	elgg_register_plugin_hook_handler('action', 'groups/edit', 'event_group_edit_hook');	
}

function event_group_edit_hook($hook, $type, $returnvalue, $params) {
	$event_guid = get_input('selected_event');
	$group_guid = get_input('group_guid');
	if($event_guid && $group_guid){
		remove_entity_relationships($group_guid, 'featured_event');
		add_entity_relationship($group_guid, 'featured_event', $event_guid);
	}
}

function import_events_database() {
	global $CONFIG;
	$path = elgg_get_plugins_path();
	$schema_file = $CONFIG->pluginspath. 'event/schema/elgg_events.sql';
	run_sql_script($schema_file);
	return TRUE;
}

function alter_table_events() {
	$sql = "ALTER TABLE  `elgg_event` ADD  `skip` INT( 1 ) NULL DEFAULT  '0'";
	mysql_query($sql);
	return TRUE;
}


function event_setup_sidebar_menus() {
	$page_owner = elgg_get_page_owner_entity();
	if (elgg_get_context() == 'groups') {
		if ($page_owner instanceof ElggGroup) {
			if (elgg_is_logged_in() && $page_owner->canEdit() ) {
					elgg_register_menu_item('page', array(
					'name' => 'event:invitations',
					'text' => elgg_echo('event:invitations'),
					'href' => elgg_get_site_url() . "event/invitation/{$page_owner->getGUID()}",
					));
					
					elgg_register_menu_item('page', array(
					'name' => 'event:report',
					'text' => elgg_echo('event:report'),
					'href' => elgg_get_site_url() . "event/report/{$page_owner->getGUID()}",
					));						
			}
		}
	}
	if (elgg_get_context() == 'event') {
		if(!$page_owner){
			elgg_register_menu_item('page', array(
				'name' => 'event:all',
				'text' => elgg_echo('event:all'),
				'href' => 'event/all',
			));
			/*
			Past event
			*/
			elgg_register_menu_item('page', array(
				'name' => 'event:past',
				'text' => elgg_echo('event:past'),
				'href' => 'event/past',
			));
		}
		/*
		My Event Link
		*/	
		$user = elgg_get_logged_in_user_entity();
		if ($user && !$page_owner) {
			$url = "event/mine/$user->guid";
			$item = new ElggMenuItem('event:iamparticipating', elgg_echo('event:iamparticipating'), $url);
			elgg_register_menu_item('page', $item);
			
			$url = "event/myticket/$user->guid";
			$item = new ElggMenuItem('event:iamparticipating', elgg_echo('event:iamparticipating'), $url);
			elgg_register_menu_item('page', $item);
		}
	}
}
	
function event_url($event) {
	global $CONFIG;
	$title = elgg_get_friendly_title($event->title);
	return "event/view/" . $event->getGUID() . "/" . $title;	
}

function event_page_handler($page){
	elgg_load_library('elgg:event');
	elgg_push_breadcrumb(elgg_echo('event:event'), 'event/all');
	$pages = dirname(__FILE__) . '/pages/event';
	switch ($page[0]) {
		case "all":
			set_input('category', $page[1]);
			include "$pages/all.php";
			break;
		case "past":
			include "$pages/past.php";
			break;	
		case 'search':
			include "$pages/search.php";
			break;	
		case "mine":
			gatekeeper();	
			event_set_page_owner($page[1]);
			include "$pages/mine.php";
			break;	
		case "myticket":
			gatekeeper();	
			event_set_page_owner($page[1]);
			include "$pages/myticket.php";
			break;	
		case "owner":
			event_set_page_owner($page[1]);
			include "$pages/all.php";
			break;	
		case "add":
			gatekeeper();
			event_set_page_owner($page[1]);
			include "$pages/add.php";
			break;	
		case "edit":
			gatekeeper();
			set_input('eventid', $page[1]);
			include "$pages/edit.php";
			break;	
		case "ticket":
			gatekeeper();
			set_input('eventid', $page[1]);
			include "$pages/ticket.php";
			break;	
		case "registration":
			gatekeeper();
			set_input('eventid', $page[1]);
			include "$pages/registration.php";
			break;
		case "invite":
			gatekeeper();
			set_input('eventid', $page[1]);
			include "$pages/invite.php";
			break;
		case "invitation":
			gatekeeper();
			set_input('groupguid', $page[1]);
			include "$pages/invitation.php";
			break;	
		case "report":
			gatekeeper();
			set_input('groupguid', $page[1]);
			include "$pages/report.php";
			break;	
		case "reports":
			gatekeeper();
			set_input('eventid', $page[1]);
			include "$pages/reports.php";
			break;		
		case "sponser":
			set_input('eventid', $page[1]);
			include "$pages/sponser.php";
			break;	
		case "view":
			set_input('eventid', $page[1]);
			include "$pages/view.php";
			break;	
		case "join":
			//gatekeeper();
			set_input('eventid', $page[1]);
			include "$pages/join.php";
			break;		
		case "payment":
			gatekeeper();
			set_input('eventid', $page[1]);
			include "$pages/make_payment.php";
			break;	
		case "pay":
			set_input('eventid', $page[1]);
			include "$pages/make_payment_guest.php";
			break;		
		case "purchaseinfo":
			gatekeeper();
			set_input('eventid', $page[1]);
			include "$pages/purchaseinfo.php";
			break;	
		case "edit_info":
			gatekeeper();
			set_input('eventid', $page[1]);
			set_input('guid', $page[2]);
			include "$pages/edit_info.php";
			break;				
		case 'members':
			set_input('eventid', $page[1]);
			include "$pages/members.php";
			break;	
		case 'export':
			gatekeeper();
			set_input('eventid', $page[1]);
			set_input('groupid', $page[2]);
			include "$pages/export.php";
			break;
		case 'generate_report':
			gatekeeper();
			set_input('eventid', $page[1]);
			set_input('groupid', $page[2]);
			include "$pages/generate_report.php";
			break;	
		case 'editticket':
			gatekeeper();
			set_input('eventid', $page[1]);
			set_input('guid', $page[2]);
			include "$pages/edit_ticket.php";
			break;	
		case 'editform':
			gatekeeper();
			set_input('eventid', $page[1]);
			set_input('guid', $page[2]);
			include "$pages/edit_form.php";
			break;		
		case 'group':
			set_input('guid', $page[1]);
			include "$pages/owner.php";
			break;	
		case "dashboard":
			set_input('eventid', $page[1]);
			include "$pages/dashboard.php";
			break;	
		case "update":
			set_input('eventid', $page[1]);
			include "$pages/update.php";
			break;
		case "event_diff":
			include "$pages/event_diff.php";
			break;
		case "event_common":
			include "$pages/event_common.php";
			break;
		case "manage-tickets":
			gatekeeper();
			set_input('eventid', $page[1]);
			include "$pages/manage-tickets.php";
			break;			
		default:
			return false;
	}
	return true;	
}

function event_set_page_owner($page_owner_guid){
   set_input('guid', $page_owner_guid);
}	