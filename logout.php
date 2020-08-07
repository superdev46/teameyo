<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Logout Page  //////////////////////////
*/
session_start();
include('includes/loader.php');
 require_once("includes/initialize.php"); ?>
<?php
if($msg->logged_user_id != ''){
	$msg->set_user_sessionStatus("offline");
	
	}
$session->logout();
//on logout delete remember me cookie
if(isset($_COOKIE['artiLogin'])){setcookie("artiLogin"," ",time()-1);}
 session_destroy();

header('location:'.$url);
 ?>