<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Paild Invoice page  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php"); 
$title = "Paid Invoices | ". $syatem_title;
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
$username=$user->firstName;
$email=$user->email;
$account_stat=$user->status;
$user->regDate;
?>
<div id="edit-milestone1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $lang['Invoice']; ?></h4>
		<div class="icons-prt">
		<a href="#" class="prnintpage" onclick="window.print(); return false;"><i class="fa fa-print" aria-hidden="true"></i></a>
		<form action="<?php echo $url; ?>client/download_pdf.php" method="post" target="_blank" enctype="multipart/form-data">
		<input type="hidden" value="<?php if(isset($_POST['edit_id1'])){ echo $_POST['edit_id1']; } ?>" name="milestone_id" />
		<button type="submit" name="mile_submit"><i class="fa fa-download" aria-hidden="true"></i></button>
		</form>
		</div>
		</div>
      <div>
	  
          <div id="invoicecont" class="invoice-box">
		  <div id="editor"></div>
          <?php if(isset($_POST['edit_id1'])){
		  $edit_id1=$_POST['edit_id1'];
		  $latestMile1=milestone::findByMilestoneId($edit_id1);
		  $latestProj1=projects::findByProjectId($latestMile1->p_id);
		  $latestUser1=user::findById($latestProj1->c_id);		  
		  $adminUser1=user::findById(1);		  
		  ?>
		  <table id="html-2-pdfwrapper" width="90%">
		  <tr> 
			  <td>
			  <img src="<?php echo $url.$img_path.$logo; ?>" class="img-fluid"/>
			  <br></br>
			  </td>
			  <td><br><font size="18"><b><?php echo $lang['INVOICE']; ?></b></font></td>
		  </tr>
		  <tr>
			  <td>
			  <font color="#5fbaff"><?php echo $lang['BILL FROM:']; ?></font><br>
			  <b><?php echo $latestUser1->firstName;?></b> <br>
	<div style="width:230px;"><?php echo $latestUser1->address;?></div>
			  </td>
			  <td>
			  <?php echo $lang['Due Date']; ?>:  <?php echo $latestMile1->deadline;?><br>
			  <?php echo $lang['Invoice No']; ?>:    <?php echo $latestMile1->p_id . $latestMile1->id ; ?><br>
			  <?php echo $lang['Status']; ?>:  <?php if($latestMile1->status == 0){ echo '<font color="#ff0000">'.$lang['Unpaid'].'</font>'; } else {echo '<font color="#00c82a">'.$lang['Paid'].'</font>';} ?>
			  </td>
		  </tr>
		  <tr>
			  <td>
			  <br>
			  <font color="#5fbaff"><?php echo $lang['TO:']; ?></font><br>
	<b><?php echo $company_name;?></b> <br>
	<div style="width:230px;"><?php echo $adminUser1->address;?></div>
			  </td>
			  <td>
			 &nbsp;
			  </td>
		  </tr>
		  <tr>
		  <td colspan="2"><br><b><?php echo $lang['Project']; ?>:</b>  <?php echo $latestProj1->project_title;?></td>
		  </tr>
		  <tr>
		  <td colspan="2">
		  <br><br>
		  <table width="100%">
		  <tr>
		  <td width="60%"><?php echo $lang['Milestone Name']; ?></td>
		  <td><?php echo $lang['Total']; ?></td>
		  </tr>
		  <tr>
		  <td colspan="2" style="border-bottom: #e7e7e7 2px solid;"></td>
		  </tr>
		  <tr>
		  <td colspan="2">&nbsp;</td>
		  </tr>
		  <tr>
		  <td><font size="5"><b><?php echo $latestMile1->title ;?></b></font></td>
		  <td><font color="#5fbaff" size="5"><b><?php echo $currency_symbol . $latestMile1->budget ;?></b></font></td>
		  </tr>
		  <tr>
		  <td colspan="2">&nbsp;</td>
		  </tr>
		  <tr>
		  <td colspan="2" style="border-bottom: #e7e7e7 2px solid;"></td>
		  </tr>
		  <tr>
		  <td>&nbsp;</td>
		  <td><br><font size="5"><b><?php echo $lang['SUBTOTAL:']; ?></b><font>&nbsp;&nbsp;&nbsp; <font color="#5fbaff" size="5"><b><?php echo $currency_symbol . $latestMile1->budget ;?></b></font></td>
		  </tr>
		  </table>
		  <br>
		  <br>
		  <br>
		  </td>
		  </tr>
<tr>
<td colspan="2">
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</td>
</tr>
<tr>
<td><font color="#5fbaff"><?php echo $lang['Note']; ?></font></td>
<td><font color="#5fbaff"><?php echo $company_name; ?></font></td>
</tr>
<tr>
<td> 
<font size="2"><?php echo $lang['Thank you for business with us. We feel great to help in you digital services.']; ?></font>
</td>
<td>
<div style="width:230px;float: right;">
<font size="2"><?php echo $adminUser1->address;?></font>
<font size="2"><?php echo $url; ?></font>
</div>
</td>
</tr> 
		  </table>
		  <?php }?>
            
        </div>
      </div> 
    </div>

  </div>
</div>
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
				<div class="pm-heading" style="width:100%;"><h2><?php echo $lang['Paid Invoices']; ?> </h2><span><?php echo $lang['All Paid Milestones']; ?></span></div>
				</div> 
  <div class="col-sm-6 creative-right text-right">
				<div class="pm-form" style="width: 100%;"><form class="form-inline md-form form-sm">
    <input class="form-control form-control" type="text" placeholder="<?php echo $lang['Search Invoice']; ?>" id="protbl-input">
    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
</form></div>
			</div>
			</div>
                <div class="clearfix"></div>

                <div class="table-responsive">          
                      <table class="table table-new table-invoice" data-pagination="true" data-page-size="5">
                        <thead>
                          <tr>
                            <th><?php echo $lang['No.']; ?></th>
                            <th class="table-title1"><?php echo $lang['Project Title']; ?></th>
                            <th class="table-title1"><?php echo $lang['Milestone'];?></th>
                            <th class="table-due"><?php echo $lang['Due date']; ?></th>
                            <th class="table-amount"><?php echo $lang['Amount']; ?></th>
                            <th style="text-align: left;"><?php echo $lang['Invoice']; ?></th>
                          </tr>
                        </thead>
                        <tbody id="projects-tbl">
           <?php 
$counter=1;
 $sumval=0;
 $sumvalall=0;
 $limit = 5;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;
$start_from_b = ($page-1) * $limit;	
		   $ProjectsLoop =projects::findBySql("select * from projects ORDER BY p_id DESC");
foreach($ProjectsLoop as $Projects){
$milestons = $Projects->p_id;
				  
$recentProjects=milestone::findBySql("select * from milestones where p_id='$milestons' and status=1 LIMIT $start_from, $limit");
$recentProjectsall=milestone::findBySql("select * from milestones where p_id='$milestons' and status=1");
$sumval += count($recentProjects);
$sumvalall += count($recentProjectsall);
					  
                      foreach($recentProjects as $recentProject){

					  ?>
                      
                            <tr>
                              <td class="countertd"><?php echo $counter; ?></td>
                              <td class="tbl-ttl">
							  <span class="onmobile"><?php echo $lang['Title']; ?>: </span> 
							  <?php 
							  $projectid = $recentProject->p_id;
							  $ProjectsLoop2 =projects::findBySql("select * from projects WHERE p_id= $projectid");
							  foreach($ProjectsLoop2 as $Projectsa){?>
<form action="../messages.php?project_id=<?php echo $Projectsa->p_id;?>" method="post">
								<input type="hidden" name="user_id" value="<?php echo $Projectsa->c_id;?>" />
								<input type="hidden" name="project_id" value="<?php echo $Projectsa->p_id;?>" />
								<button type="submit" name="chat"> <?php echo $Projectsa->project_title; ?></button>
								</form>
							  <?php } ?>
							  </td>
                              <td class="tbl-ttl"><span class="onmobile"><?php echo $lang['Milestone']; ?>: </span> <?php echo $recentProject->title;?></td>
                              <td><span class="onmobile centera"><?php echo $lang['Deadline']; ?></span><?php echo $recentProject->deadline;?></td>
                              <td><span class="onmobile centera"><?php echo $lang['Amount']; ?></span><?php echo $currency_symbol . $recentProject->budget;?></td>
                              <td class="viewinvoicebt"><form method="post" action="#">
                                	<input type="hidden" value="<?php echo $recentProject->budget;?>" name="edit_id2"/>
                                    <input type="hidden" value="<?php echo $recentProject->id;?>" name="edit_id1"/>
                                    <button type="submit" class="btn outine" name="edit-mile1"> <?php echo $lang['View invoice']; ?></button>
                                </form></td> 
                            </tr>
                          
                        <?php 
					 			$counter++;	
								}
								
}
// echo $sumvalall;
if($sumval == 0){
echo '<tr><td colspan="6">'.$lang['Payment History not available!'].'</td></tr>';
}
?>
                    	</tbody>
                      </table>
<?php 
$total_records = $sumvalall;
$total_pages = ceil($total_records / $limit);  
?>
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
<?php 
include("../templates/admin-footer-payment.php");
if(isset($_POST["edit-mile1"])){?>
<script type="text/javascript">
	
  $("#edit-milestone1").modal("show");

</script>

      <?php } ?>