<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// All Staff and Admin Members page //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Staff | ". $syatem_title;
include("../templates/admin-header.php");

 if(!($session->isLoggedIn())){
		redirectTo($url."index.php");
	}
if($_SESSION['accountStatus'] == 2){
	redirectTo($url."client/index.php");
}
if($_SESSION['accountStatus'] == 1){
	redirectTo($url."admin/index.php");
} 

//condition check for login

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
	
    <div class="page-content col-lg-9 col-md-12 col-sm-12 col-lg-push-3 clients">
<?php include('../templates/top-header.php'); ?>
         <div class="row">
            <div class="col-md-12 margin-top-10 clients">
<div class="row project-dash">
            	<div class="col-sm-6">
				<div class="pm-heading"><h2><?php echo $lang['Staff']; ?></h2><span><?php echo $lang['All staff members']; ?></span></div>
				</div> 
                <div class="col-sm-6 creative-right text-right">
<div class="pm-form" style="width: 100%;"><form class="form-inline md-form form-sm">
    <input class="form-control form-control" type="text" placeholder="<?php echo $lang['Search Staff...']; ?>" id="staff-searchnew">
    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
</form></div>
				</div>
			</div>
                <div class="row clients-row">
                
          <?php  $recentlyRegisteredUsers=user::findBySql("select * from users where accountStatus != 2 AND id != $id");
                 foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
                  
                    $profilePictureObj=profilePicture::findByfkUserId($recentlyRegisteredUser->id);
    
                            if($profilePictureObj)
                            {
                                foreach($profilePictureObj as $displayPicture)
                                {
								 $filenamePic = $displayPicture->filename;
$filenamePicture = $url."includes/timthumb.php?src=".$url."uploads/profile-pics/".$filenamePic."&h=130$w=130";
                                }
                                
                             }
                             else
                             {
                                 $filenamePicture ="../assets/images/upload-img.jpg";
                                
                             } 
                   
                  ?>
                    <div class="col-sm-3 staff">
					
                        	<div class="mix">
							<div class="container">
							<div class="row">
                        	<div class="col-sm-12 user-imgbox img-circle">
                            	<img src="<?php echo $filenamePicture;?>" class="img-fluid"/>
                            </div>
                            <div class="col-sm-12 client-info">
                                <h3> <?php echo $recentlyRegisteredUser->firstName;?></h3>
								<h4><?php echo $recentlyRegisteredUser->title;?></h4>
                            </div>
							</div>
							</div>
                            <div class="clearfix"></div>
							<div class="btn-wrapstf btn-fullw">
                                <form action="../messages.php?project_id=0" method="post" class="full-wfrm">
                                   <input type="hidden" name="user_id" value="<?php echo $recentlyRegisteredUser->id;?>" />
                                   <input type="submit" value="<?php echo $lang['Chat']; ?>" name="chat" class="form-control btn full-w"/>
                                </form>
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