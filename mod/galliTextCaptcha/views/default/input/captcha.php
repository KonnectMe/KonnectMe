<?php
/**
 *	Elgg Text Captcha
 *	Author : Raez | Team Webgalli
 *	Team Webgalli | Elgg developers and consultants
 *	Mail : info@webgalli.com
 *	Web	: http://webgalli.com
 *	Skype : 'team.webgalli'
 *	@package galliTextCaptcha plugin
 *	Licence : GNU2
 *	Copyright : Team Webgalli 2011-2015
 */
	$captcha = galliTextCaptcha_generate_captcha();
	if($captcha){
?>
<div>
	<label><?php echo elgg_echo('galliTextCaptcha:entercaptcha'); ?></label><br />
	<?php 
	echo $captcha['question'];
	foreach($captcha['answer'] as $answer){
		echo elgg_view('input/hidden', array('value'=>$answer,'name'=>'captcha_tok[]'));
	}	
	echo elgg_view('input/text', array('name'=>'captcha_ans'));
	?>
</div>
<?php
	}
?>	