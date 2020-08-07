<?php
	include('../includes/loader_ajax.php');
	
	if(isset($_POST['id']))
	{
		$user_id = $db1->escape($_POST['id']);
		
		$message = $msg->get_last_message($user_id);
		
		$c_id = $message['id'];

		if($c_id == false)
		{
			exit();
		} else {
			echo 'u_msg'.$c_id;
		}
	}
?>
