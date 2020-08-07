<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Client and Staff Edit Profile  //////////////////////////
*/
ob_start(); 
include("../includes/lib-initialize.php");
$title = "Edit Client | ". $syatem_title;
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
if(isset($_GET['editClient']))
	{
		$edit_client=$_GET['editClient'];
$message = "";
	if(isset($_POST['add-client']))
	{ 
		$user = user::findById($edit_client); 
		
		$flag=0;
		if($flag==0)
		{
			
			$user->id        		= $edit_client;
			$user->firstName	=$_POST['firstName'];
				$user->email		=$_POST['email'];
				$user->password		=$_POST['password'];
				$user->address		=$_POST['address'];
				$user->title		=$_POST['title'];
				$user->phone		=$_POST['phone'];
				$user->website		=$_POST['website'];
				$user->skype_id		=$_POST['skype_id'];
				$user->fb		=$_POST['fb'];
				$user->city		=$_POST['city'];
				$user->state		=$_POST['state'];
				$user->zip		=$_POST['zip'];
				$user->country		=$_POST['country'];
				$saveUser=$user->save();
	
				if($saveUser)
				{

						$picture = new profilePicture();	
		$picture->fkUserId = $edit_client;	// if user logged in, its id is already save in session, check header.php
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
header("Location:edit.php?editClient=".$_GET['editClient']."&message=success");

		}  else {
			$error = $picture->errors;
			header("Location:edit.php?editClient=".$_GET['editClient']."&?message=error");			
		}
header("Location:edit.php?editClient=".$_GET['editClient']."&message=success");
				}
				else
				{
header("Location:edit.php?editClient=".$_GET['editClient']."&message=fail");
				}
	
				
		
				

		}
			
		
	}
if(isset($_GET['message'])){
$msgstatus = $_GET['message'];
$notmessagea = $lang['Record updated successfully'];
$notmessageb = $lang['Same record was updated.'];
$notmessagec = $lang['Picture could not be uploaded due to following error'];
if($msgstatus == 'success'){
					$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessagea."</p>";
}
if($msgstatus == 'fail'){
$message="<p class='alert alert-danger'><i class='fa fa-check'></i> ".$notmessageb."</p>";
}

if($msgstatus == 'error'){
			 $message = "<p class='alert alert-danger'><i class='fa fa-times'></i> ".$notmessagec."<br />".$error."</p>";
}
}
//condition check for login

$id=$session->userId; //id of the current client 
$user = User::findById((int)$session->userId); //take the record of current user in an object array 	
$username=$user->firstName;;
$email=$user->email;;
$account_stat=$user->status;;
$user->regDate;


$id1=$edit_client; //id of the current client 
$user1 = User::findById($id1); //take the record of current user in an object array 	
$username1=$user1->firstName;;
$email1=$user1->email;;
$account_stat1=$user1->status;;
$user1->regDate;

$profilePictureObj1=profilePicture::findByfkUserId($id1);
if($profilePictureObj1){
	foreach($profilePictureObj1 as $displayPicture1)
	{
	 $profilePic1=$displayPicture1->filename;
	}
}
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
                        <?php if(isset($profilePic1)){ ?>
                			<img src="../uploads/profile-pics/<?php echo $profilePic1;?>" class="img-responsive" alt="Profile Picture"/>
                <?php } else { ?>
                        <img src="../assets/images/upload-img.jpg" class="img-responsive"/>
                    <?php } ?>
					</div>
                       <div class="input-btn">
                        	+
<input type="file" name="pro-pic" class="pro-pic" data-clientid="<?php echo $_GET['editClient'] ?>" id="imgInp"/>
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
                            	<input type="text" name="firstName" class="form-control" required value="<?php echo $user1->firstName;?>">
                            </div>
                         </div>
                    <div class="form-group row">
                            <div class="col-md-12 passfieldcont">
                            <div class="field-label"><label for="password"><?php echo $lang['Password*']; ?></label></div>
                          	<input type="password" name="password" class="form-control passwordfield" required value="<?php echo $user1->password;?>">
							<i class="fa fa-eye" id="inputtoggale" aria-hidden="true"></i>
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                <div class="field-label"><label for="phone"><?php echo $lang['Phone']; ?></label></div>
                          	<input type="text" name="phone" class="form-control" value="<?php echo $user1->phone;?>">

                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                <div class="field-label"><label for="skype_id">Skype ID</label></div>
                                <input type="text" name="skype_id" class="form-control" value="<?php echo $user1->skype_id;?>">
                            </div>
                         </div>
<?php if($user1->accountStatus == 2){ ?>
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="city"><?php echo $lang['City']; ?></label></div>
                            	<input type="text" name="city" value="<?php echo $user1->city;?>" class="form-control">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="zip"><?php echo $lang['Zip']; ?></label></div>
                            	<input type="text" name="zip" value="<?php echo $user1->zip;?>" class="form-control">
                            </div>
                         </div>
 <?php } ?>
                    </div>
                    <div class="col-md-6">
                         <div class="form-group row">
                            <div class="col-md-12">
                                <div class="field-label"><label for="email"><?php echo $lang['Email*']; ?></label></div>
                            	<input type="text" name="email" class="form-control" required value="<?php echo $user1->email;?>">
                            </div>
                         </div>
						 <div class="form-group row">
                            <div class="col-md-12">
                                <div class="field-label"><label for="address"><?php echo $lang['Address']; ?></label></div>
                                <input type="text" name="address" class="form-control" value="<?php echo $user1->address;?>">
                            </div>
                         </div>
						 <?php if($user1->accountStatus == 2){ ?>
					<div class="form-group row">
                            <div class="col-md-12">
                          <div class="field-label"><label for="website"><?php echo $lang['Website Url*']; ?></label></div>
                           	<input type="text" name="website" class="form-control" required value="<?php echo $user1->website;?>">
                            </div>
                         </div>						 
						 <?php } else { ?>
					<div class="form-group row">
                            <div class="col-md-12">
                          <div class="field-label"><label for="Job Title"><?php echo $lang['Job Title']; ?></label></div>
                           	<input type="text" name="title" class="form-control" required value="<?php echo $user1->title;?>">
                            </div>
                         </div>
						 <?php } ?>
                         <div class="form-group row">
                            <div class="col-md-12">
                                <div class="field-label"><label for="Facebook">Facebook Url</label></div>
                            	<input type="url" name="fb" placeholder="https://www.facebook.com/User Id" pattern=".*\.facebook\..*" class="form-control" value="<?php echo $user1->fb;?>">
                            </div>
                         </div>
 <?php if($user1->accountStatus == 2){ ?>
  <div class="form-group row">
                            <div class="col-md-12">
                                <div class="field-label"><label for="state"><?php echo $lang['State']; ?></label></div>
                            	<input type="text" name="state" value="<?php echo $user1->state;?>" class="form-control">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                <div class="field-label"><label for="country"><?php echo $lang['Country']; ?></label></div>
								<?php $countryval = $user1->country; ?>
								<select name="country" class="form-control">
	<option value=""><?php echo $lang['Select Country']; ?></option>
<?php foreach($countries as $countrie){
		echo '<option ';
		 if($countryval == $countrie){echo 'selected ';}
		echo 'value="'.$countrie.'">'.$countrie.'</option>';
	} ?>
								</select>
                            </div>
                         </div>
 <?php } ?>
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
<?php  include("../templates/admin-footer.php"); }?>