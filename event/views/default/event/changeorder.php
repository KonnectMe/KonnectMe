<?php
$order = $_GET['order'];
$parray = split("&", $order);
$table = elgg_get_config('dbprefix')."events_customforms";
for($i =0; $i<count($parray);$i++){
	$guidis = split("=",$parray[$i]);
	$guid = $guidis[1];
	$custom_form['item_order'] = ($i+1);
	saveArray($table, $custom_form, $guid, false);
	
}
echo elgg_echo('event:order_changed');

?>