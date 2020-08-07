<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Payment Gateways Setting Stripe/Paypal/2checkout  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Payment Setting | ". $syatem_title;
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

$settings = settings::findById((int)$session->userId); 

$message = "";
/* Stripe */
if(isset($_POST['stripe_submit']))
	{

$flag=0;//determines if all posted values are not empty includ
		
		if($flag==0)
		{
$settings = settings::findById((int)$session->userId); 	 
$settings->id = $session->userId; 
$settings->stripe_sk = $_POST['st_sk'];
$settings->stripe_pk = $_POST['st_pk'];

	$stripesettings=$settings->save();
			
			if($stripesettings){
				header('location:payment-setting.php?message=stripe');
			}else {
header('location:payment-setting.php?message=fail');
			}
		}
	}
/* Paypal */
if(isset($_POST['paypal_submit'])){
$flag=0;//determines if all posted values are not empty includ
		
		if($flag==0)
		{
$settings = settings::findById((int)$session->userId); 	 
$settings->id = $session->userId; 
$settings->paypal_email = $_POST['pp_email'];

	$paypalsettings=$settings->save();
			
			if($paypalsettings){
				header('location:payment-setting.php?message=paypal');
			}else {
header('location:payment-setting.php?message=fail');
			}
		}
}
/* 2checkout */
if(isset($_POST['checkout_submit'])){
$flag=0;//determines if all posted values are not empty includ
		
		if($flag==0)
		{
$settings = settings::findById((int)$session->userId); 	 
$settings->id = $session->userId; 
$settings->checkout_id = $_POST['co_sid'];
$settings->checkout_pk = $_POST['co_pk'];

	$checkoutsettings=$settings->save();
			
			if($checkoutsettings){
				header('location:payment-setting.php?message=2checkout');
			}else {
header('location:payment-setting.php?message=fail');
			}
		}
}
if(isset($_GET['message'])){
$msgstatus = $_GET['message'];
$notmessagea = $lang['Paypal Settings has been saved successfully!'];
$notmessageb = $lang['Stripe Settings has been saved successfully!'];
$notmessagec = $lang['2Checkout Settings has been saved successfully!'];
$notmessaged = $lang['Your settings is not save at this time, Please tray again later.'];
if($msgstatus == 'paypal'){
$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessagea."</p>";
}
if($msgstatus == 'stripe'){
				$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessageb."</p>";
}
if($msgstatus == '2checkout'){
				$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessagec."</p>";
}
if($msgstatus == 'fail'){
$message="<p class='alert alert-danger'><i class='fa fa-times'></i> ".$notmessaged."</p>";
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
<li class="active"><a href="payment-setting.php"><?php echo $lang['Payment Settings']; ?></a></li>
<li><a href="email-setting.php"><?php echo $lang['Email Notifications']; ?></a></li>
 </ul>
 </div>
</div>
<div class="col-md-9 ss-right">
<h2 class="page-title"><?php echo $lang['Payment Settings']; ?></h2>

<div class="row general-settings">
<?php if(isset($message) && (!empty($message))){echo $message;} ?>
<div class="payment-box">
<div class="pbox-wrap">
<div class="pbox-lft">
<img src="../assets/images/stripe.png" />
</div>
<div class="pbox-rt"><a href="#" class="setup-btn"><?php echo $lang['SET-UP']; ?></a></div>
</div>
<div class="payment-b-txt"><?php echo $lang['Enter <b>live secret key</b> &<b> Live publishable key </b>to receive funds via stripe.']; ?> </div>
<div class="row">
<div class="col-md-8">
<div class="payment-fields" style="display: none;">
<form method="post" action="#" enctype="multipart/form-data">
  <div class="form-group">
    <input type="text" name="st_sk" value="<?php echo $settings->stripe_sk;?>" class="form-control" placeholder="Live Secret Key">
  </div>
  <div class="form-group">
    <input type="text" name="st_pk" value="<?php echo $settings->stripe_pk;?>" class="form-control" placeholder="Live Publishable Key">
  </div>
  <div class="form-group align-btn">
  <button type="submit" name="stripe_submit" class="bigbutton ss-btn"><?php echo $lang['Update settings']; ?></button>
  </div>
</form>
</div>
</div>
</div>

</div>
<div class="payment-box">
<div class="pbox-wrap">
<div class="pbox-lft">
<img src="../assets/images/pp.png" />
</div>
<div class="pbox-rt"><a href="#" class="setup-btn"><?php echo $lang['SET-UP']; ?></a></div>
</div>
<div class="payment-b-txt"><?php echo $lang['Enter the PayPal email address that will receive the funds']; ?></div>
<div class="row">
<div class="col-md-8">
<div class="payment-fields" style="display: none;">
<form method="post" action="#" enctype="multipart/form-data">
  <div class="form-group">
    <input type="text" name="pp_email" value="<?php echo $settings->paypal_email;?>" class="form-control" placeholder="Business Email">
  </div>
  <div class="form-group align-btn">
  <button type="submit" name="paypal_submit" class="bigbutton ss-btn"><?php echo $lang['Update settings']; ?></button>
  </div>
</form>
</div>
</div>
</div>

</div>
<div class="payment-box">
<div class="pbox-wrap">
<div class="pbox-lft">
<img src="../assets/images/2co.png" />
</div>
<div class="pbox-rt"><a href="#" class="setup-btn"><?php echo $lang['SET-UP']; ?></a></div>
</div>
<div class="payment-b-txt"><?php echo $lang['Enter <b>seller id</b> &<b> Private key </b>to receive funds via 2checkout']; ?> </div>

<div class="row">
<div class="col-md-8">
<div class="payment-fields" style="display: none;">
<form method="post" action="#" enctype="multipart/form-data">
  <div class="form-group">
    <input type="text" name="co_sid" value="<?php echo $settings->checkout_id;?>" class="form-control" placeholder="Seller Id">
  </div>
  <div class="form-group">
    <input type="text" name="co_pk" value="<?php echo $settings->checkout_pk;?>" class="form-control" placeholder="Private Key">
  </div>
  <div class="form-group align-btn">
  <button type="submit" name="checkout_submit" class="bigbutton ss-btn"><?php echo $lang['Update settings']; ?></button>
  </div>
</form>
</div>
</div>
</div>

</div>
</div>
</div>
</div>
       
    </div>
	<div class="clearfix"></div>
		
</div>        
</div>        
</div>        
<?php  include("../templates/admin-footer.php"); ?>