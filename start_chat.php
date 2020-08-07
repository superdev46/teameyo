<?php
 date_default_timezone_set($time_zone);
if($_POST['user_pro_id']){
	$user_pro_id = $_POST['user_pro_id']; 
} else {
	$user_pro_id = 0;
}
	$message = $msg->get_the_last_message($user_id, $user_pro_id, "DO_NOT_TRUNCATE");
	
?>
<div class="active-message top-msg-box">
    <div class="media">
<?php
			$query = $db1->query("SELECT filename FROM profile_pics WHERE fkUserId = '$user_id'");
															
			$row = $db1->fetch_row($query);
			
			$result = $row['filename'];
			if ($result !="" || $result !=NULL){?>
                    <img src="<?php echo $url; ?>includes/timthumb.php?src=<?php echo $url; ?>uploads/profile-pics/<?php echo $result; ?>&h=50$w=50" width="50" height="50" alt="User">
                    <?php } else{?>
						<img src="assets/images/upload-img.jpg" width="50" height="50" alt="User">
					<?php }?>
        <div class="media-body innerBox-topbottom innerBox-right">
            <h4 class="pull-left strong no-margin">
				<?php echo $msg->return_display_name($user_id); ?>
                <br />
                <span id="last-seen">
					<?php 
						$last_seen = $msg->last_seen($user_id);
						if($last_seen !== false || $last_seen != 0)
						{
							echo $msg->calculate_last_seen($last_seen, $user_id);
						}
						
					?>
					
                    <?php
							if($msg->get_user_session_status($user_id) == 'online')
							{
								echo '<span class="online-indicator"></span>';	
							} else{
								 echo '<span class="offline-indicator"></span>';	
							}
						?>
                </span>
            </h4>
<?php 
$Usersdetails=user::findById($user_id);
if($user_pro_id != 0){ ?>
<div class="mobilesmenu"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></div> 
			<div class="buttons-cont">
			<a class="skypebtn" href="skype:<?php echo $Usersdetails->skype_id; ?>?call"><i class="fa fa-skype" aria-hidden="true"></i> <span><?php echo $lang['Call']; ?></span></a> 
			<a href="#" data-toggle="modal" data-target="#overview" class="outine"><?php echo $lang['overview ']; ?></a>
			<?php 
			$accountsta = $_SESSION['accountStatus'];
			if($accountsta == 2){ ?>
			<a href="<?php echo $url; ?>client/payments.php?projectId=<?php echo $user_pro_id; ?>&clientId=" class="blue"><?php echo $lang['Make Payment']; ?></a>
			<?php }
if($accountsta == 1){
?> 
<a href="<?php echo $url; ?>admin/payments.php?projectId=<?php echo $user_pro_id; ?>" class="blue"><?php echo $lang['Milestone']; ?></a>
<?php } ?>
			</div>
			<?php } else{ ?>
<div class="mobilesmenu"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></div> 
			<div class="buttons-cont">
			<a class="skypebtn" href="skype:<?php echo $Usersdetails->skype_id; ?>?call"><i class="fa fa-skype" aria-hidden="true"></i> <span><?php echo $lang['Call']; ?></span></a> 
			</div>
			<?php } ?>
        </div>
    </div>
</div>
<div class="border-top" id="text-messages">
<?php if($message == false) { ?>
<p class="innerBox border-top no-messages"><?php echo $lang['No messages']; ?></p>
<?php } ?>
</div>
<div class="active-message bottom-text-box">
    <div class="media">
        <div class="media-body innerBox-topbottom innerBox-right">
            <div class="innerBox-top innerBox-half float-right message-btn-target">
            <a href="#type" class="btn btn-default btn-sm" id="type-a-message">
                <i class="fa fa-paper-plane" aria-hidden="true"></i>
            </a>
            </div>
        </div>
    </div>
</div>
<div id="type" class="border-top">
	<div id="chat-toolbar">
    	<a id="emoticons" href="#"><i class="fa fa-smile-o" aria-hidden="true"></i></a>
        <a id="send-photo" href="#"><i class="fa fa-picture-o" aria-hidden="true"></i></a>
        <a id="send-file" class="float-right" href="#"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
        <div class="clearfix"></div>
    </div>
    <textarea class="form-control border-none type-a-message-box" id="<?php echo $user_id; ?>" data-project="<?php echo $user_pro_id ?>" placeholder="<?php echo $lang['Write a message']; ?>"></textarea> 
</div>