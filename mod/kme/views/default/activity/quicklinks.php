<?php
$loggedin_user = $vars['user'];
$username = $loggedin_user->username;
?>
<div class="quickimage fleft">
	<?php echo elgg_view_entity_icon($loggedin_user, 'small', array('use_hover' => false,'use_link' => false,));?>
</div>	
<div class="fright quicklinks">
	<p><a href="<?php echo SITE_URL; ?>profile/<?php echo $username; ?>/edit/">Edit profile</a></p>
	<p><a href="<?php echo SITE_URL; ?>avatar/edit/<?php echo $username; ?>/">Change avatar</a></p>
	<p><a href="<?php echo SITE_URL; ?>settings/user/<?php echo $username; ?>/">Change settings</a></p>
</div>	