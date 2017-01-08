<?php 
	$title = $vars["title"];
	$message = nl2br($vars["message"]);
	$language = get_current_language();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $language; ?>" lang="<?php echo $language; ?>">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<base target="_blank" />
		
		<?php 
			if(!empty($title)){ 
				echo "<title>" . $title . "</title>\n";
			}
		?>
	</head>
	<body>
		<style type="text/css">
			body {
				font-size: 13px;
				line-height: 1.5em;
				font-family: "Trebuchet MS",Arial,Tahoma,Verdana,sans-serif;
				color: #3E3E3E;
				text-shadow: 1px 1px 0px rgba(255,255,255,0.5);		
			}
			a {
				color: #4690d6;
			}
			#notification_container {
				padding: 20px 0;
				width: 600px;
				margin: 0 auto;
			}
			#notification_header {
				text-align: left;
				padding:10px;
				background:#232323;
				border-top:4px solid #a89f38;
				border-bottom:4px solid #a89f38;
			}
			#notification_header a {
				text-decoration: none;
				font-weight: bold;
				color: #0054A7;
				font-size: 1.5em;
			} 
			#notification_wrapper {
				background: #fff;
				border:1px solid #dedede;
				margin:0;
			}
			#notification_wrapper h2 {
				margin: 5px 0 5px 10px;
				color: #000;
				font-size: 1.35em;
				line-height: 1.2em;
			}
			#notification_content {
				background: #FFFFFF;
				padding:15px;
			}
			#notification_footer {
				border:1px solid #dedede;				
				background: #232323 url(http://konnectme.org/mod/kme/img/subfooter-bg.png) repeat-x;
				padding: 15px 10px;
				overflow:auto;
			}
			#notification_footer_logo {
				float: left;
			}
			#notification_footer_logo img {
				border: none;
			}
			.clearfloat {
				clear:both;
				height:0;
				font-size: 1px;
				line-height: 0px;
			}
			.fleft{
				float:left;
			} 
			.fright {
				float:right;
			}	
			.whitelink {
				color:#fff;
				padding-top:5px;
			}	
		</style>
	
		<div id="notification_container">
			<div id="notification_header">
				<a href="<?php echo SITE_URL;?>"><img src="http://konnectme.org/mod/kme/img/sitelogo_mail.png" alt="<?php echo $vars["config"]->site->name;?>">
			</div>
			<div id="notification_wrapper">
				<?php if(!empty($title)) echo elgg_view_title($title); ?>
			
				<div id="notification_content">
					<?php echo $message; ?>
				</div>
			</div>
			
			<div id="notification_footer">
				<?php
					$social = array(
							'facebook'=>"https://www.facebook.com/pages/KonnectMe/262800687108467",
							'rss'=>"http://konnectme.org/?view=rss",
							);
					foreach($social as $k=>$v){
				?>
					<a title="Follow our <?php echo ucfirst($k);?> feed" href="<?php echo $v;?>" target="_blank"><img id="notification_footer_logo" title="Follow our <?php echo ucfirst($k);?> feed" src="<?php echo IMG_PATH . $k;?>.png" alt="<?php echo ucfirst($k);?>" width="30" height="30"/></a>
				<?php } ?>
				
				<?php 
					if(elgg_is_logged_in()){
						$settings_url = $vars["url"] . "settings";
						if(elgg_is_active_plugin("notifications")){
							$settings_url = $vars["url"] . "notifications/personal";
						}
						echo elgg_echo("html_email_handler:notification:footer:settings", array("<a class='whitelink fleft' href='" . $settings_url . "'>", "</a>"));
					} else {
						echo elgg_view('output/url', array('text' => 'Join KonnectMe to support your Non_profits', 'href' => $vars["config"]->site->url, 'class'=>'whitelink fright'));
					}	
				?>
				<div class="clearfloat"></div>
			</div>
		</div>
	</body>
</html>