<?php

elgg_register_event_handler('init', 'system', 'kme_social_init');

function kme_social_init() {

}

function kme_post_to_facebook($title, $msg, $url, $desc, $pic_location = "http://konnectme.org/mod/kme/img/sitelogo.png", $stream = "photos"){
	require dirname(__FILE__) . '/vendors/facebook-php-sdk/src/facebook.php';
	$appId = '344035302284799';
	$appSecret = '6a066fb0151c52a1d6a4c20f416ec97e';
	$pageId = '262800687108467';
	$facebook = new Facebook(array(
		'appId' => $appId,
		'secret' => $appSecret,
		'cookie' => false,
	));
	$access_token = "CAAE45fX7nf8BANlI6caBuAJBfHgLUXOFXvyDLj2xI4FUxZAqjf6uVUgoqFGt3qYyhTq6zVwUhnZA14MDjsl1L9wmjROXBZCQ8ROELPzm7xUU0IW99PU4fo82tO2Qyz2gXrSsOmtqUZCOqFOLCQVZAuFhD4naov6ga7WzfgJ6VvAt47CXcfcVtKh7k1286nXAZD";
	try {
		$page_info = $facebook->api("/$pageId?fields=access_token");
		if($stream == 'photos'){
			$facebook->setFileUploadSupport(true);
			$link_text = "Read full article @ $url";		
			$attachment = array(
				'access_token' => $access_token,
				'message' => $msg,
				'name' => "	$title 
				
							$desc
							
							$link_text",
				'source' => "@$pic_location",
			);
		} else {
			$attachment = array(
					'access_token' => $access_token,
					'name' 			=> $title,
					'message' 		=> "$title
					
										$desc
										",
					'link' => $url,
					'picture' => $pic_location,
					'actions' => json_encode(array('name' => 'Read complete story', 'link' => $url)),	
				);
		}
		$status = $facebook->api("/$pageId/$stream", "post", $attachment);	
		echo $status['id'];
	} catch (FacebookApiException $e) {
		echo $e;
	}		
}	

