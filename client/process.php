<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Stripe payment API Success //////////////////////////
*/
ob_start();
include("../templates/admin-header.php");
include("../includes/lib-initialize.php"); 
if(!($session->isLoggedIn())){
		redirectTo($url."index.php");
	}
if($_SESSION['accountStatus'] == 1){
	redirectTo($url."admin/edit-profile.php");
}
if($_SESSION['accountStatus'] == 3){
	redirectTo($url."staff/edit-profile.php");
}

$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;;
$email=$user->email;
$account_stat=$user->status;;
$user->regDate;

//check if stripe token exist to proceed with payment
if(!empty($_POST['stripeToken'])){
// get token and user details
$stripeToken = $_POST['stripeToken'];
$custName = $_POST['custName'];
$custEmail = $_POST['custEmail'];
$amount = $_POST['amount'];
$invoice_number = $_POST['invoice_number'];
$cardNumber = $_POST['cardNumber'];
$cardCVC = $_POST['cardCVC'];
$cardExpMonth = $_POST['cardExpMonth'];
$cardExpYear = $_POST['cardExpYear'];
//include Stripe PHP library
require_once('../payment-api/stripe-php/init.php');
//set stripe secret key and publishable key
$stripe = array(
"secret_key" => $stripe_sk,
"publishable_key" => $stripe_pk
);
\Stripe\Stripe::setApiKey($stripe['secret_key']);
//add customer to stripe
$customer = \Stripe\Customer::create(array(
'email' => $custEmail,
'source' => $stripeToken
));
// item details for which payment made
$itemName = "Invoice payment";
$itemPrice = $amount * 100;
$orderID = $invoice_number;
// details for which payment performed
$payDetails = \Stripe\Charge::create(array(
'customer' => $customer->id,
'amount' => $itemPrice,
'currency' => $currency,
'description' => $itemName,
'metadata' => array(
'order_id' => $orderID
)
));
// get payment details
$paymenyResponse = $payDetails->jsonSerialize();
// check whether the payment is successful
if($paymenyResponse['amount_refunded'] == 0 && empty($paymenyResponse['failure_code']) && $paymenyResponse['paid'] == 1 && $paymenyResponse['captured'] == 1){
// transaction details
$amountPaid = $paymenyResponse['amount'];
$balanceTransaction = $paymenyResponse['balance_transaction'];
$paidCurrency = $paymenyResponse['currency'];
$paymentStatus = $paymenyResponse['status'];
$paymentDate = date("Y-m-d H:i:s");
?>
<div class="page-container">
<div class="container-fluid">
<div class="row row-eq-height">
	<?php  include("../templates/sidebar.php"); ?>
	
    <div class="page-content col-lg-9 col-md-12 col-sm-12 col-lg-push-3">
<?php include('../templates/top-header.php'); ?> 
         <div class="row">
            <div class="col-md-12 margin-top-10 clients">
            	<h2><?php echo $lang['Manage Project']; ?> </h2>
                <div class="clearfix"></div>
<?php 
if( $paymentStatus == 'succeeded'){
$milestone_id=$_POST['milestone_id'];
		$mile = milestone::findById($milestone_id);
		
		$flag=0;
		if($flag==0)
		{
			
			$mile->id =  $milestone_id;
			$mile->status =1;
			$mile->releaseDate = date("Y-m-d");
				
				$saveMile=$mile->save();
	
				if($saveMile)
				{
					header('Location:payments.php?projectId='.$_POST['proj_Id'].'&status=success&clientId='.$_POST['user_Id'].'');
				}
				else{					
				}
		}
$paymentMessage = $lang['Successfully Payment received'];
} else{
$paymentMessage = $lang['Payment failed!'];
}
} else{
$paymentMessage = $lang['Payment failed!'];
}
} else{
$paymentMessage = $lang['Payment failed!'];
}
echo $paymentMessage;
?>
            </div>
        </div><!-- row -->
    </div>
	<div class="clearfix"></div>
</div> 
</div> 
</div>
<?php include("../templates/admin-footer-payment.php"); 