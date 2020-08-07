<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Edit Existing Project  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Edit Project | ". $syatem_title;
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
$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$settings = settings::findById((int)$id);
$account_stat=$user->status;
$pro_id =  $_POST['p_id'];
if($pro_id == ""){
	header("Location:projects.php");
}
$_SESSION['pro_id'] = $pro_id;
$pro_id_u = $_SESSION['pro_id'];
	if(isset($_POST['update-project'])){

$flag=0;//determines if all posted values are not empty includ
		
if($flag==0)
{
	// $project = new Projects();
	$cont_desc = mysqli_real_escape_string($connect, $_POST['description']);
	$projectTite = mysqli_real_escape_string($connect, $_POST['projectTite']);
	$s_idsa = implode(',', $_POST['staff']);
	$pp_id	= $pro_id;
	$pp_title	= $projectTite;
	$pc_id		=$_POST['client'];
	$ps_ids		= $s_idsa;
	$pp_desc		= $cont_desc;
	$p_budget		=$_POST['budget'];
	$p_status		=$_POST['status'];
	$p_archive		=$_POST['archive'];
	$ps_time		=$_POST['startTime'];
	$pe_time		=$_POST['endTime'];
				  
	$sql_up = "UPDATE `projects` SET
			`c_id`='$pc_id',
			`s_ids`='$ps_ids',
			`project_title`='$pp_title',
			`project_desc`='$pp_desc',
			`budget`='$p_budget',
			`status`='$p_status',
			`archive`='$p_archive',
			`start_time`='$ps_time',
			`end_time`='$pe_time'
			WHERE `p_id`='$pp_id'";
	if ($connect->query($sql_up) === TRUE){
 		$project_title = $_POST['projectTite'];
		if(isset($_POST['notifyClient'])){
			$user = user::findById($_POST['client']); 
			// send verification email
			$to  = $user->email;
			$subject = 'Project Updated';
			$variablesArr = array('{USER_NAME}' => $user->firstName, '{SIGNATURE}' => $company_name, '{DASHBOARD_URL}' => $url, '{PROJECT_NAME}' => $project_title);
			$templateHTML = $settings->project_update_email;
			$message = strtr($templateHTML, $variablesArr);
			// To send HTML mail, the Content-type header must be set (don't change this section)
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			$headers .= 'From: '.$company_name.' <'.$system_email.'>' . "\r\n";
			$emailSent=mail($to,$subject, $message, $headers);
			if($emailSent){ 
				$message="<p class='alert alert-success'><i class='fa fa-check'></i>Project has been created successfully!</p>";
			}
			else{
  				echo "Project has been created successfully! but Error sending the Email please contact site administrator";
			}
			/* Staff Email */
			$all_users=user::findBySql("select * from users");
			foreach($all_users as $recentlyRegisteredUser){ 
				if($recentlyRegisteredUser->accountStatus ==3){  
					$s_all = $_POST['staff'];
					if(in_array($recentlyRegisteredUser->id, $s_all)){
						$user = user::findById($recentlyRegisteredUser->id); 
						// send verification email
						$to  = $user->email; 
						$subject = 'Project Updated';
						$variablesArr = array('{USER_NAME}' => $user->firstName, '{SIGNATURE}' => $company_name, '{DASHBOARD_URL}' => $url, '{PROJECT_NAME}' => $pp_title);
						$templateHTML = $settings->project_update_email;
						$message = strtr($templateHTML, $variablesArr);
						  // To send HTML mail, the Content-type header must be set (don't change this section)
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";	  
						$headers .= 'From: '.$company_name.' <'.$system_email.'>' . "\r\n";
						$emailSent=mail($to,$subject, $message, $headers);
						  
						if($emailSent){ 
						  
						}else{
							header("Location:projects.php?message=error_email");
						}
					}
				}
			}
			/* Staff Email End */
		}
		header("Location:projects.php?message=success");
	} else {
		header("Location:projects.php?message=fail");
	}
		$connect->close();
	}
}
if(isset($_GET['message'])){
	$msgstatus = $_GET['message'];
	$notmessagea = $lang['Record updated successfully'];
	$notmessageb = $lang['Error! Please Try Again later.'];
	if($msgstatus == 'success'){
		$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessagea."</p>";
	}
	if($msgstatus == 'fail'){		 
		$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessageb."</p>"; 
	}
}
?>
	
    
<div class="page-container">
	<div class="container-fluid">
		<div class="row row-eq-height">
			<?php  include("../templates/sidebar.php"); ?>
			
		    <div class="page-content col-lg-9 col-md-12 col-sm-12 col-lg-push-3">
				<?php include('../templates/top-header.php'); ?>
				<!-- Add Pro -->
				<div class="row add-progress">
					<div class="col-md-12">
						<h2 class="text-center progress-bar-top">Create a Work Order</h2>
					</div>
					<div class="col-md-12">
						<div class="progress">
						  <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
						  aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:0%">
						    0%
						  </div>
						</div>

					</div>
				</div>

				<div class="row alert-row">
					<div class="col-sm-12 alert-row-group">
						
					</div>
				</div>

				<div class="row">
					<div class="col-md-12 margin-top-10 clients">
						<div class="add-project">
						<?php 
							$qur_pro = projects::findBySql("select * from projects where p_id = '$pro_id'");
							$qur_ar = $qur_pro[0];

							$client_id = $qur_ar->c_id;
							$staff_id = $qur_ar->s_ids;
							$project_title = $qur_ar->project_title;
							$comment = $qur_ar->comment;
							$budget = $qur_ar->budget;
							$status = $qur_ar->status;
							$archive = $qur_ar->archive;
							$start_time = $qur_ar->start_time;
							$end_time = $qur_ar->end_time;
							$st_ids = explode(',', $staff_id); 
							$prep_service = $qur_ar->prep_service;
							$speed_service = "";
							$price_service = "";

							$save_packing = $qur_ar->save_packing;
							$shipment_optm = $qur_ar->shipment_optm;
							$promo_code = $qur_ar->promo_code;

							if($prep_service == '1')
							{
								$speed_service = ' active';
							}else if($prep_service == '2')
							{
								$price_service = ' active';
							}
							$recentlyRegisteredUsers=user::findBySql("select * from users");

							$items = items::findBySql("select * from project_items where p_id = '$pro_id'");
							$bundleitems = bundleitems::findBySql("select * from project_bundleitems where p_id = '$pro_id'");
						?>
							<form method="post" action="#" enctype="multipart/form-data">
								<div class="row">
								    <div class="col-md-12 margin-top-10 clients">
								        <?php if(isset($message) && (!empty($message))){echo $message;} ?>
									</div>
								    <div class="col-md-3">
								    	<div class="project-header">
								        	<h2><?php echo $lang['Edit Project']; ?> </h2>
										</div>
										<div class="project-himg">
											<img src="<?php echo $url?>images/create-a-project.png" class="img-fluid"/> 
										</div>
								    </div>
									<div class="col-md-8">


										<div class="page_step_form active" id="form_step_1">
											<div class="form-group">
												<div class="field-label"><label for="firstName"><?php echo $lang['Project Title*']; ?></label></div>
												<input type="text" name="projectTite" class="form-control" value="<?php echo $project_title; ?>" required>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<div class="field-label"><label for="firstName"><?php echo $lang['Select Client*']; ?></label></div>
														<select class="ui dropdown form-control" name="client">
															 <option value=""><?php echo $lang['Select a client']; ?></option>
															<?php 
																	foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
																		if($recentlyRegisteredUser->accountStatus ==2){
																			?>
																			<option value="<?php echo $recentlyRegisteredUser->id; ?>" <?php if($recentlyRegisteredUser->id == $client_id){ ?> selected="selected" <?php } ?>><?php echo $recentlyRegisteredUser->firstName; ?></option>
																			<?php 
																		}
																	}?>
														</select>
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<div class="field-label">
															<label for="firstName"><?php echo $lang['Assign staff']; ?></label>
														</div>
														<input type="hidden" name="staff[]" value="1" />
														<input type="hidden" name="staff[]" class="new_val" />
														<select multiple class="ui dropdown form-control" name="staff[]">
															<?php 
																foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
																	if($recentlyRegisteredUser->accountStatus ==3){
																		?>
																		<option value="<?php echo $recentlyRegisteredUser->id; ?>" <?php if(in_array($recentlyRegisteredUser->id, $st_ids)){ echo 'selected';}?>><?php echo $recentlyRegisteredUser->firstName; ?></option>
																		<?php 
																	}
																}
															?>
														</select>
													</div>
												</div>

												<div class="col-md-12 input-notify">
													<div class="form-group">
														<div class="inline field">
														    <div class="ui toggle checkbox custom-btnc email_notification checked">
															<input type="checkbox" name="notifyClient" tabindex="0" checked class="hidden"/>
														      <label><?php echo $lang['Email Notification']; ?><br><span><?php echo $lang['Notify to client and staff project has been created']; ?></span></label>
														    </div>
														    <a class="btn new-btnblue btn_step_next">Next</a>
														</div>
													</div>
												</div>
											</div>
										</div>	


										<div class="page_step_form" id="form_step_2">
											<div class="row">
												<div class="col-md-12">
													<div class="prep-service row <?php echo $speed_service ?>" role="1">
														<div class="col-md-3">
															<img width="100%" src="/assets/images/icon-speed.jpg">
														</div>
														<div class="col-md-9">
															<div class="title">
																<span class="sp-center">Optimize prep services for SPEED</span>
																<span class="sp-right"><i class="fa fa-check"></i></span>
															</div>
															<div class="description">
																<span>With <b>Speed Optimization</b>, we don't wait for all of your items to arrive before shipping!  Your items will be placed in one shipping plan<b> as they are delivered</b> and typically prepped &amp; shipped to Amazon, within 24-48 hours of receipt.</span>
															</div>
														</div>
													</div>
												</div>

												<div class="col-md-12">
													<div class="prep-service row <?php echo $price_service ?>" role="2">
														<div class="col-md-3">
															<img width="100%" src="/assets/images/icon-price.jpg">
														</div>
														<div class="col-md-9">
															<div class="title">
																<span class="sp-center">Optimize prep services for PRICE</span>
																<span class="sp-right"><i class="fa fa-check"></i></span>
															</div>
															<div class="description">
																<span>
																With <b>Price Optimization</b>, we'll wait until all of the items in each work order are delivered before shipping to Amazon.  Each work order correlates to it's own separate shipping plan, and we typically ship within 24-48 hours of delivery of the <b>last item</b> from that work order.</span>
															</div>
														</div>
														
													</div>
												</div>
												<input type="hidden" class="prep_service" name="prev_service" value="0">
												<div class="col-md-12 text-center">
													(For either selection, we do not combine work orders, and <b>Small Quantity thresholds apply</b>.)</span>
												</div>

												<div class="col-md-12 input-notify">
													<div class="form-group">
														<div class="inline field">
														    <a class="btn new-btnblue btn_step_prev" style="float: left;">Prev</a>
														    <a class="btn new-btnblue btn_step_next" style="float: right;">Next</a>
														</div>
													</div>
												</div>
											</div>
										</div>	

										<div class="page_step_form" id="form_step_3">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<div class="inline field">
															<?php
																if(count($items) == 0)
																{
															?>
																<div class="ui toggle checkbox custom-btnc toggle_item">
																	<input type="checkbox" name="notifyClient" tabindex="0" class="hidden"/>
															      	<label>Do you have any units sold individually? (NOT a bundle/multipack)</label>
															    </div>
															<?php
																}else if(count($items) > 0){
															?>
																<div class="ui toggle checkbox custom-btnc toggle_item checked">
																	<input type="checkbox" name="notifyClient" tabindex="0" class="hidden" checked />
															      	<label>Do you have any units sold individually? (NOT a bundle/multipack)</label>
															    </div>
															<?php		
																}
															?>
														    
														</div>
													</div>
												</div>
												
												<?php 
													if(count($items) == 0){
												?>

												<div class="col-md-12 marchant-rows">
													<h2>Units Sold Individually (No bundles/multipacks listed here)</h2>
													<div class="row marchant-group">
														<div class="col-md-3">
															<input type="text" name="SKU" class="form-control input_sku" placeholder="Merchant SKU" required>
														</div>

														<div class="col-md-3">
															<input type="text" name="ASIN" class="form-control input_asin" placeholder="ASIN" required>
														</div>

														<div class="col-md-3">
															<input type="text" name="itemName" class="form-control input_itemname" placeholder="Unit Name" required>
														</div>

														<div class="col-md-3">
															<input type="number" name="Qty" class="form-control input_qty" placeholder="Qty" required>
														</div>

														<div class="col-sm-12 btn-manage">
															<div>
																<a class="btn_item_add"><i class="fa fa-plus"></i></a>
															</div>
															
														</div>
													</div>
												</div>

												<?php
													}else if(count($items) > 0){
												?>
												<div class="col-md-12 marchant-rows show">
													<h2>Units Sold Individually (No bundles/multipacks listed here)</h2>
													<?php
														foreach ($items as $k => $item) {
													?>
														<div class="row marchant-group">
															<div class="col-md-3">
																<input type="text" name="SKU" class="form-control input_sku" placeholder="Merchant SKU" value="<?php echo $item->SKU ?>" required>
															</div>

															<div class="col-md-3">
																<input type="text" name="ASIN" value="<?php echo $item->ASIN ?>" class="form-control input_asin" placeholder="ASIN" maxlength="10" required>
															</div>

															<div class="col-md-3">
																<input type="text" name="itemName" class="form-control input_itemname" placeholder="Unit Name" value="<?php echo $item->name ?>" required>
															</div>

															<div class="col-md-3">
																<input type="number" name="Qty" class="form-control input_qty" placeholder="Qty" value="<?php echo $item->Qty ?>" required>
															</div>

															<div class="col-sm-12 btn-manage">
																<div>
																	<a class="btn_item_add"><i class="fa fa-plus"></i></a>
																	<?php 
																		if($k > 0)
																		{
																	?>
																	<a class="btn_marchant_remove"><i class="fa fa-times"></i></a>
																	<?php
																		}

																	?>
																</div>
																
															</div>
														</div>
													<?php
														}
													?>
													
												</div>
												<?php		
													}
												?>
												

												<div class="col-md-12">
													<div class="form-group">
														<div class="inline field">
															<?php 
																if(count($bundleitems) > 0)
																{
															?>
																<div class="ui toggle checkbox custom-btnc toggle_bundle checked">
																	<input type="checkbox" name="notifyClient" tabindex="0" class="hidden" checked />
																     <label>Do you have any bundles and/or multipacks?</label>
															    </div>
															<?php
																}else{
															?>
															<div class="ui toggle checkbox custom-btnc toggle_bundle">
																<input type="checkbox" name="notifyClient" tabindex="0" class="hidden"/>
															     <label>Do you have any bundles and/or multipacks?</label>
														    </div>
															<?php
																}
															?>
														    
														</div>
													</div>
												</div>

												<?php 
													if(count($bundleitems) > 0)
													{
												?>
													<div class="col-md-12 bundle-rows show">
														<h2>Units Sold as Bundles or Multipacks</h2>
														<?php 
															foreach ($bundleitems as $i => $bundleitem) {
														?>
														<div class="row bundle-group">
															<div class="col-md-7">
																<div class="row">
																	<div class="col-md-4">
																		<input type="text" name="SKU" class="form-control input_bundle_sku" placeholder="Merchant SKU" value="<?php echo $bundleitem->SKU ?>" required>
																	</div>

																	<div class="col-md-4">
																		<input type="text" name="ASIN" class="form-control input_bundle_asin" value="<?php echo $bundleitem->ASIN ?>" placeholder="ASIN" maxlength="10" required>
																	</div>

																	<div class="col-md-4">
																		<input type="text" name="itemName" class="form-control input_bundle_itemname" value="<?php echo $bundleitem->name ?>" placeholder="Unit Name" required>
																	</div>
																</div>
															</div>

															<div class="col-md-5">
																<div class="row">
																	<div class="col-md-6">
																		<input type="number" name="Qty" class="form-control input_bundle_qty" placeholder="Qty in bundle" value="<?php echo $bundleitem->bundle_qty ?>" required>
																	</div>

																	<div class="col-md-6">
																		<input type="number" name="total" class="form-control input_bundle_total" value="<?php echo $bundleitem->total ?>" placeholder="Total # of bundles" required>
																	</div>
																</div>
															</div>

															<div class="col-sm-12 btn-manage">
																<div>
																	<a class="btn_bundle_add"><i class="fa fa-plus"></i></a>
																	<?php 
																		if($i > 0)
																		{
																	?>
																	<a class="btn_bundle_remove"><i class="fa fa-times"></i></a>
																	<?php 
																		}
																	?>
																	
																</div>
																
															</div>
														</div>
														<?php
															}
														?>	
													</div>
												<?php
													}else{
												?>
												<div class="col-md-12 bundle-rows">
													<h2>Units Sold as Bundles or Multipacks</h2>
													<div class="row bundle-group">
														<div class="col-md-7">
															<div class="row">
																<div class="col-md-4">
																	<input type="text" name="SKU" class="form-control input_bundle_sku" placeholder="Merchant SKU" required>
																</div>

																<div class="col-md-4">
																	<input type="text" name="ASIN" class="form-control input_bundle_asin" placeholder="ASIN" required>
																</div>

																<div class="col-md-4">
																	<input type="text" name="itemName" class="form-control input_bundle_itemname" placeholder="Unit Name" required>
																</div>
															</div>
														</div>

														<div class="col-md-5">
															<div class="row">
																<div class="col-md-6">
																	<input type="number" name="ASIN" class="form-control input_bundle_qty" placeholder="Qty in bundle" required>
																</div>

																<div class="col-md-6">
																	<input type="number" name="Qty" class="form-control input_bundle_total" placeholder="Total # of bundles" required>
																</div>
															</div>
														</div>

														<div class="col-sm-12 btn-manage">
															<div>
																<a class="btn_bundle_add"><i class="fa fa-plus"></i></a>
															</div>
															
														</div>
													</div>
												</div>
												<?php 
													}
												?>
												
												<div class="col-md-12 input-notify">
													<div class="form-group">
														<div class="inline field">
														    <a class="btn new-btnblue btn_step_prev" style="float: left;">Prev</a>
														    <a class="btn new-btnblue btn_step_next" style="float: right;">Next</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="page_step_form" id="form_step_4">
											<div class="form-group">
												<h3>Shipment Optimization (+$25)</h3>
												<div class="inline field">
													<?php 
														if($shipment_optm == '0')
														{
													?>
													<div class="ui toggle checkbox custom-btnc shipment_optimization">
														<input type="checkbox" name="notifyClient" tabindex="0" class="hidden"/>
													    <label>Yes!  Optimize my shipment to save me money!<br>
													      	<span>With Shipment Optimization, we’ll find the best price for your shipment! <br>(Pricing is for each fulfillment center Amazon specifies shipping to)
													      	</span>
													    </label>
												    </div>
													<?php
														}else if($shipment_optm == '1'){
													?>
													<div class="ui toggle checkbox custom-btnc shipment_optimization checked">
														<input type="checkbox" name="notifyClient" tabindex="0" class="hidden" checked />
													    <label>Yes!  Optimize my shipment to save me money!<br>
													      	<span>With Shipment Optimization, we’ll find the best price for your shipment! <br>(Pricing is for each fulfillment center Amazon specifies shipping to)
													      	</span>
													    </label>
												    </div>
													<?php 
														}
													?>
												    
												</div>
											</div>

											<div class="form-group">
												<h3>Save Packing Slips (+$1 per slip/box)</h3>
												<div class="inline field">
													<?php 
														if($save_packing == '0'){
													?>
													<div class="ui toggle checkbox custom-btnc save_packing">
														<input type="checkbox" name="notifyClient" tabindex="0" class="hidden"/>
													    <label>Send me a scanned copy of my packing slips!</label>
												    </div>
													<?php
														}else if($save_packing == '1'){
													?>
													<div class="ui toggle checkbox custom-btnc save_packing checked">
														<input type="checkbox" name="notifyClient" tabindex="0" class="hidden" checked />
													    <label>Send me a scanned copy of my packing slips!</label>
												    </div>
													<?php
														}
													?>
												    
												</div>
											</div>

											<div class="form-group">
												<div class="field-label">
													<label for="firstName">Any notes or comments?</label>
												</div>
												<textarea class="form-control" name="description"><?php echo $qur_ar->comment ?></textarea>
											</div>	

											<div class="form-group">
												<h2>Promo code</h2>
												<input type="text" name="promoCode" class="form-control" placeholder="" value="<?php echo $qur_ar->promo_code ?>" required>
											</div>

											
											<div class="row">
												<div class="col-md-12 input-notify">
													<div class="form-group">
														<div class="inline field">
														    <a class="btn new-btnblue btn_step_prev" style="float: left;">Prev</a>
														    <a class="btn new-btnblue btn_step_next" style="float: right;">Next</a>
														</div>
													</div>
												</div>
											</div>
										</div>	

										<div class="page_step_form" id="form_step_5">
											<div class="row">
												<div class="col-sm-12">
													<h2 class="project_title"></h2>
												</div>
												<div class="col-md-6">
													<h2 class="summary_client">Client: </h2>
												</div>
												<div class="col-md-6">
													<h2 class="summary_staffs">Staffs: </h2>
												</div>
												<div class="col-md-12">
													<h2 class="selected_service"></h2>
												</div>

					

												<div class="col-md-12 individual_summary_group">
													<h2 style="margin: 10px 0">Units Sold Individually </h2>
													<table class="table summary_table" >
														<thead>
															<tr>
																<th>Merchant SKU</th>
																<th>ASIN</th>
																<th>Unit Name</th>
																<th>Qty</th>
															</tr>
														</thead>
														<tbody class="summary_tbody">
															
														</tbody>
														<tfoot>
															<tr>
																<td class="summary_skus" colspan="2">
																	
																</td>

																<td class="summary_qty" colspan="2">
																	
																</td>
															</tr>
														</tfoot>
													</table>
												</div>

												<div class="col-md-12 bundle_summary_group">
													<h2 style="margin: 10px 0">Units Sold as Bundles or Multipacks </h2>
													<table class="table summary_bundle_table" >
														<thead>
															<tr>
																<th>Merchant SKU</th>	
																<th>ASIN</th>											
																<th>Unit Name</th>
																<th>Qty in bundle</th>
																<th>Total # of bundles</th>
															</tr>
														</thead>
														<tbody class="summary_bundle_tbody">
															
														</tbody>
														<tfoot class="summary_bundle_tfoot">
															<tr>
																<td class="total_bundle_qty" colspan="3"></td>
																<td class="total_bundle_total" colspan="2"></td>
															</tr>
														</tfoot>
													</table>
												</div>

												<div class="col-md-12">
													<div class="row">
														<div class="col-sm-6 shipment_optimization_group">
															<h2>Shipment Optimization (+$25)</h2>
														</div>

														<div class="col-sm-6 save_packing_group">
															<h2>Save Packing Slips (+$1 per slip/box)</h2>
														</div>
													</div>
												</div>



												<div class="col-md-12 comments_group">
													<h2 style="margin: 10px 0">Notes or comments</h2>
													<textarea class="project_description" disabled="true" style="width: 100%; height: 150px">
														
													</textarea>
												</div>

												<div class="col-sm-12 promocode_group">
													<h2 class=summary_promocode></h2>
												</div>

												<div class="col-md-12">
													<div class="row">
														<div class="col-sm-6 total_skus_group">
															<h2 class=total_skus></h2>
														</div>

														<div class="col-sm-6 total_units_group">
															<h2 class=total_units></h2>
														</div>
													</div>
												</div>

												


												<div class="col-sm-12">
													<h2 class="terms_title">Consent to Terms & Conditions</h2>
													<label class="checkbox col-lg-12 terms_content">
														<input type="checkbox" name="terms" value="1"> <span></span>I agree to the <a href="https://www.profitgopher.com/terms-of-service" target="_blank">Terms and Conditions<a> of Profit Gopher.
													</label>

													<p>I understand that my choice of Speed or Price Optimization is final and cannot be changed later. I have checked my submission for accuracy and agree to be bound by the information I provided.</p>

												</div>
												<div class="col-md-12 input-notify">
													<div class="form-group">
														<div class="inline field">
														    <a class="btn new-btnblue btn_step_prev" style="float: left;">Prev</a>
														</div>
													</div>

													<div class="form-group">
														<div class="inline field">
															<a class="btn new-btnblue btn_update_project" name="update-project" role="<?php echo $pro_id ?>">Update Project</a>
														</div>
													</div>
													
												</div>
											</div>
										</div>	

									</div>
								</div>
							    <div class="clearfix"></div> 
							</form>
						</div><!--add-project -->
					                
					</div>
				</div><!-- row -->
			</div>
			<div class="clearfix"></div>
				
		</div>        
	</div>        
</div>    
<script type="text/javascript">
	var base_dir = '<?php echo dirname($_SERVER["REQUEST_URI"]) ?>';
	var userstatus = parseInt('<?php echo $_SESSION["accountStatus"] ?>');
	var currentdate = '<?php echo date("M/d/yy") ?>';
	var current_username = '<?php echo $username ?>';
	var current_userId = '<?php echo $id ?>';
</script>     
<?php  include("../templates/admin-footer.php"); ?>
<script>
$('.custom-btnc').checkbox();
</script>