<?php
$data = $vars['data'];
if(!$data){
	echo "No person donated via you.";
} else {
?>
    <table width="100%" cellspacing="5" cellpadding="5" class="highlighted konnectorstable">
		<tbody><tr class="tableheader">
			<td><?php echo elgg_echo('causes:donor_profile'); ?></td>
			<td><?php echo 'Donated for'; ?></td>
			<td><?php echo elgg_echo('causes:donnatedamount'); ?></td>
		</tr>
        <?php 
		   foreach($data as $donor){
		?> 
            <tr>
                <td><?php 
						$email = $donor->email;
						$anonymous = $donor->anonymous;
						$url = $donor->realname;
						if($anonymous == 1){
							$url = elgg_echo('causes:anonym');
						}							
						echo $url;
					?>
				</td>
                <td><?php 
					$cause_guid = $donor->causeid;
					$cause = get_entity($cause_guid);
					$url = $cause->getURL();
					echo elgg_view('output/url' ,array('text' => $cause->title, 'href' => $url)); ?>
				</td>
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