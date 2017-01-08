<?php
/**
 * Causes Konnector
 *
 * package Causes
 */
$causesid = (int) get_input('causesid');
$causes = get_entity($causesid);
$amount = $causes->target;
$percentage =  0;

if (!empty($vars['members']) && is_array($vars['members'])) {
	$user = elgg_get_logged_in_user_entity();
	echo '<ul class="elgg-list">';
	foreach ($vars['members'] as $member) {
		
			$icon = elgg_view_entity_icon($member, 'tiny', array('use_hover' => 'true'));

			$member_title = elgg_view('output/url', array(
				'href' => $member->getURL(),
				'text' => $member->name,
				'is_trusted' => true,
			));

			$guid = $member->guid;
			$raised = causes_payment_konnectors($causesid, $member->guid);
			$percentage = round($raised /$amount * 100,1);
				
			
$body = <<<HTML
<h4>$member_title</h4>
HTML;
			
			echo '<tr><td >'.elgg_view_image_block($icon, $body).'</td><td>'.$raised.'/'.$amount.'</td><td >
			<div id="progress_bar_raise"><div class="progress_raise" id="progress_raise_'.$guid.'"></div>
			<div class="progress_text_raise" id="progress_text_raise_'.$guid.'">0%</div></div></td></tr>';
			
				
		?>
            <script language="javascript" type="text/javascript">
			$('#progress_text_raise_<?php echo $guid ?>').html('<?php echo $percentage ?>% ');
			$('#progress_raise_<?php echo $guid ?>').css('width','<?php echo $percentage ?>%');	
			</script>
            <?php
	}
	echo '</ul>';
} else {
		echo '<p class="mtm">' . elgg_echo('causes:nokonnector') . "</p>";
}
?>

<!--<h4>$raised/$amount</h4>
<h4>
<div id='progress_bar_raise'><div class='progress_raise' id='progress_raise_$guid'></div>
			<div class='progress_text_raise' id='progress_text_raise_.$guid'>0%</div></div>
			</h4>
-->