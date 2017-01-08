<?php
$transactionid = $_SESSION['TransactionId'];
elgg_load_library('elgg:causes');
$guid = get_input('causesid');
$table = CAUSES_DB_TABLE;
$paymentquery = "select *from $table where transactionid = $transactionid";
$paymentdata = get_data($paymentquery);
		
echo elgg_view('input/hidden', array('name' => 'causesid' ,'value' => $guid));
echo elgg_view('input/hidden', array('name' => 'transactionid' ,'value' => $transactionid));

$option = array('Visa' => 'Visa','MasterCard' => 'MasterCard','Discover' => 'Discover' ,'American Express' => 'American Express');											
?>
<div >
<div class="donate_header"><h2><?php echo elgg_echo('causes:cardinfo')?></h2></div>

<div class="donate_label"><?php echo elgg_echo('causes:paymenttype')?></div>
<div class="donate_content"><?php echo $paymentdata[0]->card_type ?></div>
<div class="clear"></div>
<div class="donate_label"><?php echo elgg_echo('causes:cardno')?></div>
<div class="donate_content"><?php echo $paymentdata[0]->card_no ?></div>
<div class="clear"></div>
<div class="donate_label"><?php echo elgg_echo('causes:cardexpiry')?></div>
<div class="donate_content"><?php echo $paymentdata[0]->card_expiry ?></div>
<div class="clear"></div>
<div class="donate_header"><h2><?php echo elgg_echo('causes:billing')?></h2></div>

<div class="donate_label"><?php echo elgg_echo('causes:name')?></div>
<div class="donate_content"><?php echo $paymentdata[0]->name ?></div>
<div class="clear"></div>

<div class="donate_label"><?php echo elgg_echo('causes:email')?></div>
<div class="donate_content"><?php echo $paymentdata[0]->email ?></div>
<div class="clear"></div>

<div class="donate_label"><?php echo elgg_echo('causes:country')?></div>
<div class="donate_content"><?php echo $paymentdata[0]->country ?></div>
<div class="clear"></div>
<div class="donate_label"><?php echo elgg_echo('causes:address')?></div>
<div class="donate_content"><?php echo nl2br($paymentdata[0]->address) ?></div>
<div class="clear"></div>
</div>



    
<div><?php echo elgg_view('input/submit', array('value' => elgg_echo('causes:confirm'))); ?></div>




