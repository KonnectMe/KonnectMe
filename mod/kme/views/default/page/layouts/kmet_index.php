<?php elgg_set_context('kme_index'); 
elgg_load_js('elgg.flipcounter'); 
$raised = kme_get_cause_total_fund_raised();
?> 
<script type="text/javascript">	
jQuery(document).ready(function($) {		
	$("#counter").flipCounter(				
		"startAnimation",{		
			imagePath:"<?php echo VENDORS_PATH;?>flip/flipCounter-medium.png", 						
			number: <?php echo $raised - 610;?> ,						
			end_number: <?php echo $raised;?>, 						
			duration: 900				
		}		
	);
});
</script>
<div class="kme_index_intro">	
	<div class="home-intro-text fleft">		
		<div class="index_welcomer">			
			<h3 class="welcome">Welcome to KonnectMe!</h3>			
				<ul class="kme_features">				
					<li>Register your Non-Profits</li>				
					<li>Start fundraising for your Causes.</li>				
					<li>Join an Event and Fundraise.</li>				
					<li>Register for Sevathon 2016 and <a href="http://konnectme.org/event/join/3171675/sevathon-2016?count=1">Purchase tickets.</a></li>			
				</ul>
		</div>			
		<div>			
			<h3 class="raised_caption">Raised a total of $</h3><div id="counter"><input type="hidden" name="counter-value" value="100" /></div>		
		</div>		
	</div>	
	<div class="home-intro-video fright">		
		<img class="crowdfundImg" src="<?php echo IMG_PATH;?>introvideo.jpg?v=<?php echo (int) elgg_get_config('lastcache');?>" alt="How crowd funding works?" width="580" height="326" />	
	</div>
</div>
<div class="kme_index_featured">	
	<div class="elgg-col-2of3 latestcauses fleft">		
		<?php echo elgg_view('index/causes');?>	
	</div>	
	<div class="elgg-col-1of3 fright">		
		<?php 
		elgg_load_library('elgg:causes'); 
		$content = '';		
		$category = causes_category(false);			
		foreach($category as $k => $v){				
			$body .=  elgg_view('output/url', array('href' => "causes/all/".$k,'text' => $v,'is_trusted' => true,'class' => 'index_category_link','id' => $k,))."<br>";
		}		
		echo elgg_view_module('aside', elgg_echo('causes:filterby'), $body);		
		?>		
	</div>	
</div>
<div class="kme_index_tagbar">	
	<h3 class="fleft">Start fundraising for your Causes or sell tickets for your Events?</h3> 
	<?php if (elgg_is_logged_in()){ ?>		
		<a href="<?php echo SITE_URL;?>event/add/<?php echo elgg_get_logged_in_user_guid();?>" class="elgg-button elgg-button-action fright callbutton">Register event</a>	
		<a href="<?php echo SITE_URL;?>causes/add/<?php echo elgg_get_logged_in_user_guid();?>" class="elgg-button elgg-button-action fright callbutton">Start fundraising</a>
		<?php } else { ?>	
		<a href="<?php echo SITE_URL;?>login/" class="elgg-button elgg-button-action fright callbutton">Register event</a>	
		<a href="<?php echo SITE_URL;?>login/" class="elgg-button elgg-button-action fright callbutton">Start fundraising</a>	
	<?php } ?>	
</div>	
<div class="kme_index_third">
	<div class="oneofthree fleft">		
		<?php echo elgg_view('index/news');?>	
	</div>	
	<div class="oneofthree fleft">		
		<?php echo elgg_view('index/members');?>	
	</div>	
	<div class="oneofthree fleft threeofthree">		
		<?php echo elgg_view('index/nonprofits');?>	
	</div>
</div>	