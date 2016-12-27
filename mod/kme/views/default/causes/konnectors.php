<?php
/**
 * Causes Konnector
 *
 * package Causes
 */
$causesid = (int) get_input('causesid');
$causes = get_entity($causesid);
$amount = (int) $causes->target;
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
		$annotate = causes_payment_konnectors($causesid, $member->guid);
		if($amount > 0){
			$percentage = $annotate /$amount * 100;
		}	
$body = <<<HTML
<h4>$member_title</h4>
HTML;
		echo "<tr>
				<td >".elgg_view_image_block($icon, $body)."</td><td>".$annotate."/".$amount."
				</td>
				<td>
					<div class='progress progress-striped active zeromargin'>
						<div class='bar' style='width: {$percentage}%;'></div>
						<div class='fund-percentage'>{$percentage}%</div>
					</div>
				</td>
			</tr>";
	}
	echo '</ul>';
} else {
	echo '<p class="mtm">' . elgg_echo('causes:nokonnector') . "</p>";
}
?>