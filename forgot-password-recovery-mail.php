<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Recovery Password Page  //////////////////////////
*/
include("includes/lib-initialize.php");
$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$account_stat=$user->status;
$settings = settings::findById((int)$id);

$to  = $foundUser->email;
$subject = 'Recover Password';
$reset_url = $url . 'reset_password.php?name=' .  $foundUser->firstName . '&userid=' .  $foundUser->id;
$variablesArr = array('{USER_NAME}' => $foundUser->firstName , '{SIGNATURE}' => $company_name, '{DASHBOARD_URL}' => $url, '{USER_LOGIN_PASSWORD}' => $user->password , '{USER_LOGIN_EMAIL}' => $user->email , '{RESET_URL}' => $reset_url);
$templateHTML = $settings->forget_email;
$message = strtr($templateHTML, $variablesArr);
				  
				  // To send HTML mail, the Content-type header must be set (don't change this section)
				  $headers  = 'MIME-Version: 1.0' . "\r\n";
				  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				  
				  $headers .= 'From: '.$company_name.' <'.$system_email.'>' . "\r\n";
				  
				  // Mail it
				  $emailSent=mail($to,$subject, $message, $headers);
				  if($emailSent){
					 
					  $message="Please check your email to reset password!";
					  //header('location: index.php');  
				  }
				  else
				  {
					  echo "Problem in Sending Password Recovery Email";
					  exit;
				  }
				  

?>