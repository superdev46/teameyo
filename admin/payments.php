<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Payments page Edit milestone/Create Milestones/Update Milestones  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Payments | ". $syatem_title;
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
if(isset($_GET['projectId'])){
	 $projectId=$_GET['projectId'];
}
if(isset($_GET['clientId'])){
	$clientId=$_GET['clientId'];
}
  if(isset($_GET['projectId'])|| isset($_POST['add-milestone']))
{
	  if(isset($_POST['add-milestone']))
	{
		
		$flag=0;//determines if all posted values are not empty includ
		
		if($flag==0)
		{
			$project = new milestone();
			 
				$id	=       (int)NULL;
				$title	=       $_POST['title'];
				$budget		=$_POST['amount'];
				$status		= (int)$_POST['status'];
				$deadline		=$_POST['deadline'];
				$releaseDate		=$_POST['releaseDate'];
				$p_id    	   = (int)$_POST['projId'];
				//  $saveProject=$project->save();
				  $sql = "INSERT INTO milestones (id, p_id, title, deadline, releaseDate, budget, status) VALUES('$id', '$p_id', '$title', '$deadline', '$releaseDate', '$budget', '$status')";


if ($connect->query($sql) === TRUE) {
					  $lastProject=$project->findLastRecord();
					  $lastProjectId=$lastProject->id;

header('location:payments.php?projectId='.$projectId.'&clientId='.$clientId.'&message=success');  
				  }
				  else
				  {
					  
header('location:payments.php?projectId='.$projectId.'&clientId='.$clientId.'&message=fail');  
				  
				  }
				}
			
		
	}
	if(isset($_GET['message'])){
$msgstatus = $_GET['message'];
$notmessagea = $lang['Milestone has been created successfully!'];
$notmessageb = $lang['Milestone could not created at this time. Please try again later . Thanks'];
$notmessagec = $lang['Milestone updated successfully'];
$notmessaged = $lang['Milestone could not be updated.'];
if($msgstatus == 'success'){
					  $message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessagea."<p>";
}
if($msgstatus == 'fail'){
$message="<p class='alert alert-danger'><i class='fa fa-times'></i> ".$notmessageb."</p>";
}
if($msgstatus == 'updated'){
					$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessagec."</p>";
}
if($msgstatus == 'notupdated'){
					$message="<p class='alert alert-danger'><i class='fa fa-times'></i> ".$notmessaged."</p>"; //when reord is not updated
}

}
$ProjectsLoop =projects::findBySql("select * from projects WHERE p_id= $projectId");
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
		<input type="hidden" value="<?php if(isset($_POST['edit_id1'])){echo $_POST['edit_id1'];}?>" name="milestone_id" />
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
<!-- Modal -->
<div id="add-milestone" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title modal-left"><?php echo $lang['Add Project Milestone']; ?> </h4>
      </div>
      <div class="modal-body">
        <form method="post" class="milestonefrm1" action="#" enctype="multipart/form-data">
            	<div class="form-group">
                    <div class="col-sm-12">
                        <div class="field-label"><label for="firstName"><?php echo $lang['Project title']; ?>*</label></div>
                    	<input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="field-label"><label for="amount"><?php echo $lang['Amount']; ?> (<?php echo $currency_symbol ; ?>)</label></div>
                    	<input type="number" name="amount" class="form-control" required>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="field-label"><label for="status"><?php echo $lang['Status']; ?></label></div>
                    	<select class="ui dropdown form-control status1" name="status">
                    	 <option value="0"><?php echo $lang['Unpaid']; ?></option>
                         <option value="1"><?php echo $lang['Paid manually']; ?></option>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>
                 <div class="form-group">
                    <div class="col-sm-12">
                        <div class="field-label"><label for="deadline"><?php echo $lang['Deadline']; ?></label></div>
                    	<input type="text" name="deadline" autocomplete="off" class="form-control datepicker" required>
						<input type="hidden" name="releaseDate" class="form-control datepicker releaseDate" required value="1970-01-01">
                    </div>
                    <div class="clearfix"></div>
                </div>
				 <div class="form-group">
                    <div class="col-sm-12">
                <input type="hidden" name="projId" value="<?php echo $projectId ;?>" />
                <input type="hidden" name="clientId" value="<?php echo $clientId ;?>" />
                 <input type="submit" name="add-milestone" value="<?php echo $lang['Add milestone']; ?>" class="btn bigbutton"/>
				 </div>
				 </div>
              <div class="clearfix"></div> 
            </form>
      </div> 
    </div>
  </div>
</div> 


<!-- Modal -->
<div id="edit-milestone" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $lang['Project Milestone ']; ?> </h4>
      </div>
      <div class="modal-body">
      
      <?php if(isset($_POST['edit_id'])){
		  $edit_id=$_POST['edit_id'];
		  $latestMile=milestone::findByMilestoneId($edit_id);

		  ?>
          <form method="post" class="milestonefrm1" action="#" enctype="multipart/form-data">
          	<div class="form-group">
                <div class="col-sm-12">
                      <div class="field-label"><label for="firstName"><?php echo $lang['Project title'];?>*</label></div>
                    <input type="text" name="title1" class="form-control"  value="<?php echo $latestMile->title;?>" required>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="field-label"><label for="amount"><?php echo $lang['Amount']; ?> (<?php echo $currency_symbol ; ?>)</label></div>
                    <input type="number" name="amount1" class="form-control" value="<?php echo $latestMile->budget;?>" required>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="field-label"><label for="status"><?php echo $lang['Status']; ?></label></div>
                    <select class="ui dropdown form-control status1" name="status1">
                    <?php if($latestMile->status==0){?>
                     <option value="0" checked><?php echo $lang['Unpaid']; ?></option>
                     <option value="1"><?php echo $lang['Paid manually']; ?></option>
                     <?php }else{?>
                     <option value="0" ><?php echo $lang['Unpaid']; ?></option>
                     <option value="1" checked><?php echo $lang['Paid manually']; ?></option>
                     <?php } ?>
                     
                    </select>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                    <div class="col-sm-12">
                        <div class="field-label"><label for="deadline"><?php echo $lang['Deadline']; ?></label></div>
                    	<input type="text" name="deadline1" class="form-control datepicker" required value="<?php echo $latestMile->deadline; ?>">
						<?php 
						$relDate = $latestMile->releaseDate;
						?>
						<input type="hidden" name="releaseDate" class="form-control datepicker releaseDate" required value="<?php if($relDate){echo $latestMile->releaseDate;} else{ echo '1970-01-01';} ?>">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                <input type="hidden" name="editId" value="<?php echo  $edit_id ;?>" />
                 <input type="submit" name="edit-milestone-1" value="<?php echo $lang['Update']; ?>" class="btn bigbutton"/>
				 </div>
				 </div>
              <div class="clearfix"></div> 
          </form>
          <?php
	  }?>
        
      </div> 
    </div>

  </div>
</div>   
<div class="page-container">
<div class="container-fluid">
<div class="row row-eq-height">
	<?php  include("../templates/sidebar.php"); ?>
	
    <div class="page-content col-lg-9 col-md-12 col-sm-12 col-lg-push-3" style="padding-bottom:0px !important;">
<?php include('../templates/top-header.php'); ?>
         <div class="row">
            <div class="col-md-12 margin-top-10 clients">
<div class="row project-dash">
            	<div class="col-lg-6 col-md-6 col-sm-6 mobileleft">
				<div class="pm-heading" style="width:100%;"><h2><?php echo $lang['Project Title:']; ?> <?php echo $ProjectsLoop[0]->project_title;?> </h2><span><?php echo $lang['All Payment Milestones'] ?></span></div>
				
<?php $recentProjects=projects::findBySql("select * from projects WHERE trash=1");?>
				</div> 
                <div class="col-lg-6 col-md-6 col-sm-6 creative-right text-right">
<div class="mobilepromenu">
				<div class="projbtnm"><a data-toggle="modal" data-target="#add-milestone" class="milebtn"><span>+</span></a></div>
				<div class="projmobilem">
				<i class="fa fa-bars" aria-hidden="true"></i>
					<ul>
<li class="cprojectmsg"><form action="../messages.php?project_id=<?php echo $ProjectsLoop[0]->p_id;?>" method="post">
								<input type="hidden" name="user_id" value="<?php echo $ProjectsLoop[0]->c_id;?>" />
								<input type="hidden" name="project_id" value="<?php echo $ProjectsLoop[0]->p_id;?>" />
								<button type="submit" name="chat"><?php echo $lang['view project']; ?></button>
								</form></li>
					</ul>
					</div>
				</div>
				<ul class="deskvisible">
<li class="cproject"><a data-toggle="modal" data-target="#add-milestone" class="btn milebtn bigbutton"> <?php echo $lang['Add new milestone']; ?> <span>+</span></a></li>
<li class="cprojectmsg"><form action="../messages.php?project_id=<?php echo $ProjectsLoop[0]->p_id;?>" method="post">
								<input type="hidden" name="user_id" value="<?php echo $ProjectsLoop[0]->c_id;?>" />
								<input type="hidden" name="project_id" value="<?php echo $ProjectsLoop[0]->p_id;?>" />
								<button type="submit" name="chat"><?php echo $lang['view project']; ?></button>
								</form></li>
				</ul>
			</div>
			</div>
                <div class="clearfix"></div>
                <?php if(isset($message) && (!empty($message))){echo $message;} ?>
                <?php $recentProjects=milestone::findBySql("select * from milestones where p_id='$projectId'");
				?>
				<div class="row">
                <div class="table-responsive">          
                      <table class="table table-new table-milestones">
                        <thead>
                          <tr>
                            <th><?php echo $lang['No.']; ?></th>
                            <th class="table-title1"><?php echo $lang['Title']; ?></th>
                            <th class="table-due"><?php echo $lang['Deadline']; ?></th>
                            <th class="table-amount"><?php echo $lang['Amount']; ?></th>
                            <th><?php echo $lang['Status']; ?></th>
                            <th><?php echo $lang['Invoice']; ?></th>
                            <th><?php echo $lang['Action']; ?></th>
                          </tr>
                        </thead>
                        <tbody id="projects-tbl">
						  <?php 
						  $counter=1;
						  if($recentProjects == NULL){
						  echo '<tr><td colspan="7">'.$lang['There is no milestones available!'].'</td></tr>';
					  }
                      foreach($recentProjects as $recentProject){ ?>
                      
                            <tr>
                              <td><?php echo $counter; ?></td>
                              <td class="tbl-ttl"><span class="onmobile"><?php echo $lang['Title']; ?>: </span> <?php echo $recentProject->title;?></td>
                              <td><span class="onmobile centera"><?php echo $lang['Deadline']; ?> </span> <?php echo $recentProject->deadline;?></td>
                              <td><span class="onmobile centera"><?php echo $lang['Amount']; ?> </span>  <?php echo $currency_symbol . $recentProject->budget;?></td>
                              <td class="inv-status"><?php if($recentProject->status==0){ echo "<span class='label label-danger'>".$lang['Unpaid']."</span>";}else{ echo "<span class='label label-success'>".$lang['Paid']."</span>";}?></td>
  <td class="invoice tbl-milestons"><form method="post" action="#">
                                	<input type="hidden" value="<?php echo $recentProject->budget;?>" name="edit_id2"/>
                                    <input type="hidden" value="<?php echo $recentProject->id;?>" name="edit_id1"/>
                                    <button type="submit" class="btn outine" name="edit-mile1"> <?php echo $lang['View invoice']; ?></button>
                                </form></td>
                                <td class="editmilestone">
                              	<form method="post" action="#">
                                	<input type="hidden" value="<?php echo $recentProject->id;?>" name="edit_id"/>
                                    <button type="submit" class="btn edit-mile simple" name="edit-mile"><?php echo $lang['Edit Milestone']; ?></button>
                                </form></td> 
                            </tr>
                        <?php 
					 			$counter++;	
								}?>
                    	</tbody>
                      </table>
                	</div>
            </div>
            </div>
        </div><!-- row -->
    </div>
	<div class="clearfix"></div>
		
</div> 
</div> 
</div> 
<?php 
}
?>       
<?php  include("../templates/admin-footer-payment.php"); 
if(isset($_POST["edit-mile"])){?>
<script type="text/javascript">
	
  $("#edit-milestone").modal("show");

</script>
         <?php } 
	  if(isset($_POST["edit-mile1"])){?>
<script type="text/javascript">
	
  $("#edit-milestone1").modal("show");

</script>

      <?php } ?>
<?php
$message = "";
	if(isset($_POST['edit-milestone-1']))
	{
		$mile = milestone::findById($_POST['editId']); 
		
		$flag=0;
		if($flag==0)
		{
			
			$mile->id        		=  $_POST['editId'];
			$mile->p_id	= $_GET['projectId'];
			$mile->title	=$_POST['title1'];
				$mile->budget		=$_POST['amount1'];
				$mile->deadline		=$_POST['deadline1'];
				$mile->releaseDate		= $_POST['releaseDate'];
				$mile->status	= (int)$_POST['status1'];
				
				$saveMile=$mile->save();
	
				if($saveMile)
				{
header('location:payments.php?projectId='.$projectId.'&clientId='.$clientId.'&message=updated'); 
				}
				else
				{
header('location:payments.php?projectId='.$projectId.'&clientId='.$clientId.'&message=notupdated'); 
				}

		

		}
			
		
	}

?>