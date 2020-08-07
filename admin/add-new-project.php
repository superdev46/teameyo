<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Add New Projects  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Add New Project | ". $syatem_title;
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
$settings = settings::findById((int)$id);
$message = "";

	if(isset($_POST['add-project']))
	{
		
		$flag=0;//determines if all posted values are not empty includ
		
		if($flag==0)
		{
			$project = new Projects();
			$s_idsa = implode(',', $_POST['staff']);
			$project->project_title	=$_POST['projectTite'];
			$project->p_id		= (int)NULL;
			$project->c_id		=$_POST['client'];
			$project->s_ids		= $s_idsa;
			$project->project_desc		=$_POST['description'];
			$project->budget		=$_POST['budget'];
			$project->status		=$_POST['status'];
			$project->archive		=$_POST['archive'];
			$project->trash		= 0 ;
			$project->start_time		=$_POST['startTime'];
			$project->end_time		=$_POST['endTime'];
			$saveProject=$project->save();


			$notmessagea = $lang['Project has been created successfully!'];
			$notmessageb = $lang['Project could not created at this time. Please Try Again Later . Thanks'];

		    if($saveProject)
		    {
			  	$project_title = $_POST['projectTite'];
			  	if(isset($_POST['notifyClient'])){
					$user = user::findById($_POST['client']); 
					// send verification email
					$to  = $user->email;
		  			$subject = 'New Project Created';
					$variablesArr = array('{USER_NAME}' => $user->firstName, '{SIGNATURE}' => $company_name, '{DASHBOARD_URL}' => $url, '{PROJECT_NAME}' => $project_title);
					$templateHTML = $settings->project_assign_email;
					$message = strtr($templateHTML, $variablesArr);
				  // To send HTML mail, the Content-type header must be set (don't change this section)
				  $headers  = 'MIME-Version: 1.0' . "\r\n";
				  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				  
				  $headers .= 'From: '.$company_name.' <'.$system_email.'>' . "\r\n";
				  $emailSent=mail($to,$subject, $message, $headers);
				  if($emailSent){ 
			  			$message="<p class='alert alert-success'><i class='fa fa-check'></i> Project has been created successfully!</p>";
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
							$subject = 'Project assignment notification';
							$variablesArr = array('{USER_NAME}' => $user->firstName, '{SIGNATURE}' => $company_name, '{DASHBOARD_URL}' => $url, '{PROJECT_NAME}' =>  $project_title);
							$templateHTML = $settings->assign_staff_email;
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
				} else{
					$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessagea."</p>";
				}
				header("Location:projects.php?message=created");
		    }
		    else
		    {
			  $message="<p class='alert alert-danger'><i class='fa fa-times'></i> ".$notmessageb."</p>";
		    }
		}
			
		
	}	
?>
    
<div class="page-container">
<div class="container-fluid">
<div class="row row-eq-height">
	<?php  include("../templates/sidebar.php"); ?>
	
    <div class="page-content col-lg-9 col-md-12 col-sm-12 col-lg-push-3">
	<?php include('../templates/top-header.php'); ?>

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
            <?php if(isset($message) && (!empty($message))){echo $message;} ?>
            <div class="add-project">
          	<form method="post" action="#" enctype="multipart/form-data">
				<div class="row">
    				<div class="col-md-3">
			        	<div class="project-header">
			            	<h2><?php echo $lang['Create New Project']; ?> </h2>
							<p><?php echo $lang['create a project and assigned the staff here.']; ?></p>
						</div>
						<div class="project-himg">
						<img src="<?php echo $url?>images/create-a-project.png" class="img-fluid"/> 
						</div>
			    	</div>
					<div class="col-md-8">
						<div class="page_step_form active" id="form_step_1">
							<div class="form-group">
								<input type="text" name="projectTite" class="form-control" placeholder="<?php echo $lang['Project title']; ?>" required>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<select required class="ui dropdown form-control" name="client">
											 <option value=""><?php echo $lang['Select a client']; ?></option>
											<?php $recentlyRegisteredUsers=user::findBySql("select * from users ORDER BY id DESC");
													foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
														if($recentlyRegisteredUser->accountStatus ==2){
															?>
															<option value="<?php echo $recentlyRegisteredUser->id; ?>"><?php echo $recentlyRegisteredUser->firstName; ?></option>
															<?php 
														}
													}?>
										</select>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
									 	<input type="hidden" name="staff[]" value="1" />
									 	<input type="hidden" name="staff[]" class="new_val" />
										<select multiple required class="ui fluid dropdown" name="staff[]">
											<option value=""><?php echo $lang['Select Staff members']; ?></option>
											<?php $recentlyRegisteredUsers=user::findBySql("select * from users ORDER BY id DESC");
												foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
													if($recentlyRegisteredUser->accountStatus ==3){
													?>
										            <option value="<?php echo $recentlyRegisteredUser->id; ?>"><?php echo $recentlyRegisteredUser->firstName; ?></option>
										            <?php 
													}
											}?>
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
									<div class="prep-service row" role="1">
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
									<div class="prep-service row" role="2">
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
										    <div class="ui toggle checkbox custom-btnc toggle_item">
											<input type="checkbox" name="notifyClient" tabindex="0" class="hidden"/>
										      <label>Do you have any units sold individually? (NOT a bundle/multipack)</label>
										    </div>
										</div>
									</div>
								</div>
								

								<div class="col-md-12 marchant-rows">
									<h2>Units Sold Individually (No bundles/multipacks listed here)</h2>
									<div class="row marchant-group">
										<div class="col-md-3">
											<input type="text" name="SKU" class="form-control input_sku" placeholder="Merchant SKU" required>
										</div>

										<div class="col-md-3">
											<input type="text" name="ASIN" class="form-control input_asin" placeholder="ASIN" maxlength="10" required>
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

		
								<div class="col-md-12">
									<div class="form-group">
										<div class="inline field">
										    <div class="ui toggle checkbox custom-btnc toggle_bundle">
											<input type="checkbox" name="notifyClient" tabindex="0" class="hidden"/>
										      <label>Do you have any bundles and/or multipacks?</label>
										    </div>
										</div>
									</div>
								</div>

								<div class="col-md-12 bundle-rows">
									<h2>Units Sold as Bundles or Multipacks</h2>
									<div class="row bundle-group">
										<div class="col-md-7">
											<div class="row">
												<div class="col-md-4">
													<input type="text" name="SKU" class="form-control input_bundle_sku" placeholder="Merchant SKU" required>
												</div>

												<div class="col-md-4">
													<input type="text" name="ASIN" class="form-control input_bundle_asin" placeholder="ASIN" maxlength="10" required >
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
								    <div class="ui toggle checkbox custom-btnc shipment_optimization">
										<input type="checkbox" name="notifyClient" tabindex="0" class="hidden"/>
									    <label>Yes!  Optimize my shipment to save me money!<br>
									      	<span>With Shipment Optimization, we’ll find the best price for your shipment! <br>(Pricing is for each fulfillment center Amazon specifies shipping to)
									      	</span>
									    </label>
								    </div>
								</div>
							</div>

							<div class="form-group">
								<h3>Save Packing Slips (+$1 per slip/box)</h3>
								<div class="inline field">
								    <div class="ui toggle checkbox custom-btnc save_packing">
										<input type="checkbox" name="notifyClient" tabindex="0" class="hidden"/>
									    <label>Send me a scanned copy of my packing slips!</label>
								    </div>
								</div>
							</div>

							<div class="form-group">
								<div class="field-label">
									<label for="firstName">Any notes or comments?</label>
								</div>
								<textarea class="form-control" name="description"></textarea>
							</div>	

							<div class="form-group">
								<h2>Promo code</h2>
								<input type="text" name="promoCode" class="form-control" placeholder="" required>
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
											<a class="btn new-btnblue btn_add_project" name="add-project">Submit Project</a>
										</div>
									</div>
									
								</div>
							</div>
						</div>	
					</div>	
				</div>
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