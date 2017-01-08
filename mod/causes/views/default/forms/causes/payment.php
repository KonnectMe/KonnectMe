<?php
$transactionid = $_SESSION['TransactionId'];
elgg_load_library('elgg:causes');
$guid = get_input('causesid');
$userguid = elgg_get_logged_in_user_guid();
$table = CAUSES_DB_TABLE;
$i = 0;
$paymentquery = "select *from $table where donorid = $userguid order by transactionid desc limit 2";
$paymentdata = get_data($paymentquery);
	if(count($paymentdata)>1){
		$i =1;
	}
echo elgg_view('input/hidden', array('name' => 'causesid' ,'value' => $guid));
echo elgg_view('input/hidden', array('name' => 'transactionid' ,'value' => $transactionid));

$option = array('Visa' => 'Visa','MasterCard' => 'MasterCard','Discover' => 'Discover' ,'American Express' => 'American Express');											
?>
<div >
    <label><?php echo elgg_echo('causes:paymenttype')?></label><br />
    <?php echo elgg_view('input/dropdown',array('name' => 'card_type','id'=>'card_type', 'options_values' => $option, 'value'=>$paymentdata[$i]->card_type )); ?>
</div>

<div >
    <label><?php echo elgg_echo('causes:cardno')?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'card_no', 'id'=>'card_no', 'value'=>$paymentdata[$i]->card_no)); ?>
</div>

<div >
    <label><?php echo elgg_echo('causes:cardverification')?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'card_no_verify','id'=>'card_no_verify', 'value'=>$paymentdata[$i]->card_no)); ?>
</div>


<div >
    <label><?php echo elgg_echo('causes:cardexpiry')?></label><br />
    <?php echo elgg_view('input/date',array('name' => 'card_expiry','id'=>'card_expiry', 'value'=>$paymentdata[$i]->card_expiry)); ?>
</div>

<div > <?php echo elgg_echo('causes:billing')?></div>

<div >
    <label><?php echo elgg_echo('causes:name')?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'name','id'=>'name', 'value'=>$paymentdata[$i]->name)); ?>
</div>

<div >
    <label><?php echo elgg_echo('causes:email')?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'email','id'=>'email', 'value'=>$paymentdata[$i]->email)); ?>
</div>

<div >
    <label><?php echo elgg_echo('causes:country')?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'country','id'=>'country', 'value'=>$paymentdata[$i]->country)); ?>
</div>

<div >
    <label><?php echo elgg_echo('causes:address')?></label><br />
    <?php echo elgg_view('input/plaintext',array('name' => 'address','id'=>'address', 'value'=>$paymentdata[$i]->address)); ?>
</div>



    
<div><?php echo elgg_view('input/submit', array('value' => elgg_echo('causes:continue'))); ?></div>




