<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class milestone extends DatabaseObject {
	
	protected static $tblName="milestones";
	protected static $tblFields = array('id', 'p_id', 'title' , 'deadline', 'releaseDate', 'budget', 'status');
	
	public $id;
	public $p_id;
	public $title;
	public $deadline;
	public $releaseDate;
	public $budget;
	public $status;
	
	 public $message=NULL;

	
	
 	// This will return  record by username in users table
	// Find user by username
	public static function findByMilestoneId($proj_id="") {
    global $database;
		$sql  = "SELECT * FROM milestones ";
		$sql .= "WHERE id = '{$proj_id}' ";
		$sql .= "LIMIT 1";
		$result_array = self::findBySql($sql);  // $result_array is an object
		
		return !empty($result_array) ? array_shift($result_array) : false;
			
	}
	
	// Find user by username
	public static function findByProjectId($proj_id="") {
    global $database;
		$sql  = "SELECT * FROM milestones ";
		$sql .= "WHERE p_id = '{$proj_id}' ";
		$sql .= "LIMIT 1";
		$result_array = self::findBySql($sql);  // $result_array is an object
		
		return !empty($result_array) ? array_shift($result_array) : false;
			
	}
	
	// Find user by id
	public static function findByTitle($proj_title="") {
    global $database;
		$sql  = "SELECT * FROM milestones ";
		$sql .= "WHERE title = '{$proj_title}' ";
		$sql .= "LIMIT 1";
		$result_array = self::findBySql($sql);  // $result_array is an object
		
		return !empty($result_array) ? array_shift($result_array) : false;
			
	}
	
	
}
?>