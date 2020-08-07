<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Real time Chat file  //////////////////////////
*/
	$i = 0;
	global $user_id;
	if($_POST['user_pro_id']){
	$pro_ID = $_POST['user_pro_id'];
	} else {
	$pro_ID = 0;	
	}
	if(isset($lastid)) { } else { $lastid = 0; }

	if($lastid == '' || $lastid == 0)
	{
		$lastid = 0; // for pagination
	}

	$limit_clause = ' ORDER BY id DESC LIMIT '.$db1->escape($lastid).','.$perpage;

	$messages = array_reverse($msg->get_messages($user_id, $pro_ID, $limit_clause));
	
	if(is_array($messages)) 
	{ 
		$total = $msg->count_($msg->get_messages($user_id, $pro_ID));
		$current = $msg->count_($messages); 
	} else { 
		$total = 0; 
		$current = 0;
	}
if(!isset($load_more)) { ?> 
<div class="active-message top-msg-box">
    <div class="media">
    	<?php
			$query = $db1->query("SELECT filename FROM profile_pics WHERE fkUserId = '$user_id'");
															
			$row = $db1->fetch_row($query);
			
			$result = $row['filename'];
			if ($result !="" || $result !=NULL){?>
                    <img src="<?php echo $url; ?>includes/timthumb.php?src=<?php echo $url; ?>uploads/profile-pics/<?php echo $result; ?>&h=50$w=50" width="50" height="50" alt="User">
                    <?php } else{?>
						<img src="<?php echo $url; ?>includes/timthumb.php?src=<?php echo $url; ?>assets/images/upload-img.jpg&h=50$w=50" width="50" height="50" alt="User">
					<?php }?>
        <div class="media-body innerBox-topbottom innerBox-right">
            <h4 class="pull-left strong no-margin">
				<?php echo $msg->return_display_name($user_id); ?>
            	<br />
                <span id="last-seen">
					<?php 
						$last_seen = $msg->last_seen($user_id);
						if($last_seen !== false && $last_seen != 0)
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
			if($pro_ID != 0){ ?>
			<div class="mobilesmenu"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></div> 
			<div class="buttons-cont">
			<a class="skypebtn" href="skype:<?php echo $Usersdetails->skype_id; ?>?call"><i class="fa fa-skype" aria-hidden="true"></i> <span><?php echo $lang['Call']; ?></span></a> 
			<a href="#" data-toggle="modal" data-target="#overview" class="outine"><?php echo $lang['overview ']; ?></a>
			<?php 
			$accountsta = $_SESSION['accountStatus'];
			if($accountsta == 2){ ?>
			<a href="<?php echo $url; ?>client/payments.php?projectId=<?php echo $pro_ID; ?>&clientId=" class="blue"><?php echo $lang['Make Payment']; ?></a>
			<?php }
if($accountsta == 1){
?> 
<a href="<?php echo $url; ?>admin/payments.php?projectId=<?php echo $pro_ID; ?>" class="blue"><?php echo $lang['Milestone']; ?></a>
<?php } ?>
			</div>
			<?php } else {
			?>
<div class="mobilesmenu"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></div> 
			<div class="buttons-cont">
			<a class="skypebtn" href="skype:<?php echo $Usersdetails->skype_id; ?>?call"><i class="fa fa-skype" aria-hidden="true"></i> <span><?php echo $lang['Call']; ?></span></a> 
			</div>
			<?php }?>
        </div>
    </div>
</div>
<?php
 }
$more = $lastid + 1;
if($more == 1)
{
	$account = $total - $perpage;
} else {
	$account = $countVal - $perpage;	
}
if($account > 0)
{
	if($total > $current && $total !== $more)
	{
		echo '<div id="more'.$lastid.'" class="more-messages-parent bg-gray innerBox innerBox-half text-center margin-none border-top border-bottom">';
			echo '<a href="#" class="load-more-messages text-muted" id="'.$lastid.'" rel="'.$user_id.'">View older messsages (<span id="count-old-messages">'.$account.'</span>)</a>';
		echo '</div>';
	}
}
?>
<?php if(!isset($load_more)) { ?>
<div class="border-top" id="text-messages">
<?php } ?>
	
    <?php 
	if($messages !== false) { ?>
    	
        <?php foreach($messages as $message) {  
			
				if($i > 0) { $class = ' border-top'; }
				if($message['user_id'] == $msg->logged_user_id)
				{
					$chat_name = 'You';
				} else {
					$chat_name = $msg->return_display_name($message['user_id']);	
				}
					if($message['status'] == 'unread')
					{
						 $msg->update_message_status($message['id'], $user_id, $pro_ID);	
					}

			?>
            <div class="media innerBox msg-div <?php if($chat_name=="You"){echo 'online_user';}else{echo 'other_user';}?>" id="u_msg<?php echo $message['id']; ?>">
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
                                <div class="float-left" style="display: none;">
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
				<?php if($chat_name=="You"){ ?>
                        <span class="time-box  float-right innerBox-right hidden-xs text-muted"> <?php echo $msg->format_date_default($message['time']); ?></span>
				<?php } ?>
				<?php if($chat_name !="You"){ ?>
                        <span class="time-box float-left innerBox-right hidden-xs text-muted"> <?php echo $msg->format_date_default($message['time']); ?></span>
				<?php } ?>
                    </div>
                </div>
                </div>
            </div>
        </div>
            
        <?php $i++; } ?>
        
    <?php } else { ?>
    	<p class="innerBox border-top no-messages"><?php echo $lang['No Messages']; ?></p>
    <?php } ?>
 
<?php if(!isset($load_more)) { ?>    
</div>
<?php } ?>
<?php if(!isset($load_more)) { ?> 
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
    <textarea class="type-a-message-box form-control border-none" id="<?php echo $user_id; ?>" data-project="<?php echo $pro_ID ?>" placeholder="<?php echo $lang['Write a message']; ?>"></textarea>
</div>
<?php } ?>

<script>

$(document).ready( function(){
var msgwrapHeight = $(".messageWrapper").height();
var typeHeight = $("#type").height();
var totalHeight = (msgwrapHeight - typeHeight) - 136;
$("#text-messages-request").height(totalHeight);
var winHeight = $(window).height();
	var winWidth = $(window).width();
	if(winWidth <= 767){
var typeHeight = $("#type.border-top").height(), WindowHeight = $(window).height(), totalHeight = (WindowHeight - typeHeight) - 72;
$("div#text-messages-request").height(totalHeight);
	}
});
</script>
