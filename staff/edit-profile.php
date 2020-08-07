<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Edit Staff Profile //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Edit Profile | ". $syatem_title;
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
$message = "";
	if(isset($_POST['add-client']))
	{
		$user = user::findById((int)$session->userId); 
		
		$flag=0;
		if($flag==0)
		{
			
			$user->id        		=  $session->userId;
			$user->firstName	=$_POST['firstName'];
				$user->email		=$_POST['email'];
				$user->title		=$_POST['title'];
				$user->password		=$_POST['password'];
				$user->address		=$_POST['address'];
				$user->phone		=$_POST['phone'];
				$user->website		=$_POST['website'];
				$user->skype_id		=$_POST['skype_id'];
				$user->fb		=$_POST['fb'];
				$saveUser=$user->save();
	
				if($saveUser)
				{
$picture = new profilePicture();	
		$picture->fkUserId = $session->userId;	// if user logged in, its id is already save in session, check header.php
		$profilePicAlreadyExists=$picture->findByfkUserId($picture->fkUserId);
		
		foreach($profilePicAlreadyExists as $record)
		{
			
		$profilePicAlreadyExistsId	= $record->id;
		$picture->fileToUnlink 		= $record->filename;
		break;
		}
		
		//if user profile picture is already been set ,update its path

		if(isset($profilePicAlreadyExistsId))
		{
			
			$picture->id=$profilePicAlreadyExistsId;
			
		}
	
		$picture->attachFile($_FILES['pro-pic']);
	
		$picture->createdDate 	= strftime("%Y-%m-%d %H:%M:%S", time());

		if($picture->save()) {
			// Success
			
			unset($picture);
		}else {
			// Failure
			$error = $picture->errors;
			header("Location:edit-profile.php?message=error");
		}
header("Location:edit-profile.php?message=success");
				}
				else
				{
header("Location:edit-profile.php?message=fail");
				}

}
}
if(isset($_GET['message'])){
$msgstatus = $_GET['message'];
$notmessagea = $lang['Record updated successfully'];
$notmessageb = $lang['Same record was updated.'];
$notmessagec = $lang['Picture changed successfully.'];
$notmessaged = $lang['Picture could not be uploaded due to following error'];
if($msgstatus == 'success'){
					$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessagea."</p>";
}
if($msgstatus == 'fail'){
$message="<p class='alert alert-danger'><i class='fa fa-check'></i> ".$notmessageb."</p>";
}
if($msgstatus == 'image'){
			$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessagec."</p>";
}
if($msgstatus == 'error'){
			 $message = "<p class='alert alert-danger'><i class='fa fa-times'></i> ".$notmessaged."<br />".$error."</p>";
}
}
//condition check for login

$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$title=$user->title;
$email=$user->email;
$account_stat=$user->status;
?>

    
<div class="page-container">
<div class="container-fluid">
<div class="row row-eq-height">
	<?php  include("../templates/sidebar.php"); ?>
	
    <div class="page-content col-lg-9 col-md-12 col-sm-12 col-lg-push-3">
<?php include('../templates/top-header.php'); ?>
         <h2 class="page-title"><?php echo $lang['Edit Profile']; ?></h2>
			 <?php if(isset($message) && (!empty($message))){echo $message;} ?>
          <div class="add-client">
          	<form method="post" action="#" enctype="multipart/form-data">
			<div class="row">
              <div class="col-md-4 upload-profile-pic">
              		<div class="upload-pro-pic">
					<div class="img-uploadwrap">
              			<h4><?php echo $lang['Change profile image']; ?></h4>
		                        <?php if(isset($profilePic)){ ?>
                			<img src="../uploads/profile-pics/<?php echo $profilePic;?>" class="img-fluid" alt="Profile Picture"/>
                <?php } else { ?>
                        <img src="../assets/images/upload-img.jpg" class="img-responsive"/>
                    <?php } ?>
                    </div>
                        <div class="input-btn">
                        	+
                        	<input type="file" name="pro-pic" data-clientid="<?php echo $id; ?>" class="pro-pic" id="imgInp"/>
                        </div>
						<h4><?php echo $lang['Change profile image']; ?></h4>
						<h6><?php echo $lang['Profile image must be a .jpg .png file smaller than 10MB and at least 400px by 400px.']; ?></h6>
<div style="display:none;" class="imageupates col-md-12"><p class='alert alert-success'><i class='fa fa-check'></i> <?php echo $lang['Profile Picture Updated']; ?></p></div>
<div style="display:none;" class="imageupatesfail col-md-12"><p class='alert alert-danger'><i class='fa fa-close'></i> <?php echo $lang['Image formate not Supported or image is too big']; ?></p></div>
                    </div>
              </div>
              <div class="col-md-8 user-info">
              
                <div class="row">
                	<div class="col-md-6">
                    	<div class="form-group row">
                            <div class="col-md-12">
                                <div class="field-label"><label for="firstName"><?php echo $lang['Full name*']; ?></label></div>
                            	<input type="text" name="firstName" class="form-control" required value="<?php echo $user->firstName;?>">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                <div class="field-label"><label for="title"><?php echo $lang['Job Title']; ?>*</label></div>
                            	<input type="text" name="title" class="form-control" required value="<?php echo $user->title;?>">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12 passfieldcont">
                                <div class="field-label"><label for="Password"><?php echo $lang['Password*']; ?></label></div>
                            	<input type="password" name="password" class="form-control passwordfield" required value="<?php echo $user->password;?>">
								<i class="fa fa-eye" id="inputtoggale" aria-hidden="true"></i>
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                <div class="field-label"><label for="phone"><?php echo $lang['Phone']; ?></label></div>
                            	<input type="text" name="phone" class="form-control" value="<?php echo $user->phone;?>">
                            </div>
                         </div>
                          
                    </div>
                        
                        
                    <div class="col-md-6">
                    	<div class="form-group row">
                            <div class="col-md-12">
                                <div class="field-label"><label for="email"><?php echo $lang['Email*']; ?></label></div>
                            	<input type="text" name="email" class="form-control" required value="<?php echo $user->email;?>">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                <div class="field-label"><label for="address"><?php echo $lang['Address']; ?>*</label></div>
                            	<input type="text" name="address" class="form-control" value="<?php echo $user->address;?>">
                            </div>
                         </div>
                      <div class="form-group row">
                            <div class="col-md-12">
                                <div class="field-label"><label for="skype">Skype Id</label></div>
                            	<input type="text" name="skype_id" class="form-control" value="<?php echo $user->skype_id;?>">
                            </div>
                         </div>
                       
                         <div class="form-group row">
                            <div class="col-md-12">
                                <div class="field-label"><label for="fb">Facebook URL</label></div>
                            	<input type="text" name="fb" placeholder="https://www.facebook.com/User Id" pattern=".*\.facebook\..*"  class="form-control" value="<?php echo $user->fb;?>">
                            </div>
                         </div>
                    </div>
<div class="col-md-12 submit-btnal">
					<div class="form-group row">
                         <input class="bigbutton" value="<?php echo $lang['Save Changes']; ?>" name="add-client" type="submit"/>
					</div>
					</div>
                </div>
              </div>
              </div>
              <div class="clearfix"></div> 
            </form>
          </div><!--add-client -->
       
    </div>
	<div class="clearfix"></div>
		
</div>
</div>
</div>
<?php  include("../templates/admin-footer.php"); ?>