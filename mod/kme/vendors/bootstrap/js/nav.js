$(document).ready(

	function() {


		$("#mobile-nav-button ").click( function() 
		{
			
			if($(this).hasClass('enabled'))
			{
				$(this).removeClass('enabled');
				$("#menu").slideUp();
			}
			else {				
				$(this).addClass('enabled');
				$("#menu").slideDown();
			}
			
		});

	}

);
