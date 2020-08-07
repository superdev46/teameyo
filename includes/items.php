<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class Items extends DatabaseObject {
	
	protected static $tblName="project_items";
	protected static $tblFields = array('id', 'p_id', 'name', 'SKU', 'ASIN', 'Qty', 'status', 'alert' ,'delivered_qty');
	
	public $id;
	public $p_id;
	public $name;
	public $SKU;
	public $ASIN;
	public $Qty;
	public $status;
	public $alert;
	public $delivered_qty;
	
 	// This will return  record by username in users table
	// Find user by username
	public static function findByProjectId($proj_id="") {
    global $database;
		$sql  = "SELECT * FROM project_items ";
		$sql .= "WHERE p_id = '{$proj_id}' ";
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