<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Default Emails Template Edit Page  //////////////////////////
*/
ob_start(); 
include("../includes/lib-initialize.php");
$title = "System Setting | ". $syatem_title;
include("../templates/admin-header.php");
 if(!($session->isLoggedIn())){
		redirectTo($url."index.php");
	}
if($_SESSION['accountStatus'] == 2){
	redirectTo($url."client/index.php");
}
if($_SESSION['accountStatus'] == 3){
	redirectTo($url."staff/index.php");
} 
//condition check for login

$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$account_stat=$user->status;

$settings = settings::findById((int)$id);

$message = "";
	if(isset($_POST['createfrm']))	{

$flag=0;//determines if all posted values are not empty includ
		
		if($flag==0)
		{
     
$settings = settings::findById((int)$session->userId); 	  
			// $settings = new Settings();
				$settings->id =  $session->userId;
				$settings->create_account_email = $_POST['createaccount'];
	
	$savesettings=$settings->save();
			
			if($savesettings){
				header('location:email-setting.php?message=success');
			}else{
header('location:email-setting.php?message=fail');
			}

	}
	
	}
	if(isset($_POST['forgetfrm']))	{

$flag=0;//determines if all posted values are not empty includ
		
		if($flag==0)
		{
     
$settings = settings::findById((int)$session->userId); 	  
			// $settings = new Settings();
				$settings->id =  $session->userId;
				$settings->forget_email = $_POST['forgetaccount'];
	
	$savesettings=$settings->save();
			
			if($savesettings){
				header('location:email-setting.php?message=success');
			}else{
header('location:email-setting.php?message=fail');
			}

	}
	
	}
	if(isset($_POST['proassfrm']))	{

$flag=0;//determines if all posted values are not empty includ
		
		if($flag==0)
		{
     
$settings = settings::findById((int)$session->userId); 	  
			// $settings = new Settings();
				$settings->id =  $session->userId;
				$settings->project_assign_email = $_POST['projectassign'];
	
	$savesettings=$settings->save();
			
			if($savesettings){
				header('location:email-setting.php?message=success');
			}else{
header('location:email-setting.php?message=fail');
			}

	}
	
	}
if(isset($_POST['proassfrmstaff']))	{

$flag=0;//determines if all posted values are not empty includ
		
		if($flag==0)
		{
     
$settings = settings::findById((int)$session->userId); 	  
			// $settings = new Settings();
				$settings->id =  $session->userId;
				$settings->assign_staff_email = $_POST['projectassignstaff'];
	
	$savesettings=$settings->save();
			
			if($savesettings){
				header('location:email-setting.php?message=success');
			}else{
header('location:email-setting.php?message=fail');
			}

	}
	
	}
if(isset($_POST['proupdatefrm']))	{

$flag=0;//determines if all posted values are not empty includ
		
		if($flag==0)
		{
     
$settings = settings::findById((int)$session->userId); 	  
			// $settings = new Settings();
				$settings->id =  $session->userId;
				$settings->project_update_email = $_POST['projectupdate'];
	
	$savesettings=$settings->save();
			
			if($savesettings){
				header('location:email-setting.php?message=success');
			}else{
header('location:email-setting.php?message=fail');
			}

	}
	
	}
if(isset($_GET['message'])){
$msgstatus = $_GET['message'];
$notmessagea = $lang['System Settings has been saved successfully!'];
$notmessageb = $lang['Same values will not be updated, please make changes and save settings again, Thanks'];
if($msgstatus == 'success'){
					$message="<p class='alert alert-success' style='margin-top:10px;'><i class='fa fa-check'></i> ".$notmessagea."</p>";
}
if($msgstatus == 'fail'){
					 $message="<p class='alert alert-danger' style='margin-top:10px;'><i class='fa fa-times'></i> ".$notmessageb."</p>";
}
}
?>
<div class="page-container">
<div class="container-fluid">
<div class="row row-eq-height">
	<?php  include("../templates/sidebar.php"); ?>
	
    <div class="page-content col-lg-9 col-md-12 col-sm-12 col-lg-push-3" style="padding-bottom:0;">
<?php include('../templates/top-header.php'); ?>
<div class="row system-wrap">
<div class="col-md-3 ss-left">
 <h2 class="page-title"><?php echo $lang['System Settings']; ?></h2>
 <div class="ss-sidenav">
 <ul>
 <li><a href="system-settings.php"><?php echo $lang['General Settings']; ?></a></li>
<li><a href="payment-setting.php"><?php echo $lang['Payment Settings']; ?></a></li>
<li class="active"><a href="email-setting.php"><?php echo $lang['Email Notifications']; ?></a></li>
 </ul>
 </div>
</div>
<div class="col-md-9 ss-right">
<h2 class="page-title"><?php echo $lang['Emails Setting']; ?></h2>
<div class="row general-settings">
<?php if(isset($message) && (!empty($message))){echo $message;} ?>
<div class="payment-box">
<div class="pbox-wrap">
<div class="pbox-lft">
<h3><?php echo $lang['Create Account Email Setting']; ?></h3>
</div>
<div class="pbox-rt"><a href="#" class="setup-btn"><?php echo $lang['SET-UP']; ?></a></div>
</div>
<div class="payment-b-txt"><?php echo $lang['Shortcodes:']; ?> <br> <?php echo $lang['User name']; ?>: {USER_NAME}, <?php echo $lang['Login URL']; ?>: {DASHBOARD_URL}, <?php echo $lang['User Email']; ?>: {USER_LOGIN_EMAIL}, <?php echo $lang['User Password']; ?>: {USER_LOGIN_PASSWORD}, <?php echo $lang['Signature']; ?>: {SIGNATURE}</div>
<div class="row">
<div class="col-md-12">
<div class="payment-fields" style="display: block;">
<form method="post" action="#" enctype="multipart/form-data">
<textarea id="editor" name="createaccount"><?php echo $settings->create_account_email;?></textarea> 
 <button type="submit" name="createfrm" class="bigbutton ss-btn"><?php echo $lang['Save Setting']; ?></button>
</form>
</div>
</div>
</div>
</div>
<!-- Box 2 -->
<div class="payment-box">
<div class="pbox-wrap">
<div class="pbox-lft">
<h3><?php echo $lang['Forget Email Setting']; ?></h3>
</div>
<div class="pbox-rt"><a href="#" class="setup-btn"><?php echo $lang['SET-UP']; ?></a></div>
</div>
<div class="payment-b-txt"><?php echo $lang['Shortcodes:']; ?> <br> <?php echo $lang['User name']; ?>: {USER_NAME}, <?php echo $lang['Password Reset URL']; ?>: {RESET_URL}, <?php echo $lang['Signature']; ?>:  {SIGNATURE}</div>
<div class="row">
<div class="col-md-12">
<div class="payment-fields" style="display: block;">
<form method="post" action="#" enctype="multipart/form-data">
<textarea class="editor" name="forgetaccount"><?php echo $settings->forget_email;?></textarea> 
 <button type="submit" name="forgetfrm" class="bigbutton ss-btn"><?php echo $lang['Save Setting']; ?></button>
</form>
</div>
</div>
</div>

</div>
<!-- Box 2 End-->
<!-- Box 3 -->
<div class="payment-box">
<div class="pbox-wrap">
<div class="pbox-lft">
<h3><?php echo $lang['Project Create Email Setting (Client)']; ?></h3>
</div>
<div class="pbox-rt"><a href="#" class="setup-btn"><?php echo $lang['SET-UP']; ?></a></div>
</div>
<div class="payment-b-txt"><?php echo $lang['Shortcodes:']; ?> <br> <?php echo $lang['User name']; ?>:{USER_NAME}, <?php echo $lang['Project Title']; ?>: {PROJECT_NAME}, <?php echo $lang['Login URL']; ?>:{DASHBOARD_URL}, <?php echo $lang['Signature']; ?>: {SIGNATURE}</div>
<div class="row">
<div class="col-md-12">
<div class="payment-fields" style="display: block;">
<form method="post" action="#" enctype="multipart/form-data">
<textarea class="editor" name="projectassign"><?php echo $settings->project_assign_email;?></textarea> 
 <button type="submit" name="proassfrm" class="bigbutton ss-btn"><?php echo $lang['Save Setting']; ?></button>
</form>
</div>
</div>
</div>

</div> 
<!-- Box 3 End-->
<!-- Box 3.5 -->
<div class="payment-box">
<div class="pbox-wrap">
<div class="pbox-lft">
<h3><?php echo $lang['Project Update Email Setting']; ?></h3>
</div>
<div class="pbox-rt"><a href="#" class="setup-btn"><?php echo $lang['SET-UP']; ?></a></div>
</div>
<div class="payment-b-txt"><?php echo $lang['Shortcodes:']; ?> <br> <?php echo $lang['User name']; ?>:{USER_NAME}, <?php echo $lang['Project Title']; ?>: {PROJECT_NAME}, <?php echo $lang['Login URL']; ?>:{DASHBOARD_URL}, <?php echo $lang['Signature']; ?>: {SIGNATURE}</div>
<div class="row">
<div class="col-md-12">
<div class="payment-fields" style="display: block;">
<form method="post" action="#" enctype="multipart/form-data">
<textarea class="editor" name="projectupdate"><?php echo $settings->project_update_email;?></textarea> 
 <button type="submit" name="proupdatefrm" class="bigbutton ss-btn"><?php echo $lang['Save Setting']; ?></button>
</form>
</div>
</div>
</div>

</div> 
<!-- Box 3.5 End-->
<!-- Box 4 -->
<div class="payment-box">
<div class="pbox-wrap">
<div class="pbox-lft">
<h3><?php echo $lang['Project Create Email Setting (Staff)']; ?></h3>
</div>
<div class="pbox-rt"><a href="#" class="setup-btn"><?php echo $lang['SET-UP']; ?></a></div>
</div>
<div class="payment-b-txt"><?php echo $lang['Shortcodes:']; ?> <br> <?php echo $lang['User name']; ?>:{USER_NAME}, <?php echo $lang['Project Title']; ?>: {PROJECT_NAME}, <?php echo $lang['Login URL']; ?>:{DASHBOARD_URL}, <?php echo $lang['Signature']; ?>: {SIGNATURE}</div>
<div class="row">
<div class="col-md-12">
<div class="payment-fields" style="display: block;">
<form method="post" action="#" enctype="multipart/form-data">
<textarea class="editor" name="projectassignstaff"><?php echo $settings->assign_staff_email;?></textarea> 
 <button type="submit" name="proassfrmstaff" class="bigbutton ss-btn"><?php echo $lang['Save Setting']; ?></button>
</form>
</div>
</div>
</div>

</div> 
<!-- Box 4 End-->

</div>
</div>

</div>
</div>
       
    </div>
	<div class="clearfix"></div>
		
</div>        
</div>

<?php  include("../templates/admin-footer.php"); ?>