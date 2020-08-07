<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Client Projects  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Projects | ". $syatem_title;
include("../templates/admin-header.php");

if(!($session->isLoggedIn())){
		redirectTo($url."index.php");
	}
if($_SESSION['accountStatus'] == 1){
	redirectTo($url."admin/edit-profile.php");
}
if($_SESSION['accountStatus'] == 3){
	redirectTo($url."staff/edit-profile.php");
}
//condition check for login
$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$account_stat=$user->status;
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

				</div> 
                <div class="col-sm-6 creative-right text-right">
				<div class="pm-form" style="width: 100%;"><form class="form-inline md-form form-sm">
    <input class="form-control form-control" type="text" placeholder="<?php echo $lang['Search Projects']; ?>" id="protbl-input">
    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
</form></div>
			</div>
			</div>
			<div class="clearfix"></div>
			<div class="row">
 <div class="col-md-12 margin-top-10 clients">
                <?php if(isset($message) && (!empty($message))){echo $message;} ?>
			</div>
			<?php 
$limit = 10;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;
$start_from_b = ($page-1) * $limit;	
$recentProjects_page=projects::findBySql("select * from projects where c_id = $id"); 
$recentProjects=projects::findBySql("select * from projects where c_id = $id ORDER BY start_time DESC LIMIT $start_from, $limit"); 
				?>
                <div class="table-responsive">          
                      <table class="table table-new projectspage clientside" data-pagination="true" data-page-size="5">
                        <thead>
                          <tr>
                            <th><?php echo $lang['No.']; ?></th>
                            <th class="table-title1"><?php echo $lang['Project Title']; ?></th>
                            <th><?php echo $lang['Status']; ?></th>
                            <th>Shipping Plan</th>
                            <th><?php echo $lang['Options']; ?></th>
                          </tr>
                        </thead>
                        <tbody id="projects-tbl">
						  <?php 
						  $count=1;
						  $countb=1;
					if($recentProjects == NULL){
						  echo '<tr><td colspan="8">'.$lang['No Project Found!'].'</td></tr>';
					  }
                      foreach($recentProjects as $recentProject){ 
					  ?>
                      
                            <tr>
                              <td class="countertd"><?php echo $count; ?></td>
                              <td class="tbl-ttl">
							  <span class="onmobile"><?php echo $lang['Title']; ?>: </span>
							  <a class="href_title" href="items.php?projectId=<?php echo $recentProject->p_id;?>"><?php echo $recentProject->project_title;?></a></td>
                 
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
                              <td>
                              <a href="items.php?projectId=<?php echo $recentProject->p_id;?>" class="btn" type="submit" name="payments">View Details</a></td>
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
$total_pages = ceil($total_records / $limit); ?>
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
};  
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
<?php include("../templates/admin-footer.php"); ?>