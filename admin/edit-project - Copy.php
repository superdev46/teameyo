<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Edit Existing Project  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Edit Project | ". $syatem_title;
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
$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$settings = settings::findById((int)$id);
$account_stat=$user->status;
$pro_id =  $_POST['p_id'];
if($pro_id == ""){
	header("Location:projects.php");
}
$_SESSION['pro_id'] = $pro_id;
$pro_id_u = $_SESSION['pro_id'];
	if(isset($_POST['update-project'])){

$flag=0;//determines if all posted values are not empty includ
		
if($flag==0)
{
	// $project = new Projects();
	$cont_desc = mysqli_real_escape_string($connect, $_POST['description']);
	$projectTite = mysqli_real_escape_string($connect, $_POST['projectTite']);
	$s_idsa = implode(',', $_POST['staff']);
	$pp_id	= $pro_id;
	$pp_title	= $projectTite;
	$pc_id		=$_POST['client'];
	$ps_ids		= $s_idsa;
	$pp_desc		= $cont_desc;
	$p_budget		=$_POST['budget'];
	$p_status		=$_POST['status'];
	$p_archive		=$_POST['archive'];
	$ps_time		=$_POST['startTime'];
	$pe_time		=$_POST['endTime'];
				  
	$sql_up = "UPDATE `projects` SET
			`c_id`='$pc_id',
			`s_ids`='$ps_ids',
			`project_title`='$pp_title',
			`project_desc`='$pp_desc',
			`budget`='$p_budget',
			`status`='$p_status',
			`archive`='$p_archive',
			`start_time`='$ps_time',
			`end_time`='$pe_time'
			WHERE `p_id`='$pp_id'";
	if ($connect->query($sql_up) === TRUE){
 		$project_title = $_POST['projectTite'];
		if(isset($_POST['notifyClient'])){
			$user = user::findById($_POST['client']); 
			// send verification email
			$to  = $user->email;
			$subject = 'Project Updated';
			$variablesArr = array('{USER_NAME}' => $user->firstName, '{SIGNATURE}' => $company_name, '{DASHBOARD_URL}' => $url, '{PROJECT_NAME}' => $project_title);
			$templateHTML = $settings->project_update_email;
			$message = strtr($templateHTML, $variablesArr);
			// To send HTML mail, the Content-type header must be set (don't change this section)
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			$headers .= 'From: '.$company_name.' <'.$system_email.'>' . "\r\n";
			$emailSent=mail($to,$subject, $message, $headers);
			if($emailSent){ 
				$message="<p class='alert alert-success'><i class='fa fa-check'></i>Project has been created successfully!</p>";
			}
			else{
  				echo "Project has been created successfully! but Error sending the Email please contact site administrator";
			}
			/* Staff Email */
			$all_users=user::findBySql("select * from users");
			foreach($all_users as $recentlyRegisteredUser){ 
				if($recentlyRegisteredUser->accountStatus ==3){  
					$s_all = $_POST['staff'];
					if(in_array($recentlyRegisteredUser->id, $s_all)){
						$user = user::findById($recentlyRegisteredUser->id); 
						// send verification email
						$to  = $user->email; 
						$subject = 'Project Updated';
						$variablesArr = array('{USER_NAME}' => $user->firstName, '{SIGNATURE}' => $company_name, '{DASHBOARD_URL}' => $url, '{PROJECT_NAME}' => $pp_title);
						$templateHTML = $settings->project_update_email;
						$message = strtr($templateHTML, $variablesArr);
						  // To send HTML mail, the Content-type header must be set (don't change this section)
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";	  
						$headers .= 'From: '.$company_name.' <'.$system_email.'>' . "\r\n";
						$emailSent=mail($to,$subject, $message, $headers);
						  
						if($emailSent){ 
						  
						}else{
							header("Location:projects.php?message=error_email");
						}
					}
				}
			}
			/* Staff Email End */
		}
		header("Location:projects.php?message=success");
	} else {
		header("Location:projects.php?message=fail");
	}
		$connect->close();
	}
}
if(isset($_GET['message'])){
	$msgstatus = $_GET['message'];
	$notmessagea = $lang['Record updated successfully'];
	$notmessageb = $lang['Error! Please Try Again later.'];
	if($msgstatus == 'success'){
		$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessagea."</p>";
	}
	if($msgstatus == 'fail'){		 
		$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessageb."</p>"; 
	}
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
          <div class="add-project">
<?php 
$qur_pro = projects::findBySql("select * from projects where p_id = '$pro_id'");

foreach($qur_pro as $qur_ar){
	// print_r($qur_ar);
 $client_id = $qur_ar->c_id;
 $staff_id = $qur_ar->s_ids;
 $project_title = $qur_ar->project_title;
 $project_desc = $qur_ar->project_desc;
 $budget = $qur_ar->budget;
 $status = $qur_ar->status;
 $archive = $qur_ar->archive;
 $start_time = $qur_ar->start_time;
 $end_time = $qur_ar->end_time;
 $st_ids = explode(',', $staff_id);
 
 $recentlyRegisteredUsers=user::findBySql("select * from users");
?>
          	<form method="post" action="#" enctype="multipart/form-data">
<div class="row">
            <div class="col-md-12 margin-top-10 clients">
                <?php if(isset($message) && (!empty($message))){echo $message;} ?>
			</div>
    <div class="col-md-3">
        	<div class="project-header">
            	<h2><?php echo $lang['Edit Project']; ?> </h2>
			</div>
			<div class="project-himg">
			<img src="<?php echo $url?>images/create-a-project.png" class="img-fluid"/> 
			</div>
    </div>
<div class="col-md-8">
			<div class="form-group">
			 <div class="field-label"><label for="firstName"><?php echo $lang['Project Title*']; ?></label></div>
				<input type="text" name="projectTite" class="form-control" value="<?php echo $project_title; ?>" required>
			</div>
			<div class="form-group">
			<div class="field-label"><label for="firstName"><?php echo $lang['Write a project description here']; ?></label></div>
				<textarea class="form-control" name="description"><?php echo $project_desc;?></textarea>
			</div>
<div class="row">
<div class="col-md-6">
<div class="form-group">
<div class="field-label"><label for="firstName"><?php echo $lang['Budget*']; ?></label></div>
	<input type="number" name="budget" placeholder="<?php echo $currency_symbol . $recentProject->budget;?>" class="form-control" value="<?php echo $budget;?>" required>
	<input type="hidden" name="status" value="<?php echo $status;?>" >
	<input type="hidden" name="archive" value="<?php echo $archive;?>" >
</div>
<div class="form-group">
<div class="field-label"><label for="firstName"><?php echo $lang['Start Date*']; ?></label></div>
	<input type="text" name="startTime" placeholder="Start Time" class="form-control datepicker" value="<?php echo $start_time;?>" required />
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<div class="field-label"><label for="firstName"><?php echo $lang['Select Client*']; ?></label></div>
	<select class="ui dropdown form-control" name="client">
		 <option value=""><?php echo $lang['Select a client']; ?></option>
		<?php 
				foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
					if($recentlyRegisteredUser->accountStatus ==2){
						?>
						<option value="<?php echo $recentlyRegisteredUser->id; ?>" <?php if($recentlyRegisteredUser->id == $client_id){ ?> selected="selected" <?php } ?>><?php echo $recentlyRegisteredUser->firstName; ?></option>
						<?php 
					}
				}?>
	</select>
 </div>

<div class="form-group">
<div class="field-label"><label for="firstName"><?php echo $lang['End Date*']; ?></label></div>
	<input type="text" name="endTime" placeholder="<?php echo $lang['End Time']; ?>" class="form-control datepicker" value="<?php echo $end_time;?>"  required />
</div>				
</div>
<div class="col-md-12">
<div class="form-group">
 <div class="staff-heading">
 <h4><?php echo $lang['Assign staff']; ?></h4>
 <span><?php echo $lang['Choose any team member for this project']; ?></span>
 </div>
<input type="hidden" name="staff[]" value="1" />
<input type="hidden" name="staff[]" class="new_val" />
<select multiple class="ui dropdown form-control" name="staff[]">
	<?php 
			foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
				if($recentlyRegisteredUser->accountStatus ==3){
					?>
					<option value="<?php echo $recentlyRegisteredUser->id; ?>" <?php if(in_array($recentlyRegisteredUser->id, $st_ids)){ echo 'selected';}?>><?php echo $recentlyRegisteredUser->firstName; ?></option>
					<?php 
				}
			}?>
</select>
</div>
</div>
<div class="col-md-12 input-notify">
<div class="form-group">
<div class="inline field">
    <div class="ui toggle checkbox custom-btnc">
	<input type="checkbox" name="notifyClient" tabindex="0" class="hidden"/>
      <label><?php echo $lang['Email Notification']; ?><br><span><?php echo $lang['Notify to client and staff project has been Updated']; ?></span></label>
    </div>
<input type="hidden" value="<?php echo $pro_id_u;?>" name="p_id"/>
<input type="submit" name="update-project" value="<?php echo $lang['Update Project']; ?>"  class="btn new-btnblue"/>
</div>
</div>
</div>			
</div> 
</div>

</div>
              <div class="clearfix"></div> 
            </form>
<?php } ?>
          </div><!--add-project -->
                
            </div>
        </div><!-- row -->
    </div>
	<div class="clearfix"></div>
		
</div>        
</div>        
</div>        
<?php  include("../templates/admin-footer.php"); ?>
<script>
$('.custom-btnc').checkbox();
</script>