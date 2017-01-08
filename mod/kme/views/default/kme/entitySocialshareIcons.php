<?php
	$iconPath = IMG_PATH . 'share/';
	$url = current_page_url();
	if(isset($vars['share_url'])){
		$url = $vars['share_url'];
	}	
?>
<div class="sociable">
	<ul>
		<li><a href="http://twitter.com/home/?status=<?php echo $url;?>" target="_blank"><img title="Tweet this" src="<?php echo $iconPath?>twitter_on.png" alt="Twitter" class="sociable-hovers bstooltip"></a></li>
		<li><a href="http://www.facebook.com/share.php?u=<?php echo $url;?>" target="_blank"><img title="Share on Facebook" src="<?php echo $iconPath?>facebook_on.png" alt="Facebook" class="sociable-hovers bstooltip"></a></li>
		<li><a href="http://www.linkedin.com/shareArticle?url=<?php echo $url;?>" target="_blank"><img title="Bookmark on Linkedin" src="<?php echo $iconPath?>linkedin_on.png" alt="LinkedIn"  class="sociable-hovers bstooltip"></a></li>
		<li><a href="https://plus.google.com/share?url=<?php echo $url;?> target="_blank"><img title="Bookmark on Google+" src="<?php echo $iconPath?>googleplus.png" alt="Google+"  class="sociable-hovers bstooltip"></a></li>
	</ul>
</div>