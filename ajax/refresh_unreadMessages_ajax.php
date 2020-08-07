<?php
	include('../includes/loader_ajax.php');

	if(isset($_POST['id']) || isset($_POST['uid']))
	{
		if(isset($_POST['id']))
		{
			$id = $db1->escape($_POST['id']);
		} else {
			$id = $db1->escape($_POST['uid']);	
		}
		$project_id = $db1->escape($_POST['proid']);
		
		$list_unread_messages = $msg->get_unread_messages_count_by_user($project_id);
//		$list_unread_messagesB = $msg->get_unread_messages_count_by_user_B($project_id, $id);

		if($list_unread_messages)
		{
			foreach($list_unread_messages as $c)
			{
				$list_unread_message[$c['user_id']] = $c['counted'];
			}
		} 

		if(isset($list_unread_message[$id]))
		{
			echo $list_unread_message[$id];
		} 
	}
?>
