<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Staff Dashboard Page //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php"); 
$title = "Dashboard | ". $syatem_title;
include("../templates/admin-header.php"); 
 if(!($session->isLoggedIn())){
		redirectTo($url."index.php");
	}
if($_SESSION['accountStatus'] == 2){
	redirectTo($url."client/index.php");
}
if($_SESSION['accountStatus'] == 1){
	redirectTo($url."admin/index.php");
} 

//condition check for login

$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$account_stat=$user->status;
$usera = user::findById((int)$session->userId); 
if(isset($_POST['savenote'])){
		$flag=0;
		if($flag==0)
		{
			$usera->id        		=  $session->userId;
				$usera->note		=$_POST['snote'];
				$saveUser=$usera->save();
				if($saveUser)
				{
					header("Location:index.php");
				}
		}
		
}
$projects_completed = projects::findBySql("SELECT * FROM projects WHERE status = 1");
$projects_inprogress = projects::findBySql("SELECT * FROM projects WHERE status = 0");
$projects = projects::findBySql("SELECT * FROM projects WHERE find_in_set($id, s_ids) AND archive=0 AND trash != 1 ORDER BY start_time DESC LIMIT 4");
$countc = 0;
$countip = 0;
?>

    
<div class="page-container">
<div class="container-fluid">
<div class="row row-eq-height">
	<?php  include("../templates/sidebar.php"); ?>
    <div class="page-content col-lg-9 col-md-12 col-sm-12 col-lg-push-3">
<?php include('../templates/top-header.php'); ?>
         <div class="row">
            <div class="col-md-12 margin-top-10 clients">
                <div class="client-dashboard client-dashnew">
				<div class="row">
                	<div class="col-md-7">
<?php 
foreach($projects as $project){
	$project_pid = $project->p_id;
	$project_title = $project->project_title;
	$project_s_ids = $project->s_ids;
	$project_budget = $project->budget;
	$project_deadline = $project->end_time;
	$project_status = $project->status;

	$staffmembs = explode(",",$project_s_ids);
if($project_status == 1){
		$countc++;
} else {
	$countip++;
}
?>
					<div class="cliproject-box">
					<div class="cliproj-head">
					<div class="row">
					<div class="col-md-6 cliproj-heading"><?php echo $project_title; ?></div>
					<div class="col-md-6 cliproj-staff">
<div class="cliprojteam-cont"> 
<?php 
$counter = 0;
foreach($staffmembs as $staffmemb){
 if($staffmemb != 1 && $staffmemb !=  $project->c_id && $staffmemb != 0){
									  $counter++;
									  if($counter > 5){} else {
										  $user2 = user::findById($staffmemb); 
$query = $db->query("SELECT filename FROM profile_pics WHERE fkUserId = '$staffmemb'");
		 $row1 = mysqli_fetch_array($query);
		 $image = $row1['filename'];
								if($image){
									echo '<div class="cliteambox" data-toggle="tooltip" data-placement="top" title="'.$user2->firstName.'"><img src="'.$url.'includes/timthumb.php?src='.$url.'uploads/profile-pics/'.$image.'&h=36$w=36" class="img-fluid" /></div>';
								} else {
									echo '<div class="cliteambox" data-toggle="tooltip" data-placement="top" title="'.$user2->firstName.'"><img src="'.$url.'assets/images/upload-img.jpg" class="img-fluid" /></div>';
								}
								}
 }
	} 
	if($counter > 5){
								  $more = $counter-5;
								   echo '<div class="cliteamboxcount">+'. $more .'</div>'; 
							  }
	?>
					</div>
					<div class="cliproj-shead">
					<?php echo $lang['Your Team']; ?> 
					</div>
					</div>
					</div>
					</div>
					<div class="cliproj-body">
					<div class="row">
					<div class="col-md-3 cliproj-bodybox">
					<div class="cliproj-bhead"><?php echo $lang['Deadline']; ?></div>
					<div class="cliproj-bcont"><?php echo $project_deadline; ?></div>
					</div>
					<div class="col-md-3 cliproj-bodybox">
					<div class="cliproj-bhead"><?php echo $lang['Status']; ?></div>
<div class="cliproj-bcont <?php if($project_status == 0){echo 'inprogress';}else{echo 'completed';}?>"><?php if($project_status == 0){ echo $lang['IN PROGRESS'];} else { echo $lang['COMPLETED'];} ?></div>
					</div>
					<div class="col-md-3 cliproj-bodybox">
		
					</div>
					<div class="col-md-3 cliproj-bodybox">
					<form action="<?php echo $url;?>messages.php?project_id=<?php echo $project_pid; ?>" method="post">
								<input type="hidden" name="user_id" value="<?php echo $id; ?>">
								<input type="hidden" name="project_id" value="<?php echo $project_pid; ?>">
								<button type="submit" class="disbtnbox" name="chat"><i class="fa fa-comments-o visibleontab" aria-hidden="true"></i><span class="visibledesk"><?php echo $lang['Discussion']; ?></span></button>
								</form>
					</div>  
					</div>
					</div>
					</div> 
<?php
}
if($projects == NULL){
  echo '<div class="blankproject">
						  <div class="blankprotxt">
						                  	<div class="row">
						                  	   <div class="col-md-12"><h3>'.$lang['Hi '].$username.'</h3></div>
						                  	    <div class="col-md-12"><h1> '.$lang['Welcome to the'].'<br> '.$company_name. $lang['community!'].'</h1> </div>
						                  	   <div class="col-md-12"><h2>'.$lang['We’re glad you’ve joined us.'].'</h2></div>
						                  	    <div class="col-md-12"><div class="bigbutton blankprofile"><a href="edit-profile.php">'.$lang['Setup Your Profile'].'</a></div>
</div>
						                  	</div>
                         	</div>
						  </div>';
					  } else{ } ?>
					</div> 
                	<div class="col-md-5">
<div class="clidashright staffdash">
					<div class="clidashr-pi  blue-shadow">
					<div class="clidash-pihead"><?php echo $lang['Projects info']; ?></div>
					<div class="clidash-pibod">
					<div class="row">
					<div class="col-md-4 clidash-pibodcont">
					<div class="clidash-pibodconth"><?php echo $lang['Completed']; ?></div>
					<div class="clidash-pibodconn"><?php echo $countc;?></div>
					</div>
					<div class="col-md-4 clidash-pibodcont">
					<div class="clidash-pibodconth"><?php echo $lang['Inprogress']; ?></div>
					<div class="clidash-pibodconn"><?php echo $countip; ?></div>
					</div>
					<div class="col-md-4 clidash-pibodcont">
					<div class="clidash-pibodconth"><?php echo $lang['Total']; ?></div>
					<div class="clidash-pibodconn"><?php echo $countc+$countip;?></div>
					</div>
					</div>
					</div>
					</div>
					</div>
<div class="notepadcs staff-notepad">
<form action="#" method="post">
<h2><?php echo $lang['Sticky Note']; ?> <input name="savenote" type="submit" value="<?php echo $lang['Save Note']; ?>" /></h2>
<textarea name="snote" class="snote" placeholder="<?php echo $lang['Write note Here!']; ?>"><?php echo $user->note;?></textarea>
</form>
</div>
					</div>
                </div>
                </div>
            </div>
        </div>
    </div>
    
	<div class="clearfix"></div>
		
</div>
</div>
</div>
<?php  include("../templates/admin-footer.php"); ?>