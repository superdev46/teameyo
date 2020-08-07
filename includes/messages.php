<?php
require_once("./includes/initialize.php"); 
	//include('includes/loader.php');
	 
	include('templates/head.php');
	 



?>
	



<?php

if(!($session->isLoggedIn())){
		redirectTo($root."client-management/index.php");
	}
	
$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;;
$email=$user->email;;
$user->regDate;
?>
<div class="page-container">
	<?php
$profilePictureObj=profilePicture::findByfkUserId($session->userId);
if($profilePictureObj){
	foreach($profilePictureObj as $displayPicture)
	{
	 $profilePic=$displayPicture->filename;
	}
}
?>
<div class="sidebar-admin col-md-3">
	<div class="logo-admin-area">
    	<img src="assets/images/client-side-logo.png" class="img-fluid"/>
    </div><!-- logo-admin-area -->
        <div class="admin-nav-area">
            <div class="admin-intro row">
                <div class="col-sm-3 padding-right-0">
                    <?php if(isset($profilePic)){ ?>
                    <?php //echo $root;exit; ?>
                    
                    <img src="uploads/profile-pics/<?php echo $profilePic;?>" class="img-fluid" alt="Profile Picture"/>
                    <?php } else { ?>
                        
                            <img src="assets/images/upload-img.jpg" class="img-fluid"/>
                        <?php 
                    }// else ends ?>
                    
                </div>
                <div class="col-sm-9">
                    <h4>Welcome,</h4>
                    <h4 class="name-admin"><?php echo $username;?></h4>
                </div>
            </div><!-- admin-intro -->
            
            <ul class="list-unstyled">
                <li> <a href="../admin/profile.php">Dashboard  <i class="fa fa-chevron-right"></i></a></li>
                <li> <a href="../admin/clients.php">Clients <i class="fa fa-chevron-right"></i></a></li>
                <li> <a href="../messages.php">Team Chat <i class="fa fa-chevron-right"></i></a></li>
                <li> <a href="../admin/edit-profile.php">Edit Profile <i class="fa fa-chevron-right"></i></a></li>
                <li> <a href="../admin/add-client.php">Add Client <i class="fa fa-chevron-right"></i></a></li>
            </ul>
            <ul class="list-inline admin-social">
                <li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                <li><a href="#" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                
            </ul>
            <p class="copyright">© Copyright 2016 by Artimization. All Rights Reserved</p>
            
        </div><!-- admin-nav-area -->
     </div>
	
    <div class="page-content col-md-9 col-md-push-3">
    	<div class="top-bar">
        	<span>Artimization Project Manager CRM</span>
    		<a href="../logout.php">Logout</a>
            <div class="clearfix"></div>
            <div class="row">
            <div class="content-wrap margin-reset">
                 <!-- messages -->
                <div class="messages-box">
                    <?php include('messages_load.php'); ?>
                </div>
                <p style="padding-top: 5px; color: #aaa;">Hint: Type [unread] to filter unread messages</p>
                <!-- // messages -->
            </div>
          </div><!-- // row -->
         </div>
    </div>
	<div class="clearfix"></div>
		
</div> 
    
<?php
	include('templates/footer.php');
?>