//<script>
	var currentVersion = 1.0;
	jQuery(document).ready(function($) {
		sizeContent();
		$(".crowdfundImg").click(function() {
			$('.home-intro-video').html('<iframe width="580" height="326" src="http://www.youtube.com/embed/-38uPkyH9vI?autoplay=1&rel=0" frameborder="0" allowfullscreen></iframe>');
		});
	});	
	
	var versionChecked = false;
	function versionCheck(themeVersion){
		if(!versionChecked){
			if (currentVersion === null || currentVersion === undefined || currentVersion === '' || currentVersion !== themeVersion) {
				alert("The browser is serving you an old cached version. Please refresh the page or clear you cache for a smooth experience");
				versionChecked = true;
			}
		}	
	}

	$(window).bind("resize", sizeContent);
	function sizeContent(e) {
		var htmlHeight = $("html").height();
		// deduct totla height of header and footer
		var newHeight = htmlHeight - 345 + "px";
		var bodyHeight = htmlHeight - 385 + "px";
		var currentHeight = $(".elgg-sidebar").height();
		if(currentHeight > newHeight){
			return;
		} else {	
			$(".elgg-layout-one-sidebar > .elgg-body").css("min-height", bodyHeight);
			$(".elgg-sidebar").css("min-height", newHeight);
		}	
	}	 
		
 