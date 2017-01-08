<?php

set_input('viewtype',4);
$now = date('Y-m-d');
$param = array(
    'type' => 'object',
    'subtype' => 'event',
    'limit' => 3,
    'offset' => $offset,
    'full_view' => false,
    'pagination' => false,
    'order_by'=> ' time_updated DESC'
);

$date['name'] = 'period_from';
$date['value'] = $now;

if(!$vars['operand']){
	$operand = '>';
}else{
	$operand = $vars['operand'];
}

$date['operand'] = $operand;

$param['metadata_name_value_pairs'] = array($date);

    $upcoming_all_link = elgg_view('output/url', array(
        'href' => 'event/all',
        'text' => elgg_echo('See All'),
        'is_trusted' => true,
    ));
    ?>
    <div id="upcoming-events" class="sidebar-header">
        Upcoming Events
        <div class="see-all"><?php echo $upcoming_all_link; ?></div>
    </div>
    <?php
    $content = elgg_list_entities_from_metadata($param);
    if (!$content) {
        $content = elgg_echo('event:none');
    }
    echo $content;
    ?>
