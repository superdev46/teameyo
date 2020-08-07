<?php
	include('../includes/loader_ajax.php');
	
	header('Content-Type: text/html; charset=utf-8');

	if(isset($_POST['id']))
	{
		$user_id = $db1->escape($_POST['id']);
		
		$message = $db1->escape($_POST['message']);
		
		$pro_ID = $db1->escape($_POST['user_pro_id']);
			
		$cdata = $msg->add_message($user_id, $pro_ID, $message);
		
		$new_msg = true;
		if($cdata) 
		{
			include('../chat.php');
		} 
	}
?>
