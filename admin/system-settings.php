<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// System Setting Page Title/Company Name/Address/etc  //////////////////////////
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
	if(isset($_POST['update_settings']))
	{

$flag=0;//determines if all posted values are not empty includ
		
		if($flag==0)
		{
				 $company_name	= $_POST['company_name'];
				$syatem_title	=$_POST['syatem_title'];
				$login_page_title		=$_POST['login_page_title'];
				$copy_rights		= $_POST['copy_rights'];
				$system_email		= $_POST['system_email'];
				$system_currency		=$_POST['system_currency'];
				$time_zone		=$_POST['time_zone'];
				$system_language		=$_POST['system_language'];
			
$target_dir = "../images/users/";
if($_FILES['favicon_image']['name'] != ""){
            $file_name = time().'_fav_'. $_FILES['favicon_image']['name'];
            $file_tmp = $_FILES['favicon_image']['tmp_name'];
			move_uploaded_file($file_tmp, $target_dir . $file_name);
} else {
	$file_name = $settings->favicon_image;
}
if($_FILES['login_page_logo']['name'] != ""){
            $login_page_logo_name = time().'_login_'. $_FILES['login_page_logo']['name'];
            $login_page_logo_tmp = $_FILES['login_page_logo']['tmp_name'];
			move_uploaded_file($login_page_logo_tmp, $target_dir . $login_page_logo_name);
} else {
	$login_page_logo_name = $settings->login_page_logo;
}
if($_FILES['logo']['name'] != ""){
            $logo_name = time().'_logo_'. $_FILES['logo']['name'];
            $logo_tmp = $_FILES['logo']['tmp_name'];
			move_uploaded_file($logo_tmp, $target_dir . $logo_name);
} else {
	$logo_name = $settings->logo;
}
if($_FILES['mobile_logo']['name'] != ""){
            $mlogo_name = time().'_mlogo_'. $_FILES['mobile_logo']['name'];
            $mlogo_tmp = $_FILES['mobile_logo']['tmp_name'];
			move_uploaded_file($mlogo_tmp, $target_dir . $mlogo_name);
} else {
	$mlogo_name = $settings->mobile_logo;
}
			
if ($company_name && $syatem_title && $login_page_title && $copy_rights && $system_currency && $system_email && $time_zone && $system_language) {
      
$settings = settings::findById((int)$session->userId); 	  
			// $settings = new Settings();
			$settings->id        		=  $session->userId;
			$settings->company_name = $_POST['company_name'];
			$settings->syatem_title = $_POST['syatem_title'];
			$settings->login_page_title=$_POST['login_page_title'];
			$settings->copy_rights= $_POST['copy_rights'];
			$settings->system_email= $_POST['system_email'];
			$settings->system_currency=$_POST['system_currency'];
			$settings->time_zone=$_POST['time_zone'];
			$settings->system_language=$_POST['system_language'];
			$settings->login_page_logo=$login_page_logo_name;
			$settings->logo=$logo_name;
			$settings->mobile_logo=$mlogo_name;
    $settings->favicon_image= $file_name;
	$savesettings=$settings->save();
if($savesettings){
				header('location:system-settings.php?message=success');
			}else{
header('location:system-settings.php?message=fail');
			}
 
 } else {

	  header('location:system-settings.php?message=required');
            }

		}

	}
if(isset($_GET['message'])){
$msgstatus = $_GET['message'];
$notmessagea = $lang['System Settings has been saved successfully!'];
$notmessageb = $lang['Same values will not be updated, please make changes and save settings again, Thanks'];
$notmessagec = $lang['All fields are required'];
if($msgstatus == 'success'){
					$message="<p class='alert alert-success' style='margin-top:10px;'><i class='fa fa-check'></i> ".$notmessagea."</p>";
}
if($msgstatus == 'fail'){
					 $message="<p class='alert alert-danger' style='margin-top:10px;'><i class='fa fa-times'></i> ".$notmessageb."</p>";
}
if($msgstatus == 'required'){
	  $message="<p class='alert alert-danger' style='margin-top:10px;'><i class='fa fa-times'></i> ".$notmessagec."</p>";
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
 <li class="active"><a href="system-settings.php"><?php echo $lang['General Settings']; ?></a></li>
<li><a href="payment-setting.php"><?php echo $lang['Payment Settings']; ?></a></li>
<li><a href="email-setting.php"><?php echo $lang['Email Notifications']; ?></a></li>
 </ul>
 </div>
</div>
<div class="col-md-9 ss-right">

<?php if(isset($message) && (!empty($message))){echo $message;} ?>
<form method="post" action="#" enctype="multipart/form-data">
<h2 class="page-title"><?php echo $lang['General Settings']; ?> <button type="submit" name="update_settings" class="bigbutton ss-btn"><?php echo $lang['save settings']; ?></button></h2>
<div class="row general-settings">
<div class="col-md-7">
  <div class="form-group">
  <label for="timezone"><?php echo $lang['System Url']; ?></label>
    <input type="text" disabled required value="<?php echo $settings->url; ?>" class="form-control" name="url" placeholder="Url">
  </div>
  <div class="form-group">
  <label for="timezone"><?php echo $lang['Company Name*']; ?></label>
    <input type="text" required value="<?php echo $settings->company_name; ?>" class="form-control" name="company_name" placeholder="<?php echo $lang['Company Name']; ?>">
  </div>
  <div class="form-group">
  <label for="timezone"><?php echo $lang['Company Title*']; ?></label>
    <input type="text" required value="<?php echo $settings->syatem_title; ?>" class="form-control" name="syatem_title" placeholder="<?php echo $lang['System Title']; ?>">
  </div>
  <div class="form-group">
  <label for="timezone"><?php echo $lang['Login Page Title*']; ?></label>
    <input type="text" required value="<?php echo $settings->login_page_title; ?>" class="form-control" name="login_page_title" placeholder="Login page title">
  </div>
  <div class="form-group">
  <label for="timezone"><?php echo $lang['Copyrights*']; ?></label>
    <input type="text" required value="<?php echo $settings->copy_rights; ?>" class="form-control" name="copy_rights" placeholder="Copyrights">
  </div>
  <div class="form-group">
  <label for="timezone"><?php echo $lang['System Email*']; ?></label>
    <input type="text" required value="<?php echo $settings->system_email; ?>" class="form-control" name="system_email" placeholder="System Email">
  </div>
  <div class="form-group">
<label for="system_currency"><?php echo $lang['Select Currency']; ?></label>
	<select class="form-control" required name="system_currency">
	<?php 
$settinga = new Settings();
 	foreach($settinga->currency_symbols as $currency => $symbol ){
		if($settings->system_currency == $currency){
		echo '<option selected value="'.$currency.'">'.$symbol.'</option>';
		} else {
		echo '<option value="'.$currency.'">'.$symbol.'</option>';	
		}
	} ?>
</select>
  </div>
<div class="form-group">
    <label for="timezone"><?php echo $lang['Select Time Zone']; ?></label>
	<?php 
function tz_list() {
  $zones_array = array();
  $timestamp = time();
  foreach(timezone_identifiers_list() as $key => $zone) {
    date_default_timezone_set($zone);
    $zones_array[$key]['zone'] = $zone;
    $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
  }
  return $zones_array;
}
	?>
    <select class="form-control" required name="time_zone" id="timezone">
<?php foreach(tz_list() as $t) { 
if($settings->time_zone == $t['zone'] ){
?>
      <option selected value="<?php echo $t['zone'] ?>">
        <?php echo $t['diff_from_GMT'] . ' - ' . $t['zone'] ?>
      </option>
    <?php 
} else { ?>
<option value="<?php echo $t['zone'] ?>">
        <?php echo $t['diff_from_GMT'] . ' - ' . $t['zone'] ?>
      </option>
<?php }
	} ?>
    </select>
  </div>
  <div class="form-group">
    <label for="language"><?php echo $lang['Select Default language']; ?></label>
	<select class="form-control" required name="system_language" id="language">
	<option <?php if($settings->system_language == 'en'){echo 'selected';}?> value="en">English</option>
	<option <?php if($settings->system_language == 'fr'){echo 'selected';}?> value="fr">French</option>
	<option <?php if($settings->system_language == 'it'){echo 'selected';}?> value="it">Italian</option>
	<option <?php if($settings->system_language == 'sp'){echo 'selected';}?> value="sp">Spanish</option>
	</select>
  </div>
<div class="form-group file-upload">
    <div class="upload-txt"><?php echo $lang['Favicon Upload']; ?><br>
	<span><?php echo $lang['Upload a 16px x 16px .png or .gif image that<br>will be your favicon.']; ?></span>
	</div>
	<div class="upload-input">
	<div class="uploaded-img" style="display: block;">
	<?php if($settings->favicon_image){ ?>
	<img src="<?php echo $url; ?>images/users/<?php echo $settings->favicon_image; ?>" />
	<?php } else { ?>
	<img src="<?php echo $url; ?>images/users/favicon.png" />	
	<?php }?>
	</div>
    <input type="file" name="favicon_image" accept="image/x-png,image/gif,image/jpeg" class="form-control-file">
	<div class="upload-btns">
	<a href="#" class="upload-up"><?php echo $lang['Upload']; ?></a>
	</div>
	</div>
  </div>
  <!-- Mobile logo -->
<div class="form-group file-upload">
      <div class="upload-txt"><?php echo $lang['Mobile Logo Upload']; ?><br>
	<span><?php echo $lang['Upload at exactly 150px by 30px the size of your <br>Mobile logo.']; ?></span>
	</div>
<div class="upload-input mlogoupload">
	<div class="uploaded-img" style="display: block;">
	<?php if($settings->mobile_logo){ ?>
	<img src="<?php echo $url; ?>images/users/<?php echo $settings->mobile_logo; ?>" />
	<?php } else { ?>
	<img src="<?php echo $url;?>images/users/teameyo-mobile-logo.png" />
	<?php } ?>
	</div>
    <input type="file" name="mobile_logo" accept="image/x-png,image/gif,image/jpeg" class="form-control-file">
	<div class="upload-btns">
	<a href="#" class="upload-up"><?php echo $lang['Upload']; ?></a>
	</div>
	</div>
  </div>
<!-- Mobile logo End-->
<div class="form-group file-upload">
    <div class="upload-txt"><?php echo $lang['Login page logo']; ?><br>
	<span><?php echo $lang['Upload at exactly 230px by 300px the size of your <br>Login page logo.']; ?></span>
	</div>
	<div class="upload-input">
	<div class="uploaded-img" style="display: block;">
	<?php if($settings->login_page_logo){ ?>
	<img src="<?php echo $url; ?>images/users/<?php echo $settings->login_page_logo; ?>" />
	<?php } else { ?>
	<img src="<?php echo $url; ?>images/users/login-logo.png" />
	<?php } ?>
	</div>
    <input type="file" name="login_page_logo" accept="image/x-png,image/gif,image/jpeg" class="form-control-file">
	<div class="upload-btns">
	<a href="#" class="upload-up"><?php echo $lang['Upload']; ?></a>
	</div>
	</div>
  </div>
  

</div>
<div class="col-md-5">
<div class="form-group text-center file-upload">
<div class="upload-input logoupload">
	<div class="uploaded-img" style="display: block;">
	<?php if($settings->logo){ ?>
	<img src="<?php echo $url; ?>images/users/<?php echo $settings->logo; ?>" />
	<?php } else { ?>
	<img src="<?php echo $url;?>images/users/client-side-logo.png" />
	<?php } ?>
	</div>
    <input type="file" name="logo" accept="image/x-png,image/gif,image/jpeg" class="form-control-file">
	<div class="upload-btns">
	<a href="#" class="upload-up"><?php echo $lang['Upload']; ?></a>
	</div>
	</div>
    <div class="upload-txt"><?php echo $lang['Logo Upload']; ?><br>
	<span><?php echo $lang['Upload at exactly 200px by 130px<br> the size of your standard logo.']; ?></span>
	</div>
  </div>


</div>
</div>
</form>
</div>
</div>
       
    </div>
	<div class="clearfix"></div>
		
</div>        
</div>        
</div>        
<?php  include("../templates/admin-footer.php"); ?>