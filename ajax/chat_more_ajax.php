<?php
	include('../includes/loader_ajax.php');
	
	if(isset($_POST['lastid']) && isset($_POST['uid']))
	{
		$lastid = intval($db1->escape($_POST['lastid']));
		$lastid = $lastid + $perpage;
		$countVal = $_POST['countVal'];
		$user_id = $db1->escape($_POST['uid']);
		
		$load_more = true;
		include('../chat.php');
	}
	
?>
