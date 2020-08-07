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

require('updates/AutoUpdate.php');

use \VisualAppeal\AutoUpdate;

$update = new AutoUpdate(__DIR__ . '/temp', __DIR__ . '/../', 60);


// Optional:
// $update->addLogHandler(new Monolog\Handler\StreamHandler(__DIR__ . '/update.log'));
// $update->setCache(new Desarrolla2\Cache\Adapter\File(__DIR__ . '/cache'), 3600);


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
if($msgstatus == 'success'){
					$message="<p class='alert alert-success' style='margin-top:10px;'><i class='fa fa-check'></i>System Settings has been saved successfully!</p>";
}
if($msgstatus == 'fail'){
					 $message="<p class='alert alert-danger' style='margin-top:10px;'><i class='fa fa-times'></i>
Same values will not be updated, please make changes and save settings again, Thanks</p>";
}
if($msgstatus == 'required'){
	  $message="<p class='alert alert-danger' style='margin-top:10px;'><i class='fa fa-times'></i>All fields are required</p>";
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
<li><a href="updates.php">Updates<?php echo $lang['Updates']; ?></a></li>
 </ul>
 </div>
</div>
<div class="col-md-9 ss-right">

<?php if(isset($message) && (!empty($message))){echo $message;} ?>
<!--
purchase Code: 56ab4d7d-f32a-48d9-9b1c-077f437ba932
Current version: <?php echo $settings->version; ?>
-->
Purchase Code: <?php echo $settings->purchase_code; ?>
<br>
<?php
$current_version = $settings->version; 
$update->setCurrentVersion($current_version);
$update->setUpdateUrl('https://www.artimization.com/updates/'); //Replace with your server update directory
//Check for a new update
if ($update->checkUpdate() === false) {
    die('Could not check for updates! See log file for details.');
}

if ($update->newVersionAvailable()) {
    //Install new update
    echo 'New Version: ' . $update->getLatestVersion() . '<br>';
    echo 'Installing Updates: <br>';
    echo '<pre>';
    var_dump(array_map(function ($version) {
        return (string) $version;
    }, $update->getVersionsToUpdate()));
    echo '</pre>';

    // Optional - empty log file
    $f = @fopen(__DIR__ . '/update.log', 'r+');
    if ($f !== false) {
        ftruncate($f, 0);
        fclose($f);
    }

    // Optional Callback function - on each version update
    function eachUpdateFinishCallback($updatedVersion)
    {
        echo '<h3>CALLBACK for version ' . $updatedVersion . '</h3>';
    }
    $update->onEachUpdateFinish('eachUpdateFinishCallback');

    // Optional Callback function - on each version update
    function onAllUpdateFinishCallbacks($updatedVersions)
    {
        echo '<h3>CALLBACK for all updated versions:</h3>';
        echo '<ul>';
        foreach ($updatedVersions as $v) {
            echo '<li>' . $v . '</li>';
        }
        echo '</ul>';
    }
    $update->setOnAllUpdateFinishCallbacks('onAllUpdateFinishCallbacks');

    // This call will only simulate an update.
    // Set the first argument (simulate) to "false" to install the update
    // i.e. $update->update(false);
    $result = $update->update();
    if ($result === true) {
        echo 'Update simulation successful<br>';
    } else {
        echo 'Update simulation failed: ' . $result . '!<br>';

        if ($result = AutoUpdate::ERROR_SIMULATE) {
            echo '<pre>';
            var_dump($update->getSimulationResults());
            echo '</pre>';
        }
    }
} else {
    echo 'Current Version is up to date<br>';
}

echo 'Log:<br>';
echo nl2br(file_get_contents(__DIR__ . '/update.log'));
?>
</div>
</div>
       
    </div>
	<div class="clearfix"></div>
		
</div>        
</div>        
</div>        
<?php  include("../templates/admin-footer.php"); ?>