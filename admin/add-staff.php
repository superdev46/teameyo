<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Add Staff Member  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Add Staff | ". $syatem_title;
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
$account_stat=$user->status;
$settings = settings::findById((int)$id);
$message = "";
	if(isset($_POST['add-client']))
	{
		
		$flag=0;
		if($flag==0)
		{
			$user = new User();

				$id	= (int)NULL;
				$Projects_ids	= "";
				$password		=$_POST['password'];
				$email		=$_POST['email'];
				$accountStatus = 3;
				$firstName	=$_POST['firstName'];
				$title		= $_POST['title'];
				$address		=$_POST['address'];
				$phone		=$_POST['phone'];
				$website		=$_POST['website'];
				$skype_id		=$_POST['skype_id'];
				$fb		=$_POST['fb'];
				$regDate	 	= strftime("%Y-%m-%d %H:%M:%S", time());
				$type_status	 	= "";
				$last_seen		= time();
				$session_status		= "";
				$status		= 0;
				$note		= "";
				$city		= "";
				$state		= "";
				$zip		= "";
				$country	= "";
				$user_language = '';

				
$sql = "INSERT INTO users (id, Projects_ids, password, email, accountStatus, firstName, title, address, phone, website, skype_id, fb, regDate, type_status, last_seen, session_status, status, note, city, state, zip, country, user_language)
VALUES ('$id', '$Projects_ids', '$password', '$email', '$accountStatus', '$firstName', '$title', '$address', '$phone', '$website', '$skype_id', '$fb', '$regDate', '$type_status', '$last_seen', '$session_status', '$status', '$note', '$city', '$state', '$zip', '$country', '$user_language')";
				
				
				$emailAlreadyExists=user::findByEmail($email);
				if($emailAlreadyExists)
				{
					
						 $message="<p class='alert alert-danger'><i class='fa fa-times'></i>This email address has already registered. Try a different one.</p>";
				}
				
				else
				{
	
if ($connect->query($sql) === TRUE) {
					  $lastUser=$user->findLastRecord();
					  $last_id = $connect->insert_id;
					  $message="";
					  if ($_FILES['pro-pic']['tmp_name']!='') {
						$picture = new profilePicture();	
						$id=(int)NULL;
						$fkUserId = $last_id;
$fileName = $_FILES['pro-pic']['name'];
$fileType = $_FILES['pro-pic']['type'];
$filesize = $_FILES['pro-pic']['size'];
$fileError = $_FILES['pro-pic']['error'];



$fileContent = file_get_contents($_FILES['pro-pic']['tmp_name']);
$tmpImageFolder = dirname(__DIR__).'/uploads/profile-pics/';
$ext = strtolower(pathinfo($_FILES['pro-pic']['name'], PATHINFO_EXTENSION));
$newFileName = microtime(true).'.'.$ext;
$source = $_FILES['pro-pic']['tmp_name'];
$dest = $tmpImageFolder.'/'.$newFileName;
move_uploaded_file($source,$dest);

$image =  json_encode($newFileName);
$filename = str_replace('"', "", $image);
						$createdDate 	= strftime("%Y-%m-%d %H:%M:%S", time());
						$sqlb = "INSERT INTO profile_pics (id, fkUserId,filename, type, size,createdDate) VALUES('$id', '$fkUserId', '$filename', '$fileType', '$filesize', '$createdDate')"; 
if ($connect->query($sqlb) === TRUE) {
							// Success
							unset($picture);
						}
						else {
							// Failure
			 				$message = "<p class='alert alert-danger'><i class='fa fa-times'></i>" . join("Picture couldn't be uploaded due to following error<br />", $picture->errors ). "</p>";
			
						}
					  }
					  	
					   //send verification email
				  $to  = $email;
$subject = 'Your Account has been Created';
$variablesArr = array('{USER_NAME}' => $firstName, '{SIGNATURE}' => $company_name, '{DASHBOARD_URL}' => $url, '{USER_LOGIN_PASSWORD}' => $password , '{USER_LOGIN_EMAIL}' => $email , '{RESET_PASSWORD_URL}' => '', '{PROJECT_NAME}' => '');
$templateHTML = $settings->create_account_email;
$message = strtr($templateHTML, $variablesArr);
				  
				  // To send HTML mail, the Content-type header must be set (don't change this section)
				  $headers  = 'MIME-Version: 1.0' . "\r\n";
				  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				  
				  $headers .= 'From: '.$company_name.' <'.$system_email.'>' . "\r\n";
				  
				  // Mail it
				  $emailSent=mail($to,$subject, $message, $headers);
				  if($emailSent){
					 
 header('location: staff.php?message=add_success'); 
				  }
				  else
				  {
					 header('location: add-staff.php?message=fail');  
				  }
				  
				  }
				  else
				  {
$error =  $connect->error;
					header('location: add-staff.php?message=error');  
				  
				  }
				}

		}
			
		
	}
if(isset($_GET['message'])){
$msgstatus = $_GET['message'];
$notmessagea = $lang['Staff has been registered successfully!'];
$notmessageb = $lang['Staff have been registered but Error sending the Email Please contact site administrator or Check System Setting Email Field!'];
if($msgstatus == 'success'){
					  $message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessagea."</p>";
}
if($msgstatus == 'fail'){
					  $message="<p class='alert alert-danger'><i class='fa fa-times'></i> ".$notmessageb."</p>";
}
if($msgstatus == 'error'){
					  $message="<p class='alert alert-danger'><i class='fa fa-times'></i> ".$lang['Error registering user.'] .$sql. $lang['Please Try Again later.Error:']. $error."</p>";
}

}
//condition check for login

$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$account_stat=$user->status;

?>

    
<div class="page-container">
<div class="container-fluid">
<div class="row row-eq-height">
	<?php  include("../templates/sidebar.php"); ?>
	
    <div class="page-content col-lg-9 col-md-12 col-sm-12 col-lg-push-3">
<?php include('../templates/top-header.php'); ?>
         <h2 class="page-title"><?php echo $lang['Add Staff']; ?></h2>
			 <?php if(isset($message) && (!empty($message))){echo $message;} ?>
          <div class="add-client">
          	<form method="post" action="#" enctype="multipart/form-data">
			<div class="row">
              <div class="col-md-4 upload-profile-pic">
              		<div class="upload-pro-pic">
						<div class="img-uploadwrap">
                    	<img src="../assets/images/upload-img.jpg" class="img-fluid" id="blah"/>
						</div>
<div class="input-btn">
                        	+
                        	<input type="file" name="pro-pic" class="pro-pic" id="imgInpb"/>
                        </div>
						<h4><?php echo $lang['Change profile image']; ?></h4>
						<h6><?php echo $lang['Profile image must be a .jpg .png file smaller than 10MB and at least 400px by 400px.']; ?></h6>
                    </div>
              </div>
              <div class="col-md-8 user-info">
                <div class="row">
                	<div class="col-md-6">
                    	<div class="form-group row">
                            <div class="col-md-12">
							<div class="field-label"><label for="firstName"><?php echo $lang['Full name*']; ?></label></div>
                            	<input type="text" name="firstName" class="form-control" required>
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                            <div class="field-label"><label for="title"><?php echo $lang['Job Title']; ?>*</label></div>
                            	<input type="text" name="title" class="form-control" required>
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12 passfieldcont">
                            <div class="field-label"><label for="password"><?php echo $lang['Password*']; ?></label></div>
                            	<input type="password" name="password" class="form-control passwordfield" required>
								<i class="fa fa-eye" id="inputtoggale" aria-hidden="true"></i>
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                            <div class="field-label"><label for="phone"><?php echo $lang['Phone']; ?></label></div>
                            	<input type="text" name="phone" class="form-control">
                            </div>
                         </div>
                    </div>
                    <div class="col-md-6">
                         <div class="form-group row">
                            <div class="col-md-12">
                            <div class="field-label"><label for="skype_id">skype_id</label></div>
                            	<input type="text" name="skype_id" class="form-control">
                            </div>
                         </div>
						 	<div class="form-group row">
                            <div class="col-md-12">
                            <div class="field-label"><label for="email"><?php echo $lang['Email*']; ?></label></div>
                            	<input type="text" name="email" class="form-control" required>
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                            <div class="field-label"><label for="address"><?php echo $lang['Address']; ?></label></div>
                            	<input type="text"  name="address" class="form-control">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                            <div class="field-label"><label for="Facebook">Facebook Url</label></div>
                            	<input type="url" name="fb" placeholder="https://www.facebook.com/User Id" pattern=".*\.facebook\..*" class="form-control">
                            </div> 
                         </div>
                    </div>
<div class="col-md-12 submit-btnal">
					<div class="form-group row">
                         <input class="bigbutton" value="<?php echo $lang['Create Account']; ?>" type="submit" name="add-client"/>
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