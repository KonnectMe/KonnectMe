<?php
/**
 * Elgg forgotten password.
 *
 * @package Elgg
 * @subpackage Core
 */
elgg_push_breadcrumb(elgg_echo('user:password:lost')); 
$u = get_input('u');
if($u){
	$username = $u;
}	
?>
<div class="contentWrapper">
	<div class="mtm">
		<?php echo elgg_echo('user:password:text'); ?>
	</div><br>
	<div>
		<label><?php echo elgg_echo('loginusername'); ?></label><br />
		<?php echo elgg_view('input/text', array(
			'name' => 'username',
			'class' => 'elgg-autofocus',
			'value' => $username,
			));
		?>
	</div><br>
	<?php echo elgg_view('input/captcha'); ?><br>
	<div class="elgg-foot">
		<?php echo elgg_view('input/submit', array('value' => elgg_echo('request'))); ?>
	</div>
</div>