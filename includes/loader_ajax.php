<?php
 	session_start();
/*	
	error_reporting(1); */

	include('../includes/config.php');
	include('../includes/time_setup.php');

	include('../includes/database.class.php');
	
	$db1 = new ConnectMe(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	
	include('../includes/messages.class.php');
	
	$msg = new Messages();
	
	//include('../includes/demo.functions.php');
	//include('../includes/demo.session.php');
	
	$msg->logged_user_id = @$_SESSION['logged_user_id'];
	if($msg->logged_user_id != ''){
	$msg->set_user_sessionStatus("online");
	}
	
	include('../includes/embed.php');
	
	include('../includes/attachments.class.php');
	
	include('../includes/maps.class.php');
	
?>