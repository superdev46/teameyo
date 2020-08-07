<?php
// A class to help work with Sessions
// In our case, primarily to manage logging users in and out

// Keep in mind when working with sessions that it is generally 
// inadvisable to store DB-related objects in sessions

require_once("database-object.php");

class Session extends DatabaseObject {
	
	private $loggedIn = false;
	public $userId;
	public $username;
	
	public $message;
	public $views;
	function __construct() {
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
		$this->checkMessage();
		$this->checkLogin();
		if($this->loggedIn) {
		  // actions to take right away if user is logged in
		} else {
		  // actions to take right away if user is not logged in
		}
	}
	
	public function isLoggedIn() {
		return $this->loggedIn;
	}
	
	public function fbUserLoggedIn() {
		$this->loggedIn = true;
		return $this->loggedIn;
	}
	
	public function login($user) {
		// database should find user based on username/password
		if($user){
			$this->userId = $_SESSION['userId'] = $user->id;
			$this->username =$_SESSION['username']= $user->firstName;
			$this->accountStatus =$_SESSION['accountStatus']= $user->accountStatus;
			$_SESSION['logged_user_id'] = $user->id;
			$_SESSION['accountStatus'] = $user->accountStatus;
			return $this->loggedIn = true;
		}
	}
  
	public function logout() {
		unset($_SESSION['userId']);
		
		unset($this->userId);
		$this->loggedIn = false;
		
	}
	
	private function checkLogin() {
		if(isset($_SESSION['userId'])) {
			$this->userId = $_SESSION['userId'];
			$this->loggedIn = true;
		} else {
			unset($this->userId);
			$this->loggedIn = false;
		}
	}
	
	public function pageView() {
		if(isset($_SESSION['views'])) {
			return $_SESSION['views'];
		}
	}
	
	public function message($msg="") {
		if(!empty($msg)) {
			// then this is "set message"
			// make sure you understand why $this->message=$msg wouldn't work
			$_SESSION['message'] = $msg;
		} else {
			// then this is "get message"
				return $this->message;
		}
	}
	
	private function checkMessage() {
		// Is there a message stored in the session?
		if(isset($_SESSION['message'])) {
			// Add it as an attribute and erase the stored version
			$this->message = $_SESSION['message'];
			unset($_SESSION['message']);
		} else {
			$this->message = "";
		}
	}
	
  
}

$session = new Session();
$message = $session->message();
?>