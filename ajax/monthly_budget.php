<?php 

// include('../includes/loader.php');
include('../includes/lib-initialize.php'); 
if(isset($_POST['month'])){
	$c_month = $_POST['month'];
	// print_r($db1);
	$curr_year = date("Y");
$month_b = milestone::findBySql("SELECT * FROM milestones WHERE YEAR(releaseDate) = $curr_year AND MONTH(releaseDate) = $c_month AND status = 1");

$cur_m = 0;
	foreach($month_b as $curr_month){
	$cur_m += $curr_month->budget;
	}
	if($cur_m){
	 echo '$'.$cur_m;
	} else {
	echo '$0';
	}
}
?>