<?php
$typeArray = event_formtype();
$params = array(
	'name' => 'type[]',
	'id' => 'type',
	'options_values' => $typeArray,
	'onchange' => 'event_change_input(this)',
	'alt' => 0,
);

$eventid = get_input('eventid');
echo elgg_view('input/hidden', array('name' => 'eventid', 'value' => $eventid));
?>

<table width="100%" border="0" cellspacing="2" cellpadding="5" class="highlighted">
  <tr class="tableheader">
    <td ><?php echo elgg_echo('event:form_label') ?></td>
    <td ><?php echo elgg_echo('event:form_type') ?></td>
    <td ><?php echo elgg_echo('event:form_label_values') ?></td>
    <td ><?php echo elgg_echo('event:form_required') ?></td>
    <td ><input name="button" type="button" value="+ Add" style="cursor:pointer" onclick="addRow(this.parentNode.parentNode)" /></td>
  </tr>
  <tr>
    <td valign="top"> <?php echo elgg_view('input/text',array('name' => 'label[]', "id"=>'label')); ?></td>
    <td valign="top"><?php echo $dropdown = elgg_view('input/dropdown', $params); ?></td>
    <td valign="top"><?php echo elgg_view('input/text',array('name' => 'values[]', "id"=>'values_0')); ?></td>
    <td valign="top"><?php echo elgg_view('input/checkbox', array('value' => 1,	'name' => 'required[]',	)); ?></td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
<div class="elgg-foot mts">
<?php
echo elgg_view('input/submit', array('value' => elgg_echo('event:save'), 'id' => 'event-submit-button'));
?>
</div>
