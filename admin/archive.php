<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Projects Archive Page  //////////////////////////
*/
ob_start(); 
include("../includes/lib-initialize.php");
$title = "Project Archive | ". $syatem_title;
include("../templates/admin-header.php");

 if(!($session->isLoggedIn())){
		redirectTo($url."index.php");
	}
if($_SESSION['accountStatus'] == 2){
	redirectTo($url."client/index.php");
}
if($_SESSION['accountStatus'] == 3){
	redirectTo($url."staff/index.php");
} 
//condition check for login

$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;;
$email=$user->email;;
// $account_stat=$user->status;
$user->regDate;

if(isset($_POST['del_proj']))
{
	 $delProjId=$_POST['del_id'];
	 $delProjval=$_POST['del_val'];
	
	  $deleteProj="UPDATE projects SET trash=$delProjval WHERE p_id=$delProjId";
	  $projDeleted=mysqli_query($connect, $deleteProj);
	  if($projDeleted){
		 header("Location:archive.php?message=psuccess");
	   } else{
			   header("Location:archive.php?message=fail");
	   }
}
if(isset($_POST['bulk_del_proj']))
{

 	 $bulk_del_id=$_POST['bulk_del_id'];
	 $bulk_del_val=$_POST['bulk_del_val'];
 $bulk_arr = explode(',', $bulk_del_id);
	foreach($bulk_arr as $bulk_id){
$deleteProj="UPDATE projects SET trash=$bulk_del_val WHERE p_id=$bulk_id";
	  $projDeleted=mysqli_query($connect, $deleteProj);
	}
}
if(isset($_POST['comp_proj']))
{
	 $comp_id=$_POST['comp_id'];
	 $comp_val=$_POST['comp_val'];
 if($comp_val == 1){
	  $updateProj="UPDATE projects SET status=$comp_val WHERE p_id=$comp_id";
	  $comp_proj=mysqli_query($connect, $updateProj);
	  if($comp_proj){
		  header("Location:archive.php?message=completed");
	  } else{
		  header("Location:archive.php?message=fail");
	  }
	 } else{
	  $updateProj="UPDATE projects SET status=$comp_val WHERE p_id=$comp_id";
	  $comp_proj=mysqli_query($connect, $updateProj);
	  if($comp_proj){
		  header("Location:archive.php?message=reopen");
	  } else{
		  header("Location:archive.php?message=fail");
	  }		 
	 }
}
if(isset($_POST['arc_proj']))
{
	 $arc_id=$_POST['arc_id'];
	 $arc_val=$_POST['arc_val'];
	  $updateProj="UPDATE projects SET archive=$arc_val WHERE p_id=$arc_id";
	  $arc_proj=mysqli_query($connect, $updateProj);
	  if($arc_proj){
		  header("Location:archive.php?message=projects");
	  }else{
		   header("Location:archive.php?message=fail");
	  }
}
$msgstatus = $_GET['message'];
$notmessagea = $lang['Record updated successfully'];
$notmessageb = $lang['Error! Please Try Again later.'];
$notmessagec = $lang['Project has been deleted sucessfully'];
$notmessaged = $lang['Moved to projects sucessfully'];
$notmessagee = $lang['Project marked as Completed.'];
$notmessagef = $lang['Project status updated to re-open.'];
$notmessageg = $lang['Project restored Successfully.'];
if($msgstatus == 'success'){
					$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessagea."</p>";
}
if($msgstatus == 'fail'){		 
$message="<div class='container extra-top'><p class='col-md-12 alert alert-danger'><i class='fa fa-times'></i> ".$notmessageb."</p></div>";
}
if($msgstatus == 'psuccess'){		 
		 $message= "<div class='container extra-top'><p class='col-md-12 alert alert-success'><i class='fa fa-check'></i> ".$notmessagec."</p></div>";
}
if($msgstatus == 'projects'){		 
		 $message= "<div class='container extra-top'><p class='col-md-12 alert alert-success'><i class='fa fa-check'></i> ".$notmessaged."</p></div>";
}
if($msgstatus == 'completed'){		 
		 $message= "<div class='container extra-top'><p class='col-md-12 alert alert-success'><i class='fa fa-check'></i> ".$notmessagee."</p></div>";
}
if($msgstatus == 'reopen'){		 
		 $message= "<div class='container extra-top'><p class='col-md-12 alert alert-success'><i class='fa fa-check'></i> ".$notmessagef."</p></div>";
}
if($msgstatus == 'restore'){		 
		 $message= "<div class='container extra-top'><p class='col-md-12 alert alert-success'><i class='fa fa-check'></i> ".$notmessageg."</p></div>";
}
?>
      
<div class="page-container">
<div class="container-fluid">
<div class="row row-eq-height">
	<?php  include("../templates/sidebar.php"); ?>
	
    <div class="page-content col-lg-9 col-md-12 col-sm-12 col-lg-push-3">
<?php include('../templates/top-header.php'); ?>
         <div class="row">
            <div class="col-md-12 margin-top-10 clients">
			<div class="row project-dash">
            	<div class="col-lg-6 col-md-6 col-sm-6 mobileleft">
				<div class="pm-heading"><h2><?php echo $lang['Archive Projects']; ?> </h2><span><?php echo $lang['All Archive projects']; ?></span></div>
				<div class="pm-form"><form class="form-inline md-form form-sm">
    <input class="form-control form-control" type="text" placeholder="<?php echo $lang['Search Projects']; ?>" id="protbl-input">
    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
</form></div>
<?php $recentProjects=projects::findBySql("select * from projects WHERE trash=1");?>
				</div> 
<div class="col-lg-6 col-md-6 col-sm-6 arcprojectbox creative-right text-right">
<div class="mobilepromenu">
				<div class="projbtnm"><a href="add-new-project.php"><span>+</span></a></div>
				<div class="projmobilem">
				<i class="fa fa-bars" aria-hidden="true"></i>
					<ul>
					<li class="pm-arc"><a href="projects.php"><?php echo $lang['Projects']; ?></a></li>
					<li class="pm-trashbox"><a href="trash.php">
					<?php echo $lang['Trash']; ?> (<?php echo count($recentProjects); ?>)
					</a></li>
					<li class="pm-trash">
								<form method="post" action="#">
								<input type="hidden" class="bulk_ids" value="" name="bulk_del_id"/>
								<input type="hidden" value="1" name="bulk_del_val"/>
								<button type="submit" name="bulk_del_proj" disabled><?php echo $lang['Delete']; ?></button>
								</form>
					</li>
					</ul>
					</div>
				</div>
				<ul class="deskvisible">
				<li class="cproject"><a href="add-new-project.php"><?php echo $lang['Create project']; ?> <span>+</span></a></li>
				<li class="pm-arc"><a href="projects.php"><?php echo $lang['Projects']; ?></a></li>
				<li class="pm-trashbox"><a href="trash.php">
				<?php echo $lang['TRASH']; ?> (<?php echo count($recentProjects); ?>)
				</a></li>
				<li class="pm-trash">
								<form method="post" action="#">
								<input type="hidden" class="bulk_ids" value="" name="bulk_del_id"/>
								<input type="hidden" value="1" name="bulk_del_val"/>
								<button type="submit" name="bulk_del_proj" disabled><i class="fa fa-trash-o"></i></button>
								</form>
				</li>
				</ul>
			</div>
			</div>
			<div class="row">
                <div class="clearfix"></div>
				<div class="col-md-12 margin-top-10">
                <?php if(isset($message) && (!empty($message))){echo $message;} ?>
				</div>
                <?php $recentProjects=projects::findBySql("select * from projects WHERE archive=1 AND trash != 1 ORDER BY start_time DESC");
				?>
                <div class="table-responsive">          
                      <table class="table table-new projectspage">
                        <thead>
                          <tr>
                            <th><input name="btSelectAll" type="checkbox"></th>
                            <th width="26%"><?php echo $lang['Project Name']; ?></th>
                            <th><?php echo $lang['Assign Team']; ?></th>
                            <th><?php echo $lang['Client']; ?></th>
                            <th><?php echo $lang['Deadline']; ?></th>
                            <th><?php echo $lang['Status']; ?></th>
                            <th><?php echo $lang['Budget']; ?></th>
                            <th><?php echo $lang['Milestones']; ?></th>
                            <th><?php echo $lang['Options']; ?></th>
                          </tr>
                        </thead>
                        <tbody id="projects-tbl">
						  <?php 
						  $counter=1;
					if($recentProjects == NULL){
						  echo '<tr><td colspan="9">'.$lang['There is no Project in Archive!'].'</td></tr>';
					  }
                      foreach($recentProjects as $recentProject){ ?>
                      
                            <tr>
							<td class="bs-checkbox"><input data-index="<?php echo $counter; ?>" name="btSelectItem" type="checkbox"></td>
                              <td class="tbl-ttl"><span class="onmobile"><?php echo $lang['Title']; ?>: </span> <?php echo $recentProject->project_title;?></td>
                              <td class="clients-rpt" style="text-align: left;">
							  <span class="onmobile centera"><?php echo $lang['Staff']; ?> </span>
							  <?php 
							  
							  $s_ids = $recentProject->s_ids;
							  $st_ids = explode(',', $s_ids);
							  $counter = 0;
							  foreach($st_ids as $st_id){
								  if($st_id != 1 && $st_id !=  $recentProject->c_id && $st_id != 0){
									  $counter++;
									  if($counter > 3){} else {

								$user2 = user::findById($st_id); 
								global $db;
 		$query = $db->query("SELECT filename FROM profile_pics WHERE fkUserId = '$st_id'");
		 $row1 = mysqli_fetch_array($query);
		 $image = $row1['filename'];
		 echo '<div class="user-box">';
		 if($image){
echo '<form action="../messages.php?project_id='.$recentProject->p_id .'" method="post"><input type="hidden" name="user_id" value="'.$st_id.'" /><input type="hidden" name="project_id" value="'.$recentProject->p_id .'" /><button name="chat" type="submit" data-toggle="tooltip" data-placement="top" title="'.$user2->firstName.'">
<img src="'.$url.'includes/timthumb.php?src='.$url.'uploads/profile-pics/'.$image.'&h=36$w=36" /></button></form>';
		 } else {
echo '<form action="../messages.php?project_id='.$recentProject->p_id .'" method="post"><input type="hidden" name="user_id" value="'.$st_id.'" /><input type="hidden" name="project_id" value="'.$recentProject->p_id .'" /><button name="chat" type="submit" data-toggle="tooltip" data-placement="top" title="'.$user2->firstName.'"><img src="'.$url.'assets/images/upload-img.jpg" /></button></form>'; 
		 }
		 
// 		echo '<div class="user-n">'. $user2->firstName . '</div>';
		echo '</div>'; 
							  }
								  }
							  }
							 
							  if($counter > 3){
								  $more = $counter-3;
								   echo '<div class="plus-more">+'. $more .'<br>more</div>'; 
							  }
							  ?></td>
                              <td class="clients-sgl" style="text-align: center;">
							  <span class="onmobile centera"><?php echo $lang['Client']; ?></span>
							  <?php 
							 echo '<div class="user-box">';
							  $user1 = user::findById($recentProject->c_id); 
							  $fkid = $recentProject->c_id;
$querya = $db->query("SELECT filename FROM profile_pics WHERE fkUserId = '$fkid'");
		 $rowa = mysqli_fetch_array($querya);
		 $imagea = $rowa['filename'];
 if($imagea){
echo '<form action="../messages.php?project_id='.$recentProject->p_id .'" method="post"><input type="hidden" name="user_id" value="'.$fkid.'" /><input type="hidden" name="project_id" value="'.$recentProject->p_id .'" /><button name="chat" type="submit" data-toggle="tooltip" data-placement="top" title="'.$user1->firstName.'">
<img src="'.$url.'includes/timthumb.php?src='.$url.'uploads/profile-pics/'.$imagea.'&h=36$w=36" /></button></form>';
		 } else {
echo '<form action="../messages.php?project_id='.$recentProject->p_id .'" method="post"><input type="hidden" name="user_id" value="'.$fkid.'" /><input type="hidden" name="project_id" value="'.$recentProject->p_id .'" /><button name="chat" data-toggle="tooltip" data-placement="top" title="'.$user1->firstName.'"  type="submit"><img src="'.$url.'assets/images/upload-img.jpg" /></button></form>';
		 }
							//   echo '<div class="user-n">'. $user1->firstName . '</div>';
							  echo '</div>';
							  ?></td>
                              <td><span class="onmobile"><?php echo $lang['Deadline']; ?>: </span> <?php echo $recentProject->end_time;?></td>
                              <td class="prostatus">
							   <span class="onmobile centera"><?php echo $lang['Status']; ?> </span>
							  <?php $status = $recentProject->status;
							  $archive = $recentProject->archive;
							  $trash = $recentProject->trash;
							  if($status == 0){ ?>
							  <span class="inprogress"><?php echo $lang['IN PROGRESS']; ?></span>
							  <?php } else { ?>
								<span class="completed"><?php echo $lang['COMPLETED']; ?></span>
							  <?php }?>
							  </td>
                              <td class="pro-bdgt"><span class="onmobile centera"><?php echo $lang['Budget']; ?> </span><?php echo $currency_symbol . $recentProject->budget;?></td>
                              <td class="tbl-milestons extra-height">
							  <span class="onmobile centera"><?php echo $lang['Milestone']; ?> </span>
                              <a href="payments.php?projectId=<?php echo $recentProject->p_id;?>&clientId=<?php echo $user1->id; ?>" class="btn" type="submit" name="payments"><?php echo $lang['view']; ?></a>
                              </td>
                              <td class="extra-height">
							  <span class="onmobile centera"><?php echo $lang['Options']; ?></span>
							  <div class="action-toggle" data-toggle="collapse" data-target="#client-menu<?php echo $recentProject->p_id;?>"><?php echo $lang['Action']; ?> <i class="fa fa-caret-down"></i></div>
							  <div client-menu<?php echo $recentProject->p_id;?>" class="toggle-action collapse">
							  <ul>
								<li>
								<form action="../messages.php?project_id=<?php echo $recentProject->p_id;?>" method="post">
								<input type="hidden" name="user_id" value="<?php echo $recentProject->c_id;?>" />
								<input type="hidden" name="project_id" value="<?php echo $recentProject->p_id;?>" />
								<button type="submit" name="chat"><i class="fa fa-comment-o"></i> <?php echo $lang['Discussion']; ?></button>
								</form>
								</li>
								<li>
								<form method="post" action="edit-project.php">
								<input type="hidden" value="<?php echo $recentProject->p_id;?>" name="p_id"/>
								<button type="submit" name="edt_pro"><i class="fa fa-pencil"></i> <?php echo $lang['Edit Project']; ?></button>
								</form>
								</li>
								<li>
								<form method="post" action="#">
								<input type="hidden" value="<?php echo $recentProject->p_id;?>" name="del_id"/>
								<input type="hidden" value="<?php if($trash == 0){ echo '1';}else { echo '0';} ?>" name="del_val"/>
								<button type="submit" name="del_proj"><i class="fa fa-trash-o"></i> <?php echo $lang['Delete']; ?></button>
								</form>
								</li>
								<li>
								<form method="post" action="#">
								<input type="hidden" value="<?php echo $recentProject->p_id;?>" name="comp_id"/>
								<input type="hidden" value="<?php if($status == 0){ echo '1';}else { echo '0';} ?>" name="comp_val"/>
								<button type="submit" name="comp_proj">
								<?php if($status == 0){
								echo '<i class="fa fa-check-square-o"></i> '.$lang['Mark as complete'];
								}else { 
								echo '<i class="fa fa-retweet"></i> '. $lang['Re-open'];
								} ?>
								</button>
								</form>
								</li>
								<li>
								<form method="post" action="#">
								<input type="hidden" value="<?php echo $recentProject->p_id;?>" name="arc_id"/>
								<input type="hidden" value="<?php if($archive == 0){ echo '1';}else { echo '0';} ?>" name="arc_val"/>
								<button type="submit" name="arc_proj">
								<?php if($archive == 0){
								echo '<i class="fa fa-folder-open-o"></i> '.$lang['Move to Archive'];
								}else { 
								echo '<i class="fa fa-folder-open-o"></i> '.$lang['Move to Projects'];
								} ?>
								</button>
								</form>
								</li>
							</ul>
								</div>
								</td>
                            </tr>
                          
                        <?php 
					 			$counter++;	
								}?>
                    	</tbody>
                      </table>
                	</div>
            </div>
        </div><!-- row -->
    </div>
	<div class="clearfix"></div>
		
</div>        
</div>        
</div>
</div>
<?php  include("../templates/admin-footer.php"); ?>