<?php
elgg_load_library('elgg:causes');
$causesid = get_input('causesid');

$html='';
$contents = "".elgg_echo('causes:date')." \t ".elgg_echo('causes:donor_profile')." \t ".elgg_echo('causes:donor_email')." \t ".elgg_echo('causes:konnector')." \t ".elgg_echo('causes:amount')." \t ".elgg_echo('causes:trnasactionid')." \t Country \t City \t State \t ZIP \t Street \n ";

  $table = CAUSES_DB_TABLE;
  $query = "select * from $table where causeid = $causesid  order by id desc";
  $data = get_data($query);
  foreach($data as $user){
	  	$values = array();
		$values[0] = date('m-d-Y',$user->paypaltime);
		$values[1] = $user->realname;
		$values[2] = $user->email; 
		$konnecter = '';
		$konnecterid = $user->konnectorid;
			if($konnecterid != 0){
				$member = get_user($konnecterid); 
				$konnecter = $member->name;
			}else{
				$konnecter = elgg_echo('causes:nill');
			}
		$values[3] = $konnecter;		
		$values[4] = $user->amount;
		$values[5] = $user->paypal;	
		$values[6] = $user->country;
		$values[7] = $user->city;
		$values[8] = $user->state;
		$values[9] = $user->zip;
		$values[10] = $user->street;		
		$contents .= implode(" \t " ,$values)."  \n ";
  }
  
$filename ="donors.xls";
header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
echo $contents;
