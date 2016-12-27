<?php
/**
* Elgg causes  save action
*
* @package causes
*/
$default = ini_get('max_execution_time');
set_time_limit(100000000);

gatekeeper();

$category = get_input('category');
$title = strip_tags(get_input('title'));
$group_guid = get_input('group');
$event_guid = get_input('event');
$description = get_input('description');
$brief = get_input('brief');
$enddate = get_input('enddate');
$location = get_input('location');
$target = get_input('target');
$access_id = get_input('access_id');
$tags = get_input('tags');
$guid = get_input('guid');

elgg_make_sticky_form('causes');

/*
$max_allowed = strtotime("now") + 98 * 86400;
$timestamp = strtotime($enddate);
if($timestamp > $max_allowed){
	register_error(elgg_echo('causes:maxvalidity'));
	forward(REFERER);
}
*/

if (!$title) {
	register_error(elgg_echo('causes:save:failed'));
	forward(REFERER);
}

if($group_guid){
	$container_guid = (int)$group_guid;
}else{
	$container_guid = (int)get_input('container_guid', $_SESSION['user']->getGUID());
}

$ia = elgg_set_ignore_access(true);
if ($guid == 0) {
	$causes = new ElggObject;
	$causes->subtype = "causes";
	$causes->raise = 0;
	$new = true;	
} else {
	$causes = get_entity($guid);
	if (!$causes->canEdit()) {
		system_message(elgg_echo('causes:save:failed'));
		forward(REFERRER);
	}
}
$tagarray = string_to_tag_array($tags);
$causes->container_guid = $container_guid;
$causes->category = $category;
$causes->title = $title;
$causes->description = $description;
$causes->brief_description = $brief;
$causes->enddate = $enddate;
$causes->location = $location;
$causes->target = $target;
$causes->access_id = $access_id;
$causes->tags = $tagarray;

if ($causes->save()) {
			//craeting relationship as konnector
			if ($guid == 0) {
				add_entity_relationship($causes->guid, 'causes_konnector', elgg_get_logged_in_user_guid());
			}	
			if($group_guid){
				remove_entity_relationships($causes->guid, 'causes_supported');
				add_entity_relationship($causes->guid, 'causes_supported', $group_guid);
			}
			if($event_guid){
				remove_entity_relationships($causes->guid, 'causes_event_supported');
				add_entity_relationship($causes->guid, 'causes_event_supported', $event_guid);
			}
		///image uploading
		if ((isset($_FILES['icon'])) && (substr_count($_FILES['icon']['type'],'image/'))) {
			$prefix = "causes/".$causes->guid;
			$filehandler = new ElggFile();	
			$filehandler->owner_guid = $causes->owner_guid;
			$filehandler->setFilename($prefix . ".jpg");
			$filehandler->open("write");
			$filehandler->write(get_uploaded_file('icon'));
			$filehandler->close();
			$thumbtiny = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),180,150, false);
			$tiny = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), 25, 25, true);
			if ($thumbtiny) {
				$thumb = new ElggFile();
				$thumb->owner_guid = $causes->owner_guid;
				$thumb->setMimeType('image/jpeg');
				
				$thumb->setFilename($prefix."medium.jpg");
				$thumb->open("write");
				$thumb->write($thumbtiny);
				$thumb->close();
				
				$thumb->setFilename($prefix."tiny.jpg");
				$thumb->open("write");
				$thumb->write($tiny);
				$thumb->close();
			
				$causes->icontime = time();
			}
		}else{
			if($group_guid){
				$group = get_entity($group_guid);
				$icontime = $group->icontime;	
				if($icontime){
					$size = 'large';
					$tempfile = elgg_get_config('dataroot').$group->getGUID().'.jpg';
					$site_url = elgg_get_site_url();
					$url = $site_url."groupicon/$group_guid/large/$icontime.jpg";
					$imgContent = file_get_contents($url);
					if($imgContent && $icontime){
						$fp = fopen($tempfile, "w");
						fwrite($fp, $imgContent);
						fclose($fp);
						$newimage = get_resized_image_from_existing_file($tempfile,180,150, false);
						$tiny = get_resized_image_from_existing_file($tempfile, 25, 25, true);
							if ($newimage) {
								$prefix = "causes/".$causes->guid;
								$thumb = new ElggFile();
								$thumb->owner_guid = $causes->owner_guid;
								$thumb->setMimeType('image/jpeg');
								
								$thumb->setFilename($prefix."medium.jpg");
								$thumb->open("write");
								$thumb->write($newimage);
								$thumb->close();
								
								$thumb->setFilename($prefix."tiny.jpg");
								$thumb->open("write");
								$thumb->write($tiny);
								$thumb->close();
								
								$causes->icontime = time();
							}
						unlink($tempfile);	
					}
				}	
			}
		}
		//////////////////////////////////////////
	elgg_clear_sticky_form('causes');
	system_message(elgg_echo('causes:save:success'));
	//add to river only if new
	if ($new) {
		add_to_river('river/object/causes/create','create', elgg_get_logged_in_user_guid(), $causes->getGUID());
	}
	elgg_set_ignore_access($ia);
	forward("causes/amount/".$causes->guid);
} else {
	register_error(elgg_echo('causes:save:failed'));
	forward("causes");
}