<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Projects Trash Page  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Trash | ". $syatem_title;
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
	
	  $deleteProj="delete from projects where p_id=$delProjId limit 1";
	  $projDeleted=mysqli_query($connect, $deleteProj);
	  $deleteProjChat="delete from messages where Project_id=$delProjId";
	  $projChatDeleted=mysqli_query($connect, $deleteProjChat);
	  if($projDeleted){
		 header("Location:trash.php?message=trash");
	   } else{
			   header("Location:trash.php?message=fail");
	   }
 }
if(isset($_POST['comp_proj']))
{
	 $comp_id=$_POST['comp_id'];
	 $comp_val=$_POST['comp_val'];
	  $updateProj="UPDATE projects SET status=$comp_val WHERE p_id=$comp_id";
	  $comp_proj=mysqli_query($connect, $updateProj);
if($comp_proj){
		  header("Location:projects.php?message=restore");
	  } else{
		  header("Location:projects.php?message=fail");
	  }
}
if(isset($_POST['arc_proj']))
{
	 $arc_id=$_POST['arc_id'];
	 $arc_val=$_POST['arc_val'];
	 $arc_del_val=$_POST['arc_del_val'];
	  $updateProj="UPDATE projects SET archive=$arc_val, trash=$arc_del_val WHERE p_id=$arc_id";
	  $arc_proj=mysqli_query($connect, $updateProj);
	  if($arc_proj){
		  header("Location:projects.php?message=restore");
	  }else{
		   header("Location:projects.php?message=fail");
	  }
}
if(isset($_GET['message'])){
$msgstatus = $_GET['message'];
$notmessagea = $lang['Record updated successfully'];
$notmessageb = $lang['Error! Please Try Again later.'];
$notmessagec = $lang['Project moved to archive sucessfully'];
$notmessaged = $lang['Project marked as Completed.'];
$notmessagee = $lang['Project restored Successfully.'];
$notmessagef = $lang['Project deleted Successfully.'];
if($msgstatus == 'success'){
					$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessagea."</p>";
}
if($msgstatus == 'fail'){		 
$message="<div class='container extra-top'><p class='col-md-12 alert alert-danger'><i class='fa fa-times'></i> ".$notmessageb."</p></div>";
}
if($msgstatus == 'archive'){		 
		 $message= "<div class='container extra-top'><p class='col-md-12 alert alert-success'><i class='fa fa-check'></i> ".$notmessagec."</p></div>";
}
if($msgstatus == 'completed'){		 
		 $message= "<div class='container extra-top'><p class='col-md-12 alert alert-success'><i class='fa fa-check'></i> ".$notmessaged."</p></div>";
}
if($msgstatus == 'restore'){		 
		 $message= "<div class='container extra-top'><p class='col-md-12 alert alert-success'><i class='fa fa-check'></i> ".$notmessagee."</p></div>";
}
if($msgstatus == 'trash'){		 
		 $message= "<div class='container extra-top'><p class='col-md-12 alert alert-success'><i class='fa fa-check'></i> ".$notmessagef."</p></div>";
}
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
            	<div class="col-lg-5 col-md-5 col-sm-5 mobileleft">
				<div class="pm-heading"><h2><?php echo $lang['Trash']; ?> </h2><span><?php echo $lang['All Deleted projects']; ?></span></div>
				<div class="pm-form"><form class="form-inline md-form form-sm">
    <input class="form-control form-control" type="text" placeholder="<?php echo $lang['Search Projects']; ?>" id="protbl-input">
    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
</form></div>
<?php $recentProjects=projects::findBySql("select * from projects WHERE trash=1 ORDER BY start_time DESC");?>
				</div> 
                <div class="col-lg-7 col-md-7 col-sm-7 project-opt creative-right text-right">
<div class="mobilepromenu">
				<div class="projbtnm"><a href="add-new-project.php"><span>+</span></a></div>
				<div class="projmobilem">
				<i class="fa fa-bars" aria-hidden="true"></i>
					<ul>
					<li class="pm-arc"><a href="projects.php"><?php echo $lang['Projects']; ?></a></li>
					<li class="pm-trashbox"><a href="trash.php">
					<?php echo $lang['Trash']; ?> (<?php echo count($recentProjects); ?>)
					</a></li>
					</ul>
					</div>
				</div>
				<ul class="deskvisible">
				<li class="cproject"><a href="add-new-project.php"><?php echo $lang['Create project']; ?> <span>+</span></a></li>
				<li class="pm-arc"><a href="projects.php"><?php echo $lang['Projects']; ?></a></li>
				<li class="pm-trashbox"><a href="trash.php">
				<?php echo $lang['TRASH']; ?> (<?php echo count($recentProjects); ?>)
				</a></li>
				</ul>
			</div>
			</div>
			<div class="row">
                <div class="clearfix"></div>
				 <div class="col-md-12 margin-top-10">
                <?php if(isset($message) && (!empty($message))){echo $message;} ?>
				</div>
                <div class="table-responsive">          
                      <table class="table table-new projectspaget">
                        <thead>
                          <tr>
                            <!--<th><input name="btSelectAll" type="checkbox"></th>-->
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
						  echo '<tr><td colspan="8">'.$lang['Trash is Empty!'].'</td></tr>';
					  }
                      foreach($recentProjects as $recentProject){   ?>
                            <tr>
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
							  echo '</div>';
							  ?></td>
                              <td><span class="onmobile"><?php echo $lang['Deadline']; ?>: </span> <?php echo $recentProject->end_time;?></td>
                              <td class="prostatus">
							  <span class="onmobile centera"><?php echo $lang['Status']; ?> </span>
							  <?php $status = $recentProject->status;
							  $archive = $recentProject->archive;
							  if($status == 0){ ?>
							  <span class="inprogress"><?php echo $lang['IN PROGRESS']; ?></span>
							  <?php } else { ?>
								<span class="completed"><?php echo $lang['COMPLETED']; ?></span>
							  <?php }?>
							  </td>
                              <td class="pro-bdgt"><span class="onmobile centera"><?php echo $lang['Budget']; ?> </span> <?php echo $currency_symbol . $recentProject->budget;?></td>
                              <td class="tbl-milestons extra-height">
							  <span class="onmobile centera"><?php echo $lang['Milestone']; ?> </span>
                              <a href="payments.php?projectId=<?php echo $recentProject->p_id;?>&clientId=<?php echo $user1->id; ?>" class="btn" type="submit" name="payments"><?php echo $lang['view']; ?></a>
                              </td>
                               <td class="extra-height">
							  <span class="onmobile centera"><?php echo $lang['Options']; ?></span>
							  <div class="action-toggle" data-toggle="collapse" data-target="#client-menu<?php echo $recentProject->p_id;?>"><?php echo $lang['Action']; ?> <i class="fa fa-caret-down"></i></div>
							  <div id="client-menu<?php echo $recentProject->p_id;?>" class="toggle-action collapse">
							  <ul>
								<li>
								<form method="post" action="#">
								<input type="hidden" value="<?php echo $recentProject->p_id;?>" name="arc_id"/>
								<input type="hidden" value="0" name="arc_val"/>
								<input type="hidden" value="0" name="arc_del_val"/>
								<button type="submit" name="arc_proj"><i class="fa fa-folder-open-o"></i> <?php echo $lang['Restore']; ?> </button>
								</form>
								</li>
								<li>
								<button type="button" data-toggle="modal" data-target="#deletepro<?php echo $recentProject->p_id;?>"><i class="fa fa-trash-o"></i> <?php echo $lang['Delete Permanently']; ?></button>
								</li>
							</ul>
								</div>
							<!-- The Modal -->
<div  class="modal fade deletepro" id="deletepro<?php echo $recentProject->p_id;?>" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><?php echo $lang['Confirmation']; ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
<h3><?php echo $lang['Are your sure you want to <br> permanently delete this project']; ?></h3>
<p><?php echo $lang['Deleting Project will aslo  delete all data. <br>milestone, payment record.']; ?></p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
	  <div class="mod-footbox">
<button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><?php echo $lang['CANCEL']; ?></button>
</div>
<div class="mod-footbox">
<form method="post" action="#">
								<input type="hidden" value="<?php echo $recentProject->p_id;?>" name="del_id"/>
								<button type="submit" class="btn btn-danger" name="del_proj"><?php echo $lang['DELETE']; ?></button>
								</form>
</div>
      </div>

    </div>
  </div>
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