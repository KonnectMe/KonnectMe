<?php
set_input('viewtype',1);
$user = $vars['user'];
$offset = (int) get_input('offset');
$category = get_input('category');
$now = date('Y-m-d');

$param = array(
			'type' => 'object',
			'subtype' => 'event',
			'limit' => 10,
			'offset' => $offset,
			'full_view' => false,
			'list_type' => 'gallery',
	    );

$date['name'] = 'period_to';
$date['value'] = $now;

if(!$vars['operand']){
	$operand = '>';
}else{
	$operand = $vars['operand'];
}

$date['operand'] = $operand;
	
if($category){
	$param['view_toggle_type'] = false;
	$param['metadata_name_value_pairs'] = array( array('name' =>'category','value'=>$category), $date);
	$param['metadata_name_value_pairs_operator'] = 'and';
}else{
	$param['list_type_toggle'] = true;
	$param['view_toggle_type'] = false;
	$param['metadata_name_value_pairs'] = array($date);
}

$content = elgg_list_entities_from_metadata($param);
if (!$content) {
	$content = elgg_echo('event:none');
}
echo $content;
?>
