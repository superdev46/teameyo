<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Login Page  //////////////////////////
*/
$filename =  __DIR__ . '/includes/config.php';
if (!file_exists($filename)) { 
$myfile = fopen('includes/config.php', "w");
if($myfile){
header('Location: install/index.php');
}
}else{
require_once("./includes/initialize.php"); 
$title = "Login | ". $syatem_title;	 
date_default_timezone_set($time_zone);
if(isset($_SESSION['accountStatus'])){
if($_SESSION['accountStatus'] == 2){
	redirectTo($url."client/index.php");
}
if($_SESSION['accountStatus'] == 1){
	redirectTo($url."admin/index.php");
}
if($_SESSION['accountStatus'] == 3){
	redirectTo($url."staff/index.php");
} 
}
	$message = "";
	// Remember to give your form's submit tag a name="submit" attribute!
	//condtions for checking empty values
	
	if (isset($_POST['submit']) || (isset($_COOKIE['artiLogin']) && ($_COOKIE['artiLogin']!=" "))) { // Form has been submitted.
		
		if(((isset($_POST['username']))&&(isset($_POST['password'])))&&((!empty($_POST['username']))&&(!empty($_POST['password'])))
			||( isset($_COOKIE['artiLogin'])))
		{
			//check if the form is submitted
			if(isset($_POST['submit']))
			{
			  $username = trim($_POST['username']);
			  $password = trim($_POST['password']);
			}
			//check if the cookie is saved for Remember me option
			elseif(isset($_COOKIE['artiLogin']))
			{
				$usernamePassword		= $_COOKIE['artiLogin'];	
				$usernamePasswordAry	= explode(":",$usernamePassword);
				$username			= $usernamePasswordAry[0];
				$password			= $usernamePasswordAry[1];
			}
			else
			{
				
			}
			
			
			 // Check database to see if username/password exist.
			  
		$foundUser = User::authenticate($username, $password);
		
		if ($foundUser) {
			//	Check if username is activated o rnot
			$user = User::findById($foundUser->id);
			
			if($user->accountStatus == 1 || $user->accountStatus == 3) 
			{	
				if(isset($_POST['remember'])){
				setcookie("artiLogin",$username.':'.$password, time()+60*60*24*100);
				}	
				
				$session->login($foundUser);
				redirectTo("admin/index.php");
			} 
			elseif($user->accountStatus == 2) 
			{ 
				if(isset($_POST['remember'])){
				setcookie("artiLogin",$username.':'.$password, time()+60*60*24*100);
				}
				
				$session->login($foundUser);
				redirectTo("client/index.php");
			} 
			else 
			{
				$message = "Your account has not been activated yet.<br/> Please check your email to activate!";
			}
		} else {
			// username/password combo was not found in the database
			$message = "Email/password combination incorrect";
		}
	  }
	  
	  else
	  {
		 $message="Please enter Email and password";
	  }
	  
	}
	 
	else { // Form has not been submitted.
		//$username = "";
		//$password = "";
	} 

?>
<?php include("templates/frontend-header.php");
  if(isset($_GET['message']) == 'installed'){ ?>
  <div class="error-message">
  Congratulations! Your System Installed Successfully, Please remove 'Install' folder from your installation directory to secure your Installation.
  </div>
  <?php } ?>
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
                <form class="login-form grey" action="<?php echo $url; ?>" method="post">
                	
                    <h3 class="form-title grey offset-md-3"><?php if($login_page_title){echo $login_page_title;} else { ?>Hello and welcome, <br/>Please Login<?php } ?></h3>
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
                            
                            <input class="form-control placeholder-no-fix logemail" type="text" autocomplete="off" name="username"/>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group row">
                        <label class="control-label col-sm-3 padding-right-0"><?php echo $lang['Password']; ?></label>
                        <div class="input-icon col-sm-8 ">
                           
                            <input class="form-control placeholder-no-fix pass" type="password" autocomplete="off"  name="password"/>
                            <input type="submit"  name="submit" class="btn orange" value="<?php echo $lang['LOG IN']; ?> ">
							<div class="row" style="margin:0;">
								<label class="checkbox col-lg-6">
								<input type="checkbox" name="remember" value="1"/> <span></span><?php echo $lang['Remember me']; ?>
								</label>
								<div class="col-lg-6">
								<a href="forgot-password.php" id="forget-password"><?php echo $lang['Forgot your password?']; ?></a>
								</div>
							</div>
							<div class="clearfix"></div>
                   </div>
				   </div>
                </form>
			</div>
     <div class="clearfix"></div>
   </div>
   </div>
   </div><!-- login-area-->
<?php include("templates/frontend-footer.php");
}
 ?>