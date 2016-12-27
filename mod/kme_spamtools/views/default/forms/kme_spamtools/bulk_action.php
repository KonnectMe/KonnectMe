
<?php

$limit = get_input('limit', 25);
$offset = get_input('offset', 0);

$ia = elgg_set_ignore_access(TRUE);
$hidden_entities = access_get_show_hidden_status();
access_show_hidden_entities(TRUE);

$options = array('type' => 'user', 'metadata_name' => 'kme_spamuser', 'metadata_value'=>true, 'count' => true, 'reverse_order_by' => true);
$count = elgg_get_entities_from_metadata($options);

$options['count']  = FALSE;
$options['limit'] = $limit;
$options['offset'] = $offset;

$users = elgg_get_entities_from_metadata($options);

if($users){
	echo elgg_view('input/button',array('name' => 'submit' ,'value' => 'Select all', 'id' => 'selectall'));
	echo "<ul class='elgg-list'>";
	foreach($users as $user){
		$guid = $user->guid;
		?>
			<li>
				<?php 
				$icon = elgg_view_entity_icon($user, 'small');
				$checkbox = elgg_view('input/checkbox', array('name' => 'user_guids[]', 'value' => $guid, 'default' => false));
				$name = $user->name;
				$last_login = "Last login on " . elgg_view('output/friendlytime', array('time' => $user->last_login));
				$email = $user->email;
				if($user->kme_spamuser){
					$safelink = elgg_view('output/confirmlink', array('text' => 'Mark as safe', 'href' => "action/kme_spamtools/flag?todo=marksafe&guid=$guid", 'is_action' =>true, 'class' => 'redlink'));
					$deletelink = elgg_view('output/confirmlink', array('text' => 'Delete', 'href' => "action/admin/user/delete?guid=$guid", 'is_action' =>true, 'class' => 'redlink'));
				} 
				$info = "$checkbox $name <br> $last_login | Email : $email <br> $safelink | $deletelink";
				echo elgg_view_image_block($icon, $info);
				?>
			</li>			
		<?php
	}
	echo "</ul><br>";
	echo elgg_view('input/submit',array('name' => 'submit' ,'value' => 'Delete selected'));
}	

access_show_hidden_entities($hidden_entities);
elgg_set_ignore_access($ia);

echo $pagination = elgg_view('navigation/pagination',array(
	'offset' => $offset,
	'count' => $count,
	'limit' => $limit,
));