<?php
/**
 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core
 */
elgg_push_breadcrumb(elgg_echo('kme:loginreg')); 
?>

<div>
	<label><?php echo elgg_echo('loginusername'); ?></label>
	<?php echo elgg_view('input/text', array(
		'name' => 'username',
		'class' => 'elgg-autofocus',
		'required' => TRUE,
		));
	?>
</div>
<div>
	<label><?php echo elgg_echo('password'); ?></label>
	<?php echo elgg_view('input/password', array('name' => 'password','required' => TRUE)); ?>
</div>

<div>
	<label><?php echo 'Or use the social login'; ?></label>
<?php 
	echo elgg_view('social_connect/connect');
	echo elgg_view('login/extend', $vars); 
?>
</div>

<div class="elgg-foot">
	<label class="mtm float-alt">
		<input type="checkbox" name="persistent" value="true" />
		<?php echo elgg_echo('user:persistent'); ?>
	</label>
	
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('login'))); ?>
	
	<?php 
	if (isset($vars['returntoreferer'])) {
		echo elgg_view('input/hidden', array('name' => 'returntoreferer', 'value' => 'true'));
	}
	?>

	<ul class="elgg-menu elgg-menu-general mtm">
	<?php
		if (elgg_get_config('allow_registration')) {
			echo '<li><a class="registration_link" href="' . elgg_get_site_url() . 'register">' . elgg_echo('register') . '</a></li>';
		}
	?>
		<li><a class="forgot_link" href="<?php echo elgg_get_site_url(); ?>forgotpassword">
			<?php echo elgg_echo('user:password:lost'); ?>
		</a></li>
	</ul>
</div>
