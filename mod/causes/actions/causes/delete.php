<?php
/**
 * Delete a causes
 *
 * @package Causes
 */

		gatekeeper();
		$user = elgg_get_logged_in_user_entity();
		$guid = (int) get_input('guid');
		$causes = get_entity($guid);
		
		
		if ($causes->getSubtype() == "causes" && $causes->canEdit()) {
				$container = get_entity($causes->container_guid);
				$prefix = "causes/" . $guid;
				$imagenames = array('.jpg', 'tiny.jpg', 'small.jpg', 'medium.jpg');
				$img = new ElggFile();
				$img->owner_guid = $owner_guid;
				foreach ($imagenames as $name) {
					$img->setFilename($prefix . $name);
					$img->delete();
				}				
				$rowsaffected = $causes->delete();
				if ($rowsaffected > 0) {
					system_message(elgg_echo("causes:delete:success"));
				} else {
					register_error(elgg_echo("causes:delete:failed"));
				}
				forward("causes/mine/".$user->guid);
		}
forward(REFERER);		