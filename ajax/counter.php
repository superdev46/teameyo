<?php 
if(isset($_POST['counter_up']) && $_POST['counter_up'] == 'update_c'){
// session_start();
include('../includes/loader.php'); 
$us_id = $_SESSION['userId'];
$format = '%s';
$unmsg = $msg->total_unread_messages($format);
if($unmsg){
echo $unmsg;
} else {
echo '0';	
}

}
	?>