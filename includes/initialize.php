<?php
// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'failed');

defined('LIB_ROOT') ? null : define('LIB_ROOT', 'includes');
defined('LIB_ROOT') ? null : define('LIB_ROOT', '../includes');	
defined('LIB_ROOT1') ? null : define('LIB_ROOT1', '../includes');
// load config file first
require_once(LIB_ROOT.DS.'config.php');

// load basic functions next so that everything after can use them

require_once(LIB_ROOT.DS.'functions.php');

// load core objects
require_once(LIB_ROOT.DS.'session.php');
require_once(LIB_ROOT.DS.'database.php');
require_once(LIB_ROOT.DS.'database-object.php');

// load database-related classes
require_once(LIB_ROOT.DS.'user.php');
require_once(LIB_ROOT.DS.'profilePicture.php');
require_once(LIB_ROOT.DS.'projects.php');
require_once(LIB_ROOT.DS.'settings.php');
require_once(LIB_ROOT.DS.'message.php');
require_once(LIB_ROOT.DS.'milestone.php');
require_once(LIB_ROOT.DS.'items.php');
require_once(LIB_ROOT.DS.'bundleitems.php');
require_once(LIB_ROOT.DS.'itemsdelivery.php');
require_once(LIB_ROOT.DS.'bundleitemsdelivery.php');


$dash_settings = settings::findById(1);
$img_path = 'images/users/';
$url = $dash_settings->url;
$company_name = $dash_settings->company_name;
$syatem_title = $dash_settings->syatem_title;
$login_page_title = $dash_settings->login_page_title;
$copy_rights = $dash_settings->copy_rights;
$time_zone = $dash_settings->time_zone;
$system_email = $dash_settings->system_email;
$system_language = $dash_settings->system_language;

if(isset($session->userId)){
$id=$session->userId;
$userb = User::findById((int)$session->userId);
$user_lang = $userb->user_language;
if($user_lang !== ""){
require_once(LIB_ROOT.DS.'languages/'.$user_lang.'.php');
global $lang;	
} elseif($system_language != ""){
require_once(LIB_ROOT.DS.'languages/'.$system_language.'.php');
global $lang;
}else{
require_once(LIB_ROOT.DS.'languages/en.php');
global $lang;
}
}else{
if($system_language != ""){
require_once(LIB_ROOT.DS.'languages/'.$system_language.'.php');
global $lang;
}else{
require_once(LIB_ROOT.DS.'languages/en.php');
global $lang;
}
}

$favicon_image_check = $dash_settings->favicon_image;
if($favicon_image_check){
	$favicon_image = $favicon_image_check;
}else{
	$favicon_image ='favicon.png';
}
$logo_check = $dash_settings->logo;
if($logo_check){
	$logo = $logo_check;
}else{
	$logo = 'client-side-logo.png';
}
$login_page_logo = $dash_settings->login_page_logo;
$mobile_logo = $dash_settings->mobile_logo;
$system_currency = $dash_settings->system_currency;
	$sc_arr = explode(",",$system_currency);
	$currency_symbol = $sc_arr[1];
	$currency = $sc_arr[0];
	
		date_default_timezone_set($time_zone);
$getlastseen=user::findBySql("SELECT * FROM users");
foreach($getlastseen as $seen){
	$seentime = $seen->last_seen;
	// echo gmdate("Y-m-d H:i:s", $seentime) . '<br>';
$today = date("Y-m-d h:i:s:a");
$date = date("Y-m-d h:i:s:a", $seentime);
$last_hour = time() - 30*60; //last hour timestamp
if($seen->last_seen <= $last_hour){
	$updatestatus = $seen->id;
	  $updateUserstatus="UPDATE users SET session_status = 'offline' WHERE id= '$updatestatus'";
	  $updated=mysqli_query($connect, $updateUserstatus);
	  // mysqli_close($connect);
}

}

?>