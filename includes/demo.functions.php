<?php
	// Please Note: These are demo functions, probably you don't need all of them when you integrate
	
	// Return a list of users (used on index.php page)
	function get_users()
	{
		global $db1;
		
		$query = $db1->query("SELECT * FROM users");
		
		return $db1->results($query);
	}	
	
	// Return profile pic (used on messages.php)
	function profile_picture($user_id, $base_url)
	{
		global $msg;
		
		$app_path = $_SERVER['DOCUMENT_ROOT'].'/messages/';

		$path = 'uploads/profile-pics/';
		$profilePictureObj1=profilePicture::findByfkUserId($user_id);
		if($profilePictureObj1){
			foreach($profilePictureObj1 as $displayPicture1)
			{
			 $profilePic1=$displayPicture1->filename;
			 if(file_exists($app_path.$path.$profilePic1))
			{
				return $base_url.$path.$result;	
			} else {
				return $base_url.$path.'default.jpg';	
			}
			}
		}
		//$result = $msg->user_profile_picture($user_id, $base_url);
		//$result = $msg->user_profile_picture($user_id, $base_url);
		
	}
?>