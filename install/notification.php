<?php 
$installed_on = $hostname;
	$admin_email = 'omer@artimization.com';
				  $headers  .= 'MIME-Version: 1.0' . "\r\n";
				  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$header .= 'From: Teameyo <admin@'.$installed_on.'>' . '\r\n';
	$subject = 'Teameyo Installation Notification';
	$message = 'Hi admin, Teameyo installed on '.$installed_on.' Domain.';
	mail($admin_email, $subject, $message, $header);