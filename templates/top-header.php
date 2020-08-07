<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Main Top Header Bar //////////////////////////
*/
include('../includes/loader.php'); 
$profilePictureObj=profilePicture::findByfkUserId($session->userId);

if($profilePictureObj){
	foreach($profilePictureObj as $displayPicture)
	{
	 $profilePic=$displayPicture->filename;
	}
}
$id=$session->userId;
$userb = User::findById((int)$session->userId);
if(isset($_POST['user_language']))
	{ 
		$user = user::findById($id); 
		
		$flag=0;
		if($flag==0)
		{
			$user->id = $id;
			$user->user_language = $_POST['user_language'];
			$saveUser=$user->save();
				if($saveUser)
				{
					$uri = $_SERVER['REQUEST_URI'];
					header("Location: ".$uri);
				} else{
					// echo 'Error While Update Language! Please Try again Later';
				}
		}
	} 
?>
	<div class="row message-tbar">
	<div class="col-lg-9 col-md-8 msg-lft">
	<div class="mobile-menu"><i class="fa fa-bars" aria-hidden="true"></i>
	<?php if($mobile_logo){ ?>
    	<img src="<?php echo $url.$img_path.$mobile_logo; ?>" class="img-fluid"/>
	<?php } else { ?>
		<img src="<?php echo $url;?>images/users/teameyo-mobile-logo.png" class="img-fluid"/>
	<?php }?>
	</div>
	<div class="msg-date"><?php $dt = new DateTime();
echo $dt->format('l, F j, Y');?>
<form class="language-form" action="#" method="post">
<div class="language-selecter">
<i class="fa fa-globe" aria-hidden="true"></i>
<ul>
<li class="<?php if($userb->user_language == 'en'){echo 'active';}?>" data-value="en">English</li>
<li class="<?php if($userb->user_language == 'fr'){echo 'active';}?>" data-value="fr">French</li>
<li class="<?php if($userb->user_language == 'it'){echo 'active';}?>" data-value="it">Italian</li>
<li class="<?php if($userb->user_language == 'sp'){echo 'active';}?>" data-value="sp">Spanish</li>
</ul>
</div>
<input type="hidden" class="user_language" name="user_language" value="" />
</form>
	</div>
	<?php 
	$invoice_budget = milestone::findBySql("SELECT budget FROM milestones WHERE status = '1'");
	$fbudget = 0;
				foreach($invoice_budget as $budget){
					$fbudget+= $budget->budget;	
				}
	?>
	<div class="msg-icons"><div class="msg-icon-img">
	<i class="fa fa-envelope-o" aria-hidden="true"></i>
	<span><?php 
	$format = '%s';
$unmsg = $msg->total_unread_messages($format);
if($unmsg){
echo $unmsg;
} else {
echo '0';	
}
	?></span>
	<div class="msg-menu">
	<div class="msg-menuww">
	<i class="fa fa-caret-up"></i>
	<h4><?php echo $lang['New Messages']; ?></h4>
	<div class="unread-scroll">
	<ul>
<?php 
global $msg;
$unread_msgs = $msg->get_unread_messages();

if(empty($unread_msgs)){ ?>
	<li><?php echo $lang['No unread Meassages']; ?></li>
<?php } else {
	foreach($unread_msgs as $unread_msg){
	// print_r($unread_msg);
	$unread_uid = $unread_msg['user_id'];
	$unread_umsg = $unread_msg['message'];
	$Project_id = $unread_msg['Project_id'];
	$unread_time = $unread_msg['time'];
	$query = $db1->query("SELECT filename FROM profile_pics WHERE fkUserId = '$unread_uid'");
															
			$row = $db1->fetch_row($query);
			
			$result = $row['filename'];
							$query2 = $db1->query("SELECT *  FROM users WHERE id='$unread_uid'");								
							$row2 = $db1->fetch_row($query2);
							$result2 = $row2['accountStatus'];

if($row2['firstName']){ ?>
<li>
<form action="<?php echo $url; ?>messages.php?project_id=<?php echo $Project_id; ?>" method="post">
<input type="hidden" name="user_id" value="<?php echo $unread_uid; ?>" />
<?php if($Project_id != 0){?>
<input type="hidden" name="project_id" value="<?php echo $Project_id; ?>" />
<?php } else { ?>
<input type="hidden" name="project_id" />
<?php } ?>
<button name="chat" type="submit">
	<div class="mbox-img">
<?php if ($result !="" || $result !=NULL){?>
                    <img src="<?php echo $url; ?>includes/timthumb.php?src=<?php echo $url;?>uploads/profile-pics/<?php echo $result; ?>&h=40$w=40" width="40" class="img-fluid rounded-circle" alt="User">
<?php } else{?>
						<img src="<?php echo $url; ?>includes/timthumb.php?src=<?php echo $url;?>assets/images/upload-img.jpg&h=40$w=40" width="40" class="img-fluid rounded-circle" alt="User">
<?php } ?>
	
	</div>
	<div class="mbox-txt">
	<div class="mbox-txt-name"><?php echo $row2['firstName'];
							if($msg->get_user_session_status($unread_uid) == 'online')
							{
								echo '<span class="online-indicator"></span>';	
							} else{
								 echo '<span class="offline-indicator"></span>';	
							}
		$pro_title = projects::findBySql("select * from projects where p_id='$Project_id'");
		if($pro_title[0] != '' ){
	echo ' <span class="prottl">Project Title: ' . $pro_title[0]->project_title . '</span>';
		}
	?>
	</div>
	<div class="mbox-txt-msg">
	<?php 
	$unreadmsg = substr($unread_umsg, 0, 30);
	$chattext = str_replace('\n\n', ' ', $unreadmsg);
	echo $chattext;?>
	</div>
	</div>
	<div class="mbox-info">
	
	<?php 
	if($result2==1){
		?><div class="mbox-info-tag admin-badge"><?php echo $lang['Admin']; ?></div><?php
		}elseif($result2==2){ 
		?><div class="mbox-info-tag client-badge"><?php echo $lang['Client']; ?></div><?php 
		}elseif($result2==3){ 
		?><div class="mbox-info-tag staff-badge"><?php echo $lang['Staff']; ?></div>
	<?php } ?>
	<div class="mbox-info-time"><?php echo date("g:iA", $unread_time); ?></div>
	<span class="mbox-info-sec" style="display:none;"><?php echo date("g:i:s", $unread_time); ?></span>
	</div>
</button>
</form>
	</li>
<?php }
} 
}
?>
	</ul>
	</div>
	</div>
	</div>
	</div>
	<?php $accountStatus = $_SESSION['accountStatus']; 
	if($accountStatus == 1){ ?>
	<div class="msg-icon-price" data-toggle="tooltip" data-placement="bottom" title="Total Earnings"><?php echo $currency_symbol . number_format($fbudget);?></div>

	<?php } elseif($accountStatus == 2){
		$sessionIdcli = $session->userId;
		$projects_allb = projects::findBySql("SELECT * FROM projects WHERE c_id = '$sessionIdcli'");
		$project_idb = array();
foreach($projects_allb as $allpros){
	$project_p_id = $allpros->p_id;
	$project_idb[] = $project_p_id;
}
$paid_miles = 0;
foreach($project_idb as $projectsb){
	// print_r($projects);
$projectMileb=milestone::findBySql("select * from milestones where p_id='$projectsb'");
foreach($projectMileb as $milesb){
 if($milesb->status == 1){
	 $paid_milesb += $milesb->budget;
	 }
}
}
if($paid_milesb == ""){
	$paidmiles = 0;
} else{
	$paidmiles = $paid_milesb;
}
?>
<div class="msg-icon-price" data-toggle="tooltip" data-placement="bottom" title="Paid milestone"><?php echo $currency_symbol . $paidmiles;?></div>
<?php }  else{} ?>
	
	</div>
	</div>
	<?php 
	if( active('index.php')){
	if($accountStatus == 1){  ?>
		<div class="mobile-mils"><?php echo $lang['Total Earnings']; ?>: <?php echo $currency_symbol . $fbudget;?></div>
	<?php } elseif($accountStatus == 2){ ?>
	<div class="mobile-mils"><?php echo $lang['Paid Milestone']; ?>: <?php echo $currency_symbol . $paidmiles;?></div>
	<?php } else{} 
	}
	?>
	<div class="col-lg-3 col-md-4 msg-rt">
	<div class="msr-wrapc">
	<div class="msg-welcome"><span><?php echo $lang['WELCOME']; ?></span><br><?php 
	if(isset($username)){
	echo $username;
	}	?></div><div class="msg-img">
<?php if(isset($profilePic)){ ?>
                
                <img src="<?php echo $url; ?>includes/timthumb.php?src=<?php echo $url; ?>uploads/profile-pics/<?php echo $profilePic;?>&h=50$w=50" class="img-fluid rounded-circle" alt="Profile Picture"/>
                <?php } else { ?>
                    
                        <img src="<?php echo $url; ?>includes/timthumb.php?src=<?php echo $url; ?>assets/images/upload-img.jpg&h=50$w=50" class="img-fluid rounded-circle"/>
                    <?php 
                } ?>
	<i class="fa fa-caret-down"></i></div>
	<div class="logout-menu">
	<div class="logout-menuwrap">
	<i class="fa fa-caret-up"></i>
	<ul>
	<li><a href="<?php echo $url; ?>admin/edit-profile.php"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $lang['Edit Profile']; ?></a></li>
	<li><a href="<?php echo $url; ?>logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> <?php echo $lang['Logout']; ?></a></li>
	</ul>
	</div>
	</div>
	</div>
	</div>
	</div> 