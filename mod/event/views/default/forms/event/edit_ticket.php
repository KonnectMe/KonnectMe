<?php
$eventid = get_input('eventid');
$guid = (int) get_input('guid');
//$ticket = get_entity($guid);
$table = elgg_get_config('dbprefix')."events_tickets";
$tickets = get_data("select *from $table where id=".$guid);
$ticket = $tickets[0];

echo elgg_view('input/hidden', array('name' => 'eventid', 'value' => $eventid));
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
?>
<div >
    <label class="label" ><?php echo elgg_echo("event:ticket_type"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'ticket_type', 'id' => 'ticket_type', 'value' => $ticket->title)); ?>
</div>

<div >
    <label class="label" ><?php echo elgg_echo("event:description"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'description', 'id' => 'description', 'value' => $ticket->description)); ?>
</div>

<div >
    <label class="label" ><?php echo elgg_echo("event:ticket_price"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'price', 'id' => 'price', 'value' => $ticket->price)); ?>
</div>

<div >
    <label class="label" ><?php echo elgg_echo("event:avail_number"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'number', 'id' => 'number', 'value' => $ticket->seats)); ?>
</div>


<div class="elgg-foot mts">
<?php echo elgg_view('input/submit', array('value' => elgg_echo('event:save'), "onclick" => "return validate_ticket()")); ?>

</div>
