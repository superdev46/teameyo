<?php 

// session_start();
include('../includes/lib-initialize.php'); 

$u_type = $_POST['user_type'];
if($u_type == 'client')
{
	$uid = $_POST['user_id'];
	$user = User::findById((int)$uid);
	echo $user->firstName;
}else if($u_type == 'staff')
{
	$uids = explode(',', $_POST['user_id']);
	$names = array();
	$names_str = '';
	for($i = 0; $i < count($uids); $i++)
	{
		$uid = $uids[$i];
		$user = User::findById((int)$uid);
		array_push($names, $user->firstName);
	}

	if(count($names) > 0)
	{
		$names_str = implode(',', $names);
	}
	echo $names_str;
}

?>