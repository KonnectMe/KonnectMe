<?php
	$skip = array('kme_index', 'home', 'message', 'main', 'register', 'login', 'forgotpassword');
	$context = elgg_get_context();
	if(in_array($context, $skip)){
		return;
	}	
?>	
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript" src="http://s.sharethis.com/loader.js"></script>
<script type="text/javascript">stLight.options({publisher: "2696d90f-2358-4cb8-976f-80a6f0ab20b3", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<script>
var options={ "publisher": "2696d90f-2358-4cb8-976f-80a6f0ab20b3", "position": "left", "ad": { "visible": false, "openDelay": 5, "closeDelay": 0}, "chicklets": { "items": ["facebook", "twitter", "linkedin", "email", "sharethis"]}};
var st_hover_widget = new sharethis.widgets.hoverbuttons(options);
</script>
<?php
	return;
?>	
	<!-- AddThis Button BEGIN -->
	<div class="addthis_toolbox addthis_floating_style addthis_counter_style">
		<a class="addthis_button_facebook_like" fb:like:layout="box_count"></a>
		<a class="addthis_button_google_plusone" g:plusone:size="tall"></a>
		<a class="addthis_button_tweet" tw:count="vertical"></a>
		<a class="addthis_counter"></a>
	</div>
	<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515a856e156c427f"></script>
	<!-- AddThis Button END -->
	<style type="text/css">
	.addthis_floating_style {
		position: relative;
		margin-left: -80px;
		top:53px;		
		float: left;
		background: #fff;
		padding: 10 5px;
		text-align: center;
		z-index: 1;	
		border-radius: 3px;
		-webkit-border-radius: 3px;
		-moz-border-radius: 3px;
		-webkit-box-shadow: 0 1px 8px rgba(0, 0, 0, 0.05), 0 0 1px rgba(0, 0, 0, 0.1), 0 1px 0 rgba(0, 0, 0, 0.1), inset 0 1px 0 white;
		-moz-box-shadow: 0 1px 8px rgba(0,0,0,0.05), 0 0 1px rgba(0,0,0,0.1), 0 1px 0 rgba(0,0,0,0.1), inset 0 1px 0 #fff;
		box-shadow: 0 1px 8px rgba(0, 0, 0, 0.05), 0 0 1px rgba(0, 0, 0, 0.1), 0 1px 0 rgba(0, 0, 0, 0.1), inset 0 1px 0 white;
	}	
	</style>
