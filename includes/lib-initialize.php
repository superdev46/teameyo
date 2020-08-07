<?php
// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'failed');

defined('LIB_ROOT') ? null : define('LIB_ROOT', '../includes');	
defined('INC_ROOT') ? null : define('INC_ROOT', '../includes');

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
require_once(LIB_ROOT.DS.'userWarnings.php');

//load project items class
require_once(LIB_ROOT.DS.'items.php');
require_once(LIB_ROOT.DS.'bundleitems.php');
require_once(LIB_ROOT.DS.'itemsdelivery.php');
require_once(LIB_ROOT.DS.'bundleitemsdelivery.php');


$connect = mysqli_connect(DB_SERVER , DB_USER, DB_PASS, DB_NAME);
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
$stripe_sk = $dash_settings->stripe_sk;
$stripe_pk = $dash_settings->stripe_pk;
$paypal_email = $dash_settings->paypal_email;
$checkout_id = $dash_settings->checkout_id;
$checkout_pk = $dash_settings->checkout_pk;

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
	  $updateUserstatus="UPDATE users SET session_status = 'offline' WHERE id=$updatestatus";
	  $updated=mysqli_query($connect, $updateUserstatus);

}

}
$countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

?>