//<script>
function more_cause(){
	var html = '<div><label class="label"><?php echo elgg_echo("causes:amount")?></label><br><input type="text" value="" name="amount[]" id="amount" class="elgg-input-text"></div>';
	html += '<div><label class="label"><?php echo elgg_echo("causes:description")?></label><br><input type="text" value="" name="amount_description[]" id="amount_description" class="elgg-input-text"></div>';
	$("#causes_div").append(html);
}


function open_konnector(obj){
	if(obj.checked == true){
		$("#konnectordiv").addClass('visible_div');
	}else{
		$("#konnectordiv").addClass('invisible_div');	
	}
}

function empty_customamount(){
	$("#customamount").val('');
}

function empty_amount(value){
	if(value != "" && !isNaN(value)){
		$('input[name=amount]').attr('checked', false);
	}else{
		empty_customamount();
	}
}

function validate_cause(){
	var msg = validate_form();
	if(msg != ""){
		alert("Please fill in all required fields");
		return false;
	}else{
		return true;
	}
}

function validate_form(){
	 var msg = '';
	 $('.validate').each(function(index) {
			var v= $(this).val();
			var type = $(this).attr('type');
			var f1 = $(this).attr('name');
						if(type == 'checkbox' || type == 'radio'){
					 	 		var v1 = $('input[name="' + f1 + '"]:checked').val();
						  		if(!v1){ msg=1; $(this).css("border","1px solid red");}  else { $(this).css("border","1px solid #cccccc");}
							}
							else { if(v == '0' || v == '' ){msg=1; $(this).css("border","1px solid red"); }  else { $(this).css("border","1px solid #cccccc");}  }
		});
	return msg;
}

function causes_donate(obj){
	$(obj).closest('form').submit();
}