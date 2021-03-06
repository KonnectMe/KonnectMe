<?php
/**
 * Elgg register form
 *
 * @package Elgg
 * @subpackage Core
 */
$password = $password2 = '';
$username = get_input('u');
$email = get_input('e');
$name = get_input('n');

if (elgg_is_sticky_form('register')) {
	extract(elgg_get_sticky_values('register'));
	elgg_clear_sticky_form('register');
}

if (elgg_get_config('allow_registration')) {
	?>

	<div>
		<label><?php echo elgg_echo('email'); ?></label><br />
		<?php
		echo elgg_view('input/text', array(
			'name' => 'email',
			'value' => $email,
			'required' => TRUE,	
			'id' => 'email',		
		));
		?>
	</div>
	<div id="emailStatus"></div>
	<div>
		<label><?php echo elgg_echo('username'); ?></label><br />
		<?php
		echo elgg_view('input/text', array(
			'name' => 'username',
			'value' => $username,
			'required' => TRUE,		
			'id' => 'username',
		));
		?>
	</div>
	<div id="usernameStatus"></div>
	<div>
		<label><?php echo elgg_echo('password'); ?></label><br />
		<?php
		echo elgg_view('input/password', array(
			'name' => 'password',
			'value' => $password,
			'required' => TRUE,				
		));
		?>
	</div>
	<div>
		<label><?php echo elgg_echo('passwordagain'); ?></label><br />
		<?php
		echo elgg_view('input/password', array(
			'name' => 'password2',
			'value' => $password2,
			'required' => TRUE,				
		));
		?>
	</div>

	<?php
	// view to extend to add more fields to the registration form
	echo elgg_view('register/extend', $vars);

	// Add captcha hook
	echo elgg_view('input/captcha', $vars);

	echo '<div class="elgg-foot">';
	echo elgg_view('input/hidden', array('name' => 'friend_guid', 'value' => $vars['friend_guid']));
	echo elgg_view('input/hidden', array('name' => 'invitecode', 'value' => $vars['invitecode']));
	echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('register')));
	echo '</div>';
} else {
	echo "KonnectMe Registrations are disabled temporarily. If you wish to register, we recommend the social login";
}

