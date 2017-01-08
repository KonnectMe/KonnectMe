// <script>
//	galliCache
//	Author : Mahin Akbar | Team Webgalli
//	Web    : http://webgalli.com/

$(document).ready(function($){
	$("input[name='__elgg_ts']").each(function(){		
		$(this).val(elgg.security.token.__elgg_ts);	
	});		
	$("input[name='__elgg_token']").each(function(){		
		$(this).val(elgg.security.token.__elgg_token);	
	});	
	$('.elgg-form-login').find('input[type=submit]').live('click', galliCache_ajax_form_submission);	
	$('.elgg-form-user-requestnewpassword').find('input[type=submit]').live('click', galliCache_ajax_form_submission);	
	$('.elgg-form-register').find('input[type=submit]').live('click', galliCache_ajax_form_submission);		
});	

function galliCache_ajax_form_submission(event){
	var form = $(this).parents('form');
	var action = form.attr('action');
	var data = form.serialize();
	var method = form.attr('method');
	if(method == 'post'){
		elgg.action(action, {
			data: data,
			success: function(json) {
				if(json.system_messages.error.length == 0){
					form.each (function(){  
						this.reset();
					}); 
					elgg.system_message("<?php echo elgg_echo('galliCache:pagereload');?>"); 
					setTimeout("location.reload()", 1000);
				} else {
					form.effect('shake', { times: 3 }, 100);
				}
			}
		});	
	}		
	event.preventDefault();
}	
