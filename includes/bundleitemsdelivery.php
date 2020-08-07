<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class BundleItemsdelivery extends DatabaseObject {
	
	protected static $tblName="bundleitems_delivery";
	protected static $tblFields = array('id', 'bundleitem_id', 'qty', 'delivery_date');
	
	public $id;
	public $bundleitem_id;
	public $qty;
	public $delivery_date;
	
 	// This will return  record by username in users table
	// Find user by username
	public static function findByItemId($item_id="") {
    global $database;
		$sql  = "SELECT * FROM bundleitems_delivery ";
		$sql .= "WHERE bundleitem_id = '{$item_id}' ";
		// $sql .= "LIMIT 1";
		$result_array = self::findBySql($sql);  // $result_array is an object
	
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	// Find user by id
	// public static function findByTitle($proj_title="") {
 //    global $database;
	// 	$sql  = "SELECT * FROM projects ";
	// 	$sql .= "WHERE project_title = '{$proj_title}' ";
	// 	$sql .= "LIMIT 1";
	// 	$result_array = self::findBySql($sql);  // $result_array is an object
		
	// 	return !empty($result_array) ? array_shift($result_array) : false;	
	// }
}
?>