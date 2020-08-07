<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Client Dashboard  //////////////////////////
*/
ob_start();

include("../includes/lib-initialize.php"); 
$title = "Dashboard | ". $syatem_title;
include("../templates/admin-header.php"); 
 if(!($session->isLoggedIn())){
		redirectTo($url."index.php");
	}
if($_SESSION['accountStatus'] == 1){
	redirectTo($url."admin/index.php");
}
if($_SESSION['accountStatus'] == 3){
	redirectTo($url."staff/index.php");
} 
//condition check for login
$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$account_stat=$user->status;
$user->regDate;
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

$projects_all = projects::findBySql("SELECT * FROM projects WHERE c_id = '$id'");
$projects = projects::findBySql("SELECT * FROM projects WHERE c_id = '$id' ORDER BY start_time DESC LIMIT 5");
$projects_completed = projects::findBySql("SELECT * FROM projects WHERE c_id = '$id' AND status = 1");
$projects_inprogress = projects::findBySql("SELECT * FROM projects WHERE c_id = '$id' AND status = 0");
// print_r($projects); 
?>

    
<div class="page-container">
<div class="container-fluid">
<div class="row row-eq-height">
	<?php include("../templates/sidebar.php"); ?>
	
    <div class="page-content col-lg-9 col-md-12 col-sm-12 col-lg-push-3">
<?php include('../templates/top-header.php'); ?>
         <div class="row">
            <div class="col-md-12 margin-top-10 clients">
                <div class="client-dashboard client-dashnew">
				<div class="row">
                	<div class="col-md-7">
<?php 

$project_id = array();
foreach($projects_all as $allpros){
	$project_p_id = $allpros->p_id;
	$project_id[] = $project_p_id;
}


foreach($projects as $project){
	$project_pid = $project->p_id;
	$project_title = $project->project_title;
	$project_s_ids = $project->s_ids;
	$project_budget = $project->budget;
	$project_deadline = $project->end_time;
	$project_status = $project->status;
	$staffmembs = explode(",",$project_s_ids);
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
					<div class="cliproj-bhead"><?php echo $lang['Budget']; ?></div>
					<div class="cliproj-bcont"><?php echo $currency_symbol . $project_budget; ?></div>					
					</div>
					<div class="col-md-3 cliproj-bodybox">
					<div class="cliproj-bhead"><?php echo $lang['Deadline']; ?></div>
					<div class="cliproj-bcont"><?php echo $project_deadline; ?></div>
					</div>
					<div class="col-md-3 cliproj-bodybox">
					<div class="cliproj-bhead"><?php echo $lang['Status']; ?></div>
<div class="cliproj-bcont <?php if($project_status == 0){echo $lang['inprogress'];}else{echo 'completed';}?>"><?php if($project_status == 0){ echo  $lang['IN PROGRESS'];} else { echo $lang['COMPLETED'];} ?></div>
					</div>
					<div class="col-md-3 cliproj-bodybox btnaligncls">
					<a href="#" data-toggle="collapse" data-target="#toggleact<?php echo $project_pid;?>" class="btn-action btnnewtab"><?php echo $lang['Action']; ?></a>
					<div id="toggleact<?php echo $project_pid;?>" class="toggle-action collapse">
					<ul>
					<li>
					<form action="<?php echo $url;?>messages.php?project_id=<?php echo $project_pid; ?>" method="post">
								<input type="hidden" name="user_id" value="<?php echo $id; ?>">
								<input type="hidden" name="project_id" value="<?php echo $project_pid; ?>">
								<button type="submit" name="chat"><i class="fa fa-comment-o"></i> <?php echo $lang['Discussion']; ?></button>
								</form>
					</li> 
					<li><a href="<?php echo $url; ?>client/payments.php?projectId=<?php echo $project_pid;?>&clientId=<?php echo $id; ?>"><i class="fa fa-credit-card" aria-hidden="true"></i> <?php echo $lang['Make Payment']; ?></a></li>
					</ul>
					</div>
					</div>  
					</div>
					</div>
					</div> 
<?php } 
// print_r($project_id);
$total_miles = 0;
$paid_miles = 0;
$unpaid_miles = 0;
foreach($project_id as $projects){
	// print_r($projects);
$projectMile=milestone::findBySql("select * from milestones where p_id='$projects'");
foreach($projectMile as $miles){
	 $total_miles += $miles->budget;
	 if($miles->status == 1){
	 $paid_miles += $miles->budget;
	 }else {
	$unpaid_miles += $miles->budget;
	 }
	//  print_r($miles); 

	}
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
					  } else{
?>
<div class="cliviweallpro">
<a href="<?php echo $url; ?>client/projects.php" class="proallbtn"><?php echo $lang['View ALL PROJECTS']; ?></a>
</div>
					  <?php } ?>
					</div> 
                	<div class="col-md-5">
					<div class="clidashright">
					<div class="clidashr-pi">
					<div class="clidash-pihead"><?php echo $lang['Projects info']; ?></div>
					<div class="clidash-pibod">
					<div class="row">
					<div class="col-md-4 clidash-pibodcont">
					<div class="clidash-pibodconth"><?php echo $lang['Completed']; ?></div>
					<div class="clidash-pibodconn"><?php echo count($projects_completed);?></div>
					</div>
					<div class="col-md-4 clidash-pibodcont">
					<div class="clidash-pibodconth"><?php echo $lang['Inprogress']; ?></div>
					<div class="clidash-pibodconn"><?php echo count($projects_inprogress) ?></div>
					</div>
					<div class="col-md-4 clidash-pibodcont">
					<div class="clidash-pibodconth"><?php echo $lang['Total']; ?></div>
					<div class="clidash-pibodconn"><?php echo count($projects_completed)+count($projects_inprogress);?></div>
					</div>
					</div>
					</div>
					</div>
					<div class="clidashr-ac">
					<div class="clidashr-achead"><?php echo $lang['ACCOUNTING']; ?></div>
					<div class="clidash-acmile">
					<div class="row">
					<div class="col-md-6 clidash-acmiletm">
					<div class="clidash-acmiletmhead"><?php echo $lang['Total milestone']; ?></div>
					<div class="clidash-acmilebody"><?php echo $currency_symbol . $total_miles; ?></div>
					</div>
					<div class="col-md-6 clidash-acmilepm">
					<div class="clidash-acmiletmhead"><?php echo $lang['Paid milestone']; ?></div>
					<div class="clidash-acmilebody"><?php echo $currency_symbol . $paid_miles;?></div> 
					</div>
					</div>
					</div>
					<div class="clidash-acmileb">
					<div class="row">
					<div class="col-md-12 clidash-acmiletmb">
					<div class="clidash-acmiletmheadb"><?php echo $lang['Dues Payable']; ?></div>
					<div class="clidash-acmilebodyb"><?php echo $currency_symbol . $unpaid_miles;?></div>
					</div>
					</div>
					</div>
					
					</div>
					</div>
<div class="notepadcs notepadcsclient">
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