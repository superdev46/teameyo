<?php
	include('../includes/loader_ajax.php');
	if(isset($_POST['post_tabs']) && $_POST['post_tabs'] == 'contacts')
	{
		 $init_load = true;
		 $load_more = true;
		
		$msg->active_tab = 'contacts';
		if(isset($_POST['project_idb'])){
$project_id = $_POST['project_idb'];
		}
		include('../chat_list.php');

	}
	
	if(isset($_POST['post_tabs']) && $_POST['post_tabs'] == 'chats')
	{
		 $init_load = true;
		$load_more = true;
		$chat_tab = true;
		if(isset($_POST['project_idb'])){
 $project_id = $_POST['project_idb'];
		}
		$msg->active_tab = 'chats';
		 include('../chat_list.php');
	}
?>
