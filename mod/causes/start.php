<?php
 /**
 * Elgg Causes
 */
define('CAUSES_DB_TABLE', elgg_get_config('dbprefix') . 'paypal');

elgg_register_event_handler('init', 'system', 'causes_init');
function causes_init() {
	$user = elgg_get_logged_in_user_entity();
	elgg_extend_view('css/elgg','causes/css');
	elgg_extend_view('js/elgg', 'causes/js');
	$css_url = 'mod/causes/vendors/progress/style.css';
	elgg_register_css('progress', $css_url);
	elgg_load_css('progress');
	elgg_register_widget_type('causes', elgg_echo("causes:widget"), elgg_echo("causes:widget:desc"), "profile");
	elgg_register_widget_type('konnections', elgg_echo("konnections:widget"), elgg_echo("konnections:widget:desc"), "profile");
	elgg_extend_view('page/elements/head','causes/metatags');
	$root = dirname(__FILE__);
	elgg_register_library('elgg:causes', "$root/lib/causes.php");
	elgg_register_menu_item('site', array(
						'name' => 'causes',
						'text' => elgg_echo('causes:causes'),
						'href' => "causes/all/",
						'priority'=>1000
					));
	elgg_extend_view('groups/tool_latest', 'causes/profile/group_causes');
	elgg_extend_view('causes/tool_latest', 'causes/profile/comments');		
	elgg_register_page_handler('causes', 'causes_page_handler');	
	elgg_register_event_handler('pagesetup', 'system', 'causes_setup_sidebar_menus');
	elgg_register_plugin_hook_handler('action', 'groups/edit', 'causes_group_edit_hook');
	$path = elgg_get_plugins_path();
	elgg_register_action("causes/add", $path . "causes/actions/causes/add.php");	
	elgg_register_action("causes/edit", $path . "causes/actions/causes/add.php");
	elgg_register_action("causes/amount", $path . "causes/actions/causes/amount.php");
	elgg_register_action("causes/delete", $path . "causes/actions/causes/delete.php");	
	elgg_register_action("causes/join_konnector", $path . "causes/actions/causes/join_konnector.php");	
	elgg_register_action("causes/leave_konnector", $path . "causes/actions/causes/leave_konnector.php");	
	elgg_register_action("causes/donate", $path . "causes/actions/causes/donate.php",'public');
	elgg_register_action("causes/adddonation", $path . "causes/actions/causes/adddonation.php");
	elgg_register_action("causes/donate-widget", $path . "causes/actions/causes/donate.php",'public');
	elgg_register_action("causes/payment", $path . "causes/actions/causes/payment.php",'public');
	elgg_register_action("causes/donation", $path . "causes/actions/causes/donation.php",'public');
	//action url
	elgg_register_entity_url_handler('object', 'causes', 'causes_url');
	run_function_once('import_paypal_database');
	//run_function_once('new_anonymous_user');
}

function causes_group_edit_hook($hook, $type, $returnvalue, $params) {
	$cause_guid = get_input('selected_cause');
	$group_guid = get_input('group_guid');
	if($cause_guid && $group_guid){
		remove_entity_relationships($group_guid, 'featured_cause');
		add_entity_relationship($group_guid, 'featured_cause', $cause_guid);
	}
}
	
/*
Import database
*/	
function import_paypal_database() {
	global $CONFIG;
	$path = elgg_get_plugins_path();
	$schema_file = $CONFIG->pluginspath. 'causes/schema/elgg_paypal.sql';
	run_sql_script($schema_file);
	return TRUE;
}

function causes_url($causes) {
	global $CONFIG;
	$title = elgg_get_friendly_title($causes->title);
	return "causes/view/" . $causes->getGUID() . "/" . $title;	
}

function causes_setup_sidebar_menus() {		 	
	$page_owner = elgg_get_page_owner_entity();
	$causes_guid = get_input('causesid');
	$causes = get_entity($causes_guid);		
		if (elgg_get_context() == 'causes') {	
		 if(!$page_owner){
			elgg_register_menu_item('page', array(
				'name' => 'causes:all',
				'text' => elgg_echo('causes:all'),
				'href' => 'causes/all',
			));
			
			/*
				Past event
			*/
			elgg_register_menu_item('page', array(
				'name' => 'causes:past',
				'text' => elgg_echo('causes:past'),
				'href' => 'causes/past',
			));	
		}
		$user = elgg_get_logged_in_user_entity();
		/*
		My Event Link
		*/	
		if ($user && !$page_owner) {
			$url = "causes/mine/{$user->guid}/".elgg_get_friendly_title($causes->title);
			$item = new ElggMenuItem('causes:mine', elgg_echo('causes:mine'), $url);
			elgg_register_menu_item('page', $item);

			$url = "causes/my-supporters/{$user->guid}/";
			$item = new ElggMenuItem('causes:my-supporters', elgg_echo('My supporters'), $url);
			elgg_register_menu_item('page', $item);

			$url = "causes/konnected/";
			$item = new ElggMenuItem('causes:konnected', elgg_echo('causes:konnected'), $url);
			elgg_register_menu_item('page', $item);
		}
	 }	 
}

function causes_page_handler($page){
	elgg_load_library('elgg:causes');
	elgg_push_breadcrumb(elgg_echo('causes:causes'), 'causes/all');
	$pages = dirname(__FILE__) . '/pages/causes';
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
			set_input('guid', $page[1]);
			include "$pages/mine.php";
			break;	
		case "my-supporters":
			gatekeeper();	
			set_input('guid', $page[1]);
			include "$pages/my-supporters.php";
			break;	
		case "add":
			gatekeeper();
			set_input('guid', $page[1]);
			include "$pages/add.php";
			break;	
		case "edit":
			gatekeeper();
			set_input('causesid', $page[1]);
			include "$pages/edit.php";
			break;
		case "amount":
			gatekeeper();
			set_input('causesid', $page[1]);
			include "$pages/amount.php";
			break;		
		case "view":
			set_input('causesid', $page[1]);
			include "$pages/view.php";
			break;	
		case 'konnectors':
			set_input('causesid', $page[1]);
			include "$pages/konnectors.php";
			break;	
		case 'konnected':
			gatekeeper();
			include "$pages/konnected.php";
			break;	
		case 'donors':
			set_input('causesid', $page[1]);
			include "$pages/donors.php";
			break;	
		case 'comments':
			set_input('causesid', $page[1]);
			include "$pages/comments.php";
			break;	
		case 'statistics':
			set_input('causesid', $page[1]);
			include "$pages/statistics.php";
			break;
		case 'group':
			set_input('guid', $page[1]);
			include "$pages/owner.php";
			break;	
		case 'donate':
			set_input('causesid', $page[1]);
			set_input('amount', $page[3]);
			include "$pages/donate.php";
			break;	
		case 'payment':
			set_input('causesid', $page[1]);
			set_input('payment', 1);
			include "$pages/payment.php";
			break;	
		case 'donation':
			set_input('causesid', $page[1]);
			include "$pages/donation.php";
			break;		
		case 'export':
			gatekeeper();
			set_input('causesid', $page[1]);
			include "$pages/export.php";
			break;				
		case "update":
			set_input('causesid', $page[1]);
			include "$pages/update.php";
			break;						
		case "adddonation":	
			set_input('causesid', $page[1]);
			include "$pages/adddonation.php";
			break;		
		default:
			return false;
	}
	
	return true;	
}
	
function new_anonymous_user(){
	$site = get_config('site');
	$site_guid = $site->guid;
	$username = "anonymous";
 	$password = 'elgg'.substr(time(),0,4);
 	$password2 = 'elgg'.substr(time(),0,4);
 	$email = "anonymous@fakeid.com";
 	$name = $username;
	$guid = register_user($username, $password, $name, $email, TRUE);
	if ($guid) {
		add_entity_relationship($site_guid, 'anonymous_user', $guid);
	}
}

?>