<?php defined("DB_SERVER") ? null : define("DB_SERVER", "localhost");
defined("DB_NAME")   ? null : define("DB_NAME", "management");
defined("DB_USER")   ? null : define("DB_USER", "root");
defined("DB_PASS")   ? null : define("DB_PASS", "");
$connect = new mysqli(DB_SERVER , DB_USER, DB_PASS, DB_NAME);
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
} 

$sql = "SELECT * FROM settings";
if ($result=mysqli_query($connect,$sql)){
 while($row = mysqli_fetch_array($result)){
  $main_url = ($row["url"]);
    }
  mysqli_free_result($result);
}
// Global Vars
	$base_url = $main_url;
	$base_root = dirname(__DIR__);
	$perpage = 15;
	$contacts_per_page = 100;