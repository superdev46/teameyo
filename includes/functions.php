<?php

// ===============================================================================
// Redirect pages or URL  
// ===============================================================================
function redirectTo($location=NULL) {
  if ($location != NULL) {
  //  header("location:{$location}");
echo "<script>location.href='$location';</script>";
    exit;
  }
}

// ===============================================================================
// Show any message 
// ===============================================================================
function outputMessage($message="") {
  if (!empty($message)) { 
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}
// ===============================================================================
// Select aboslute path from root directory by putting ../
// ===============================================================================
function FindRoot()
    {
		
        $times = substr_count($_SERVER['PHP_SELF'],"/");
        $rootaccess = "";
        $i = 1;		//if you're working on local computer set it 2, if its on live server set this value to 1
        while ($i < $times)
            {
                $rootaccess .= "../";
                $i++;
            
		}
		
        return $rootaccess;
		
		//$rootaccess="http://localhost/php/";
		
    }
$root = FindRoot();

// ===============================================================================
// It displays current page URL ../
// ===============================================================================
function curPageURL() {
	$pageURL = 'http';
	// if ($_SERVER["HTTPS"] == true) {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	
	return $pageURL;
}

// ===============================================================================
// Handles non-declared variables
// ===============================================================================
function __autoload($class_name) 
{
	$class_name = strtolower($class_name);
	$path = "{$class_name}.php";
	if(file_exists($path)) 
		require_once($path);
	else 
		die("The file {$class_name}.php could not be found.");
}

// ===============================================================================
// This will return Date and Time i.e. January 12, 2011 at 02:22:12
// ===============================================================================
function datetime_to_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

// ===============================================================================
// This will return only Date i.e. January 12, 2011
// ===============================================================================
function date_to_text($date="") {
  $unixdatetime = strtotime($date);
  return strftime("%B %d, %Y", $unixdatetime);
}
function day_to_text($day="") {
  $unixdatetime = strtotime($day);
  return strftime("%d", $unixdatetime);
}
function month_to_text($month="") {
  $unixdatetime = strtotime($month);
  return strftime("%B", $unixdatetime);
}
function year_to_text($year="") {
  $unixdatetime = strtotime($year);
  return strftime("%Y", $unixdatetime);
}

// ===============================================================================
// Random encrypted activation key for Account activation after account has been created
// ===============================================================================
function actKey ($getStr) {
	$actKey = sha1(mt_rand(10000,99999).time().$getStr);
	return $actKey;
}

function randomProId ($getStr) {
	$actKey = sha1(mt_rand(100,999).$getStr);
	return $actKey;
}

// ===============================================================================
// Formate the date by removing zero
// ===============================================================================
function strip_zeros_from_date( $marked_string="" ) {
  // first remove the marked zeros
  $no_zeros = str_replace('*0', '', $marked_string);
  // then remove any remaining marks
  $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

function dobToYears($dob)
{	 

$currentDate=date('Y-m-d');

$d1 = new DateTime($dob);
$d2 = new DateTime($currentDate);

$diff = $d2->diff($d1);

return $diff->y." years old <br />";	
}

?>