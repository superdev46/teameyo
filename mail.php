<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Logout Page  //////////////////////////
*/

include('./includes/lib-initialize.php'); 

$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$account_stat=$user->status;
$settings = settings::findById((int)$id);

$project_title = "Test Project Title";
		// send verification email
		$to  = "snhealth923@gmail.com";
		$subject = 'New Project Created';
		$variablesArr = array('{USER_NAME}' => "First Name", '{SIGNATURE}' => "Company Name", '{DASHBOARD_URL}' => "http://localhost", '{PROJECT_NAME}' => $project_title);
		$templateHTML = $settings->project_assign_email;
		$message = strtr($templateHTML, $variablesArr);
	  // To send HTML mail, the Content-type header must be set (don't change this section)
	  $headers  = 'MIME-Version: 1.0' . "\r\n";
	  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	  
	  $headers .= 'From: '.$company_name.' <'.$system_email.'>' . "\r\n";
	  $emailSent=mail($to,$subject, $message, $headers);
	  if($emailSent){ 
  			$message="<p class='alert alert-success'><i class='fa fa-check'></i> Project has been created successfully!</p>";
  			echo $message;
	  }
	  else{
		  echo "Project has been created successfully! but Error sending the Email please contact site administrator";
	 }

?>