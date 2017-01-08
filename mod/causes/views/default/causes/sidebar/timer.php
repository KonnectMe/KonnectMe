<?php
/**
 * Causes Timer
 *
 * @package Causes
 *
 * @uses $vars['entity'] Causes entity
 * @uses $vars['limit']  The number of Konnectors to display
 */

$date = $vars['entity']->enddate;

?>

<script language="javascript" type="text/javascript" >
TargetDate = "<?php echo $date?> 0:00 AM";
</script>

<?php
$content = '<span id="cntdwn"></span>';
echo elgg_view_module('aside', elgg_echo('causes:countdown'), $content);
?>
<script type="text/javascript" src="<?php echo $vars['url'] . 'mod/causes/vendors/counter/countdown.js'; ?>"></script>