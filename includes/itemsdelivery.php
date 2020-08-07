<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class Itemsdelivery extends DatabaseObject {
	
	protected static $tblName="items_delivery";
	protected static $tblFields = array('id', 'item_id', 'qty', 'delivery_date');
	
	public $id;
	public $item_id;
	public $qty;
	public $delivery_date;
	
 	// This will return  record by username in users table
	// Find user by username
	public static function findByItemid($item_id="") {
    global $database;
		$sql  = "SELECT * FROM items_delivery ";
		$sql .= "WHERE item_id = '{$item_id}' ";
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