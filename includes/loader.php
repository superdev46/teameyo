<?php

  if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	
	error_reporting(1);
	
	include('config.php');

	include('database.class.php');
	
	$db1 = new ConnectMe(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	
	include('messages.class.php');
	
	$msg = new Messages();
	
	$msg->logged_user_id = @$_SESSION['logged_user_id'];
	if($msg->logged_user_id != ''){
	$msg->set_user_sessionStatus("online");
	}
			
?>