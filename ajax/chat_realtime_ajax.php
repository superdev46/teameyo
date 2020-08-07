<?php
	include('../includes/loader_ajax.php');

	if(isset($_POST['id']))
	{ 
$user_id = $db1->escape($_POST['id']);

		$user_pro_id = $_POST['user_pro_id'];
		$message = $msg->get_last_message($user_id, $user_pro_id);

		if(!empty($message['user_id']))
		{ 
			if($message['user_id'] == $msg->logged_user_id)
			{
				$chat_name = 'You';
			} else {
				$chat_name = $msg->return_display_name($message['user_id']);	
				include('../realtime_chat.php');
			}
			
			
		}
	}
?>