<?php
/**
 * Likes JavaScript extension for elgg.js
 */
?>

/**
 * Repositions the likes popup
 *
 * @param {String} hook    'getOptions'
 * @param {String} type    'ui.popup'
 * @param {Object} params  An array of info about the target and source.
 * @param {Object} options Options to pass to
 *
 * @return {Object}
 */
elgg.ui.likesPopupHandler = function(hook, type, params, options) {
	if (params.target.hasClass('elgg-likes')) {
		options.my = 'right bottom';
		options.at = 'left top';
		return options;
	}
	return null;
};

elgg.register_hook_handler('getOptions', 'ui.popup', elgg.ui.likesPopupHandler);




elgg.provide('elgg.likes');

elgg.likes.init = function() {
};

elgg.likes.add = function(guid) {
	button=$("#likebutton"+guid);
	count=$("#likecount"+guid);	
	data = elgg.security.addToken({'guid': guid});
	elgg.action('likes/add', {
		data: data,
		success: function(json) {
			if (json.success == true) {
				elgg.system_message(json.message);
				button.parent().html(json.button);
				count.parent().html(json.count);
			}
			else 
				elgg.register_error(json.message);
		}
	});
	return;
};

elgg.likes.delete = function(guid) {
	button=$("#likebutton"+guid);
	count=$("#likecount"+guid);	
	data = elgg.security.addToken({'guid': guid});
	elgg.action('likes/delete', {
		data: data,
		success: function(json) {
			if (json.success == true) {
				elgg.system_message(json.message);
				button.parent().html(json.button);
				count.parent().html(json.count);
			}
			else 
				elgg.register_error(json.message);
		}
	});
	return;
};


elgg.likes.deletebylikeid = function(likeid) {
	data = elgg.security.addToken({'likeid':likeid});
	elgg.action('likes/deletebylikeid', {
		data: data,
		success: function(json) {
			if (json.success == true) {	
				elgg.system_message(json.message);
				$("#likes-"+json.guid).remove();
				button=$("#likebutton"+json.guid);
				count=$("#likecount"+json.guid);			
				button.parent().html(json.button);
				count.parent().html(json.count);
			}
			else 
				elgg.register_error(json.message);
		}
	});
	return;
};


elgg.register_hook_handler('init', 'system', elgg.likes.init);
