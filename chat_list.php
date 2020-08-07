<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Real time Chat Contacts and Recent chat Contacts //////////////////////////
*/
if(isset($init_load))
	{
		$i = 0;
	
		if(isset($lastid) || isset($lastid) == '' || isset($lastid) == 0)
		{
			$lastid = 0; // for pagination
		}
if(isset($_GET['project_id'])){
$project_id = $_GET['project_id'];
}
if(isset($_POST['project_idb'])){
$proval_b =  $_POST['project_idb'];
if($proval_b != ""){
$project_id = $proval_b;	
}
}
if($project_id  == 0 ){
	/* For Team Chat List */
	$limit_clause = ' ORDER BY id DESC LIMIT '.$db1->escape($lastid).','.$contacts_per_page;
	$friends = user::findBySql("SELECT * FROM users ORDER BY accountStatus");
	$project_id = 0;
	
if(!isset($load_more)) {
echo '<ul class="list-unstyled p0" id="messages-stack-list" data-proval="'.$project_id.'">';
}

foreach($friends as $friend){
			$status = $friend->accountStatus;
			$currentUser = $msg->logged_user_id;
			$friend_id = $friend->id;
			$query = $db1->query("SELECT filename FROM profile_pics WHERE fkUserId = '$friend_id'");
			$row = $db1->fetch_row($query);
			$result = $row['filename'];
			$allunreadmsg = message::findBySql("select * from messages where user_id = '$friend_id' and receiver = '$currentUser' and Project_id = '$project_id' and status = 'unread'");
			$msgcount = count($allunreadmsg);

		if($status != 2 && $currentUser != $friend_id){ 
		
		if($friend_id == NULL || $friend_id == ""){ 
		?>
			<li class="border-bottom" id="no_chat_users_found"><p class="innerBox">No users found</p></li>
		<?php } 
$chattext = $msg->get_the_last_message($friend_id, $project_id);
		if(isset($chat_tab)){
			if($chattext != ''){
		?>
<li class="prepare-message border-bottom" id="<?php echo $friend_id;?>" data-project="<?php echo $project_id;?>">
  <div class="media innerBox">
            <div class="media-object float-left hidden-phone">
                <a href="#">
                <?php if ($result !="" || $result !=NULL){?>
                    <img src="<?php echo $url; ?>includes/timthumb.php?src=<?php echo $url; ?>uploads/profile-pics/<?php echo $result; ?>&h=50$w=50" width="50" height="50" alt="User">
                    <?php } else{?>
						<img src="<?php echo $url; ?>includes/timthumb.php?src=<?php echo $url; ?>assets/images/upload-img.jpg&h=50$w=50" width="50" height="50" alt="User">
					<?php }?>
                </a>
                <div id="unreader-counter-<?php echo $friend_id;?>">
				<?php if($msgcount != 0){echo '<span class="label label-warning">'.$msgcount.'</span>';} ?>
				</div> 
            </div>
<div class="media-body">
                <div>
                	<span class="strong"><?php echo $friend->firstName ?></span> 
                    <div class="float-right">
                    	<?php
							if($msg->get_user_session_status($friend_id) == 'online')
							{
								echo '<span class="online-indicator"></span>';	
							} else{
								 echo '<span class="offline-indicator"></span>';	
							}
						?>
                        <?php
							
							if($status==1){?>
                             <span class="admin-badge"><?php echo $lang['Admin']; ?></span>
                            <?php
							}elseif($status==2){ ?>
                            <span class="client-badge"><?php echo $lang['Client']; ?></span>
                            <?php
							}elseif($status==3){ ?>
                            <span class="staff-badge"><?php echo $lang['Staff']; ?></span>
                            <?php
							} 
						?>
                    </div>
                    <i><?php echo $friend->title; ?></i>
                    
                	
                </div>
                <div id="type-status-<?php echo $friend_id; ?>"></div>
                
                <?php
					if(isset($chat_tab))
					{
$chattext = $msg->get_the_last_message($friend_id, $project_id);
						$chattext = str_replace('\n\n', ' ', $chattext);
						$chattextb = str_replace('\n', ' ', $chattext);
						
						echo '<p>'.$chattextb.'</p>';
					}
				?>
                
            </div>
</div>
    </li>
			<?php }
			} else{ ?>
<li class="prepare-message border-bottom" id="<?php echo $friend_id;?>" data-project="<?php echo $project_id;?>">
  <div class="media innerBox">
            <div class="media-object float-left hidden-phone">
                <a href="#">
                <?php if ($result !="" || $result !=NULL){?>
                    <img src="<?php echo $url; ?>includes/timthumb.php?src=<?php echo $url; ?>uploads/profile-pics/<?php echo $result; ?>&h=50$w=50" width="50" height="50" alt="User">
                    <?php } else{?>
						<img src="<?php echo $url; ?>includes/timthumb.php?src=<?php echo $url; ?>assets/images/upload-img.jpg&h=50$w=50" width="50" height="50" alt="User">
					<?php }?>
                </a>
                <div id="unreader-counter-<?php echo $friend_id;?>">
				<?php if($msgcount != 0){echo '<span class="label label-warning">'.$msgcount.'</span>';} ?>
				</div> 
            </div>
<div class="media-body">
                <div>
                	<span class="strong"><?php echo $friend->firstName ?></span> 
                    <div class="float-right">
                    	<?php
							if($msg->get_user_session_status($friend_id) == 'online')
							{
								echo '<span class="online-indicator"></span>';	
							} else{
								 echo '<span class="offline-indicator"></span>';	
							}
						?>
                        <?php
							
							if($status==1){?>
                             <span class="admin-badge"><?php echo $lang['Admin']; ?></span>
                            <?php
							}elseif($status==2){ ?>
                            <span class="client-badge"><?php echo $lang['Client']; ?></span>
                            <?php
							}elseif($status==3){ ?>
                            <span class="staff-badge"><?php echo $lang['Staff']; ?></span>
                            <?php
							} 
						?>
                    </div>
                    <i><?php echo $friend->title; ?></i>
                    
                	
                </div>
                <div id="type-status-<?php echo $friend_id; ?>"></div>
                
                <?php
					if(isset($chat_tab))
					{
$chattext = $msg->get_the_last_message($friend_id, $project_id);
						$chattext = str_replace('\n\n', ' ', $chattext);
						$chattextb = str_replace('\n', ' ', $chattext);
						
						echo '<p>'.$chattextb.'</p>';
					}
				?>
                
            </div>
</div>
    </li>
<?php }

}
	}
if(!isset($load_more)) {
echo '</ul>';
} 
	
} else {
	
	/* For Projects Chat List */
	$limit_clause = ' ORDER BY id DESC LIMIT '.$db1->escape($lastid).','.$contacts_per_page;
	$projects_staff = projects::findBySql("SELECT s_ids FROM projects WHERE p_id = '$project_id'");
	$project_memb =  $projects_staff[0]->s_ids;

	$friends = user::findBySql("SELECT * FROM users WHERE FIND_IN_SET(id, '$project_memb') ORDER BY accountStatus");
	
	
if(!isset($load_more)) {
echo '<ul class="list-unstyled p0" id="messages-stack-list" data-proval="'.$project_id.'">';
}
foreach($friends as $friend){
			$status = $friend->accountStatus;
			$currentUser = $msg->logged_user_id;
			$friend_id = $friend->id;
			$query = $db1->query("SELECT filename FROM profile_pics WHERE fkUserId = '$friend_id'");
			$row = $db1->fetch_row($query);
			$result = $row['filename'];
			$allunreadmsg = message::findBySql("select * from messages where user_id = '$friend_id' and receiver = '$currentUser' and Project_id = '$project_id' and status = 'unread'");
			$msgcount = count($allunreadmsg);

		if($currentUser != $friend_id){ 
		if($friend_id == NULL || $friend_id == ""){ 
		?>
			<li class="border-bottom" id="no_chat_users_found"><p class="innerBox"><?php echo $lang['No users found']; ?></p></li>
		<?php }	?>
<li class="prepare-message border-bottom" id="<?php echo $friend_id;?>" data-project="<?php echo $project_id;?>">
  <div class="media innerBox">
            <div class="media-object float-left hidden-phone">
                <a href="#">
                <?php if ($result !="" || $result !=NULL){?>
                    <img src="<?php echo $url; ?>includes/timthumb.php?src=<?php echo $url; ?>uploads/profile-pics/<?php echo $result; ?>&h=50$w=50" width="50" height="50" alt="User">
                    <?php } else{?>
						<img src="<?php echo $url; ?>includes/timthumb.php?src=<?php echo $url; ?>assets/images/upload-img.jpg&h=50$w=50" width="50" height="50" alt="User">
					<?php }?>
                </a>
                <div id="unreader-counter-<?php echo $friend_id;?>">
				<?php if($msgcount != 0){echo '<span class="label label-warning">'.$msgcount.'</span>';} ?>
				</div> 
            </div>
<div class="media-body">
                <div>
                	<span class="strong"><?php echo $friend->firstName ?></span> 
                    <div class="float-right">
                    	<?php
							if($msg->get_user_session_status($friend_id) == 'online')
							{
								echo '<span class="online-indicator"></span>';	
							} else{
								 echo '<span class="offline-indicator"></span>';	
							}
						?>
                        <?php
							
							if($status==1){?>
                             <span class="admin-badge"><?php echo $lang['Admin']; ?></span>
                            <?php
							}elseif($status==2){ ?>
                            <span class="client-badge"><?php echo $lang['Client']; ?></span>
                            <?php
							}elseif($status==3){ ?>
                            <span class="staff-badge"><?php echo $lang['Staff']; ?></span>
                            <?php
							} 
						?>
                    </div>
                    <i><?php echo $friend->title; ?></i>
                    
                	
                </div>
                <div id="type-status-<?php echo $friend_id; ?>"></div>
                
                <?php
					if(isset($chat_tab))
					{
						$chattext = $msg->get_the_last_message($friend_id, $project_id);
						$chattext = str_replace('\n\n', ' ', $chattext);
						$chattextb = str_replace('\n', ' ', $chattext);
						
						echo '<p>'.$chattextb.'</p>';
					}
				?>
                
            </div>
</div>
    </li>
		<?php }
	}
if(!isset($load_more)) {
echo '</ul>';
} 
}

	}