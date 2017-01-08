<div class="subfooter-firstrow">
	<div class="elgg-col-2of3 fleft">
	<h3>About KonnectMe</h3>
	<p>KonnectMe is an eco system for Non-Profit which helps both the organization as well as the individual. It makes it easier for Non-Profits to spread awareness, organize events, and raise money for a cause. Individual can learn and connect with various Non-Profit organizations and Donate to their cause. Search for Non-Profits and donate to the cause of your choice. Register your Non-Profits and begin to Fundraise.</p>
	</div>
	<div class="elgg-col-1of3 fright">
		<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FKonnectMe%2F262800687108467&amp;width=347&amp;height=200&amp;colorscheme=dark&amp;show_faces=true&amp;border_color=%23212121&amp;stream=false&amp;header=false&amp;appId=111342105591331" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:347px; height:200px;" allowTransparency="true"></iframe>
		<div class="socialfollow fleft">
			<h3 class="fleft">Follow us also in : </h3>
		<?php
			$social = array(
					'rss'=>"http://konnectme.org/?view=rss",
					'linkedin'=>"http://linkedin.com/xyz",
					'youtube'=>"http://youtube.com/xyz",
					'twitter'=>"http://twitter.com/xyz",
					'facebook'=>"https://www.facebook.com/pages/KonnectMe/262800687108467",
					'googleplus'=>"http://googleplus.com/xyz",
					);
			foreach($social as $k=>$v){
		?>
			<a title="Follow our <?php echo ucfirst($k);?> feed" href="<?php echo $v;?>" target="_blank"><img class="fright" title="Follow our <?php echo ucfirst($k);?> feed" src="<?php echo IMG_PATH . $k;?>.png" alt="<?php echo ucfirst($k);?>" width="30" height="30"/></a>
			<?php } ?>
		</div>
	</div>
</div>	
<div class="subfooter-secondrow">
	<div class="elgg-col-1of4 fleft">
		<h3>How we work?</h3>
		<ul class="whiteanchor">
			<li><a href="http://konnectme.org/about">About Us</a></li>
			<li><a href="#">Fees</a></li>
			<li><a href="#">Blogs</a></li>
			<li><a href="#">News / Press release</a></li>
			<li><a href="http://konnectme.org/terms">Terms & Conditions</a></li>
			<li><a href="http://konnectme.org/privacy">Privacy Policy</a></li>
		</ul>	
	</div>
	<div class="elgg-col-1of4 fleft">
		<h3>What you can do?</h3>
		<ul>
			<li>Explore Causes / Events</li>
			<li>Register Causes / Events</li>
			<li>Register Non profits</li>
			<li>Donate to Nonprofits</li>
			<li>Invite friends</li>
			<li>Become a Konnector</li>
		</ul>	
	</div>
	<div class="elgg-col-1of4 fleft">
		<h3>Contact Us</h3>
		<ul>
			<li class="email">Email : support@konnectme.org</li>
			<li class="web">Web : http://www.konnectme.org/</li>
		</ul>	
	</div>
	<div class="elgg-col-1of4 fright">
		<h3>Sign up for news letter</h3>
	</div>
</div>	
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-6782565-5']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
