//<script> 
	jQuery(document).ready(function($) {
		$(".bstooltip").tooltip();
		sizeContent();
		$(".crowdfundImg").click(function() {
			$('.home-intro-video').html('<iframe width="580" height="326" src="//www.youtube.com/embed/UfVng-m6lAE?autoplay=1&rel=0" frameborder="0" allowfullscreen></iframe>');
		});
		$(".index_category_link").live('click',function(e){
			var latestcauses = $(".latestcauses");
			var cat = $(this).attr('id');
			latestcauses.empty();
			latestcauses.addClass('elgg-ajax-loader');
			$.ajax({
				url: '<?php echo $vars['url'];?>ajax/view/index/causes/?category=' + cat,
				success: function(data) {
					latestcauses.removeClass('elgg-ajax-loader');
					latestcauses.html(data);
				}
			});			
			e.preventDefault();		
		});
		$('.getShortlink').click(function() {
		   $(this).select();
		});
		var $paginationWrapper = $('.wmpLoadMoreBtn');
		if ($paginationWrapper.length){		
			$(window).scroll(function(){
				if($(window).scrollTop() > 10 ){	
					$('a.loadmorelink').click();
				}
			});	
		}
	});	
	
	$(window).bind("resize", sizeContent);
	function sizeContent(e) {
		var htmlHeight = $("html").height();
		var bodyHeight = htmlHeight - 470 + "px";
		$(".elgg-page-body").css("min-height", bodyHeight);
	}	 
	
	elgg.provide('elgg.custom_system_message');
	elgg.custom_system_message.init = function() {
		$('.elgg-system-messages li').stop().animate({opacity: 1.0}, 10);
		$('.elgg-system-messages li').stop().fadeOut(7000);
	}
	elgg.register_hook_handler('init', 'system', elgg.custom_system_message.init);	
	
	$(document).ready(function() {
		availability_checker("#username", "#usernameStatus");
		availability_checker("#email", "#emailStatus");
	});	
	
	function availability_checker(identifier, status_identifier){
		var input = $(identifier);
		var statusDiv =  $(status_identifier);
		var errorMsg = "";
		input.change(function(){ 
			var dataval = input.val();
			if(identifier == "#username"){
				data = "u="+ dataval;
				errorMsg = "Username must be alphanumeric with minimum of 4 characters.";
			} else if (identifier == "#email"){
				data = "e="+ dataval;
				errorMsg = "Email needs to be in a vaild format.";
			}
			if(dataval.length > 3){
				statusDiv.html('Checking availability...');
				$.ajax({ 
					type: "POST", 
					url: "<?php echo elgg_get_site_url();?>livevalidation/", 
					data: data, 
					success: function(msg){ 
						statusDiv.ajaxComplete(function(event, request){ 
							if(msg != 'OK') { 
								input.removeClass("green"); // remove green color
								input.addClass("red"); // add red  color
								statusDiv.html(msg);
							} else { 
								input.removeClass("red"); // remove red color
								input.addClass("green"); // add green color
								statusDiv.html('<font color="Green"> Available </font>');
							} 
						});
					} 
				}); 
			} else {
				input.addClass("red"); // add red color
				statusDiv.html('<font color="#cc0000">' + errorMsg + '</font>');
			}
			return false;
		});	
	}	