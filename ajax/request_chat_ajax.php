<?php
	include('../includes/loader_ajax.php');
	
	header('Content-Type: text/html; charset=utf-8');

	if(isset($_POST['id']))
	{
		$user_id = $db1->escape($_POST['id']);
		
		$user_pro_id = $db1->escape($_POST['user_pro_id']);

		$cdata = $msg->get_messages($user_id, $user_pro_id);
		
		if($cdata) 
		{
			include('../chat.php');
		} else {
			include('../start_chat.php');	
		}
	}
?>
