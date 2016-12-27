<?php
function upload_to_youtube($video_source,$video_type,$title,$description,$tags){
	global $CONFIG;
	$elgg_admin_username = elgg_get_plugin_setting('username', 'videos');
	$elgg_admin_password = elgg_get_plugin_setting('password', 'videos');
	$elgg_admin_developer_key = elgg_get_plugin_setting('developer_key', 'videos');
	$elgg_admin_source = elgg_get_plugin_setting('source', 'videos');
	$elgg_client_id = elgg_get_plugin_setting('client_id', 'videos');
	$elgg_admin_service = elgg_get_plugin_setting('service', 'videos');
	$application_id = elgg_get_plugin_setting('application_id', 'videos');
	if (empty($tags)){
		$tags = elgg_get_plugin_setting('default_tag', 'videos');
	}
	set_include_path($CONFIG->pluginspath . "videos/vendors");
	require_once("Zend/Loader.php");

	Zend_Loader::loadClass('Zend_Gdata_YouTube');
	Zend_Loader::loadClass('Zend_Gdata_AuthSub');
	Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
	$authenticationURL= 'https://www.google.com/accounts/ClientLogin';
	$httpClient = Zend_Gdata_ClientLogin::getHttpClient(
														$username = $elgg_admin_username,
														$password = $elgg_admin_password,
														$service = $elgg_admin_service,
														$client = null,
														$source = $elgg_admin_source,
														$loginToken = null,
														$loginCaptcha = null,
														$authenticationURL);
	$developerKey = $elgg_admin_developer_key;
	$applicationId = $elgg_admin_application_id;
	$clientId = $elgg_admin_client_id;
	$yt = new Zend_Gdata_YouTube($httpClient, $applicationId, $clientId, $developerKey);
	//print_r($yt);
	// create a new VideoEntry object
	$myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();
	// create a new Zend_Gdata_App_MediaFileSource object
	$filesource = $yt->newMediaFileSource($video_source);
	$filesource->setContentType($video_type);
	$filesource->setSlug($title);
	// add the filesource to the video entry
	$myVideoEntry->setMediaSource($filesource);
	$myVideoEntry->setVideoTitle($title);
	$myVideoEntry->setVideoDescription($description);
	// The category must be a valid YouTube category!
	$myVideoEntry->setVideoCategory('Entertainment');
	// Set keywords. Please note that this must be a comma-separated string
	// and that individual keywords cannot contain whitespace
	$myVideoEntry->SetVideoTags($tags);
	// set some developer tags -- this is optional
	// (see Searching by Developer Tags for more details)
	//	$myVideoEntry->setVideoDeveloperTags(array('mydevtag', 'anotherdevtag'));
	// set the video's location -- this is also optional
/*	$yt->registerPackage('Zend_Gdata_Geo');
	$yt->registerPackage('Zend_Gdata_Geo_Extension');
	$where = $yt->newGeoRssWhere();
	$position = $yt->newGmlPos('37.0 -122.0');
	$where->point = $yt->newGmlPoint($position);
	$myVideoEntry->setWhere($where);
*/	// upload URI for the currently authenticated user
	$uploadUrl = 'http://uploads.gdata.youtube.com/feeds/api/users/default/uploads';
	// try to upload the video, catching a Zend_Gdata_App_HttpException, 
	// if available, or just a regular Zend_Gdata_App_Exception otherwise
	$newEntry = null;
	$error = false;
			try {
				$newEntry = $yt->insertEntry($myVideoEntry, $uploadUrl, 'Zend_Gdata_YouTube_VideoEntry');
				$Youtube_video_Id = $newEntry->getVideoId();
				return $Youtube_video_Id;
			} catch (Zend_Gdata_App_HttpException $httpException) {
				$error_message .= $httpException->getRawResponseBody();
				$error = true;
			} catch (Zend_Gdata_App_Exception $e) {
				$error .= $e->getMessage();
				$error = true;
			}
	if	($error){
		register_error($error_message);
		forward(REFERER);
	}	
}

?>