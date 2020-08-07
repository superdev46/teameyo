<?php
	include('../includes/loader_ajax.php');

	if(isset($_POST['id']) && isset($_POST['uid']))
	{
		$message_id = $db1->escape($_POST['id']);
		
		$user_id = $db1->escape($_POST['uid']);
		$proid = $db1->escape($_POST['proid']);
					
		$ok = $msg->delete_message($message_id, $user_id, $proid);
				
		if($ok) 
		{
			echo true;
		} else {
			echo false;	
		}
	}
?>
