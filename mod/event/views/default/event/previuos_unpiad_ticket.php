<?php
$event = $vars['event'];
$event_guid = $event->guid;
$ticket = $vars['ticket'];
$count = count($ticket);
if(!$count){
	return;
}
?>
<p class='logintocomment'>You have <?php echo $count ?> pending ticket(s). You can delete those tickets or continue purchasing new ones. <br> <br />

<?php
echo $info = elgg_view("output/confirmlink", 
	array(	'href' => $vars['url'] . "action/event/delete_unpaid_ticket?guid=".$event_guid,
		'text' => elgg_echo('Delete Tickets'),
		'confirm' => elgg_echo('deleteconfirm'),
		'class' => 'elgg-button elgg-button-submit'
));

echo $info = elgg_view("output/url", 
	array(	'href' => $vars['url'] . "event/payment/".$event_guid."/".elgg_get_friendly_title($event->title),
		'text' => elgg_echo('Continue'),
		'class' => 'elgg-button elgg-button-submit'
));

?>
</p>