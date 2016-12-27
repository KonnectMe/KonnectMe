<?php
$causesid = get_input('causesid');
$causes = get_entity($causesid);
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $causesid));
?>

<div id="causes_div">
<?php
$amount = explode("|",$causes->amount);
$description = explode("|",$causes->amount_description);
for($i=0; $i<count($amount); $i++){
?>

<div >
    <label class="label" ><?php echo elgg_echo("causes:amounts"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'amount[]','id' => 'amount', 'value' => $amount[$i])); ?>
</div>

<div >
    <label class="label"><?php echo elgg_echo("causes:description"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'amount_description[]','id'=>'amount_description', 'value' => $description[$i])); ?>
</div>
<?php } ?>

</div>

<div><a href="javascript:more_cause()" >Add More</a></div>
 
<div>
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('event:save'))); ?>
    
</div>
