<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Staff Assigned Projects page //////////////////////////
*/
ob_start(); 
include("../includes/lib-initialize.php"); 
$title = "Projects | ". $syatem_title;
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
$username=$user->firstName;;
$email=$user->email;;
$account_stat=$user->status;;
$user->regDate;

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
            	<div class="col-sm-6">
				<div class="pm-heading"><h2><?php echo $lang['Manage Project']; ?> </h2><span><?php echo $lang['All projects leads']; ?></span></div>
<?php $recentProjects=projects::findBySql("select * from projects WHERE trash=1");?>
				</div> 
                <div class="col-sm-6 creative-right text-right">
				<div class="pm-form" style="width: 100%;"><form class="form-inline md-form form-sm">
    <input class="form-control form-control" type="text" placeholder="<?php echo $lang['Search Projects']; ?>" id="protbl-input">
    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
</form></div>
			</div>
			</div> 
			<div class="row">
                <div class="clearfix"></div>
                <?php if(isset($message) && (!empty($message))){echo $message;} 
$limit = 10;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;
$start_from_b = ($page-1) * $limit;	

$recentProjects_page=projects::findBySql("select * from projects WHERE FIND_IN_SET('$id', s_ids) > 0 AND archive=0 AND trash != 1"); 
$recentProjects=projects::findBySql("select * from projects WHERE FIND_IN_SET('$id', s_ids) > 0 AND archive=0 AND trash != 1 ORDER BY start_time DESC LIMIT $start_from, $limit"); 
				?>
                <div class="table-responsive">          
                      <table class="table table-new stafftable" data-pagination="true" data-page-size="5">
                        <thead>
                          <tr>
                            <th><?php echo $lang['No.']; ?></th>
                            <th class="staff-project-title"><?php echo $lang['Project Title']; ?></th>
                            <th><?php echo $lang['Assign Team']; ?></th>
                            <th><?php echo $lang['Client']; ?></th>
                            <th><?php echo $lang['Status']; ?></th>
                            <th><?php echo $lang['Options']; ?></th>
                          </tr>
                        </thead>
                         <tbody id="projects-tbl">
						  <?php 
						  $count=1;
						  $countb=1;
					if($recentProjects == NULL){
						  echo '<tr><td colspan="7">There is no Projects available!</td></tr>';
					  }
                      foreach($recentProjects as $recentProject){ 
							  $s_ids = $recentProject->s_ids;
							  $st_ids = explode(',', $s_ids);
							 
							  $counter = 0;
					  ?>
                      
                            <tr>
	                            <td class="countertd bs-checkbox"><?php echo $count; ?></td>
	                            <td class="tbl-ttl">
	                              	<span class="onmobile"><?php echo $lang['Title:']; ?> </span> 
	                              	<a class="items_detail" href="items.php?projectId=<?php echo $recentProject->p_id;?>">
	                              		<?php echo $recentProject->project_title;?>
	                              	</a> 
	                            </td>
  <td class="clients-rpt" style="text-align: left;">
  <span class="onmobile centera"><?php echo $lang['Assigned Team']; ?></span>
  <?php 
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
echo '<form action="../messages.php?project_id='.$recentProject->p_id.'" method="post"><input type="hidden" name="user_id" value="'.$st_id.'" /><input type="hidden" name="project_id" value="'.$recentProject->p_id .'" /><button name="chat" type="submit" data-toggle="tooltip" data-placement="top" title="'.$user2->firstName.'">
<img src="'.$url.'includes/timthumb.php?src='.$url.'uploads/profile-pics/'.$image.'&h=36$w=36" /></button></form>';
		 } else {
echo '<form action="../messages.php?project_id='.$recentProject->p_id.'" method="post"><input type="hidden" name="user_id" value="'.$st_id.'" /><input type="hidden" name="project_id" value="'.$recentProject->p_id .'" /><button name="chat" type="submit" data-toggle="tooltip" data-placement="top" title="'.$user2->firstName.'"><img src="'.$url.'assets/images/upload-img.jpg" /></button></form>'; 
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
echo '<form action="../messages.php?project_id='.$recentProject->p_id.'" method="post"><input type="hidden" name="user_id" value="'.$fkid.'" /><input type="hidden" name="project_id" value="'.$recentProject->p_id .'" /><button name="chat" type="submit" data-toggle="tooltip" data-placement="top" title="'.$user1->firstName.'">
<img src="'.$url.'includes/timthumb.php?src='.$url.'uploads/profile-pics/'.$imagea.'&h=36$w=36" /></button></form>';
		 } else {
echo '<form action="../messages.php?project_id='.$recentProject->p_id.'" method="post"><input type="hidden" name="user_id" value="'.$fkid.'" /><input type="hidden" name="project_id" value="'.$recentProject->p_id .'" /><button name="chat" data-toggle="tooltip" data-placement="top" title="'.$user1->firstName.'"  type="submit"><img src="'.$url.'assets/images/upload-img.jpg" /></button></form>';
		 }
							//   echo '<div class="user-n">'. $user1->firstName . '</div>';
							  echo '</div>';
							  ?></td>
                               <td class="prostatus">
							   <span class="onmobile centera"><?php echo $lang['Status']; ?></span>
							  <?php $status = $recentProject->status;
							  $archive = $recentProject->archive;
							  $trash = $recentProject->trash;
							  if($status == 0){ ?>
							  <span class="inprogress"><?php echo $lang['IN PROGRESS']; ?></span>
							  <?php } else { ?>
								<span class="completed"><?php echo $lang['COMPLETED']; ?></span>
							  <?php }?>
							  </td>
                              <td>
							   <div class="disbtn">
							   <form action="<?php echo $url;?>messages.php?project_id=<?php echo $recentProject->p_id; ?>" method="post">
								<input type="hidden" name="user_id" value="<?php echo $user1->id; ?>">
								<input type="hidden" name="project_id" value="<?php echo $recentProject->p_id; ?>">
								<button class="disbtnbox" type="submit" name="chat"><?php echo $lang['Discussion']; ?></button>
								</form>
							   </div>
                              </td>
                            </tr>
                          
                        <?php 
						$count++;
							 
								}?>
                    	</tbody>
                      </table>
<?php 
$total_records = count($recentProjects_page);  

$total_pages = ceil($total_records / $limit);?>
<div class="row pagination-box">
<div class="col-md-6 resilts-txt"><?php echo $lang['Showing']; ?> <span class="start_val"><?php echo $start_from_b;?></span> <?php echo $lang['to']; ?> <span class="end_val"><?php echo $limit; ?></span> <?php echo $lang['of']; ?> <?php echo $total_records;?> <?php echo $lang['entries']; ?></div>
<div class="col-md-6">
<?php
echo '<nav aria-label="Page navigation"><ul class="pagination justify-content-end">';
echo '<li class="page-item">
      <a class="page-link" href="?page=1" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">'.$lang['Previous'].'</span>
      </a>
    </li>
';

for ($i=1; $i<=$total_pages; $i++) {

    $pagLink .= "<li class='page-item'><a class='page-link' href='?page=".$i."'>".$i."</a></li>";
}
echo $pagLink . '
<li class="page-item">
      <a class="page-link" href="?page='.$total_pages.'" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">'.$lang['Next'].'</span>
      </a>
    </li>
</ul></nav>';  
?>
            </div>
            </div>
                	</div>
                	</div>
            </div>
        </div><!-- row -->
    </div>
	<div class="clearfix"></div>
		
</div>
</div>
</div>
<?php  include("../templates/admin-footer.php"); ?>