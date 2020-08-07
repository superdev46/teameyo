<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Client 2checkout Payments Success Page   //////////////////////////
*/
ob_start(); 
include("../includes/lib-initialize.php");
$title = "Payments | ". $syatem_title;
include("../templates/admin-header.php");

if(!($session->isLoggedIn())){
		redirectTo($url."index.php");
	}
if($_SESSION['accountStatus'] == 1){
	redirectTo($url."admin/edit-profile.php");
}
if($_SESSION['accountStatus'] == 3){
	redirectTo($url."staff/edit-profile.php");
}
//condition check for login

$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$phone=$user->phone;
$address=$user->address;
$city=$user->city;
$state=$user->state;
$zip=$user->zip;
$country=$user->country;
$account_stat=$user->status;
$user->regDate;

require_once("../payment-api/lib/Twocheckout.php");

Twocheckout::privateKey($checkout_id);
Twocheckout::sellerId($checkout_pk);
try {
    $charge = Twocheckout_Charge::auth(array(
        "merchantOrderId" => $_POST['milestone_id'],
        "token" => $_POST['token'],
        "currency" => $currency ,
        "total" => $_POST['amount1'],
        "billingAddr" => array(
            "name" => $_POST['username1'],
			"addrLine1" => $address,
			"city" => $city,
			"state" => $state,
			"zipCode" => $zip,
			"country" => $country,
			"email" => $email,
			"phoneNumber" => $phone
        ),
        
    ), 'array');
	print_r($charge);
    if ($charge['response']['responseCode'] == 'APPROVED') {
		echo 'OK';
        $message= "<p class='alert alert-success'><i class='fa fa-check'>Payment Received Successfully</i>
Thank you for your Order!</p>";
		$milestone_id=$_POST['milestone_id'];
		$mile = milestone::findById($milestone_id);
		
		$flag=0;
		if($flag==0)
		{
			
			$id =  (int)$milestone_id;
			$status =1;
			$releaseDate = date("Y-m-d");
			$p_id	= "" ;
			$title	= "";
			$budget		= "";
			$deadline		= "";
$sql_up = "UPDATE `milestones` SET
`status`='$status',
`releaseDate`='$releaseDate',
`p_id`='$p_id',
`title`='$title',
`budget`='$budget',
`deadline`='$deadline'
WHERE `id`='$id'";

if ($connect->query($sql_up) === TRUE)
				{
					header('Location:payments.php?projectId='.$_POST['proj_Id'].'&status=success&clientId='.$_POST['user_Id'].'');
				}
				else
				{
					
				}

		

		} 
		
    }
} catch (Twocheckout_Error $e) {
    $e->getMessage();
}

?>
<div class="page-container">
<div class="container-fluid">
<div class="row row-eq-height">
	<?php  include("../templates/sidebar.php"); ?>
	
    <div class="page-content col-lg-9 col-md-12 col-sm-12 col-lg-push-3">
<?php include('../templates/top-header.php'); ?> 
         <div class="row">
            <div class="col-md-12 margin-top-10 clients">
            	<h2><?php echo $lang['Manage Project']; ?> </h2>
                <div class="clearfix"></div>
                <?php if(isset($message) && (!empty($message))){echo $message;} ?>
                
            </div>
        </div><!-- row -->
    </div>
	<div class="clearfix"></div>
	
</div> 
</div> 
</div> 
<?php
?>
     
<?php  include("../templates/admin-footer-payment.php"); 