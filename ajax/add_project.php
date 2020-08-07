<?php 

// include('../includes/loader.php');
include('../includes/lib-initialize.php'); 

$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$account_stat=$user->status;
$settingsID = 1;
$settings = settings::findById($settingsID);
$message = "";

if(isset($_POST['project_create'])){

	$project_data = $_POST['project_create'];

	if(isset($_POST['items'])){
		$items = $_POST['items'];
	}else{
		$items = array();
	}

	if(isset($_POST['bundle_items'])){
		$bundleitems = $_POST['bundle_items'];
	}else{
		$bundleitems = array();
	}
	
	
	$project = new Projects();

	$project->project_title	= $project_data['project_title'];
	$project->p_id		= (int)NULL;
	$project->c_id		= $project_data['c_id'];
	$project->s_ids		= $project_data['s_ids'];
	$project->comment	= $project_data['comment'];
	$project->prep_service	= $project_data['prep_service'];
	$project->promo_code	= $project_data['promo_code'];
	$project->save_packing	= $project_data['save_packing'];
	$project->shipment_optm	= $project_data['shipment_optm'];
	$project->budget		= 0;
	$project->status		= 0;
	$project->archive		= 0;
	$project->trash		= 0 ;
	$project->start_time		= date("Y-m-d H:i:s");
	$project->end_time		= date("Y-m-d H:i:s");
	$saveProject=$project->save();
	if($saveProject){
		for($i = 0; $i < count($items); $i++)
		{
			$item = $items[$i];
			$project_item = new Items();
			$project_item->p_id = $saveProject;
			$project_item->SKU = $item['sku'];
			$project_item->ASIN = $item['asin'];
			$project_item->name = $item['itemname'];
			$project_item->Qty = $item['qty'];
			$project_item->price = 0;
			$project_item->save();
		}

		for($i = 0; $i < count($bundleitems); $i++)
		{
			$item = $bundleitems[$i];
			$bundle_item = new BundleItems();
			$bundle_item->p_id = $saveProject;
			$bundle_item->SKU = $item['bundle_sku'];
			$bundle_item->ASIN = $item['bundle_asin'];
			$bundle_item->name = $item['bundle_itemname'];
			$bundle_item->bundle_qty = $item['bundle_qty'];
			$bundle_item->total = $item['bundle_total'];
			$bundle_item->save();
		}

		$notmessagea = $lang['Project has been created successfully!'];
		$notmessageb = $lang['Project could not created at this time. Please Try Again Later . Thanks'];

		$project_title = $project_data['project_title'];
	  	if($project_data['email_notification'] == 'true'){
			$user = user::findById($project_data['c_id']); 
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
			  $message = "Project has been created successfully! but Error sending the Email please contact site administrator";
		 }
		
		 
		/* Staff Email */
		$all_users=user::findBySql("select * from users");
			foreach($all_users as $recentlyRegisteredUser){ 
				if($recentlyRegisteredUser->accountStatus ==3){  
					$s_all = explode(',', $project_data['s_ids']);
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
							echo json_encode(array('msg' => '/projects.php?message=error_email'));
						}
					}
				}
			}
		/* Staff Email End */
		} else{
			$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessagea."</p>";
		}
		echo json_encode(array('status' => 200 ,'msg' => '/projects.php?message=created'));
		exit();
	}else
	{
		 $message="<p class='alert alert-danger'><i class='fa fa-times'></i> ".$notmessageb."</p>";
	}

}
?>