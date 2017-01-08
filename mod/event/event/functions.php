<?php
	/* save function
	*/
	function saveArray($table, $arr, $id = 0, $guid = true){
		$fieldis = keyvalueis($arr);
		$valueis = keyvalueis($arr,1);
		$stordata = implode(",", $valueis);  
		$fieldname = implode(",",$fieldis);
		if($id == 0){
			$query = "insert into $table($fieldname)values($stordata)";
			return $id = insert_data($query);
		}else{
			if($guid){
				updateArray($table,$fieldis,$valueis,$id); 
			}else{
				update_based_id($table,$fieldis,$valueis,$id); 
			}
			return $id;
		}
	}
	
	function keyvalueis($arr,$t=0){
		$rarry=array();	
		foreach($arr as $key=>$value){
			 $value="'" .mysql_ready($value) . "'"  ; 
			 if($t==0){
				 $value=$key;
			 }
			 array_push($rarry,$value );
		 }
		return $rarry;
	}
	
	function mysql_ready($var){ 
		if (get_magic_quotes_gpc()) {  
			$var = stripslashes($var);    
		} 
		$var = mysql_real_escape_string($var);  
		return $var; 
	}
	
	/* Update Tbale */
	function updateArray($table,$f,$v,$id)
	{
		for($i=0;$i<count($f);$i++){
			$key=$f[$i];$uvalue=$v[$i];
			$query="update $table set $key=$uvalue where guid=$id";
			update_data($query);
		}
	}
	
	function update_based_id($table,$f,$v,$id)
	{
		for($i=0;$i<count($f);$i++){
			$key=$f[$i];$uvalue=$v[$i];
			$query="update $table set $key=$uvalue where id=$id";
			update_data($query);
		}
	}
	
	/*
	Last Id
	*/
	function lastid(){
		$lastid = -1; $sql = "SELECT LAST_INSERT_ID()"; $rs = mysql_query($sql);
	    if($row = mysql_fetch_array($rs)){$lastid= $row['LAST_INSERT_ID()'];} return $lastid;
	 }

	
?>
