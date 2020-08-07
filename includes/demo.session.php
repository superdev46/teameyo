<?php

	////////////////////////////////////////////////////////////////////////////
	// Please Note: Do not use this session on your work, use your own session
	// This is a simulation just to demostrate the features of messages system
	////////////////////////////////////////////////////////////////////////////
	
	// Controls if isset the id of the user, else go back and set
	if(!isset($_SESSION['m_simulate_login']) && basename($_SERVER['PHP_SELF']) !== '/')
	{
		header('Location: /');
		exit();
	} elseif(isset($_POST['user_id']) && isset($_POST['submit']) && basename($_SERVER['PHP_SELF']) == '/') {
		$_SESSION['m_simulate_login'] = $_POST['user_id'];
		$msg->logged_user_id = $_SESSION['m_simulate_login']; // This is important so it can record login data
		$msg->set_user_sessionStatus('online');
		header('Location: messages.php');
		exit();	
	}
	
	if(isset($_GET['logout']) && $_GET['logout'] == true)
	{ 
		$msg->logged_user_id = @$_SESSION['m_simulate_login']; // This is important so it can record logout data
		$msg->set_user_sessionStatus('offline');
		$_SESSION = array();
		if(isset($_COOKIE[session_name()]))
		{
			setcookie(session_name(), '', time() - 3600);	
		}
		session_destroy();
	}
	
?>