<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// All Clients page  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Clients | ". $syatem_title;
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

$message = '';
if(isset($_POST['del_user']))
{
	 $delUserId=$_POST['del_id'];
	if($delUserId!=$session->userId)
	{
	  $deleteUser="delete from users where id=$delUserId limit 1";
	  $userDeleted=mysqli_query($connect, $deleteUser);
	  if($userDeleted){
		 header("Location:clients.php?message=success");
	   } else{
header("Location:clients.php?message=fail");
	   }
	  }
	  else
	  {
header("Location:clients.php?message=fail");
	  }
	  
	
}

if(isset($_POST['bulk_del_user']))
{
	$client_ids=$_POST['bulk_del_uid'];
	$bulk_del_val=$_POST['bulk_del_val'];
$flag=0;
		if($flag==0)
		{
			$cli_arr = explode(',', $client_ids);
			foreach($cli_arr as $cli_id){
			$user = user::findById($cli_id); 
			// $user->id = $cli_id;
			$user->status=$bulk_del_val;
			$saveUser=$user->save();
			}
			if($saveUser){
				header("Location:clients.php?message=success");
			}else {
header("Location:clients.php?message=fail");
			}
		}
}
if(isset($_GET['message'])){
$msgstatus = $_GET['message'];
$translsuccess = $lang['Client has been registered successfully!'];
$deltrans = $lang['User has been deleted sucessfully.'];
$errtrans = $lang['Error! Please Try Again later.'];
if($msgstatus == 'add_success'){
 $message="<p class='alert alert-success'><i class='fa fa-check'></i>".$translsuccess."</p>";
}
if($msgstatus == 'success'){
		 $message= "<p class='alert alert-success'><i class='fa fa-check'></i>".$deltrans."</p>";
}
if($msgstatus == 'fail'){		 
		  $message="<p class='alert alert-danger'><i class='fa fa-times'></i>".$errtrans."</p>";
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
				<div class="pm-heading"><h2><?php echo $lang['Clients']; ?></h2><span><?php echo $lang['All Clients']; ?></span></div>
				<div class="pm-form"><form class="form-inline md-form form-sm">
    <input class="form-control form-control" type="text" placeholder="<?php echo $lang['Search Clients']; ?>" id="staff-searchnew">
    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
</form></div>
<?php  
$trashcountUsers=user::findBySql("SELECT * FROM users WHERE accountStatus = 2 AND status = 1");
$recentlyRegisteredUsers=user::findBySql("SELECT * FROM users WHERE accountStatus = 2 AND status = 0"); ?>
				</div> 
                <div class="col-lg-6 col-md-6 col-sm-6 creative-right text-right">
				<div class="mobilepromenu">
				<div class="projbtnm"><a href="add-client.php"><span>+</span></a></div>
				<div class="projmobilem">
				<i class="fa fa-bars" aria-hidden="true"></i>
<ul>
				<li class="pm-trashbox"><a href="client-trash.php">
				<?php echo $lang['Trash']; ?> (<?php echo count($trashcountUsers); ?>)
				</a></li>
				<li class="pm-trash um-trash">
								<form method="post" action="#">
								<input type="hidden" class="bulk_uids" value="" name="bulk_del_uid"/>
								<input type="hidden" value="1" name="bulk_del_val"/>
								<button type="submit" name="bulk_del_user" disabled><?php echo $lang['Delete']; ?></button>
								</form>
				</li>
				</ul>
				</div>
				</div>
				<ul class="deskvisible">
				<li class="cproject cprojectas"><a href="add-client.php"><?php echo $lang['Add Client']; ?><span>+</span></a></li>
				<li class="pm-trashbox"><a href="client-trash.php">
				<?php echo $lang['TRASH']; ?> (<?php echo count($trashcountUsers); ?>)
				</a></li>
				<li class="pm-trash um-trash">
								<form method="post" action="#">
								<input type="hidden" class="bulk_uids" value="" name="bulk_del_uid"/>
								<input type="hidden" value="1" name="bulk_del_val"/>
								<button type="submit" name="bulk_del_user" disabled><i class="fa fa-trash-o"></i></button>
								</form>
				</li>
				</ul>
				<!-- <a href="add-new-project.php" class="btn orange"> Add new project</a></div>-->
			</div>
			</div>
                <?php if(isset($message) && (!empty($message))){echo $message;} ?>
                <div class="row clients-row">
                
          <?php 
		   $urlB = $url;
		   if($recentlyRegisteredUsers == NULL){
			   echo '<div class="empty-box">No Clients available!</div>';
		   }
                 foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
                  
                    $profilePictureObj=profilePicture::findByfkUserId($recentlyRegisteredUser->id);
    
                            if($profilePictureObj)
                            {
                                foreach($profilePictureObj as $displayPicture)
                                {
                                 $profilePic=$displayPicture->thumbnailPath();
								 $filenamePic = $displayPicture->filename;
$filenamePicture = $urlB."includes/timthumb.php?src=".$urlB."uploads/profile-pics/".$filenamePic."&h=130$w=130";
                                }
                                
                             }
                             else
                             {
                                 $profilePic ="../assets/images/upload-img.jpg";
                                 $filenamePicture ="../assets/images/upload-img.jpg";
                                
                             } 
							 $cli_name = $recentlyRegisteredUser->firstName;
                  
                  ?>
                    <div class="col-sm-3 staff">
                        
                        	<div class="mix">
							<div class="container">
							<div class="row">
                        	<div class="col-sm-12 user-imgbox img-circle">
							<input type="checkbox" value="<?php echo $recentlyRegisteredUser->id;?>" name="client-checkbox" />
                            	<img src="<?php echo $filenamePicture; ?>" class="img-fluid"/>
                            </div>
                            <div class="col-sm-12 client-info">
                                <h3> <?php echo $recentlyRegisteredUser->firstName;?></h3>                 
                            </div>
                            </div>
							</div>
                            <div class="clearfix"></div>
							<div class="btn-wrapstf btn-fullw">
							    <a href="#" class="btn full-w" data-toggle="modal" data-target="#popup<?php echo $recentlyRegisteredUser->id;?>"><?php echo $lang['VIEW PROFILE']; ?></a>
                            </div>
<div class="modal fade popupbox" id="popup<?php echo $recentlyRegisteredUser->id;?>" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close close-btn" data-dismiss="modal">&times;</button>
        <h4 class="modal-title modal-left"><?php echo $lang['Profile']; ?> </h4>
        <h4 class="modal-title pop-edit"><a href="edit.php?editClient=<?php echo $recentlyRegisteredUser->id;?>"><?php echo $lang['Edit Profile']; ?></a></h4>
      </div>
                                 <div class="modal-body for-users">
                                          
                                          <div class="row amount-row">
                                              
                                              <div class="col-sm-12 user-imgbox img-circle">
                                              <img src="<?php echo $filenamePicture; ?>" class="img-fluid"/><div class="backbg"></div>
                                              </div>
                                               
                                              <div style="margin-top: 20px;" class="col-sm-12">
                                              <h3> <?php echo $recentlyRegisteredUser->firstName;?></h3>
                                             </div>
                                          </div>
                                 <hr>
                                 <div class="container">
                                    <div class="row details">
                                         <div class="col-sm-4"><h4><b><?php echo $lang['Phone Number']; ?></b></h4></div>
                                         <div class="col-sm-8 right-amount"><h4><?php echo $recentlyRegisteredUser->phone;?></h4></div>
                                         
                                         <div class="col-sm-4"><h4><b><?php echo $lang['Email']; ?> </b></h4></div>
                                         <div class="col-sm-8 right-amount"><h4><a href="mailto:<?php echo $recentlyRegisteredUser->email;?>" target="_top"><?php echo $recentlyRegisteredUser->email;?></a></h4></div>
                                         
                                         <div class="col-sm-4"><h4><b><?php echo $lang['Address']; ?></b></h4></div>
                                         <div class="col-sm-8 right-amount"><h4><?php echo $recentlyRegisteredUser->address;?></h4></div>
                                         
                                         <div class="col-sm-4"><h4><b><?php echo $lang['Website Url']; ?></b></h4></div>
										 <?php 
										 $website = $recentlyRegisteredUser->website;
												$url = parse_url($website);

												if($url['scheme'] == 'https'){
												$actUrl = $website;
												} elseif($url['scheme'] == 'http'){
												$actUrl = $website;	
												} else{
													$actUrl = 'http://'.$website;
												}
										 ?>
                                         <div class="col-sm-8 right-amount"><h4><a href="<?php echo $actUrl;?>" target="_blank"><?php echo $recentlyRegisteredUser->website;?></a></h4></div>
                                         
                                         <div class="col-sm-4"><h4><b><?php echo $lang['City']; ?></b></h4></div>
                                         <div class="col-sm-8 right-amount"><h4><?php echo $recentlyRegisteredUser->city;?></h4></div>
                                         
                                         <div class="col-sm-4"><h4><b><?php echo $lang['State']; ?></b></h4></div>
                                         <div class="col-sm-8 right-amount"><h4><?php echo $recentlyRegisteredUser->state;?></h4></div>
                                         
                                         <div class="col-sm-4"><h4><b><?php echo $lang['Zip code']; ?></b></h4></div>
                                         <div class="col-sm-8 right-amount"><h4><?php echo $recentlyRegisteredUser->zip;?></h4></div>
                                         
                                         <div class="col-sm-4"><h4><b><?php echo $lang['Country']; ?></b></h4></div>
                                         <div class="col-sm-8 right-amount"><h4><?php echo $recentlyRegisteredUser->country;?></h4></div>
                                    </div>
                                </div>
                                <hr>
                                <div class="container">
                                 
                                    <div class="row">
                                       <div class="col-sm-7 skype-btn">
                                           <div class="container"> 
                                             <div class="row">
                                            <div class="col-sm-2"><i class="fa fa-skype" aria-hidden="true"></i></div>
                                            <div style="text-align: left;" class="col-sm-6"><h4 style="margin-top: 1px;"><b>Skype</b></h4><?php echo $recentlyRegisteredUser->skype_id;?></div>
                                           <div style="text-align: right;" class="col-sm-3"><a href="skype:<?php echo $recentlyRegisteredUser->skype_id;?>?call"><i class="fa fa-phone" aria-hidden="true"></i></a></div>
                                           </div>                                          
                                           </div>
                                       </div>
                                                                                 <div class="col-sm-1"></div>

                                       <div style="padding-left: 0;padding-right: 0;" class="col-sm-4 fb-btn"><i class="fa fa-facebook" aria-hidden="true"></i><a href="<?php echo $recentlyRegisteredUser->fb;?>" target="_blank">Facebook</a></div>
                                    </div>
                                </div>
                                    
                                 </div>
    </div>
    </div>
    </div>                 
                            </div>

                    </div><!-- col-xs-3 mix -->
                   <?php } unset($recentlyRegisteredUsers);?>
                    <div class="norecords" style="display: none;"><?php echo $lang['No records Found!']; ?></div>
                </div> <!-- mix-grid -->
            </div>
        </div><!-- row -->
    </div>
	<div class="clearfix"></div>
		
</div>        
</div>        
</div>        
<?php  include("../templates/admin-footer.php"); ?>