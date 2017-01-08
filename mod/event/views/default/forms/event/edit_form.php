<?php
$eventid = get_input('eventid');
$guid = (int) get_input('guid');
$table = elgg_get_config('dbprefix')."events_customforms";
$forms = get_data("select *from $table where id=".$guid);
$form = $forms[0];

echo elgg_view('input/hidden', array('name' => 'eventid', 'value' => $eventid));
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));

$typeArray = event_formtype();

$params = array(
	'name' => 'type',
	'id' => 'type',
	'options_values' => $typeArray,
	'value' => $form->type,
);

?>
<div >
    <label class="label" ><?php echo elgg_echo("event:form_label"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'label', 'id' => 'label', 'value' => $form->title)); ?>
</div>

<div >
    <label class="label" ><?php echo elgg_echo("event:form_type"); ?></label><br />
    <?php echo $dropdown = elgg_view('input/dropdown', $params); ?>
</div>

<div >
    <label class="label" ><?php echo elgg_echo("event:form_label_values"); ?></label><br />
    <?php echo elgg_view('input/plaintext',array('name' => 'values', 'id' => 'values', 'value' => $form->default_values)); ?>
</div>

<div >
    <label class="label" ><?php echo elgg_echo("event:form_required"); ?></label><br />
    <?php 
	$checked = false;
	if($form->required == 1){
		$checked = true;
	}
	echo elgg_view('input/checkbox', array(
			'value' => 1,
			'name' => 'required',
			'checked' => $checked,
			)); ?>
</div>


<div class="elgg-foot mts">
<?php echo elgg_view('input/submit', array('value' => elgg_echo('event:save'), "onclick" => "return validate_form()")); ?>

</div>
