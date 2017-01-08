<?php
$counter = get_input('counter');
$start = get_input('start');
$type = get_input('type');
$event_table = elgg_get_config('dbprefix')."event";
$data = get_data("select guid,title from $event_table ");
if($counter || $start){
	$limit = 10;
	if($type == 1){
		$content = elgg_view('importdb/event',array('counter'=>$counter));
	}
	if($type == 2){
		$content = elgg_view('importdb/cause',array('counter'=>$counter));
	}
	
}else{
	$content = '<div><input type="button" value="Import Event" onclick="start_import(1)"></div>';
	$content .= "<br>";
	if($data){
		$selectbox = '<select name="event" id="event_guid">';
		foreach($data as $event){
			$selectbox .= '<option value="'.$event->guid.'">'.$event->title.'</option>';	
		}
		$selectbox .= '</select>';
	//$content .= $selectbox;	
	$content .= '<div>'.$selectbox.'<input type="button" value="Import Purchase Info" onclick="start_purchase(1)" style="width:200px;"></div>';
	}
	$content .= '<div style="margin-top:40px;"><h2>Causes</h2></div>';
	$content .= '<div><input type="button" value="Import Cause" onclick="start_import(2)"></div>';
}

$title = elgg_echo('Import');
$body = elgg_view_layout('content', array(
	'filter' => false,
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => "",
));
echo elgg_view_page($title, $body);	
?>
<script language="javascript" type="text/javascript">
function start_import(t){
	location = "?counter=0&start=1&type="+t;
	
}
function start_purchase(){
	var guid = $('#event_guid').val();
	location = "<?php echo elgg_get_site_url() ?>importdb/event_purchase/"+guid;
}
</script>

