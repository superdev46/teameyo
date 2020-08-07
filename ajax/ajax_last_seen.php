<?php
	
	include('../includes/loader_ajax.php');
	
	if(isset($_POST['offline']) && $_POST['offline'] == 'true')
	{
		$msg->set_user_sessionStatus('offline');
	} elseif(isset($_POST['offline']) && $_POST['offline'] == 'false') {
		$msg->set_user_sessionStatus('online');	
	}

?>