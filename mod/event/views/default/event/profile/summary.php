<?php
/**
 * Event profile summary
 *
 * @uses $vars['event']
 */

if (!isset($vars['entity']) || !$vars['entity']) {
	echo elgg_echo('groups:notfound');
	return true;
}

$event = $vars['entity'];
$owner = $event->getOwnerEntity();
$title = elgg_get_friendly_title($event->title);
if(!$owner){
	return;
}	
?>
<div class="elgg-event-left">

                    <div class="event-subheader">
                       <?php echo $event->title; ?>

                        <div class="events-dashboard">
			    <a href="<?php echo elgg_get_site_url() . "event/dashboard/{$event->guid}/{$title}"?>">Events Dashboard</a>
                            
                        </div>
                    </div>

                    <div class="event-content">
			<p>
                        <?php 
			$options = array('value' => $event->{'description'});
			echo elgg_view("output/longtext", $options);
			?>
			    </p>
               </div>
			<?php
	$iconPath = IMG_PATH . 'share/';
	$url = current_page_url();
	if(isset($vars['share_url'])){
		$url = $vars['share_url'];
	}	
?>
<p>
				<!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_default_style ">
				<a class="addthis_button_preferred_1"></a>
				<a class="addthis_button_preferred_2"></a>
				<a class="addthis_button_preferred_3"></a>
				<a class="addthis_button_preferred_4"></a>
				<a class="addthis_button_compact"></a>
				<a class="addthis_counter addthis_bubble_style"></a>
				</div>
				<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515a856e156c427f"></script>
				<!-- AddThis Button END -->			
			</p>	
                   <?php /* ?> <div id="share-links">
                        Share on
                        <a href="http://www.facebook.com/share.php?u=<?php echo $url;?>" class="facebook hide-text">Facebook</a>
                        <a href="http://twitter.com/home/?status=<?php echo $url;?>" class="twitter hide-text">Twitter</a>
                        <a href="https://plus.google.com/share?url=<?php echo $url;?>" class="googleplus hide-text">Google+</a>
                        <a href="http://www.linkedin.com/shareArticle?url=<?php echo $url;?>" class="linkedin hide-text">LinkedIn</a>
                        <a href="#" class="link hide-text">Link</a>


                    </div>
                  <?php */ ?>
                </div>
