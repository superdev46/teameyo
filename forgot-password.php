<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Forget Password Page  //////////////////////////
*/
require_once("./includes/initialize.php");
$title = "Forgot Password | ". $syatem_title;	 
$settings = settings::findById(1);
	if($session->isLoggedIn()) {
		redirectTo($url."index.php");
	}
	
	$message = "";
	// Remember to give your form's submit tag a name="submit" attribute!
	//condtions for checking empty values
	if(!empty($_POST["forgot-password"])){
		

		
		if(!empty($_POST["email"])) {
			
			$username =$_POST["email"];
			$foundUser = User::findByEmail($username);
		}
		
		if(!empty($foundUser)) {
$to  = $foundUser->email;
$subject = 'Recover Password';

$reset_url = $url . 'reset_password.php?name='. $foundUser->firstName .'&userid=' .  $foundUser->id;
$variablesArr = array('{USER_NAME}' => $foundUser->firstName , '{SIGNATURE}' => $company_name, '{DASHBOARD_URL}' => $url, '{RESET_URL}' => $reset_url);
$templateHTML = $settings->forget_email;
$message = strtr($templateHTML, $variablesArr);
				  
				  // To send HTML mail, the Content-type header must be set (don't change this section)
				  $headers  = 'MIME-Version: 1.0' . "\r\n";
				  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				  
				  $headers .= 'From: '.$company_name.' <'.$system_email.'>' . "\r\n";
				  
				  // Mail it
				  $emailSent=mail($to,$subject, $message, $headers);
				  if($emailSent){
					 
					  $message="Please check your email to reset password!";
					  //header('location: index.php');  
				  }
				  else
				  {
					  echo "Problem in Sending Password Recovery Email";
					  exit;
				  }

		} else {
			$message = 'No User Found';
		}
	
	}
	
?>

<?php include("templates/frontend-header.php"); ?>
<div class="login-area">
	<div class="content container">
    	<div class="row">
        	<div class="col-sm-5">
<div class="logo"><a class="signLogo" href="<?php echo $url; ?>">
				<?php if($login_page_logo){ ?>
				<img src="<?php echo $url.$img_path.$login_page_logo; ?>" alt=""/>
				<?php } else { ?>
				<img src="<?php echo $url; ?>assets/images/login-logo.png" alt=""/>
				<?php } ?>
				</a></div>
            </div>
            <div class="col-sm-6">
            	
                <?php if(!empty($success_message)) { ?>
                <div class="success_message"><?php echo $success_message; ?></div>
                <?php } ?>
                <form class="login-form grey forgetpage" action="forgot-password.php" method="post" name="frmForgot">
                	
                    <h3 class="form-title grey offset-md-3"><?php echo $lang['Forgot Password?']; ?></h3>
                    <?php if(isset($message)&&(!empty($message))){ ?>
                    <div class="row">
					<div class="col-md-3"></div>
                    <div class="col-sm-8">
					<div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span style="display:block;"><?php echo $message;?></span>
					</div>
                    </div>
                    </div>                    
                    <?php } ?>
                    <div class="form-group row">
                        <label class="control-label col-sm-3 padding-right-0"><?php echo $lang['Email Address']; ?></label>
                        <div class="input-icon col-sm-8">
	<input class="form-control placeholder-no-fix" type="text" autocomplete="off" name="email"/>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group row">
					<div class="col-sm-3"></div>
                        <div class="input-icon col-sm-8 ">
                           
                           
                            <input type="submit"  name="forgot-password" class="btn orange" value="<?php echo $lang['Forget Password?']; ?>">
                            <div class="clearfix"></div>
                            <div class="row">
                            <label class="checkbox col-lg-6">
                        <div class="col-lg-6">
                        </div>
                        <div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                   </div>
            <div class="clearfix"></div>
        </div>
                </form>
	</div>
    
   </div><!-- login-area-->
<?php include("templates/frontend-footer.php"); ?>