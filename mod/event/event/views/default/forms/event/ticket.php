<?php
$checked = false;
$eventid = get_input('eventid');

echo elgg_view('input/hidden', array('name' => 'eventid', 'value' => $eventid));
?>


<div id="ticket_div"  >
<table width="100%" border="0" cellspacing="2" cellpadding="5" class="highlighted">
  <tr class="tableheader">
    <td ><?php echo elgg_echo("event:ticket_type"); ?></td>
    <td ><?php echo elgg_echo("event:description"); ?></td>
    <td ><?php echo elgg_echo("event:ticket_price"); ?></td>
    <td ><?php echo elgg_echo("event:avail_number"); ?></td>
    <td ><input name="button" type="button" value="+ Add" style="cursor:pointer" onclick="addRow(this.parentNode.parentNode)" /></td>
  </tr>
  <tr>
    <td > <?php echo elgg_view('input/text',array('name' => 'ticket_type[]', "id"=>'ticket_type')); ?></td>
    <td ><?php echo elgg_view('input/text',array('name' => 'description[]', "id"=>'description')); ?></td>
    <td ><?php echo elgg_view('input/text',array('name' => 'price[]', "id"=>'price')); ?></td>
    <td ><?php echo elgg_view('input/text',array('name' => 'number[]', "id"=>'number')); ?></td>
    <td >&nbsp;</td>
  </tr>
</table>
</div>
<div class="elgg-foot mts">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('event:save'), "onclick"=>"return validate_ticket()")); ?>
</div>
