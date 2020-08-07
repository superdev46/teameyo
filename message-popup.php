<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Message Popup  //////////////////////////
*/
include('includes/loader.php'); 
require_once("includes/initialize.php");
date_default_timezone_set($time_zone);
	if(isset($_POST['message_page']) && $_POST['message_page'] == 'whole_page'){
$unread_msgs = $msg->get_unread_messages();
if(empty($unread_msgs)){ ?>
	<li><?php echo $lang['No unread Meassages']; ?></li>
<?php } else {
	foreach($unread_msgs as $unread_msg){
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

if($row2['firstName']){
	?>
<li>
<form action="<?php echo $url;?>messages.php?project_id=<?php echo $Project_id; ?>" method="post">
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
	<div class="mbox-txt-name"><?php echo $row2['firstName']; ?>
	<?php
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
	<div class="mbox-txt-msg"><?php 
	$unreadmsg = substr($unread_umsg, 0, 30);
	// echo nl2br($unreadmsg); 
$chattext = str_replace('\\n', ' ', $unreadmsg);
	echo $chattext;
	?></div>
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

	}
?>