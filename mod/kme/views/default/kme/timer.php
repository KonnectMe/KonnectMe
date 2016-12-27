<?php 
$date_format = $vars['date_format'];
$number = $vars['number'];
if(!$date_format){
	return;
}	
elgg_load_js('elgg.countdown');
$rand = rand(1,999999);
?>
<script type="text/javascript">
	$(document).ready(function () {
		$('.counter_<?php echo $rand;?>').countdown({
			image: '<?php echo elgg_get_site_url();?>mod/kme/vendors/countdown/digits.png',
			startTime: '<?php echo $date_format['d'];?>:<?php echo $date_format['h'];?>:<?php echo $date_format['m'];?>:<?php echo $date_format['s'];?>',
			digitWidth: 21,
			digitHeight: 32
        });
	});
</script> 
<?php	if(!$number){ ?>
<div class="counter_wrapper">
	<div class="time_counter">
		<div class="counter_<?php echo $rand;?>"></div>
			<div class="countersec">
				<ul class="desc colr">
					<li class="days left"><?php echo elgg_echo('kme:days');?></li>
					<li class="hours left"><?php echo elgg_echo('kme:hours');?></li>
					<li class="minutes left"><?php echo elgg_echo('kme:minutes');?></li>
					<li class="seconds left"><?php echo elgg_echo('kme:seconds');?></li>
				</ul>
			</div>
	</div>	
</div>
<?php } else { 
	// add the number here
} ?>
