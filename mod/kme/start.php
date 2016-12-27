<?php

$SITE_URL = elgg_get_site_url();
define('THEME_VERSION','1.0');
define("SITE_URL", $SITE_URL);
define('SITE_NAME', "kme");
define("IMG_PATH", SITE_URL."mod/kme/img/");
define("VENDORS_PATH", SITE_URL."mod/kme/vendors/");
define('PLUGIN_PATH', elgg_get_plugins_path());

elgg_register_event_handler('init', 'system', 'kme_init');

include_once(PLUGIN_PATH . 'kme/lib/kme.php');

function kme_init() {

	$countdown_js_url = elgg_get_site_url() . 'mod/kme/vendors/countdown/countdown.js';
	elgg_register_js('elgg.countdown', $countdown_js_url, 'footer');
	
	$flipcounter_js_url = elgg_get_site_url() . 'mod/kme/vendors/flip/jquery.flipCounter.1.2.pack.js';
	elgg_register_js('elgg.flipcounter', $flipcounter_js_url, 'head');

	elgg_unregister_plugin_hook_handler('output:before', 'layout', 'elgg_views_add_rss_link');

	elgg_extend_view('js/elgg', 'kme/js');
	elgg_extend_view('page/elements/head', 'kme/metahead');
	elgg_extend_view('css/elgg', 'kme/css', 1000);

    elgg_register_ajax_view('index/causes');
	elgg_unextend_view('profile/status', 'thewire/profile_status');

	elgg_unregister_js('jquery');
	elgg_register_js('jquery-cdn', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js', 'head');
	elgg_load_js('jquery-cdn');
	elgg_unregister_js('jquery-ui');
	elgg_register_js('jquery-ui-cdn', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js', 'head');
	elgg_load_js('jquery-ui-cdn');
	
	elgg_unregister_css('progress');
	
	elgg_register_plugin_hook_handler('index', 'system', 'kme_index');

	kme_navigation();
	kme_breadcrumps_manager();
	
	$unregister_ph = array('login', 'register', 'activity');
	foreach($unregister_ph as $ph){
		elgg_unregister_page_handler($ph);
	}
	elgg_register_page_handler('login', 'kme_login_page_handler');
	elgg_register_page_handler('register', 'kme_login_page_handler');
	elgg_register_page_handler('livevalidation', 'kme_login_page_handler');
	elgg_register_page_handler('activity', 'kme_activity_page_handler');
	
	elgg_register_plugin_hook_handler('profile:fields', 'group', 'kme_additional_group_fields');	
	elgg_register_plugin_hook_handler('forward', 'login', 'kme_gate_keeper');
	elgg_register_plugin_hook_handler("action", 'register', 'make_reg_form_sticky',1);
 
	elgg_register_event_handler('create', 'group', 'kme_group_create_event_listener',1000);
	if(elgg_is_admin_logged_in()){
		elgg_register_event_handler('pagesetup', 'system', 'kme_group_setup_sidebar_menus');
		elgg_register_action("groups/approve", PLUGIN_PATH . "kme/actions/groups/approve.php", 'admin');
	}
	
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'kme_groups_entity_menu_setup');
	elgg_unextend_view('groups/tool_latest', 'groups/profile/activity_module');
	elgg_extend_view('groups/tool_latest', 'groups/profile/activity_module', 1);	
	elgg_unextend_view('groups/tool_latest', 'discussion/group_module');
	elgg_extend_view('groups/tool_latest', 'discussion/group_module', 2);	 	

	elgg_extend_view('register/extend', 'registrationterms/register', 1000);
	elgg_register_plugin_hook_handler('action', 'register', 'registrationterms_register_hook');	
	// special login redirect 
	elgg_register_event_handler('login', 'user', 'kme_login_forward', 1000);
}

function kme_login_forward($event, $type, $user) {
	$cookie_present = false;
	if( isset($_COOKIE["refnp"]) or isset($_COOKIE["forward_to_sevathon"]) ){
		$cookie_present = true;		
	}
	if ((strcmp("login", $event) == 0) && $cookie_present) {
		forward(elgg_normalize_url("event/join/926979/sevathon-2014/"));
	}
}

function make_reg_form_sticky($hook, $entity_type, $returnvalue, $params) {
	elgg_make_sticky_form('register');
	$username = get_input('username');
	if(!$username){
		register_error('Please provide a username');
		forward(REFERER);
	} else {
		return set_input('name', $username);
	}
}

function kme_group_setup_sidebar_menus() {
	$page_owner = elgg_get_page_owner_entity();
	if (elgg_get_context() == 'groups' && !elgg_instanceof($page_owner, 'group')) {
		elgg_register_menu_item('page', array(
			'name' => 'kme:groups:pendingapproval',
			'text' => elgg_echo('kme:groups:pendingapproval'),
			'href' => 'groups/pendingapproval/',
		));
	}
}

function kme_group_create_event_listener($event, $object_type, $object) {
	if ($object) {
		$object->approved = 0;
		system_message(elgg_echo('kme:adminvalidationneeded'));
	}
	return true;
}

function kme_navigation(){
	/*
	elgg_register_menu_item('righttop', array(
		'name' => 'home',
		'text' => elgg_echo('kme:home'),
		'href' => elgg_get_site_url(),
		'priority' => 1,			
	));
	*/
	elgg_register_menu_item('righttop', array(
		'name' => 'causes',
		'text' => 'Causes',
		'href' => 'causes/all',
		'priority' => 2,			
	));
	elgg_register_menu_item('righttop', array(
		'name' => 'event',
		'text' => 'Events',
		'href' => 'event/all',
		'priority' => 3,			
	));
	
	elgg_register_menu_item('righttop', array(
		'name' => 'nonprofits',
		'text' => 'Non-Profits',
		'href' => 'groups/all',
		'priority' => 4,			
	));
	/*
	elgg_register_menu_item('righttop', array(
		'name' => 'sevathon',
		'text' => 'Sevathon',
		'href' => 'http://konnectme.org/event/view/3047818/sevathon-2015',
		'priority' => 1,
	));
	*/
	if(!elgg_is_logged_in()){
		elgg_register_menu_item('righttop', array(
			'name' => 'login',
			'text' => 'Login | Register',
			'href' => 'login',
			'priority' => 10,			
		));
	}
	$sm_array = array('causes','event','groups');
	foreach($sm_array as $m){
		elgg_unregister_menu_item('site', $m);
	}
	elgg_unregister_menu_item('topbar', 'elgg_logo');
	elgg_unregister_menu_item('footer', 'faq');	
	elgg_register_menu_item('topbar', array(
		'name' => 'tools',
		'text' => elgg_view_menu('site', array('sort_by' => 'priority')),
		'href' => false,
		'priority' => 800,	
	));		
}

function kme_breadcrumps_manager(){
	$context = elgg_get_context();
	if($context == 'profile'){
		$page_owner = elgg_get_page_owner_entity();
		elgg_push_breadcrumb(elgg_echo('members'), 'members');
		if($page_owner){
			elgg_push_breadcrumb($page_owner->name);
		}
	}
}	

function kme_login_page_handler($page_elements, $handler) {
	$base_dir = PLUGIN_PATH . 'kme/pages/account';
	switch ($handler) {
		case 'login':
			require_once("$base_dir/login.php");
			break;
		case 'register':
			require_once("$base_dir/login.php");
			break;
		case 'livevalidation':
			require_once("$base_dir/livevalidation.php");
			break;
		default:
			return false;
	}
	return true;
}

function kme_activity_page_handler($page) {
	$base_dir = PLUGIN_PATH . 'kme/pages/';
	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
	$page_type = elgg_extract(0, $page, 'all');
	$page_type = preg_replace('[\W]', '', $page_type);
	if ($page_type == 'owner') {
		$page_type = 'mine';
	}
	set_input('page_type', $page_type);
	$entity_type = '';
	$entity_subtype = '';
	require_once("{$base_dir}river.php");
	return true;
}

function kme_index($hook, $type, $return, $params) {
	if ($return == true) {
		return $return;
	}
	if (!include_once(dirname(__FILE__) . "/index.php")) {
		return false;
	}
	return true;
}

function kme_gate_keeper($hook, $type, $returnvalue, $params) {
	return elgg_get_site_url().'login/';
}

function kme_additional_group_fields($hook, $type, $returnvalue, $params) {
	unset($returnvalue['interests']);
	$extra_profile_fields = array(
		'tax' => 'text',
		'paypal' => 'text',
		'email' => 'text',
		'website' => 'url',
		'address' => 'longtext',
		'interests' => 'tags',
	);
	$fields = array_merge($returnvalue, $extra_profile_fields);
	return $fields;
}

function kme_get_new_owner_guid($old_guid){
	$owner = elgg_get_entities_from_metadata(array('metadata_name' => 'old_guid', 'metadata_value' => $old_guid, 'limit'=>1));
	if($owner){
		return $owner[0]->guid;
	} 
	return false;
}	

function kme_get_cause_total_fund_raised(){
	$pre = elgg_get_config('dbprefix');
	$query = "SELECT SUM(amount) AS amount FROM {$pre}paypal";
	$data = get_data($query);
	return (int) $data[0]->amount;
}	

function registrationterms_register_hook() {
	if (get_input('agreetoterms', false) != 'true') {
		register_error(elgg_echo('registrationterms:required'));
		forward(REFERER);
	}
}
