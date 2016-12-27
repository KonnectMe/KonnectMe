<?php 
/**
 * Initialize Elgg's js lib with the uncacheable data
 * Don't want to cache these -- they could change for every request
 */

if (0) { ?><script><?php }
?>
elgg.config.lastcache = <?php echo (int)elgg_get_config('lastcache'); ?>;
elgg.config.viewtype = '<?php echo elgg_get_viewtype(); ?>';
elgg.config.simplecache_enabled = <?php echo (int)elgg_is_simplecache_enabled(); ?>;

elgg.security.token.__elgg_ts = <?php echo $ts = time(); ?>;
elgg.security.token.__elgg_token = '<?php echo generate_action_token($ts); ?>';

<?php
$user = elgg_get_logged_in_user_entity();

if ($user instanceof ElggUser) {
	$user_json = array();
	foreach ($user->getExportableValues() as $v) {
		$user_json[$v] = $user->$v;
	}
	
	$user_json['subtype'] = $user->getSubtype();
	$user_json['url'] = $user->getURL();
	$user_json['admin'] = $user->isAdmin();
	
	echo 'elgg.session.user = new elgg.ElggUser(' . json_encode($user_json) . ');'; 
}
?>

//Before the DOM is ready, but elgg's js framework is fully initalized
elgg.trigger_hook('boot', 'system');