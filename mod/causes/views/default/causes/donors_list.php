<?php
$data = $vars['data'];
	if(!$data){
		echo elgg_echo('causes:nodonor');
	}else{
		?>
        <table width="100%" cellspacing="5" cellpadding="5" class="highlighted konnectorstable">
					<tbody><tr class="tableheader">
						<td><?php echo elgg_echo('causes:donor_profile'); ?></td>
						<td><?php echo elgg_echo('causes:donnatedamount'); ?></td>
						</tr>
                       <?php 
					   foreach($data as $donor){
					   ?> 
                        <tr>
                        <td><?php 
							$email = $donor->email;
							$anonymous = $donor->anonymous;
							
						//	if($users = get_user_by_email($email)){
						//		$user = $users[0];
						//		//$url = elgg_view('output/url',array('href' => $user->getURL(), 'text' => $user->name));
						//		$icon = elgg_view_entity_icon($user, 'tiny', array('use_hover' => 'true'));
						//		$body = $user->name;
						//		$url = elgg_view_image_block($icon, $body);
						//	}else{
								$url = $donor->realname;
						//	}
							
							if($anonymous == 1){
								$url = elgg_echo('causes:anonym');
							}
							
							echo $url;
							?></td>
                        <td><?php echo $donor->amount ?></td>
                        </tr>
            		<?php } ?>
            
            </tbody></table>
            
        <?php
	}
	
?>
<?php
if($vars['pagination']){
	echo elgg_view('navigation/pagination',array('count'=>$vars['count'], 'offset' => $vars['offset'], 'limit' => $vars['limit']  ));	
}
?>