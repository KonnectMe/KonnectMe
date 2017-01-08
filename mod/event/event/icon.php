<?php
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	$guid = (int) get_input('guid');
	$object = get_entity($guid);
	if($object){
		$owner = $object->getOwnerEntity()->guid;
	}
	$size = strtolower(get_input('size'));
		if (!in_array($size,array('medium','small','tiny','master')))
			$size = "medium";
		if ($size == "master")
			$size = "";
	$filehandler = new ElggFile();
	$filehandler->owner_guid = $owner;
	$filehandler->setFilename("event/" . $guid . $size . ".jpg");
	$success = false;
	if ($filehandler->open("read")) {
		if ($contents = $filehandler->read($filehandler->size())) {
			$success = true;
		} 
	}
	if (!$success) {
		global $CONFIG;
		$contents = @file_get_contents($CONFIG->wwwroot . "mod/event/graphics/default{$size}.gif");
	}
	header("Content-type: image/jpeg");
	header("Cache-Control: public");
	header('Expires: ' . date('r',time() + 864000));
	//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	//header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Pragma: public");
	header("Content-Length: " . strlen($contents));
	$splitString = str_split($contents, 1024);
	foreach($splitString as $chunk)
	echo $chunk;
?>
