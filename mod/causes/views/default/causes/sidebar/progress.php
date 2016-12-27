<?php
$causesid = $vars['entity']->guid;
$percentage =  causes_target_percentage($causesid);
$content = '<div id="progress_bar"><div id="progress"></div><div id="progress_text">Target 0% raised</div></div>';
echo elgg_view_module('aside', elgg_echo('causes:raise'), $content);
?>

<script language="javascript" type="text/javascript">
$('#progress_text').html('Target <?php echo $percentage ?>% raised');
$('#progress').css('width','<?php echo $percentage ?>%');	

</script>