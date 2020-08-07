<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// All Pages Sidebar //////////////////////////
*/
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
$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$accountStatus=$user->accountStatus;

?>
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
        	<li class="<?php echo active('index.php'); ?>"> 
        		<a href="<?php echo $url; ?>admin/index.php"><span><i class="fa fa-tachometer" aria-hidden="true"></i></span><?php echo $lang['Dashboard']; ?><i class="fa fa-chevron-right"></i></a>
        	</li>
            <li class="<?php echo active('clients.php'); echo active('add-client.php'); ?>"> 
            	<a href="#" data-toggle="collapse" data-target="#client-menu">
            		<span><i class="fa fa-user" aria-hidden="true"></i></span><?php echo $lang['Clients']; ?><i class="fa fa-plus" aria-hidden="true"></i>
            	</a>
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
<li class="<?php echo active('paid-invoices.php'); echo active('unpaid-invoices.php'); ?>"> <a href="#" data-toggle="collapse" data-target="#financials-menu"><span><i class="fa fa-university" aria-hidden="true"></i></span><?php echo $lang['Financials']; ?><i class="fa fa-plus" aria-hidden="true"></i></a>
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
            <div class="bigbutton"><a href="<?php echo $url; ?>client/add-new-project.php"><?php echo $lang['Create project']; ?> <span>+</span></a></div>
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