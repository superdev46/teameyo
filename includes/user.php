<?php

// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class User extends DatabaseObject {
	
	protected static $tblName="users";
	protected static $tblFields = array('id', 'Projects_ids', 'password', 'email', 'accountStatus', 'firstName', 'title', 'address', 'phone', 'website', 'skype_id', 'fb', 'regDate', 'type_status', 'last_seen', 'session_status', 'status', 'note', 'city', 'state', 'zip', 'country', 'user_language');
	
	public $id;
	public $Projects_ids;
	public $password; 
	public $email;
	public $accountStatus;
	public $firstName;
	public $title;
	public $address;
	public $phone;
	public $website;
	public $skype_id;
	public $fb;
	public $regDate;
	public $type_status;
	public $last_seen;
	public $session_status;
	public $status;
	public $note;
	public $city;
	public $state;
	public $zip;
	public $country;
	public $user_language;
	
	public $message=NULL;

	public static function authenticate($username="", $password="") {
		global $database;
		$username = $database->escapeValue($username);
		$password = $database->escapeValue($password);
	
		$sql  = "SELECT * FROM users ";
		$sql .= "WHERE (email = '{$username}')";
		
		$sql .= "AND password = '{$password}' ";
		$sql .= "LIMIT 1";
		$resultArray = self::findBySql($sql);
			return !empty($resultArray) ? array_shift($resultArray) : false;
	}
public static function findallUser() {
    global $database;
		$sql  = "SELECT * FROM users";
		$result_array = self::findBySql($sql);  // $result_array is an object
		
		return !empty($result_array) ? array_shift($result_array) : false;
			
	}
 	// This will return  record by username in users table
	// Find user by username
	public static function findByUsername($username="") {
    global $database;
		$sql  = "SELECT * FROM users ";
		$sql .= "WHERE username = '{$username}' ";
		$sql .= "LIMIT 1";
		$result_array = self::findBySql($sql);  // $result_array is an object
		
		return !empty($result_array) ? array_shift($result_array) : false;
			
	}
	// Find user by id
	public static function findById($useId="") {
    global $database;
		$sql  = "SELECT * FROM users ";
		$sql .= "WHERE id = '{$useId}' ";
		$sql .= "LIMIT 1";
		$result_array = self::findBySql($sql);  // $result_array is an object
		
		return !empty($result_array) ? array_shift($result_array) : false;
			
	}
	
	public static function findByEmail($email="") {
    global $database;
		$sql  = "SELECT * FROM users ";
		$sql .= "WHERE email = '{$email}' ";
		$sql .= "LIMIT 1";
		$result_array = self::findBySql($sql);  // $result_array is an object
		
		return !empty($result_array) ? array_shift($result_array) : false;
			
	}
}
?>