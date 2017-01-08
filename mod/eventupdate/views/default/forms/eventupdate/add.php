<?php
$guid = get_input('guid');
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
?>

<div >
    <?php echo elgg_view('input/text',array('name' => 'description','id'=>'content')); ?>
</div>

 
<div>
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('event:save'),"onclick"=>"return validate_event()")); ?>
</div>
