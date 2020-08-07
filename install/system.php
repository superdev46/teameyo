<?php 
include('../includes/config.php');
date_default_timezone_set('GMT');
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$website_url = dirname(dirname($actual_link)).'/';
$connect = mysqli_connect(DB_SERVER , DB_USER, DB_PASS, DB_NAME);
if(isset($_POST['admin-form'])){
	$firstName = $_POST['firstName'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$title = $_POST['title'];
	$accountStatus = (int)$_POST['accountStatus'];
	$regDate = strftime("%Y-%m-%d %H:%M:%S", time());
	$last_seen = time();
$sql = "INSERT INTO users (firstname, password, email, title, Projects_ids, accountStatus, address, phone, website, skype_id, fb, regDate, type_status, last_seen, session_status, status, note, city, state, zip, country, user_language )
VALUES ('$firstName', '$password', '$email', '$title', '', '$accountStatus', '', '', '', '', '', '$regDate', '', '$last_seen', '', '0', '', '', '', '', '', 'en' )";

if ($connect->query($sql) === TRUE) {
$url = $website_url;
$company_name = 'Teameyo'; 
$syatem_title = 'Teameyo - Lets manage together' ;
$login_page_title = 'Hello and welcome, <br/>Please Login';
$copy_rights = '&copy; Copyright 2019 by Teameyo.<br/> All Rights Reserved';
$system_currency = 'USD,$';
$time_zone = 'Asia/Karachi';
$favicon_image = '';
$login_page_logo = '';
$logo = '';
$mobile_logo = '';
$stripe_sk = ''; 
$stripe_pk = ''; 
$paypal_email = ''; 
$checkout_id = ''; 
$checkout_pk = '';
$system_email = 'no-reply@teameyo.com'; 
$forget_email = '<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f3f2f0" align="center">
<tbody><tr><td height="40"> </td></tr>
<tr><td height="20"> </td></tr>
  <tr>
    <td>
  <table style="margin:0 auto" width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center">
  <tbody><tr>
    <td>
    <table style="margin:0 auto" width="400" cellspacing="0" cellpadding="0" border="0" align="center">
   <tbody><tr>
    <td height="60"></td>
  </tr>
  <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">Hi, {USER_NAME} </font></td>
  </tr>
  <tr>
    <td height="30"></td>
  </tr>
  <tr>
    <td><font size="6" face="Arial, Helvetica, sans-serif" color="#5fbaff"><b>You requested your Teameyo password be reset.</b></font></td>
  </tr>
  <tr>
    <td height="40"></td>
  </tr>
  <tr>
    <td> <table width="450" cellspacing="0" cellpadding="0" border="0">
  <tbody><tr>
<td width="200" height="40" bgcolor="#5fbaff" align="center">
    <a href="{RESET_URL}"><font size="3" face="Arial, Helvetica, sans-serif" color="#FFFFFF" style="text-decoration:none;"><b>Reset your password</b></font></a> 
    </td><td width="200">&nbsp;</td>  </tr>
</tbody></table>
</td>
  </tr>
  <tr>
    <td height="30"></td>
  </tr>
    <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">You will then be able to log into your account and change your password.</font></td>
  </tr>
    <tr>
  <td height="30"></td>
  </tr>
      <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">If you <b> did not request your password be reset</b> then ignore this email.</font></td>
  </tr>
    <tr>
  <td height="30"></td>
  </tr>
  <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">Kind Regards,<br>{SIGNATURE}</font></td>
  </tr>
  <tr>
  <td height="60"></td>
  </tr>
</tbody></table>
    </td>
  </tr>
</tbody></table>
    </td></tr><tr><td height="50"> </td></tr>
</tbody></table>';
$create_account_email = '<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f3f2f0" align="center">
<tbody><tr><td height="40"> </td></tr>
<tr><td height="20"> </td></tr>
  <tr>
    <td>
  <table style="margin:0 auto" width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center">
  <tbody><tr>
    <td>
    <table style="margin:0 auto" width="400" cellspacing="0" cellpadding="0" border="0" align="center">
   <tbody><tr>
    <td height="60"></td>
  </tr>
  <tr>
    <td><font size="6" face="Arial, Helvetica, sans-serif" color="#5fbaff"><b>Welcome to the Teameyo community!</b></font></td>
  </tr>
  <tr>
    <td height="40"></td>
  </tr>
  <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">Hi {USER_NAME},</font></td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>
  <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">You are free to login with followed details</font></td>
  </tr>
  <tr>
    <td height="30"></td>
  </tr>
   <tr>
    <td><table width="400" cellspacing="0" cellpadding="0" border="0">
  <tbody><tr>
<td width="100" height="40" bgcolor="#5fbaff" align="center">
    <a href="{DASHBOARD_URL}"><font size="3" face="Arial, Helvetica, sans-serif" color="#FFFFFF" style="text-decoration:none;"><b>Login</b></font></a> 
    </td><td width="300">&nbsp;</td>  </tr>
</tbody></table></td>
  </tr>
   <tr>
    <td height="30"></td>
  </tr>
  <tr>
      <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">
Email : {USER_LOGIN_EMAIL}<br>
 Password: {USER_LOGIN_PASSWORD}</font></td>
  </tr>
  <tr>
    <td height="30"></td>
  </tr>
  <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">Kind Regards,<br>
{SIGNATURE}</font></td>
  </tr>
  <tr>
  <td height="60"></td>
  </tr>
</tbody></table>
    </td>
  </tr>
</tbody></table>
    </td></tr><tr><td height="60"> </td></tr>
</tbody></table>'; 
$project_assign_email = '<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f3f2f0" align="center">
<tbody><tr><td height="40"> </td></tr>
<tr><td height="20"> </td></tr>
  <tr>
    <td>
  <table style="margin:0 auto" width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center">
  <tbody><tr>
    <td>
    <table style="margin:0 auto" width="400" cellspacing="0" cellpadding="0" border="0" align="center">
   <tbody><tr>
    <td height="60"></td>
  </tr>
  <tr>
    <td><font size="6" face="Arial, Helvetica, sans-serif" color="#5fbaff"><b>A new project has been created in the Teameyo community!</b></font></td>
  </tr>
  <tr>
    <td height="40"></td>
  </tr>
    <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">Hi, {USER_NAME}</font></td>
  </tr>
    <tr>
  <td height="30"></td>
  </tr>
      <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">Project name: {PROJECT_NAME}</font></td>
  </tr>
   <tr>
  <td height="20"></td>
  </tr>
      <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">Please login your account to view status and updates of the project.</font></td>
  </tr>
  <tr>
  <td height="20"></td>
  </tr>
    <tr>
  <td><table width="400" cellspacing="0" cellpadding="0" border="0">
  <tbody><tr>
<td width="100" height="40" bgcolor="#5fbaff" align="center">
    <a href="{DASHBOARD_URL}"><font size="3" face="Arial, Helvetica, sans-serif" color="#FFFFFF" style="text-decoration:none;"><b>Login</b></font></a> 
    </td><td width="300">&nbsp;</td>  </tr>
</tbody></table></td>
  </tr>
    <tr>
  <td height="30"></td>
  </tr>
  <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">Kind Regards,<br>{SIGNATURE}</font></td>
  </tr>
  <tr>
  <td height="60"></td>
  </tr>
</tbody></table>
    </td>
  </tr>
</tbody></table>
    </td></tr><tr><td height="50"> </td></tr>
</tbody></table>';
$assign_staff_email = '<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f3f2f0" align="center">
<tbody><tr><td height="40"> </td></tr>
<tr><td height="20"> </td></tr>
  <tr>
    <td>
  <table style="margin:0 auto" width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center">
  <tbody><tr>
    <td>
    <table style="margin:0 auto" width="400" cellspacing="0" cellpadding="0" border="0" align="center">
   <tbody><tr>
    <td height="60"></td>
  </tr>
  <tr>
    <td><font size="6" face="Arial, Helvetica, sans-serif" color="#5fbaff"><b>Admin assigned you in a project</b></font></td>
  </tr>
  <tr>
    <td height="40"></td>
  </tr>
    <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">Hi, {USER_NAME}</font></td>
  </tr>
    <tr>
  <td height="30"></td>
  </tr>
      <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">Project name: {PROJECT_NAME}</font></td>
  </tr>
   <tr>
  <td height="20"></td>
  </tr>
      <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">Please login your account to view status and updates of the project.</font></td>
  </tr>
  <tr>
  <td height="20"></td>
  </tr>
    <tr>
  <td><table width="400" cellspacing="0" cellpadding="0" border="0">
  <tbody><tr>
<td width="100" height="40" bgcolor="#5fbaff" align="center">
    <a href="{DASHBOARD_URL}"><font style="text-decoration:none;" size="3" face="Arial, Helvetica, sans-serif" color="#FFFFFF"><b>Login</b></font></a> 
    </td><td width="300">Â </td>  </tr>
</tbody></table></td>
  </tr>
    <tr>
  <td height="30"></td>
  </tr>
  <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">Kind Regards,<br>{SIGNATURE}</font></td>
  </tr>
  <tr>
  <td height="60"></td>
  </tr>
</tbody></table>
    </td>
  </tr>
</tbody></table>
    </td></tr><tr><td height="50"> </td></tr>
</tbody></table>';
$project_update_email = '<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f3f2f0" align="center">
<tbody><tr><td height="40"> </td></tr>
<tr><td height="20"> </td></tr>
  <tr>
    <td>
  <table style="margin:0 auto" width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center">
  <tbody><tr>
    <td>
    <table style="margin:0 auto" width="400" cellspacing="0" cellpadding="0" border="0" align="center">
   <tbody><tr>
    <td height="60"></td>
  </tr>
  <tr>
    <td><font size="6" face="Arial, Helvetica, sans-serif" color="#5fbaff"><b>Admin update the project information <br></b></font></td>
  </tr>
  <tr>
    <td height="40"></td>
  </tr>
    <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">Hi, {USER_NAME}</font></td>
  </tr>
    <tr>
  <td height="30"></td>
  </tr>
      <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">Project name: {PROJECT_NAME}</font></td>
  </tr>
   <tr>
  <td height="20"></td>
  </tr>
      <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">Please login your account to view status and updates of the project.</font></td>
  </tr>
  <tr>
  <td height="20"></td>
  </tr>
    <tr>
  <td><table width="400" cellspacing="0" cellpadding="0" border="0">
  <tbody><tr>
<td width="100" height="40" bgcolor="#5fbaff" align="center">
    <a href="{DASHBOARD_URL}"><font style="text-decoration:none;" size="3" face="Arial, Helvetica, sans-serif" color="#FFFFFF"><b>Login</b></font></a> 
    </td><td width="300">&nbsp;</td>  </tr>
</tbody></table></td>
  </tr>
    <tr>
  <td height="30"></td>
  </tr>
  <tr>
    <td><font size="3" face="Arial, Helvetica, sans-serif" color="#000000">Kind Regards,<br>{SIGNATURE}</font></td>
  </tr>
  <tr>
  <td height="60"></td>
  </tr>
</tbody></table>
    </td>
  </tr>
</tbody></table>
    </td></tr><tr><td height="50"> </td></tr>
</tbody></table>';
$sqlsetting = "INSERT INTO settings (url, company_name, syatem_title, login_page_title, copy_rights, system_currency, time_zone, favicon_image, login_page_logo, logo, mobile_logo, stripe_sk, stripe_pk, paypal_email, checkout_id, checkout_pk, system_email, forget_email, create_account_email, project_assign_email, assign_staff_email, project_update_email, system_language, version, purchase_code) VALUES ('$url', '$company_name', '$syatem_title', '$login_page_title', '$copy_rights', '$system_currency', '$time_zone', '$favicon_image', '$login_page_logo', '$logo', '$mobile_logo', '$stripe_sk', '$stripe_pk', '$paypal_email', '$checkout_id', '$checkout_pk', '$system_email', '$forget_email', '$create_account_email', '$project_assign_email', '$assign_staff_email', '$project_update_email', 'en', '', '')";
header('Location: '.$website_url.'?message=installed');
if ($connect->query($sqlsetting) === TRUE) {
	
} else{
	echo 'Error Inserting Records';
}
} else {
    echo "Error: " . $sql . "<br>" . $connect->error;
}
$connect->close();
}
if (!$connect) {
    echo "Error: Unable to connect to MySQL. <br> Please <a href='index.php'>Click Here</a> to install/Add Database Details!";
    exit;
}else{ ?>
<!DOCTYPE html>
<html>
<head>
<title>Teameyo Installation</title>
 <link href='https://fonts.googleapis.com/css?family=Raleway:400,600,500,700' rel='stylesheet' type='text/css'>
 <link href="style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="dbinstall">
<h1>Admin Account Setup</h1>
<form method="post" action="">
<input required type="text" name="firstName" placeholder="Full Name"/>
<input required type="text" name="password" placeholder="Password"/>
<input required type="email" name="email" placeholder="Admin Email"/>
<input required type="text" name="title" placeholder="Designation"/>
<input required type="hidden" name="accountStatus" value="1" />
<button type="submit" name="admin-form">Submit</button>
</form>
</div>
</body>
</html>
<?php }