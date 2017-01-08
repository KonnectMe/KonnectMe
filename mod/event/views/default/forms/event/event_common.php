<?php
$events = $vars['events'];
?>
<div >
    <label class="label" >Past Event</label><br />
    <?php echo elgg_view('input/dropdown',array('name' => 'event_one', 'id' => 'event_one', 'options_values' => $events )); ?>
</div>

<div >
    <label class="label" >Current Event</label><br />
    <?php echo elgg_view('input/dropdown',array('name' => 'event_two', 'id' => 'event_two', 'options_values' => $events )); ?>
</div>



<div class="elgg-foot mts">
<?php echo elgg_view('input/submit', array('value' => 'Generate', )); ?>

</div>
