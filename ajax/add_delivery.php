<?php 

// include('../includes/loader.php');
include('../includes/lib-initialize.php'); 

if( $_POST['role'] == 'item')
{
	$item_id = $_POST['item_id'];
	$Qty = $_POST['qty'];
	$status = $_POST['status'];
	if($status == 'adding'){
		$item_delivery = new Itemsdelivery();
		$item_delivery->item_id = $item_id;
		$item_delivery->qty = $Qty;
		$item_delivery->delivery_date = date("Y-m-d H:i:s");
		$result = $item_delivery->save();
		if($result > 0)
		{
			$item = items::findBySql("select * from project_items where id='$item_id'")[0];
			$delivered_qty = $Qty + $item->delivered_qty;

			if($delivered_qty >= $item->Qty){
				$sql_up = "UPDATE `project_items` SET `delivered_qty`='$delivered_qty', `status`='1' WHERE `id`='$item_id'";
			}else{
				$sql_up = "UPDATE `project_items` SET `delivered_qty`='$delivered_qty', `status`='4' WHERE `id`='$item_id'";
			}
			
			if($connect->query($sql_up) === TRUE){

			}
		}
	}else if($status == 'prepping'){
		$sql_up = "UPDATE `project_items` SET `status`='2' WHERE `id`='$item_id'";
		$connect->query($sql_up);
	}else if($status == 'completed'){
		$sql_up = "UPDATE `project_items` SET `status`='3' WHERE `id`='$item_id'";
		$connect->query($sql_up);
	}else if($status == 'add_alert')
	{
		$alert_content = $_POST['alert_content'];
		$sql_up = "UPDATE `project_items` SET `alert`='$alert_content' WHERE `id`='$item_id'";
		$connect->query($sql_up);
	}
	echo 1;

}else if($_POST['role'] == 'bundleitem'){
	$item_id = $_POST['item_id'];
	$Qty = $_POST['qty'];
	$status = $_POST['status'];

	if($status == 'adding')
	{
		$bundleitem_delivery = new BundleItemsdelivery();
		$bundleitem_delivery->bundleitem_id = $item_id;
		$bundleitem_delivery->qty = $Qty;
		$bundleitem_delivery->delivery_date = date("Y-m-d H:i:s");
		$result = $bundleitem_delivery->save();

		if($result > 0)
		{
			$item = bundleitems::findBySql("select * from project_bundleitems where id='$item_id'")[0];
			$delivered_qty = $Qty + $item->delivered_qty;

			if($delivered_qty >= $item->bundle_qty){
				$sql_up = "UPDATE `project_bundleitems` SET `delivered_qty`='$delivered_qty', `status`='1' WHERE `id`='$item_id'";
			}else{
				$sql_up = "UPDATE `project_bundleitems` SET `delivered_qty`='$delivered_qty', `status`='4' WHERE `id`='$item_id'";
			}
			
			if($connect->query($sql_up) === TRUE){

			}
		}
	}else if($status == 'prepping')
	{
		$sql_up = "UPDATE `project_bundleitems` SET `status`='2' WHERE `id`='$item_id'";
		if($connect->query($sql_up) === TRUE){

		}
	}else if($status == 'completed'){
		$sql_up = "UPDATE `project_bundleitems` SET `status`='3' WHERE `id`='$item_id'";
		if($connect->query($sql_up) === TRUE){

		}
	}else if($status == 'add_alert')
	{
		$alert_content = $_POST['alert_content'];
		$sql_up = "UPDATE `project_bundleitems` SET `alert`='$alert_content' WHERE `id`='$item_id'";
		if($connect->query($sql_up) === TRUE){

		}
	}
	echo 1;
}

?>