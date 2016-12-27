<?php
/*
	width : 99%;
	-moz-transition: all .2s ease-in-out;
	-webkit-transition: all .2s ease-in-out;
	transition: all .2s ease-in-out;	
	
	font-family: "Open Sans","Helvetica Neue",Arial,"Liberation Sans",FreeSans,sans-serif;
    font-size:13px;
    font-weight:normal;
    padding:3px 12px;
	
	border-radius: 3px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;

	box-shadow: 0 0 0 1px #fa699b inset,1px 1px 0 rgba(0, 0, 0, 0.15);
	-webkit-box-shadow: inset 0 0 0 1px #fa699b, 1px 1px 0 rgba(0, 0, 0, 0.15);
	-moz-box-shadow: inset 0 0 0 1px #fa699b,1px 1px 0 rgba(0, 0, 0, 0.15);

	box-sizing: border-box;
	-webkit-box-sizing: border-box;

	background: #d13b6f url("<?php echo IMG_PATH;?>texture.png");
	border: 2px solid #d13b6f;
	color: #790909;
	text-align: center;
	text-shadow: 2px 2px 0 rgba(39, 3, 3, 0.15);
	margin: 0 auto;	
		
*/	
?>
.fivepxcurved {
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}
.fleft {
	float:left;
}
.fright{
	float:right;
}	
a {
	color: #d13b6f;
}

a:hover,a.selected { <?php //@todo remove .selected ?>
	color: #d13b6f;
}
h1, h2, h3, h4, h5, h6 {
	font-weight: normal;
	color: #444E51;
}
.elgg-inner::after, .elgg-page-footer::after, .elgg-foot::after{
	content: "";
	display: none;
}
body {
	background: #e9e7e4 url(<?php echo IMG_PATH;?>texture.png);
	font-size: 13px;
	line-height: 1.5em;
	font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
	color: #3E3E3E;
	text-shadow: 1px 1px 0px rgba(255,255,255,0.5);	
}
.elgg-page-default {
	min-width: 998px;	
	background: #e9e7e4 url(<?php echo IMG_PATH;?>texture.png);
}
.elgg-page-header {
	position: relative;
	background: #323232 url(<?php echo IMG_PATH;?>texture.png) repeat-x;	
	height:75px;
	max-height:75px;
	z-index:9001;
}
.elgg-heading-site {
	float:left;
	padding-top:10px;
}	
.top-donate {
	margin:-19px 0 0 170px;
}	
.elgg-layout-one-sidebar > .elgg-body {
	min-width:630px;
}
.kme_index{
	background: transparent url(<?php echo IMG_PATH;?>index-bg.png) repeat-x;
	margin-top: 15px;
}
.elgg-page-default .elgg-page-header > .elgg-inner {
	height: 60px;
}
.elgg-page-default .elgg-page-header > .elgg-inner h2 {
	max-width:200px;
	float:left;
}

.elgg-page-topbar {
	background: #1c1c1c url(<?php echo IMG_PATH;?>texture.png) repeat-x;	
	border-bottom: 1px #000404 solid;
	-moz-box-shadow: 0 1px 0 rgba(247, 246, 242, 0.1);
	-webkit-box-shadow: 0 1px 0 rgba(247, 246, 242, 0.1);
	box-shadow:  0 1px 0 rgba(247, 246, 242, 0.1);	
	position: relative;
	height: 40px;
	z-index: 8000;
}
.elgg-page-topbar > .elgg-inner {
	padding: 7px;
}
.elgg-page-default .elgg-page-sub-footer {
	background: #212121 url(<?php echo IMG_PATH;?>subfooter-bg.png) repeat-x;
	position: relative;
	height: 180px;

	border-bottom: 1px #000404 solid;
	-moz-box-shadow: 0 1px 0 rgba(247, 246, 242, 0.1);
	-webkit-box-shadow: 0 1px 0 rgba(247, 246, 242, 0.1);
	box-shadow:  0 1px 0 rgba(247, 246, 242, 0.1);	

	text-align: center;
	color: #8D9CA3;
	text-shadow: 1px 1px 0px rgba(255, 255, 255, 0.5);		
}
.elgg-page-default .elgg-page-footer {
	background: #1c1c1c url(<?php echo IMG_PATH;?>texture.png) repeat;
	position: relative;
	height: 40px;
	border-top: 1px solid #484747;
	text-align: center;
	color: #8D9CA3;
	text-shadow: 1px 1px 0px rgba(255, 255, 255, 0.5);		
}
.elgg-page-default .elgg-page-sub-footer  > .elgg-inner {
	max-width:990px;
	width:990px;
}
.elgg-page-default .elgg-page-footer > .elgg-inner {
	border-top: 0px solid #DEDEDE;
}
.elgg-menu-site-default {
	position: relative;
	bottom: 10px;
	left: 0;
	height: 23px;
	float:right;
	max-width:600px;
	margin-top:10px;
}
.elgg-menu-site-default > li {
	float: left;
	margin-left: 0px;
}
.elgg-menu-site-default > li > a{
	color: #fcfcfc;
	display: block;
	font-size: 12px;
	text-transform:uppercase;
	margin: 0px 3px;
	text-decoration: none;
	height: 21px;
	line-height: 26px;
	font-weight: normal;
	padding: 27px 13px;
}
.elgg-menu-site-default > .elgg-state-selected > a, .elgg-menu-site-default > li:hover > a {
	background: #424242 url(<?php echo IMG_PATH;?>texture.png) repeat;
	color: #fff;
	-webkit-box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.25);
	-moz-box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.25);
	box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.25);
	
	-webkit-border-radius: 0px;
	-moz-border-radius: 0px;
	border-radius: 0px;
		
}
.elgg-layout-one-sidebar {
	background: transparent;
}
.elgg-module-aside, .elgg-module-info, .groups-profile{
	padding: 10px;
/*	background: #fff url(<?php echo IMG_PATH;?>texture.png) repeat;	 */
	background: #fff;	
	
	border-radius: 3px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
		
	-webkit-box-shadow: 0 1px 8px rgba(0, 0, 0, 0.05), 0 0 1px rgba(0, 0, 0, 0.1), 0 1px 0 rgba(0, 0, 0, 0.1), inset 0 1px 0 white;
	-moz-box-shadow: 0 1px 8px rgba(0,0,0,0.05), 0 0 1px rgba(0,0,0,0.1), 0 1px 0 rgba(0,0,0,0.1), inset 0 1px 0 #fff;
	box-shadow: 0 1px 8px rgba(0, 0, 0, 0.05), 0 0 1px rgba(0, 0, 0, 0.1), 0 1px 0 rgba(0, 0, 0, 0.1), inset 0 1px 0 white;
	
}
.elgg-module-aside .elgg-head,.elgg-module-info .elgg-head{
	color: #444E51;
	border-radius: 0px;	
	background : none;
	border-bottom: 1px solid #BEBEBE;
	padding: 0px 0 8px 5px;
	margin: 0 0 10px 0px;	
}

.elgg-image-block{
	margin:1px 0;
}

.elgg-menu-owner-block li a, .elgg-menu-page li a {
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}
.elgg-list-river, .elgg-list ,.elgg-list-river > li, .elgg-list > li {
	border : 0px;
	margin-top: 5px;
}	
.elgg-sidebar {
	padding: 1px;
	width: 315px;
	margin: 20px 0 0 10px;
}
.elgg-layout-one-sidebar > .elgg-body {
	margin: 0px 0;
}
.elgg-subtext {
	font-style: normal;
}
.elgg-menu-page, .elgg-menu-owner-block {
	margin:0px;
	padding: 2px;
	
	background: none;
	border: none;
	color: #aaaaaa;
	text-shadow: 2px 2px 0 black;
	
	border-radius: 0px;
}
.elgg-menu-page a, .elgg-menu-owner-block li a {
	display: block;
	border-radius: 0px;

	background: transparent;
	border: 0px solid transparent;
	color: #3a3a3a;
	text-shadow: 2px 2px 0 rgba(39, 3, 3, 0.15);

	margin: 0 0 3px;
	padding: 3px 4px 3px 8px;
	
}
.elgg-menu-page a:hover ,.elgg-menu-owner-block li a:hover, .elgg-menu-page li.elgg-state-selected > a ,.elgg-menu-owner-block li.elgg-state-selected > a{
	background: none;
	color: #3a3a3a;
	text-shadow: 1px 1px 0 #2E2E2E;	
}

#login-dropdown {
	top: -34px;
	z-index: 9999;
}
#login-dropdown .elgg-button {
	background: #2a323d;
	-webkit-border-radius: 0px 0px 3px 3px;
	-moz-border-radius:  0px 0px 3px 3px;
	border-radius: 0px 0px 3px 3px;
	border: 1px solid #2a323d;
	display: inline-block;
	color: white;
	font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size: 13px;
	font-weight: normal;
	padding: 3px 12px;
	text-decoration: none;
	text-shadow: 0px;
}
/************ FORMS AND BUTTONS ************/
label {
	font-weight: normal;
	font-size: 100%;
}
input, textarea, select {
	border: 1px solid #D8DDE3;
	background: #F5F5F7;
	font: 100% "Open Sans","Helvetica Neue",Arial,"Liberation Sans",FreeSans,sans-serif;
	padding: 4px;

	box-shadow: inset 1px 1px 3px 0 rgba(235, 232, 232, 0.75);
	-webkit-box-shadow: inset 1px 1px 3px 0 rgba(235, 232, 232, 0.75);
	-moz-box-shadow: inset 1px 1px 3px 0 rgba(235,232,232,0.75);

	border-radius: 3px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	
}
.elgg-button {             	
	font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size:13px;
    font-weight:normal;
    padding:3px 12px;
	
	border-radius: 3px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;

	box-shadow: inset 0 0 0 1px #CA4E4A,2px 2px 0 rgba(0, 0, 0, 0.15);
	-webkit-box-shadow: inset 0 0 0 1px #CA4E4A,2px 2px 0 rgba(0, 0, 0, 0.15);
	-moz-box-shadow: inset 0 0 0 1px #E49B50,3px 3px 0 rgba(0, 0, 0, 0.15);

	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	
/*	background: #AB423F url("<?php echo IMG_PATH;?>texture.png"); */
	background: #AB423F;
	border: 2px solid #AB423F;
	color: #582221;
	text-shadow: 1px 1px 0 #CE504C;	

	text-align: center;
	margin: 0 auto;	
	
}
.elgg-button:hover {
	text-decoration: none;
		
	box-shadow: inset 0 0 0 1px #CA4E4A,2px 2px 0 rgba(0, 0, 0, 0.15);
	-webkit-box-shadow: inset 0 0 0 1px #CA4E4A,2px 2px 0 rgba(0, 0, 0, 0.15);
	-moz-box-shadow: inset 0 0 0 1px #E49B50,3px 3px 0 rgba(0, 0, 0, 0.15);

/*	background: #AB423F url("<?php echo IMG_PATH;?>texture.png"); */
	background: #AB423F;
	border: 2px solid #AB423F;
	color: #582221;
	text-shadow: 1px 1px 0 #CE504C;	
}
.elgg-button-delete {
	text-align: center;
	box-shadow: inset 0 0 0 1px #a5a5a5,2px 2px 0 rgba(0, 0, 0, 0.15);
	-webkit-box-shadow: inset 0 0 0 1px #a5a5a5,2px 2px 0 rgba(0, 0, 0, 0.15);
	-moz-box-shadow: inset 0 0 0 1px #a5a5a5,3px 3px 0 rgba(0, 0, 0, 0.15);

/*	background: #737373 url("<?php echo IMG_PATH;?>texture.png"); */
	background: #737373;
	border: 2px solid #737373;
	color: #323232;
	text-shadow: 1px 1px 0 #969696;	
}
.elgg-button-delete:hover {
	background: #f5220e;
}
.elgg-button-action {
	text-shadow: none;
}
/****** GROUPS *********/
#groups-tools > li {
	width: 49%;
	min-height: 10px;
	margin-bottom: 0px;
}
#groups-tools > li:nth-child(odd) {
	margin-right: 2%;
}
/********* SYSTEM MESSAGE ************/
.elgg-system-messages {
	position: absolute; 
	top: 0px; 
	left: 0px; 
	right: 0px;
	padding: 0;
	max-width: none;
	z-index:9999;
}
.elgg-message {
	background: #D9EDF7;
	color: #3A87AD;
	border: 1px solid #BCE8F1;

	font-weight: bold;
	display: block;
	padding: 10px 20px;
	margin-bottom: 10px;
	cursor: pointer;
	opacity: 1;

	-webkit-box-shadow: 0 2px 5px rgba(0, 0, 0, 0.45);
	-moz-box-shadow: 0 2px 5px rgba(0, 0, 0, 0.45);
	box-shadow: 0 2px 5px rgba(0, 0, 0, 0.45);

	-webkit-border-radius: 0px;
	-moz-border-radius: 0px;
	border-radius: 0px;
}
.elgg-system-messages li {
	margin-top:0px;
}	
.elgg-state-success {
	background: #DFF0D8;
	border-color: #D6E9C6;
	color: #468847;
}
.elgg-state-error {
	background: #F2DEDE;
	border-color: #EED3D7;
	color: #B94A48;
}
.elgg-state-notice {
	background: #FCF8E3;
	border-color: #FBEED5;
	color: #C09853;
}
/************ HOME PAGE ************/
.kme_index_wrapper{
	margin-top: -15px;
}
.home-intro-text {
	min-width:100px;
}
.home-intro-video {
	padding:35px 0 2px;
	background : url("<?php echo IMG_PATH;?>video_shadow.png") no-repeat bottom left;	
}

/***** LOGIN FORM ********/
.elgg-module-dropdown {
	z-index:9999;
}
	
/************** MISC ************/
.elgg-comments,.elgg-comments > form, .elgg-output {
	margin-top: 0px;
}
