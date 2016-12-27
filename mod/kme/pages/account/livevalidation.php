<?php
/**
 * Elgg register form
 *
 * @package Elgg
 * @subpackage Core
 */

$username = get_input('u', null);
$email = get_input('e', null);
if(!empty($username)){
	try {
		if(validate_username($username)){
			if(get_user_by_username($username)){
				echo "<font color='#cc0000'><b>$username</b> is already in use.</font>";
			} else {
				echo 'OK';
			}	
		}
	} catch (RegistrationException $r) {
		echo "<font color='#cc0000'>" . $r->getMessage() . "</font>";
	}
}	

if(!empty($email)){
	if(is_email_address($email)){
		if(get_user_by_email($email)){
			echo "<font color='#cc0000'><b>$email</b> is already in use.</font> <a href='http://konnectme.org/forgotpassword?u={$email}'>Forgot password?</a>";
		} else {
			echo 'OK';
		}
	} else {
		echo "<font color='#cc0000'>Please use a valid email address</font>";
	}	
}	
exit;
?>