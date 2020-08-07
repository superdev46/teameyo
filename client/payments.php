<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Client Milestones View and Release Page  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php"); 
$title = "Payments | ". $syatem_title;
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
$user->regDate;

if(isset($_GET['projectId'])|| isset($_POST['add-milestone']))
{
	 $projectId=$_GET['projectId'];
	$clientId=$_GET['clientId'];
	$ProjectsLoop =projects::findBySql("select * from projects WHERE p_id= $projectId");
?>
<!-- Modal -->
<div id="edit-milestone1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $lang['Invoice']; ?></h4>
		<div class="icons-prt">
		<a href="#" class="prnintpage" onclick="window.print(); return false;"><i class="fa fa-print" aria-hidden="true"></i></a>
		<form action="download_pdf.php" method="post" target="_blank" enctype="multipart/form-data">
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
<div id="edit-milestone" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $lang['Payment Form']; ?></h4>
      </div>
      <div class="modal-body payment-modal">
      
      <?php if(isset($_POST['edit_id'])){
		  $edit_id=$_POST['edit_id'];
		  $latestMile=milestone::findByMilestoneId($edit_id);
		  $latestProj=Projects::findByProjectId($projectId);?>
           <div class="row amount-row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-6"> 
               <h4> <?php echo $lang['Milestone']; ?></h4>
                </div>
           
           <div class="col-lg-6 col-md-6 col-sm-6 col-6 right-amount"> 
          <h4><?php echo $lang['Amount']; ?></h4> 
           </div>
           
               <div class="col-lg-6 col-md-6 col-sm-6 col-6"> <h3>
               <?php echo $latestMile->title;?></h3>
                </div>
           
           <div class="col-lg-6 col-md-6 col-sm-6 col-6 right-amount"> 
          <h2> <?php echo $currency_symbol . $latestMile->budget;?></h2>
           </div>
           
              </div>
           <hr>
          
          <div class="payment-modal"><h3><?php echo $lang['Select a Payment method']; ?></h3> </div>
<ul class="nav nav-tabs" id="paymentgway" role="tablist">
<?php if($checkout_id != "" && $checkout_pk != ""){ ?>
  <li class="nav-item active">
    <a class="nav-link" id="2co-tab" data-toggle="tab" href="#2co" role="tab" aria-controls="2co" aria-selected="true"><img src="<?php echo $url; ?>/images/2co.jpg"/></a>
  </li>
<?php } if($stripe_sk != "" && $stripe_pk != ""){ ?>
  <li class="nav-item">
    <a class="nav-link" id="visa-tab" data-toggle="tab" href="#visa" role="tab" aria-controls="visa" aria-selected="false"><img src="<?php echo $url; ?>/images/visa.jpg"/></a>
  </li>
  <?php } if($paypal_email != ""){ ?>
  <li class="nav-item">
    <a class="nav-link" id="paypal-tab" data-toggle="tab" href="#paypal" role="tab" aria-controls="paypal" aria-selected="false"><img src="<?php echo $url; ?>/images/pp.jpg"/></a>
  </li>
  <?php } ?>
</ul>

<div class="tab-content" id="paymentgwaycontent">
<?php 
if($checkout_id != "" && $checkout_pk != "" && $stripe_sk == "" && $stripe_pk == "" && $paypal_email == ""){
	$activetab = 'show active';
}elseif($checkout_id == "" && $checkout_pk == "" && $stripe_sk != "" && $stripe_pk != "" && $paypal_email == ""){
	$activetab = 'show active';
}elseif($checkout_id == "" && $checkout_pk == "" && $stripe_sk == "" && $stripe_pk == "" && $paypal_email != ""){
	$activetab = 'show active';
}elseif($checkout_id != "" && $checkout_pk != "" && $stripe_sk != "" && $stripe_pk != "" && $paypal_email != ""){
	$activetaba = 'show active';
}
if($checkout_id != "" && $checkout_pk != ""){ ?>
  <div class="tab-pane fade <?php echo $activetab; ?> <?php echo $activetaba; ?>" id="2co" role="tabpanel" aria-labelledby="2co-tab">
<div class="paymentmeth"> 
		  <form id="myCCForm" action="payment.php" method="post">
            <input id="token" name="token" type="hidden" value="">
             <input id="amount" name="amount1" type="hidden" value="<?php echo $latestMile->budget;?>">
            <input id="username1" name="username1" type="hidden" value="<?php echo $username;?>">
            <input  name="user_Id" type="hidden" value="<?php echo $id;?>">
            <input  name="proj_Id" type="hidden" value="<?php echo $projectId;?>">
            <input  name="milestone_id" type="hidden" value="<?php echo $edit_id;?>">
            <div class="form-group">
                <div class="col-sm-12 card-settings">
                   <h4> <?php echo $lang['Card number']; ?></h4>
                    <input id="ccNo" type="text" class="form-control" placeholder="xxxx xxxx xxxx xxxx" size="20" value="" autocomplete="off" required />
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
			<div class="container">
			<div class="row">
                
                <div class="col-sm-7">
                     <h4><?php echo $lang['Expiry date']; ?></h4>
                    <input type="text" class="form-control" placeholder="MM" size="2" id="expMonth" required />
                    <input type="text" class="form-control" placeholder="YY" size="2" id="expYear" required />
                </div>
                
                <div class="col-sm-5">
                    <h4><?php echo $lang['Security Code']; ?></h4>
                    <input id="cvv" size="4" class="form-control" placeholder="CVV" type="text" value="" autocomplete="off" required />
                </div>
			</div>
			</div>
            </div>
        <div class="form-group">
        <div class="col-md-12">
		<input type="submit" class="bigbutton" value="<?php echo $lang['Make Payment']; ?>">
		</div>
		</div>
    </form>
	</div>
  </div>
  <?php } if($stripe_sk != "" && $stripe_pk != ""){ ?>
  <div class="tab-pane fade <?php echo $activetab; ?>" id="visa" role="tabpanel" aria-labelledby="visa-tab">
  <div class="paymentmeth">
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
<div class="panel-body">
<span class="paymentErrors alert-danger"></span>
<form action="process.php" method="POST" id="paymentForm">
<input type="hidden" name="custName" value="<?php echo $username;?>" class="form-control">
<input type="hidden" name="custEmail" value="<?php echo $email; ?>" class="form-control">
<input  name="user_Id" type="hidden" value="<?php echo $id;?>">
<input  name="proj_Id" type="hidden" value="<?php echo $projectId;?>">
<input  name="milestone_id" type="hidden" value="<?php echo $edit_id;?>">
<input type="hidden" name="amount" value="<?php echo $latestMile->budget;?>" class="form-control">
<input  name="invoice_number" type="hidden" value="<?php echo $latestMile->p_id . $latestMile->id;?>">
 <div class="form-group">
                <div class="col-sm-12 card-settings">
                   <h4> <?php echo $lang['Card number']; ?></h4>
<input type="text" name="cardNumber" placeholder="xxxx xxxx xxxx xxxx" size="20" autocomplete="off" id="cardNumber" class="form-control" />
</div>
</div>
 <div class="form-group">
			<div class="container">
			<div class="row">
                
                <div class="col-sm-7">
                     <h4><?php echo $lang['Expiry date']; ?></h4>
                    <input type="text" name="cardExpMonth" placeholder="MM" size="2" id="expMonth" class="form-control" />
                   <input type="text" name="cardExpYear" placeholder="YY" size="4" id="expYear" class="form-control" />
                </div>
                
                <div class="col-sm-5">
                    <h4><?php echo $lang['Security Code']; ?></h4>
                    <input type="text" placeholder="CVC" name="cardCVC" size="4" autocomplete="off" id="cardCVC" class="form-control" />
                </div>
			</div>
			</div>
            </div>

<div class="form-group">
<div class="col-md-12">
<input type="submit" id="makePayment" class="bigbutton" value="<?php echo $lang['Make Payment']; ?>">
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
  </div>
   <?php } if($paypal_email != ""){ ?>
  <div class="tab-pane fade <?php echo $activetab; ?>" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
  <div class="paymentmeth">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="text-align: center;">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="<?php echo $paypal_email; ?>">
    <input type="hidden" name="item_name" value="<?php echo $latestMile->title;?>">
    <input type="hidden" name="item_number" value="1">
    <input type="hidden" name="amount" value="<?php echo $latestMile->budget;?>">
    <input type="hidden" name="no_shipping" value="0">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="currency_code" value="<?php echo $currency;?>"> 
    <input type="hidden" name="lc" value="AU">
    <input type="hidden" name="bn" value="PP-BuyNowBF">
    <input type="submit" class="bigbutton" name="submit" value="Make payment with Paypal" alt="PayPal - The safer, easier way to pay online.">
    <img alt="" border="0" src="https://www.paypal.com/en_AU/i/scr/pixel.gif" width="1" height="1">
<input type="hidden" name="return" value="<?php echo $url;?>client/paypal_payment.php?milestone_id=<?php echo $edit_id;?>&projectId=<?php echo $projectId;?>&status=success&clientId=<?php echo $id;?>">
</form>
</div>
  </div>
   <?php } 
   if($paypal_email == "" && $stripe_sk == "" && $stripe_pk == "" && $checkout_id == "" && $checkout_pk == ""){
	   echo '<div style="text-align: center; padding-bottom: 40px;">Please Contact Admin for payment!</div>';
   }
   ?>
</div>
          <?php } ?>
                 <div class="row" style="margin-top: 20px;"> 
                    <div class="col-sm-8 encryptedinfo"> <h5><b><?php echo $lang['Your current information is encrypted'];?></b> </h5>
                    <p><?php echo $lang['Fully Secured Accounts your credit card detalis will not be saved on this server']; ?></p></div>
                    <div class="col-sm-4 encryptedlogo"> <h5><b><?php echo $lang['System secure by']; ?></b> </h5>
                    <img src="<?php echo $url; ?>/images/comodo-ssl.png"/>
                    </div>
                    <hr>
                    <div class="col-sm-12" style="margin-top: 20px;"> <h5><b><?php echo $lang['We accecpt']; ?></b></h5>
                    <img src="<?php echo $url; ?>/images/gatways.png"/></div>
                 </div>
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
				<div class="pm-heading" style="width:100%;"><h2><?php echo $lang['Project Title']; ?>: <?php echo $ProjectsLoop[0]->project_title;?> </h2><span><?php echo $lang['All Payment Milestones']; ?></span></div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 creative-right text-right">
				<div class="pm-form" style="width: 74%;">
				<form class="form-inline md-form form-sm">
				<input class="form-control form-control" type="text" placeholder="<?php echo $lang['Search Milestones...']; ?>" id="protbl-input">
				<button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
				</form>
				</div>
<div class="mobilepromenu">
				<div class="projmobilem">
				<i class="fa fa-bars" aria-hidden="true"></i>
					<ul>
<li class="cprojectmsg"><form action="../messages.php?project_id=<?php echo $ProjectsLoop[0]->p_id;?>" method="post">
								<input type="hidden" name="user_id" value="<?php echo $ProjectsLoop[0]->c_id;?>" />
								<input type="hidden" name="project_id" value="<?php echo $ProjectsLoop[0]->p_id;?>" />
								<button type="submit" name="chat"><?php echo $lang['View Project']; ?></button>
								</form></li>
					</ul>
					</div>
				</div>
	<ul class="deskvisible">

<li class="cprojectmsg"><form action="../messages.php?project_id=<?php echo $ProjectsLoop[0]->p_id;?>" method="post">
								<input type="hidden" name="user_id" value="<?php echo $ProjectsLoop[0]->c_id;?>" />
								<input type="hidden" name="project_id" value="<?php echo $ProjectsLoop[0]->p_id;?>" />
								<button type="submit" name="chat"><?php echo $lang['VIEW PROJECT']; ?></button>
								</form></li>
				</ul>
			</div>
			</div>
                <div class="clearfix"></div>
                <?php 
				$successstatus = $_GET['status'];
				if($successstatus == 'success'){
					echo '<div class="successpayment"><i class="fa fa-check-circle" aria-hidden="true"></i>
 Thank You! Payment is Successfully done.</div>';
				}
				if(isset($message) && (!empty($message))){echo $message;} ?>
                <?php $recentProjects=milestone::findBySql("select * from milestones where p_id='$projectId'"); ?>
				<div class="row">
                <div class="table-responsive">          
                      <table class="table table-new table-milestones">
                        <thead>
                          <tr>
                            <th><?php echo $lang['No.']; ?></th>
                            <th class="table-title1"><?php echo $lang['Title']; ?></th>
                            <th class="table-due"><?php echo $lang['Due date']; ?></th>
                            <th class="table-amount"><?php echo $lang['Amount']; ?></th> 
                            <th><?php echo $lang['Status']; ?></th>
                            <th><?php echo $lang['Invoice']; ?></th>
                            <th><?php echo $lang['Payment']; ?></th>
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
                              <td class="tbl-ttl"><span class="onmobile"><?php echo $lang['Milestone']; ?>: </span> <?php echo $recentProject->title;?></td>
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
									<?php if($recentProject->status==0){ ?>
                                    <button type="submit" class="btnnewbt btn blue" name="edit-mile"> <?php echo $lang['Make Payment']; ?></button>
									<?php } else { ?>
									<button disabled type="submit" class="btnnewbt btn blue" name="edit-mile"> <?php echo $lang['Payment Done']; ?></button>
									<?php }?>
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
            </div>
        </div><!-- row -->
    </div>
	<div class="clearfix"></div>
	
</div> 
</div> 

<?php } ?>       
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
      <?php }?>
<script src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
<script>
  // Called when token created successfully.
  var successCallback = function(data) {
    var myForm = document.getElementById('myCCForm');

    // Set the token as the value for the token input
    myForm.token.value = data.response.token.token;

    // IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
    myForm.submit();
  };

  // Called when token creation fails.
  var errorCallback = function(data) {
    // Retry the token request if ajax call fails
    if (data.errorCode === 200) {
       // This error code indicates that the ajax call failed. We recommend that you retry the token request.
    } else {
      alert(data.errorMsg);
    }
  };

  var tokenRequest = function() {
    // Setup token request arguments
    var args = {
      sellerId: "<?php echo $checkout_id; ?>",
      publishableKey: "<?php echo $checkout_pk; ?>",
      ccNo: $("#ccNo").val(),
      cvv: $("#cvv").val(),
      expMonth: $("#expMonth").val(),
      expYear: $("#expYear").val()
    };

    // Make the token request
    TCO.requestToken(successCallback, errorCallback, args);
  };

  $(function() {
    // Pull in the public encryption key for our environment
    TCO.loadPubKey('production');

    $("#myCCForm").submit(function(e) {
      // Call our token request function
      tokenRequest();

      // Prevent form from submitting
      return false;
    });
  });

</script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  <script type="text/javascript"> 
  Stripe.setPublishableKey('<?php echo $stripe_pk; ?>');
$(document).ready(function() {
$("#paymentForm").submit(function(event) {
$('#makePayment').attr("disabled", "disabled");
// create stripe token to make payment
Stripe.createToken({
number: $('#cardNumber').val(),
cvc: $('#cardCVC').val(),
exp_month: $('#cardExpMonth').val(),
exp_year: $('#cardExpYear').val()
}, handleStripeResponse);
return false;
});
});
// handle the response from stripe
function handleStripeResponse(status, response) {
console.log(JSON.stringify(response));
if (response.error) {
$('#makePayment').removeAttr("disabled");
$(".paymentErrors").html(response.error.message);
} else {
var payForm = $("#paymentForm");
//get stripe token id from response
var stripeToken = response['id'];
//set the token into the form hidden input to make payment
payForm.append("<input type='hidden' name='stripeToken' value='" + stripeToken + "' />");
payForm.get(0).submit();
}
}
       </script>
	  
