//<style>
.div_header {
	padding: 5px;
	font-weight: bold;
	background: #E4E4E4;
}
.div_header_small{
	float:left;
	width:10%;
	text-align:left
}
.div_content_small{
	float:left;
	width:10%;
	text-align:left
}
.div_header_medium{
	float:left;
	width:15%;
	text-align:left
}
.div_content_medium{
	float:left;
	width:15%;
	text-align:left
}
.div_header_large{
	float:left;
	width:25%;
}
.div_content_large{
	float:left;
	width:25%;
}
.form_select{
	width:150px;
}
.undisply{
	display:none;
}
.event{
	width:186px;
	height:300px;
	padding: 5px; background: #FFF; 
	border: 1px solid #cccccc; 
	-moz-border-radius: 7px;-webkit-border-radius: 7px; 
	 
	 box-shadow: 2px 2px 2px #cccccc;
	 margin-bottom:10px; 
	 margin-left:10px;
}	
.div_left{
	float:left;
	width:50px;
	border-right:dotted 1px;
	border-right-color:#CCC;	
}
.div_right{
	margin-left:5px;
	float:left;
	width:60%;
	
}
.clear{
	clear:both;
}
.event img{
	padding:1px;
}	
table.highlighted {
	border-collapse: collapse;
	margin: 10px 0;
}
.highlighted td {
	border: 1px solid #CCC;
	border-top: none;
	padding: 3px 5px;
	text-align: center;
	vertical-align: middle;
}
.highlighted tr.tableheader td {
	border: 1px solid #C04948;
	background: #FFC;
}
.konnectorstable td:first-child {
	text-align: left;
}
.noul ul,.noul li{
	display:none;
}	
.ticket_header{
	cursor:pointer;
}
.ticket_closed{
	color:#F00;
}
.error_msg{
	font-family:Verdana, Geneva, sans-serif;
	font-size:11px;
	color:#F00;
}
.event_form_delete{
	cursor:pointer;
	float:right;
}
.ticke_0 {
	display:block;
}
.event_open{
	display:block;
}
.event_terms {
	height: 100px;
	overflow: auto;
	text-align: justify;
	padding: 15px;
	margin: 15px 0;
	border: 1px solid #dedede;
}
.event_agree{
	margin-top:10px;
	height:10px;
	text-align:justify;
	padding-bottom:15px;
}
.event_terms_class label{
	font-weight:bold;
}
.event_ticket_purchase_module .elgg-list , .event_ticket_purchase_module  .elgg-list > li , #event_ticket ul, #event_ticket ul li{
	border:none;
}	
.event_ticket_purchase_module {
	border-color:#dedede;
}
.event_ticket_purchase_module label{
	font-weight:bold;
}
.event_field_half_width {
	width:45%;
	padding:0 15px 0 0;
	float:left;
}	
.event_guest_kme_features {
	color: #3E3E3E;
	font-size: 13px;
	padding: 0px 20px;
	text-shadow: none;
}
.event_guest_kme_features li {
	padding: 0px 25px;
	background: url(<?php echo SITE_URL;?>mod/kme/img/arrow.png) no-repeat bottom left;
	margin: 10px 20px 5px;
	font-size: 13px;
}