<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Client Trash Page  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Trash | ". $syatem_title;
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
if(isset($_POST['user_id'])){
$SESSION['user_id'] = $_POST['user_id'];
}
//condition check for login

$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;;
$email=$user->email;;
$account_stat=$user->status;;
$user->regDate;

if(isset($_POST['del_user']))
{
	 $delUserId=$_POST['del_id'];
	if($delUserId!=$session->userId)
	{
	  $deleteUser="delete from users where id=$delUserId limit 1";
	  $userDeleted=mysqli_query($connect, $deleteUser);
/* Remove Chat */
$allusers = user::findBySql("select * from users"); 
foreach($allusers as $alluser){
	$alluserbox =  $alluser->id;
$allmessages = "delete from messages where user_id = '$delUserId' AND receiver = '$alluserbox' || user_id = '$alluserbox' AND receiver = '$delUserId'";
$allmessagesaa=mysqli_query($connect, $allmessages);
}
/* Remove Chat End */
/* Remove User From Projects */
$checkUserProjects = projects::findBySql("select * from projects where FIND_IN_SET($delUserId, s_ids)");
$flag=0;
		if($flag==0)
		{
foreach($checkUserProjects as $checkUserProject){
	$userproject_id = $checkUserProject->p_id;
	$project = project::findByProjectId($userproject_id);
	
$input = $delUserId;
$list = $project->s_ids;

$array1 = Array($input);
$array2 = explode(',', $list);
$array3 = array_diff($array2, $array1);

$output = implode(',', $array3);
if($userproject_id){
$project->p_id = $userproject_id;
$project->s_ids = $output;
$savevalues=$project->save();
}
}
}

/* Remove User From Projects End*/
	  if($userDeleted){
		 header("Location:client-trash.php?message=success");
	   } else{
header("Location:client-trash.php?message=fail");
	   }
	  }
	  else
	  {
header("Location:client-trash.php?message=fail");
	  }
	  
	
}
if(isset($_POST['restore_user']))
{
	$ru_id=$_POST['ru_id'];
	$ru_status=$_POST['ru_status'];
$flag=0;
		if($flag==0)
		{
			$user = user::findById($ru_id); 
			$user->status=$ru_status;
			$saveUser=$user->save();
			if($saveUser){
 header("Location:client-trash.php?message=restore");
			}else {
header("Location:client-trash.php?message=fail");
			}
		}
	
}
if(isset($_GET['message'])){
$msgstatus = $_GET['message'];
$messagea = $lang['User Permanently Deleted.'];
$messageb = $lang['User Restored sucessfully.'];
$messagec = $lang['Error restoring user. Please Try Again later.'];

if($msgstatus == 'success'){
				$message= "<p class='alert alert-success'><i class='fa fa-check'></i>".$messagea."</p>";
}
if($msgstatus == 'restore'){
				$message= "<p class='alert alert-success'><i class='fa fa-check'></i>".$messageb."</p>";
}
if($msgstatus == 'fail'){		 
$message="<p class='alert alert-danger'><i class='fa fa-times'></i>".$messagec."</p>";
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
<div class="row project-dash">
            	<div class="col-lg-6 col-md-6 col-sm-6 mobileleft">
				<div class="pm-heading"><h2><?php echo $lang['Trash Clients']; ?></h2><span><?php echo $lang['All Deleted Clients']; ?></span></div>
				<div class="pm-form"><form class="form-inline md-form form-sm">
    <input class="form-control form-control" type="text" placeholder="<?php echo $lang['Search Clients...']; ?>" id="client-search">
    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
</form></div>
<?php $recentlyRegisteredUsers=user::findBySql("SELECT * FROM users WHERE accountStatus = 2 AND status = 1");?>
				</div> 
                <div class="col-lg-6 col-md-6 col-sm-6 creative-right text-right">
				<div class="mobilepromenu">
				<div class="projbtnm"><a href="add-client.php"><span>+</span></a></div>
				<div class="projmobilem">
				<i class="fa fa-bars" aria-hidden="true"></i>
<ul>
<li class="pm-trashbox"><a href="clients.php">
				<?php echo $lang['All Clients']; ?>
				</a></li>
				</ul>
				</div>
				</div>
				<ul class="deskvisible">
				<li class="cproject"><a href="add-client.php"><?php echo $lang['Add Client']; ?><span>+</span></a></li>
				<li class="pm-trashbox"><a href="clients.php">
				<?php echo $lang['All Clients']; ?>
				</a></li>
				</ul>
			</div>
			</div>
                <?php if(isset($message) && (!empty($message))){echo $message;} ?>
                <div class="row clients-row">
                
          <?php
		   $urlB = $url;
		   if($recentlyRegisteredUsers == NULL){
			   echo '<div class="empty-box">'.$lang['Trash Empty!'].'</div>';
		   }
                 foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
                  
                    $profilePictureObj=profilePicture::findByfkUserId($recentlyRegisteredUser->id);
    
                            if($profilePictureObj)
                            {
                                foreach($profilePictureObj as $displayPicture)
                                {
 $filenamePic = $displayPicture->filename;
$filenamePicture = $urlB."includes/timthumb.php?src=".$urlB."uploads/profile-pics/".$filenamePic."&h=130$w=130";
                                }
                                
                             }
                             else
                             {
                                $filenamePicture ="../assets/images/upload-img.jpg";
                                
                             } 
							 $cli_name = $recentlyRegisteredUser->firstName;
                   
                  ?>
                    <div class="col-sm-3 staff">
                        
                        	<div class="mix">
							<div class="container">
							<div class="row">
                        	<div class="col-sm-12 img-circle">
                            	<img src="<?php echo $filenamePicture;?>" class="img-fluid"/>
                            </div>
                            <div class="col-sm-12 client-info">
                                <h3> <?php echo $recentlyRegisteredUser->firstName;?></h3>                 
                            </div>
                            </div>
							</div>
                            <div class="clearfix"></div>
							<div class="btn-wrapstf">
							<form method="post" action="#" class="restore_user chat-frm">
							<input type="hidden" value="<?php echo $recentlyRegisteredUser->id;?>" name="ru_id"/>
							<input type="hidden" value="0" name="ru_status"/>
							<input type="submit" name="restore_user" value="<?php echo $lang['RESTORE']; ?>" class="form-control btn"/>
							</form>
                            	<form method="post" action="#" class="del-form chat-frm">
                                	<input type="hidden" value="<?php echo $recentlyRegisteredUser->id;?>" name="del_id"/>
                                	<input type="submit" name="del_user" value="<?php echo $lang['DELETE']; ?>" class="form-control btn"/>
                                </form> 
</div>								
                            </div>
                        
                    </div><!-- col-xs-3 mix -->
                   <?php } unset($recentlyRegisteredUsers);?>
                    
                </div> <!-- mix-grid -->
            </div>
        </div><!-- row -->
    </div>
	<div class="clearfix"></div>
		
</div>        
</div>        
</div>        
<?php  include("../templates/admin-footer.php"); ?>