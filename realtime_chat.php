<?php 
if($message['user_id'] == $msg->logged_user_id)
				{
					$chat_name = 'You';
				} else {
					$chat_name = $msg->return_display_name($message['user_id']);	
				}
				
				?>
<div class="media innerBox msg-div <?php if($chat_name=="You"){echo 'online_user';}else{echo 'other_user';}?>" id="u_msg<?php echo $message['id']; ?>" id="u_msg<?php echo $message['id']; ?>">
<div class="media-body">
    <div class="container"> 
    <div class="row">
	        
        <div class="col-sm-12 media-box-a">
        	<?php
			$recv_id=$message['user_id'];
			$query1 = $db1->query("SELECT filename FROM profile_pics WHERE fkUserId = '$recv_id'");
															
			$row1 = $db1->fetch_row($query1);
			
			$result1 = $row1['filename'];
			if ($result1 !="" || $result1 !=NULL){?>
                    <img src="<?php echo $url; ?>includes/timthumb.php?src=<?php echo $url; ?>uploads/profile-pics/<?php echo $result1; ?>&h=50$w=50" width="50" height="50" alt="User">
                    <?php } else{?>
						<img src="<?php echo $url; ?>includes/timthumb.php?src=<?php echo $url; ?>assets/images/upload-img.jpg&h=50$w=50" width="50" height="50" alt="User">
					<?php }?>
            <div class="chat-style">
                <div class="media">
                    <div class="float-left" style="display: none">
                        <span class="innerBox-right text-muted visible-xs"><?php echo $msg->format_date_default($message['time']); ?> </span>
                    </div>
                    <div class="media-body">
					<?php if($chat_name != 'You'){ ?>
                        <h3><?php echo $chat_name; ?>
						</h3>
					<?php } ?>
                        <?php echo $msg->read_messages($message['message']); ?>
                    </div>
                </div>
            </div>	
<span class="time-box float-left innerBox-right text-muted hidden-xs"> <?php echo $msg->format_date_default($message['time']); ?></span>
        </div>
    </div>
    </div>
</div>
</div>