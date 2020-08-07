<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Admin Dashboard  //////////////////////////
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
if($_SESSION['accountStatus'] == 3){
	redirectTo($url."staff/index.php");
}
date_default_timezone_set($time_zone);

//condition check for login

$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$account_stat=$user->status;
$user->regDate;
$month = date('m');
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
$projects = projects::findBySql("SELECT * FROM projects");
$projectsb = projects::findBySql("SELECT * FROM projects WHERE MONTH(start_time) = $month");
$invoice_budget = milestone::findBySql("SELECT budget FROM milestones WHERE status = '1'");
$recvable = milestone::findBySql("SELECT budget FROM milestones WHERE status = '0'");
$curr_year = date("Y");
$this_month = milestone::findBySql("SELECT budget FROM milestones WHERE YEAR(releaseDate) = $curr_year AND MONTH(releaseDate) = $month AND status = '1'");
$all_usera = user::findBySql("SELECT * FROM users");
$new_clients = user::findBySql("SELECT * FROM users WHERE MONTH(regDate) = $month AND accountStatus = 2");
$old_clients = user::findBySql("SELECT * FROM users WHERE MONTH(regDate) != $month AND accountStatus = 2");
$staff_mem = 0;
$clients_mem = 0;
foreach($all_usera as $all_user){
	$staffmemb = $all_user->accountStatus;
	if($staffmemb == 3 ){
		$staff_mem++;
	}
	if($staffmemb == 2 ){
		$clients_mem++;
	}
}
$projects_ip = 0;
$projects_c = 0;
foreach($projects as $project){
	$prostatus = $project->status;
	if($prostatus == 0){
		$projects_ip++;
	}
	if($prostatus == 1){
		$projects_c++;
	}
}
$current_m = 0;
$fbudget = 0;
$rfbudget = 0;
	foreach($this_month as $current){
	$current_m += $current->budget;
	}
	foreach($invoice_budget as $budget){
		$fbudget+= $budget->budget;	
	}
	foreach($recvable as $rbudget){
		$rfbudget+= $rbudget->budget;	
	}
?>

    
<div class="page-container">
<div class="container-fluid">
<div class="row row-eq-height">
	<?php  include("../templates/sidebar.php"); ?>
	
    <div class="page-content dashboard-page col-lg-9 col-md-12 col-sm-12 col-lg-push-3" style="padding-bottom:0px !important;">
<?php include('../templates/top-header.php'); ?>
<div class="row db-container cont-top-main">
<div class="col-lg-4 col-md-6 col-sm-12">
<div class="db-box-wrap"> 
<div class="db-boxh"><div class="db-hlft"><?php echo $lang['TOTAL PROJECTS']; ?></div><div class="db-hrt"><a href="<?php echo $url; ?>admin/projects.php"><?php echo $lang['View all']; ?></a></div></div>
<div class="chart-wrap">
<div id="chartContainer" style="height: 230px; max-width: 920px; margin: 0px auto;"></div>
<div class="total-pro"><?php echo count($projects); ?><span><?php echo $lang['Total Projects']; ?></span></div>
</div>
<div class="container">
<div class="row chart-footer">
<div class="col-md-6 foot-c-box"><span class="fc-scolor"></span><?php echo $projects_c; ?><span class="fctxt"><?php echo $lang['Completed Projects']; ?></span></div>
<div class="col-md-6 foot-c-box"><span class="fc-fcolor"></span><?php echo $projects_ip; ?><span class="fctxt"><?php echo $lang['Inprogress Projects']; ?></span></div>
</div>
</div>
</div>
</div>
<div class="col-lg-4 col-md-6 col-sm-12 clients-chart">
<div class="db-box-wrap">
<div class="db-boxh"><div class="db-hlft"><?php echo $lang['TOTAL CLIENTS']; ?></div><div class="db-hrt"><a href="<?php echo $url;?>admin/clients.php"><?php echo $lang['View all']; ?></a></div></div>
<div class="chart-wrap">
<div id="chartContainer2" style="height: 230px; max-width: 920px; margin: 0px auto;"></div>
<div class="total-pro"><?php echo $clients_mem; ?><span><?php echo $lang['Total Clients']; ?></span></div>
</div>
<div class="container">
<div class="row chart-footer">
<div class="col-md-6 foot-c-box"><span class="fc-fcolor"></span><?php echo count($old_clients); ?><span class="fctxt"><?php echo $lang['Lifetime Clients']; ?></span></div> 
<div class="col-md-6 foot-c-box"><span class="fc-scolor"></span><?php echo count($new_clients); ?><span class="fctxt"><?php echo $lang['New Clients']; ?></span></div>
</div>
</div>
</div> 
</div>
<div class="col-lg-4 col-md-12 col-sm-12">
<div class="admin-dash-rt blue-shadow">
<div class="container">
<div class="row"> 
<div class="col-lg-8 col-md-8 col-sm-8 col-8 dash-lftb"><span><?php echo $lang['New Projects in this month']; ?></span></div>
<div class="col-lg-4 col-md-4 col-sm-4 col-4 dash-rttb"><?php echo count($projectsb); ?></div>
</div>
</div>
</div>
<div class="admin-dash-rt white-admin-box admin-mid-box">
<div class="container">
<div class="row"> 
<div class="col-lg-8 col-md-8 col-sm-8 col-8 dash-lftb"><span><?php echo $lang['TOTAL STAFF']; ?></span><a href="<?php echo $url; ?>admin/staff.php"><?php echo $lang['View members']; ?></a></div>
<div class="col-lg-4 col-md-4 col-sm-4 col-4 dash-rttb"><?php echo $staff_mem; ?></div>
</div>
</div>
</div>
<div class="admin-dash-rt white-admin-box">
<div class="container">
<div class="row"> 
<div class="col-lg-8 col-md-8 col-sm-8 col-8 dash-lftb"><span><?php echo $lang['Unpaid Invoices']; ?></span><a href="<?php echo $url; ?>admin/unpaid-invoices.php"><?php echo $lang['View Invoices']; ?></a></div>
<div class="col-lg-4 col-md-4 col-sm-4 col-4 dash-rttb"><?php echo count($recvable); ?></div>
</div>
</div>
</div>
</div>
</div>

<div class="row cont-bot-main">
<div class="col-md-4 col-sm-4">
<div class="monthly-rev">
<div class="month-heading"><?php echo $lang['revenue this month']; ?></div>
<div class="month-rps"><?php echo $currency_symbol . $current_m;?></div>
<div class="form-group">
<select class="form-control month-drop">
    <option <?php if($month == '01'){echo 'selected';} ?> value='01'>Janaury</option>
    <option <?php if($month == '02'){echo 'selected';} ?> value='02'>February</option>
    <option <?php if($month == '03'){echo 'selected';} ?> value='03'>March</option>
    <option <?php if($month == '04'){echo 'selected';} ?> value='04'>April</option>
    <option <?php if($month == '05'){echo 'selected';} ?> value='05'>May</option>
    <option <?php if($month == '06'){echo 'selected';} ?> value='06'>June</option>
    <option <?php if($month == '07'){echo 'selected';} ?> value='07'>July</option>
    <option <?php if($month == '08'){echo 'selected';} ?> value='08'>August</option>
    <option <?php if($month == '09'){echo 'selected';} ?> value='09'>September</option>
    <option <?php if($month == '10'){echo 'selected';} ?> value='10'>October</option>
    <option <?php if($month == '11'){echo 'selected';} ?> value='11'>November</option>
    <option <?php if($month == '12'){echo 'selected';} ?> value='12'>December</option>
</select>
</div>
</div>
</div>
<div class="col-md-8 col-sm-8">
<div class="container dash-total-wrap">
<div class="dash-centhead"><?php echo $lang['ACCOUNTING']; ?></div>
<div class="row">
<div class="dascont-comn dascont-lft col-md-6">
<div class="dash-shead"><?php echo $lang['Total Earnings']; ?></div>
<div class="dash-sprice"><?php echo $currency_symbol . $fbudget; ?></div>
</div>
<div class="dascont-comn dascont-rt col-md-6">
<div class="dash-shead"><?php echo $lang['Account Receivable']; ?></div>
<div class="dash-sprice"><?php echo $currency_symbol . $rfbudget; ?></div>
</div>
</div>
</div>
</div>

</div>
      <div class="row db-container cont-bot-main">
         <div class="col-lg-8 col-md-12 col-sm-12">
           <div class="db-box-wrap db-box-wrapadmin">
<div class="db-boxh"><div class="db-hlft"><?php echo $lang['RUNNING PROJECTS']; ?></div><div class="db-hrt"><a href="<?php echo $url; ?>admin/projects.php"><?php echo $lang['View all']; ?></a></div></div>
         <div class="dashbord-pro">
 <?php 
 $recentProjects_page=projects::findBySql("select * from projects WHERE archive=0 AND trash != 1"); 
$recentProjects=projects::findBySql("select * from projects WHERE archive=0 AND trash != 1 ORDER BY start_time DESC LIMIT 8"); 
?>
 
 <div class="table-responsive">          
                      <table class="table table-new projectspage indexpage" data-pagination="true" data-page-size="5">
                        <thead>
                          <tr>
                            <th width="26%"><?php echo $lang['Project Name']; ?></th> 
                            <th><?php echo $lang['Assign Team']; ?></th>
                            <th><?php echo $lang['Client']; ?></th>
                            <th><?php echo $lang['Deadline']; ?></th>
                            <th><?php echo $lang['Status']; ?></th>
                            <th><?php echo $lang['Chat']; ?></th>
                          </tr>
                        </thead>
                        <tbody id="projects-tbl">
						  <?php 
						  $counter=1;
					if($recentProjects == NULL){
						  echo '<tr><td colspan="6">';
						  echo $lang['There is no Project Please Create Project!'];
						  echo '</td></tr>';
					  }
                      foreach($recentProjects as $recentProject){ ?>
                      
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
								   echo '<div class="plus-more">+'. $more .'</div>'; 
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
                              <td><span class="onmobile"><?php echo $lang['Deadline']; ?>: </span>
							  <?php echo $recentProject->end_time;?></td>
                              <td class="prostatus">
							  <?php $status = $recentProject->status;
							  $archive = $recentProject->archive;
							  $trash = $recentProject->trash;
							  if($status == 0){ ?>
							  <span class="inprogress"><?php echo $lang['IN PROGRESS']; ?></span>
							  <?php } else { ?>
								<span class="completed"><?php echo $lang['COMPLETED']; ?></span>
							  <?php }?>
							  </td>
                             
                              <td class="cliproj-bodybox newprobox">
							  <form action="../messages.php?project_id=<?php echo $recentProject->p_id;?>" method="post">
								<input type="hidden" name="user_id" value="<?php echo $recentProject->c_id;?>" />
								<input type="hidden" name="project_id" value="<?php echo $recentProject->p_id;?>" />
								<button type="submit" class="disbtnbox" name="chat"><i class="fa fa-comments-o"></i></button>
								</form>
								</td>
                            </tr>
                          
                        <?php 
					 			$counter++;	
								} ?>
                    	</tbody>
                      </table>
<?php $total_records = count($recentProjects_page);  
$total_pages = ceil($total_records / $limit); ?>

                	</div>

         </div>
          </div>
       </div>
       
        <div class="col-lg-4 col-md-12 col-sm-12">
     <div class="notepadcs admin-notepad">
<form action="#" method="post">
<h2><?php echo $lang['Sticky Note']; ?><input name="savenote" type="submit" value="<?php echo $lang['Save Note']; ?>" /></h2>
<textarea name="snote" class="snote" placeholder="<?php echo $lang['Write note Here!']; ?>"><?php echo $user->note;?></textarea>
</form>
</div>
     </div>
       
       
     </div>


         </div>
    
	<div class="clearfix"></div>
		
</div>        
</div>        
</div>
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <script type="text/javascript"> 
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
		["Task", 'Hours per Day'],
          ["<?php echo $lang["Inprogress Projects"]; ?>",     <?php echo $projects_ip; ?>],
          ["<?php echo $lang["Completed Projects"]; ?>",      <?php echo $projects_c; ?>]
        ]);
        var options = {
          title: '',
          pieHole: 0.8,
		  pieSliceText: 'none',
		  legend: {position: 'none'},
		  chartArea:{left:10,top:10,right:10,bottom:10,width:"100%",height:"100%"},
		   tooltip: { text: 'value', textStyle: {fontSize: 12}, },
		  slices: {0: {color: '#7eb735'}, 1:{color: '#1f95ff'}},
        };		

        var chartb = new google.visualization.PieChart(document.getElementById('chartContainer'));
        chartb.draw(data, options);
      }
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChartb);
      function drawChartb() {
        var datab = google.visualization.arrayToDataTable([
		["Task", "Hours per Day"],
          ["<?php echo $lang["New Clients this Month"]; ?>",     <?php echo count($new_clients); ?>],
          ["<?php echo $lang["Lifetime Clients"]; ?>",     <?php echo count($old_clients); ?> ]
        ]);
        var optionsb = {
          title: '',
          pieHole: 0.8,
		  pieSliceText: 'none',
		  legend: {position: 'none'},
		  chartArea:{left:10,top:10,right:10,bottom:10,width:"100%",height:"100%"},
		   tooltip: { text: 'value', textStyle: {fontSize: 12}, },
		  slices: {0: {color: '#7eb735'}, 1:{color: '#1f95ff'}},
        };		

        var chartb = new google.visualization.PieChart(document.getElementById('chartContainer2'));
        chartb.draw(datab, optionsb);
      }
    </script>

<?php  include("../templates/admin-footer.php"); ?>