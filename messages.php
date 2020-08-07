<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Team Chat Page  //////////////////////////
*/
	include('includes/loader.php');
	require_once("./includes/initialize.php");
	$title = "Discussions | " . $syatem_title;
	include('templates/head.php');
	  date_default_timezone_set($time_zone);
	$project_id = $_GET['project_id'];
//condition check for login
if(!($session->isLoggedIn())){
		redirectTo($url."index.php");
	}
?>
<script type="text/javascript">
function eventFire(el, etype){
  if (el.fireEvent) {
    el.fireEvent('on' + etype);
  } else {
    var evObj = document.createEvent('Events');
    evObj.initEvent(etype, true, false);
    el.dispatchEvent(evObj);
  }
}
</script>
<?php 
 if(isset($_POST['chat'])){
	 $client_id=$_POST['user_id'];
	 if($client_id){ ?>
    <script type="text/javascript">
	var client =<?php echo $client_id; ?>;
		jQuery(window).load(function () {
setTimeout( function(){
	<?php 
	$proid = $_GET['project_id'];
	if($proid == 0){ ?>
  		jQuery( "#tab-contacts" ).trigger( "click" );
	setTimeout( function(){
		jQuery( "#" +client).trigger( "click" );
	},500);
	<?php  }else{ ?>
		jQuery( "#" +client).trigger( "click" );
	<?php } ?>
}, 500);
setTimeout( function(){
$("#text-messages-request").getNiceScroll(0).doScrollTop($('#text-messages').height());
}, 1500);
});
	</script>   
    <?php }
}
$id=$session->userId; //id of the current logged in user 
$user_id=$session->userId;
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$accountStatus=$user->accountStatus;
$email=$user->email;

$_SESSION['chat_contatcs_accountStatus'] = $user->accountStatus;
// print_r($user);

$profilePictureObj=profilePicture::findByfkUserId($session->userId);
if($profilePictureObj){
	foreach($profilePictureObj as $displayPicture)
	{
	 $profilePic=$displayPicture->filename;
	}
}
function active($currect_page){
  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);  
  if($currect_page == $url){
      return 'active'; //class name in css 
  } 
}

?>
<div class="page-container">
<div class="container-fluid">
<div class="row row-eq-height">
<div class="sidebar-admin col-lg-3 col-md-3 col-sm-12">
	<div class="logo-admin-area">
<div class="cross-mobile"><i class="fa fa-times" aria-hidden="true"></i></div>
	<div class="mobile-welcome">
<div class="msr-wrapc">
<div class="msg-img">
<?php if(isset($profilePic)){ ?>
                
                <img src="<?php echo $url; ?>includes/timthumb.php?src=<?php echo $url; ?>uploads/profile-pics/<?php echo $profilePic;?>&h=50$w=50" class="img-fluid rounded-circle" alt="Profile Picture"/>
                <?php } else { ?>
                    
                        <img src="<?php echo $url; ?>includes/timthumb.php?src=<?php echo $url; ?>assets/images/upload-img.jpg&h=50$w=50" class="img-fluid rounded-circle"/>
                    <?php 
                } ?>
	</div>
	<div class="msg-welcome"><span><?php echo $lang['WELCOME']; ?></span><br><?php 
	if(isset($username)){
	echo $username;
	}	?></div>
	</div>
	</div>
<?php if($logo){ ?>
    	<img src="<?php echo $url.$img_path.$logo; ?>" class="img-fluid"/>
	<?php } else { ?>
		<img src="<?php echo $url;?>images/users/client-side-logo.png" class="img-fluid"/>
	<?php }?>
    </div><!-- logo-admin-area -->
    <div class="admin-nav-area">
        <?php if($accountStatus == 1){?>
		<div class="bigbutton"><a href="<?php echo $url; ?>admin/add-new-project.php"><?php echo $lang['Create project']; ?> <span>+</span></a></div>
<ul class="list-unstyled">
        	<li class="<?php echo active('index.php'); ?>"> <a href="<?php echo $url; ?>admin/index.php"><span><i class="fa fa-tachometer" aria-hidden="true"></i></span><?php echo $lang['Dashboard']; ?>  <i class="fa fa-chevron-right"></i></a></li>
            <li class="<?php echo active('clients.php'); echo active('add-client.php'); ?>"> <a href="#" data-toggle="collapse" data-target="#client-menu"><span><i class="fa fa-user" aria-hidden="true"></i></span> <?php echo $lang['Clients']; ?> <i class="fa fa-plus" aria-hidden="true"></i></a>
			<ul id="client-menu" class="collapse">
			<li class="<?php echo active('clients.php'); ?>"><a href="<?php echo $url; ?>admin/clients.php">-- <?php echo $lang['View All Clients']; ?> <i class="fa fa-chevron-right"></i></a></li>
			<li class="<?php echo active('add-client.php'); ?>"><a href="<?php echo $url; ?>admin/add-client.php">-- <?php echo $lang['Add New Client']; ?> <i class="fa fa-chevron-right"></i></a></li>
			</ul>
			</li>
	<li class="<?php echo active('staff.php'); ?>"> <a href="#" data-toggle="collapse" data-target="#staff-menu"><span><i class="fa fa-users" aria-hidden="true"></i></span><?php echo $lang['Staff']; ?> <i class="fa fa-plus" aria-hidden="true"></i></a>
			<ul id="staff-menu" class="collapse">
			<li class="<?php echo active('staff.php'); ?>"><a href="<?php echo $url; ?>admin/staff.php">-- <?php echo $lang['View All Staff']; ?> <i class="fa fa-chevron-right"></i></a></li>
			<li class="<?php echo active('add-staff.php'); ?>"><a href="<?php echo $url; ?>admin/add-staff.php">-- <?php echo $lang['Add Staff']; ?> <i class="fa fa-chevron-right"></i></a></li>
			</ul>
			</li>
            <li class="<?php echo active('projects.php'); ?>"> <a href="<?php echo $url; ?>admin/projects.php"><span><i class="fa fa-tasks" aria-hidden="true"></i></span><?php echo $lang['Projects']; ?> <i class="fa fa-chevron-right"></i></a></li>
<li class="<?php echo active('paid-invoices.php'); echo active('unpaid-invoices.php'); ?>"> <a href="#" data-toggle="collapse" data-target="#financials-menu"><span><i class="fa fa-university" aria-hidden="true"></i></span> <?php echo $lang['Financials']; ?> <i class="fa fa-plus" aria-hidden="true"></i></a>
			<ul id="financials-menu" class="collapse">
			<li class="<?php echo active('paid-invoices.php'); ?>"><a href="<?php echo $url; ?>admin/paid-invoices.php">-- <?php echo $lang['Paid Invoices']; ?> <i class="fa fa-chevron-right"></i></a></li>
			<li class="<?php echo active('unpaid-invoices.php'); ?>"><a href="<?php echo $url; ?>admin/unpaid-invoices.php">-- <?php echo $lang['Unpaid Invoices']; ?> <i class="fa fa-chevron-right"></i></a></li>
			</ul>
			</li>
            <li class="<?php echo active('messages.php'); ?>"><form action="<?php echo $url; ?>messages.php?project_id=0" method="post"><input type="hidden" name="project_id" value="0" /><button type="submit" name="chat"><span><i class="fa fa-comments-o" aria-hidden="true"></i></span><?php echo $lang['Team Chat']; ?><i class="fa fa-chevron-right"></i></button></form></li>
            <li class="<?php echo active('system-settings.php'); ?>"> <a href="<?php echo $url; ?>admin/system-settings.php"><span><i class="fa fa-cogs" aria-hidden="true"></i></span><?php echo $lang['System Settings']; ?> <i class="fa fa-chevron-right"></i></a></li>
            <li class="<?php echo active('edit-profile.php'); ?> mobile-show"> <a href="<?php echo $url; ?>admin/edit-profile.php"><span><i class="fa fa-user" aria-hidden="true"></i></span><?php echo $lang['Profile']; ?> <i class="fa fa-chevron-right"></i></a></li>
            <li class="<?php echo active('logout.php'); ?> mobile-show"> <a href="<?php echo $url; ?>logout.php"><span><i class="fa fa-sign-out" aria-hidden="true"></i></span><?php echo $lang['Logout']; ?> <i class="fa fa-chevron-right"></i></a></li>
        </ul>
         <?php }
		  else if($accountStatus == 3){?>
        	<ul class="list-unstyled">
        	<li class="<?php echo active('index.php'); ?>"> <a href="<?php echo $url; ?>staff/index.php"><span><i class="fa fa-tachometer" aria-hidden="true"></i></span><?php echo $lang['Dashboard']; ?>  <i class="fa fa-chevron-right"></i></a></li>
            <li class="<?php echo active('staff.php'); ?>"> <a href="<?php echo $url; ?>staff/staff.php"><span><i class="fa fa-users" aria-hidden="true"></i></span><?php echo $lang['Staff']; ?> <i class="fa fa-chevron-right"></i></a></li>
            <li class="<?php echo active('projects.php'); ?>"> <a href="<?php echo $url; ?>staff/projects.php"><span><i class="fa fa-tasks" aria-hidden="true"></i></span><?php echo $lang['Projects']; ?> <i class="fa fa-chevron-right"></i></a></li>
            <li class="<?php echo active('messages.php'); ?>"><form action="<?php echo $url; ?>messages.php?project_id=0" method="post"><input type="hidden" name="project_id" value="0" /><button type="submit" name="chat"><span><i class="fa fa-comments-o" aria-hidden="true"></i></span><?php echo $lang['Team Chat']; ?><i class="fa fa-chevron-right"></i></button></form></li>
            <li class="<?php echo active('edit-profile.php'); ?>"> <a href="<?php echo $url; ?>staff/edit-profile.php"><span><i class="fa fa-user" aria-hidden="true"></i></span><?php echo $lang['Edit Profile']; ?> <i class="fa fa-chevron-right"></i></a></li>
			<li class="<?php echo active('logout.php'); ?>"> <a href="<?php echo $url; ?>logout.php"><span><i class="fa fa-sign-out" aria-hidden="true"></i></span><?php echo $lang['Logout']; ?><i class="fa fa-chevron-right"></i></a></li>
        	</ul>
         <?php } else{?>
   <ul class="list-unstyled">
        	<li class="<?php echo active('index.php'); ?>"> <a href="<?php echo $url; ?>client/index.php"><span><i class="fa fa-tachometer" aria-hidden="true"></i></span><?php echo $lang['Dashboard']; ?> <i class="fa fa-chevron-right"></i></a></li>
            <li class="<?php echo active('projects.php'); ?>"> <a href="<?php echo $url; ?>client/projects.php"><span><i class="fa fa-tasks" aria-hidden="true"></i></span><?php echo $lang['Projects']; ?> <i class="fa fa-chevron-right"></i></a></li>
			<li class="<?php echo active('payment-history.php'); ?>"> <a href="<?php echo $url; ?>client/payment-history.php"><span><i class="fa fa-credit-card" aria-hidden="true"></i></span><?php echo $lang['Payment History']; ?><i class="fa fa-chevron-right"></i></a></li> 
            <li class="<?php echo active('edit-profile.php'); ?>"> <a href="<?php echo $url; ?>client/edit-profile.php"><span><i class="fa fa-user" aria-hidden="true"></i></span><?php echo $lang['Profile']; ?><i class="fa fa-chevron-right"></i></a></li>
            <li class="<?php echo active('logout.php'); ?>"> <a href="<?php echo $url; ?>logout.php"><span><i class="fa fa-sign-out" aria-hidden="true"></i></span><?php echo $lang['Logout']; ?><i class="fa fa-chevron-right"></i></a></li>
        </ul>
		<?php }?>
       
        <p class="copyright"><?php echo $copy_rights; ?></p>
        
    </div><!-- admin-nav-area -->
 </div>
	
    <div class="page-content messagecontaa col-lg-9 col-md-12 col-sm-12 col-lg-push-3" style="padding-bottom:0px !important;">
<?php include('templates/top-header.php'); ?>
    <div class="clearfix"></div>
       
	<div class="row cont-fix">
            <div class="content-wrap margin-reset">
                 <!-- messages -->
                <div class="messages-box <?php if($accountStatus==1){echo "admin-are";}else{echo "client-are";}?>">
                    <?php 
					if($accountStatus==2){
					if($project_id){
					include('messages_load.php');
					} else { ?>
<script>
window.location = "client/projects.php";
</script>
					<?php }
					} else {
					include('messages_load.php');	
					}?>
                </div>
                <!-- // messages -->
            </div> 
    </div>
	</div>
</div>
</div>
<div class="modal fade" role="dialog" id="overview">
  <div class="modal-dialog">
    <div class="modal-content">
<?php 
$project_id = $_GET['project_id']; 
if($project_id != 0){
$projectTitle =projects::findBySql("select * from projects where p_id=$project_id"); 
foreach($projectTitle as $Projectdtl){ ?>
      <div class="modal-header">
	  <h4 class="modal-title"><?php echo $lang['Project Overview']; ?></h4>
	  <?php if($accountStatus==1){ ?>
	  <div class="editpribtn">
	  								<form method="post" action="<?php echo $url;?>admin/edit-project.php">
								<input type="hidden" value="<?php echo $Projectdtl->p_id;?>" name="p_id"/>
								<button type="submit" name="edt_pro"><i class="fa fa-pencil"></i> <?php echo $lang['Edit Project']; ?></button>
								</form></div>
	  <?php } ?>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
<h4 class="modal-title"><?php echo $Projectdtl->project_title; ?></h4>
<div class="descrp">
<pre>
<?php echo $Projectdtl->project_desc; ?>
</pre>
</div>
<div class="details">
<div class="row">
<div class="col-md-3"><?php echo $lang['Start Date: ']; ?> </div><div class="col-md-9"><?php echo $Projectdtl->start_time; ?></div>
<div class="col-md-3"><?php echo $lang['Deadline']; ?>: </div><div class="col-md-9 color-red"><?php echo $Projectdtl->end_time; ?></div>
<?php if($accountStatus != 3){ ?>
<div class="col-md-3"><?php echo $lang['Budget']; ?>: </div><div class="col-md-9"><?php echo $currency_symbol . $Projectdtl->budget; ?>
<?php } ?>
</div>
</div>
</div>
      </div>
<?php }
} ?>

    </div>
  </div>
</div>
    
	<div class="clearfix"></div>
		
</div> 
<div class="preloadimg" style="display: none !important;">
<img class="emoticons" src="assets/img/emoticons/Angry.png" id="angry" data-value="[angry]">
<img class="emoticons" src="assets/img/emoticons/Angry-Devil.png" id="angry-devil" data-value="[angry-devil]"> 
<img class="emoticons" src="assets/img/emoticons/Anguished.png" id="anguished" data-value="[anguished]"> 
<img class="emoticons" src="assets/img/emoticons/Astonished.png" id="astonished" data-value="[astonished]">
<img class="emoticons" src="assets/img/emoticons/Blushed.png" id="blushed" data-value="[blushed]"> 
<img class="emoticons" src="assets/img/emoticons/Cold-Sweat.png" id="cold-sweat" data-value="[cold-sweat]"> 
<img class="emoticons" src="assets/img/emoticons/Confounded.png" id="confounded" data-value="[confounded]"> 
<img class="emoticons" src="assets/img/emoticons/Confused.png" id="confused" data-value="[confused]"> 
<img class="emoticons" src="assets/img/emoticons/Crying.png" id="crying" data-value="[crying]"> 
<img class="emoticons" src="assets/img/emoticons/Disappointed.png" id="disappointed" data-value="[disappointed]"> 
<img class="emoticons" src="assets/img/emoticons/Disappointed-Relieved.png" id="disappointed-relieved" data-value="[disappointed-relieved]"> 
<img class="emoticons" src="assets/img/emoticons/Dizzy.png" id="dizzy" data-value="[dizzy]"> 
<img class="emoticons" src="assets/img/emoticons/Emoji.png" id="emoji" data-value="[emoji]"> 
<img class="emoticons" src="assets/img/emoticons/Expressionless.png" id="expressionless" data-value="[expressionless]"> 
<img class="emoticons" src="assets/img/emoticons/Eyes.png" id="eyes" data-value="[eyes]"> 
<img class="emoticons" src="assets/img/emoticons/Face-with-Cold.png" id="face-with-cold" data-value="[face-with-cold]"> 
<img class="emoticons" src="assets/img/emoticons/Fearful.png" id="fearful" data-value="[fearful]"> 
<img class="emoticons" src="assets/img/emoticons/Fire.png" id="fire" data-value="[fire]"> 
<img class="emoticons" src="assets/img/emoticons/Flushed.png" id="flushed" data-value="[flushed]"> 
<img class="emoticons" src="assets/img/emoticons/Frowning.png" id="frowning" data-value="[frowning]"> 
<img class="emoticons" src="assets/img/emoticons/Ghost.png" id="ghost" data-value="[ghost]"> 
<img class="emoticons" src="assets/img/emoticons/Grinmacing.png" id="grinmacing" data-value="[grinmacing]"> 
<img class="emoticons" src="assets/img/emoticons/Grinning.png" id="grinning" data-value="[grinning]"> 
<img class="emoticons" src="assets/img/emoticons/Halo.png" id="halo" data-value="[halo]"> 
<img class="emoticons" src="assets/img/emoticons/Head-Bandage.png" id="head-bandage" data-value="[head-bandage]"> 
<img class="emoticons" src="assets/img/emoticons/Heart-Eyes.png" id="heart-eyes" data-value="[heart-eyes]"> 
<img class="emoticons" src="assets/img/emoticons/Hugging.png" id="hugging" data-value="[hugging]"> 
<img class="emoticons" src="assets/img/emoticons/Hungry.png" id="hungry" data-value="[hungry]"> 
<img class="emoticons" src="assets/img/emoticons/Hushed.png" id="hushed" data-value="[hushed]"> 
<img class="emoticons" src="assets/img/emoticons/Kiss-Emoji.png" id="kiss-emoji" data-value="[kiss-emoji]"> 
<img class="emoticons" src="assets/img/emoticons/Kissing.png" id="kissing" data-value="[kissing]"> 
<img class="emoticons" src="assets/img/emoticons/Kissing-Face.png" id="kissing-face" data-value="[kissing-face]"> 
<img class="emoticons" src="assets/img/emoticons/Loudly-Crying.png" id="loudly-crying" data-value="[loudly-crying]"> 
<img class="emoticons" src="assets/img/emoticons/Money-Face.png" id="money-face" data-value="[money-face]"> 
<img class="emoticons" src="assets/img/emoticons/Nerd.png" id="nerd" data-value="[nerd]"> 
<img class="emoticons" src="assets/img/emoticons/Neutral.png" id="neutral" data-value="[neutral]"> 
<img class="emoticons" src="assets/img/emoticons/Relieved.png" id="relieved" data-value="[relieved]"> 
<img class="emoticons" src="assets/img/emoticons/Rolling-Eyes.png" id="rolling-eyes" data-value="[rolling-eyes]"> 
<img class="emoticons" src="assets/img/emoticons/Shyly.png" id="shyly" data-value="[shyly]"> 
<img class="emoticons" src="assets/img/emoticons/Sick.png" id="sick" data-value="[sick]"> 
<img class="emoticons" src="assets/img/emoticons/Sign.png" id="sign" data-value="[sign]"> 
<img class="emoticons" src="assets/img/emoticons/Sleeping.png" id="sleeping" data-value="[sleeping]"> 
<img class="emoticons" src="assets/img/emoticons/Sleeping-Snoring.png" id="sleeping-snoring" data-value="[sleeping-snoring]"> 
<img class="emoticons" src="assets/img/emoticons/Slightly.png" id="slightly" data-value="[slightly]"> 
<img class="emoticons" src="assets/img/emoticons/Smiling-Devil.png" id="smiling-devil" data-value="[smiling-devil]"> 
<img class="emoticons" src="assets/img/emoticons/Smiling-Eyes.png" id="smiling-eyes" data-value="[smiling-eyes]"> 
<img class="emoticons" src="assets/img/emoticons/Smiling-Face.png" id="smiling-face" data-value="[smiling-face]"> 
<img class="emoticons" src="assets/img/emoticons/Smiling-Smiling.png" id="smiling-smiling" data-value="[smiling-smiling]"> 
<img class="emoticons" src="assets/img/emoticons/Smirk.png" id="smirk" data-value="[smirk]"> 
<img class="emoticons" src="assets/img/emoticons/Sunglasses.png" id="sunglasses" data-value="[sunglasses]"> 
<img class="emoticons" src="assets/img/emoticons/Surprised.png" id="surprised" data-value="[surprised]"> 
<img class="emoticons" src="assets/img/emoticons/Sweat.png" id="sweat" data-value="[sweat]"> 
<img class="emoticons" src="assets/img/emoticons/Tears.png" id="tears" data-value="[tears]"> 
<img class="emoticons" src="assets/img/emoticons/Thermometer.png" id="thermometer" data-value="[thermometer]"> 
<img class="emoticons" src="assets/img/emoticons/Thinking.png" id="thinking" data-value="[thinking]"> 
<img class="emoticons" src="assets/img/emoticons/Thumbs-Up.png" id="thumbs-up" data-value="[thumbs-up]"> 
<img class="emoticons" src="assets/img/emoticons/Tightly.png" id="tightly" data-value="[tightly]"> 
<img class="emoticons" src="assets/img/emoticons/Tired.png" id="tired" data-value="[tired]">  
<img class="emoticons" src="assets/img/emoticons/Tongue-Out-Tightly.png" id="tongue-out-tightly" data-value="[tongue-out-tightly]"> 
<img class="emoticons" src="assets/img/emoticons/Tongue-Out.png" id="tongue-out" data-value="[tongue-out]"> 
<img class="emoticons" src="assets/img/emoticons/Tongue-Winking.png" id="tongue-winking" data-value="[tongue-winking]"> 
<img class="emoticons" src="assets/img/emoticons/Unamused.png" id="unamused" data-value="[unamused]"> 
<img class="emoticons" src="assets/img/emoticons/Up-Pointing.png" id="up-pointing" data-value="[up-pointing]"> 
<img class="emoticons" src="assets/img/emoticons/Upside.png" id="upside" data-value="[upside]"> 
<img class="emoticons" src="assets/img/emoticons/Very-Angry.png" id="very-angry" data-value="[very-angry]"> 
<img class="emoticons" src="assets/img/emoticons/Very-Mad.png" id="very-mad" data-value="[very-mad]"> 
<img class="emoticons" src="assets/img/emoticons/Very-sad.png" id="very-sad" data-value="[very-sad]"> 
<img class="emoticons" src="assets/img/emoticons/Victory.png" id="victory" data-value="[victory]"> 
<img class="emoticons" src="assets/img/emoticons/Weary.png" id="weary" data-value="[weary]"> 
<img class="emoticons" src="assets/img/emoticons/Wink.png" id="wink" data-value="[wink]"> 
<img class="emoticons" src="assets/img/emoticons/Worried.png" id="worried" data-value="[worried]"> 
<img class="emoticons" src="assets/img/emoticons/Zipper.png" id="zipper" data-value="[zipper]"> 
</div>
<?php include('templates/footer.php'); ?>