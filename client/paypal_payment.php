<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Paypal Success page  //////////////////////////
*/
ob_start();
include("../templates/admin-header.php");
include("../includes/lib-initialize.php"); 
if(!($session->isLoggedIn())){
		redirectTo($url."index.php");
	}
if($_SESSION['accountStatus'] == 1){
	redirectTo($url."admin/edit-profile.php");
}
if($_SESSION['accountStatus'] == 3){
	redirectTo($url."staff/edit-profile.php");
}
$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;;
$email=$user->email;;
$account_stat=$user->status;;
$user->regDate;
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
<?php 
$milestone_id=$_GET['milestone_id'];
if($milestone_id){
	
		$mile = milestone::findById($milestone_id);
$mile->id =  $milestone_id;
			$mile->status =1;
			$mile->releaseDate = date("Y-m-d");
				
				$saveMile=$mile->save();
	
				if($saveMile)
				{
					header('Location:payments.php?projectId='.$_GET['projectId'].'&status=success&clientId='.$_GET['clientId'].'');
				}
				else{					
				}
				echo $lang['payment received Successfully'];
}
?>                
                
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