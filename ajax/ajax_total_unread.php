<?php 
	
	include('../includes/loader_ajax.php');
	
	if(isset($_POST['total_unread']) && $_POST['total_unread'] == 'true')
	{
		$t_r = $msg->total_unread_messages();
		if($t_r !== false)
		{ 
			echo $t_r; 
		} else {
			echo '';	
		}
	}

?>