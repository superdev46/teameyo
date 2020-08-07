<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Reset Password Page  //////////////////////////
*/
require_once("./includes/initialize.php"); 
	if($session->isLoggedIn()) {
		redirectTo("admin/profile.php");
	}
	
	$message = "";
	// Remember to give your form's submit tag a name="submit" attribute!
	//condtions for checking empty values
	if(!empty($_POST["reset-password"])){
		

		
		if(!empty($_POST["password"])) {
			
			$pass =$_POST["password"];
			$user_id=$_POST["user-id"];
			$foundUser = user::findById($user_id);

			if(!empty($foundUser)) {
$sql = "UPDATE users SET
password='$pass'
WHERE id='$user_id'";

if ($connect->query($sql) === TRUE) {
					
					$message="password updated successfully <br/><a href='index.php'>Login with new password</a>";
				}
				else
				{
					$message="Something went wrong. Try another time."; //when reord is not updated
				}
			
			} else {
				$message = 'No User Found';
			}
		} else{
			$message = 'Password can not be empty';
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
                <form class="login-form grey" action="#" method="post" name="frmForgot">
                	
                    <h3 class="form-title grey offset-md-3">Reset Password</h3>
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
                        <label class="control-label col-sm-3 padding-right-0">Enter New Password</label>
                        <div class="input-icon col-sm-8">
                            
                            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"/>
                             <input class="form-control placeholder-no-fix" type="hidden" autocomplete="off" placeholder="Password" name="user-id" value="<?php if(isset($_GET["userid"])){ echo $_GET["userid"];} ?>"/>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group row">
					<div class="col-sm-3"></div>
                        <div class="input-icon col-sm-8 ">
                           
                           
                            <input type="submit"  name="reset-password" class="btn orange" value="Reset Now">
                            <div class="clearfix"></div>
                            <div class="row">
                            <label class="checkbox col-lg-6">
                        <div class="col-lg-6">
                        </div>
                        <div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                   
                </form>
           	</div>
            <div class="clearfix"></div>
        </div>
	</div>
    
   </div><!-- login-area-->
<?php include("templates/frontend-footer.php"); ?>