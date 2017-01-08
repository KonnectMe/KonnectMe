<?php $site_url = elgg_get_site_url();?>
//<script>
selectedticket = '';
function addRow(r)
{
var root = r.parentNode;
var allRows = root.getElementsByTagName('tr');
var cRow = allRows[1].cloneNode(true)
var cInp = cRow.getElementsByTagName('input');
var cInp2 = cRow.getElementsByTagName('span');
var cInp3 = cRow.getElementsByTagName('textarea');
var cInp4 = cRow.getElementsByTagName('select');
for(var i=0;i<cInp.length;i++){cInp[i].setAttribute('id',cInp[i].getAttribute('id')+'_'+(allRows.length+1)); cInp[i].value='';}
for(var i=0;i<cInp2.length;i++){cInp2[i].setAttribute('id',cInp2[i].getAttribute('id')+'_'+(allRows.length+1)); cInp2[i].innerHTML='';}
for(var i=0;i<cInp3.length;i++){cInp3[i].setAttribute('id',cInp3[i].getAttribute('id')+'_'+(allRows.length+1)); cInp3[i].value='';}
for(var i=0;i<cInp4.length;i++){cInp4[i].setAttribute('id',cInp4[i].getAttribute('id')+'_'+(allRows.length+1)); cInp4[i].setAttribute('alt',allRows.length+1); }
root.appendChild(cRow);
}

function deleteRow(tableID){
	try {var table = document.getElementById(tableID);	var rowCount = table.rows.length;
	for(var i=0; i<rowCount; i++) {var row = table.rows[i];	var chkbox = row.cells[0].childNodes[0];
	if(null != chkbox && true == chkbox.checked) {table.deleteRow(i);
					rowCount--;
					i--;
				}
	}
	}catch(e) {	alert(e);}
}

function cleardiv(div){setinnerhtml(div,'','suces');}
function getvalue(obj){return document.getElementById(obj).value;}
function setvalue(obj,st){ document.getElementById(obj).value=st; }
function changeclass(obj,cls){document.getElementById(obj).className=cls;}
function setinnerhtml(div,caption,style){ 
	changeclass(div,'notempty');
	document.getElementById(div).innerHTML=caption;
	document.getElementById(div).className=style;
}

function view_ticket(obj){
	if(obj.checked == true){
		$("#ticket_div").hide();
		$("#ticket_div_list").hide();
	}else{
		$("#ticket_div").show();
		$("#ticket_div_list").show();
	}
}

function event_open_tick(obj){
	$(".ticket").hide();
	$(obj).next('div').show();
	
}

//---------------------same as above
function sameasabove(obj){
	//alert($(obj).prev($(".counter")).attr('id'));
	var cnt = $(obj).val();
	var newcnt = Math.abs(cnt)-1;
	var name = $("#name_1").val();
	$('.form_fields').each(function(index) {
		var v= $(this).val();
		var f1 = v+"_"+newcnt;
		var f2 = v+"_"+cnt;
		var type = document.getElementById(f1).type;
		if(type == 'text' || type == 'select-one' || type == 'textarea'){
			var v1 = $("#"+f1).val();
		}else{
			var v1 = $('input[id="' + f1 + '"]:checked').val();
			 if(obj.checked == true){
				 $("#"+f2).css("border","0px solid #cccccc");
				 $("input[id='"+f2+"'][value="+v1+"]").attr('checked', true);
			 }else{$("#"+f2).removeAttr('checked');	}
		}
		if(obj.checked == true){
			$("#"+f2).val(v1);
				if(type == 'text' || type == 'select-one' || type == 'textarea'){	$("#"+f2).css("border","1px solid #cccccc");}
		}else{
			$("#"+f2).val("");
		}
	});
}

//-------------------------form validation
function isvalid_mail(str){
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
	if(!filter.test(str) && str!='' ){return 0;} else { return 1;}	
}

function event_validate_join(action){
	var fields = $("#field").val();	
	var count = $("#counter").val();	
	var count2 = Math.abs(count)-1;
	var free = $("#free").val();	
	var required = $("#required").val();	
	
	var f = fields.split(",")
	var r = required.split(",")
	var msg = '';
	var msg2 = 0;
	var cpation = '';
	var errormsg = '';
	var errormsg2 = '';
	var no = 1;
	for(var n=0; n<count; n++){
		var cpation = '';
		var formno = Math.abs(n)+1;
		var haveform = $('#event_form_'+n).val();
		var entity_guid = $('#entity_guid_'+n).val();		
			if(haveform){	
			//ticket
				if(free == 0){
					var input_radio =	$('input[name=ticket_'+n+']:checked').val();
					if (!input_radio) {
						msg += 1;	
						$("#ticket_div_"+n).html('Select Ticket');
						
					} else{
						$("#ticket_div_"+n).html('');
					}
				}
			// partner
			if($("#sponser_"+n).val()){
				if($("#sponser_"+n).val() == 0){
					msg += 1;	
					$("#sponser_"+n).css("border","1px solid red"); 
				}else{
					$("#sponser_"+n).css("border","1px solid #cccccc");
				}
			}
		// forms	
			  for(var i=0; i<f.length; i++){
				var msgthis = '';  
				var r1 = r[i];
				var f1 = f[i]+'_'+n;
				var valueis = $("#"+f1).val();
				var type = $("#"+f1).attr('type');
				try{
					var type2 = document.getElementById(f1).type;
				}catch(e){
					var type2 = type;
				}
				var v1 = $("#"+f1).val();				
							if(type2 == 'text' || type2 == 'textarea'){			
								if(v1 == ''){	
									msgthis = 1; $("#"+f1).css("border","1px solid red"); 
								}else{ 
									$("#"+f1).css("border","1px solid #cccccc");
								}
								
								if(r1 == 7){
									var email = isvalid_mail(v1);
									if(email == 0 || v1==''){
										msgthis = 1; $("#"+f1).css("border","1px solid red");
									}else{ 
										$("#"+f1).css("border","1px solid #cccccc"); 
									}
								}//email validation								
								if(r1 == 6){
										var number = v1.replace(/-/g,"");
										var mystring = number.replace(/[,()]/g,"");
										if(isNaN(mystring) || v1 == ''){
											msgthis = 1; $("#"+f1).css("border","1px solid red");
										}else{ 
											$("#"+f1).css("border","1px solid #cccccc");
										 }
								}//Number validation
							}
							else if(type2 == 'select-one'){
								if(v1 == ''){
									msgthis = 1;
								 	$("#"+f1).css("border","1px solid red"); }
								else{ 
									$("#"+f1).css("border","1px solid #cccccc"); 
								}
							}
							else{
								var v1 = $('input[id="' + f1 + '"]:checked').val();
								if(!v1){msgthis = 1; $("#"+f1).css("border","1px solid red"); }	
								else{ $("#"+f1).css("border","0px solid #cccccc");  }
							}						
						if(msgthis != "" && required !=''){
							msg += 1;
							msg2 = 1;
							errormsg2 += $("#label_"+f[i]).html()+" <?php echo elgg_echo('event:missing'); ?> \n";
						}
							
					}// end of innner for loop
					
					if(msg2 == 1){
						errormsg += '.....<?php echo elgg_echo('event:validate:header'); ?> '+formno+'....\n'+errormsg2;
						msg2 = 0;
						errormsg2 = '';
					}
						
			no++;			
			}// end of ourt for loop
	  }// if loop
	  // checking is it agree or not
	  if(action == 1){
			if($("#agree").val()){
				if(document.getElementById("agree").checked != true){
					msg += 1; 
					errormsg += "<?php echo elgg_echo('event:agree_msg'); ?>";
				}
			}
	  }
	 if(msg==''){	return true;}else {
		 alert('<?php echo elgg_echo('event:validate:msg') ?>\n'+errormsg);
		return false;
	 }
}

// checking ticket 
function event_have_ticket(obj){
	var guid= $(obj).val();
	var newguid = "bal_"+guid;
	var cnt = 0;
	var balance = Math.abs($("."+newguid).val());	
	$('.ticket_'+guid).each(function(index) {
		var id = $(this).attr('name');
		var input_radio =	$('input[name='+id+']:checked').val();
		if(newguid == "bal_"+input_radio){ cnt = Math.abs(cnt)+1; }
				
	});
	if(balance<cnt){
		alert("no ticket available");
		$(obj).attr('checked',false);
	}
}

function event_url(url){
	location = url;
}

//more ticket
function event_ticket_next(){
var next = 0;
$('.ticketno').each(function(index) { next=index; });
return next;	
}

function event_form_delete(id){
	$("#event_info_"+id).remove();
}

function event_more_ticket(obj){
	if(event_validate_join(0)){
		var count = $("#counter").val();
		var next =  Math.abs(count)+1;
		var eventid = $("#eventid").val();
		$('.hidden').hide();
		$.post("<?php echo $site_url . "ajax/view/event/newticket"; ?>", {'next': count, 'eventid' : eventid}, function(data){
			$("#event_ticket").append(data);
			$("#counter").val(next);
		});
	}
}

function event_change_input(obj){
	var value = $(obj).val();
	var alt = $(obj).attr('alt');
	if(value == 10){
		$input = $("#values_"+alt);
		$textarea = $("<textarea></textarea>").attr({
			id: 'values_'+alt,
			name: 'values[]',
		});
		$input.after($textarea).remove();
	}
}

function event_generate_report(group){
	var eventguid = $("#event").val();
	var url = '<?php echo $site_url . "event/generate_report/"; ?>'+eventguid+'/'+group;
	location = url;
}

function event_show_tab(obj){
	var classis = $(obj).attr('class'); 
	var id = $(obj).attr('alt');
	if(classis == 'fleft ticketno'){
		$('#event_image_'+id).attr('src','<?php echo elgg_get_site_url().'mod/event/graphics/minus.gif' ?>');
	}else{
		$('#event_image_'+id).attr('src','<?php echo elgg_get_site_url().'mod/event/graphics/plus.gif' ?>');
	}
}

