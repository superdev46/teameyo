<?php

require_once(LIB_ROOT.DS.'config.php'); 

class MySQLDatabase {
	
	private $connection;
	public $lastQuery;
	private $magicQuotesActive;
	private $realEscapeStringExists;
	
	function __construct() {
		$this->openConnection();
//		$this->magicQuotesActive = getMagicQuotesGpc();
//		$this->realEscapeStringExists = function_exists( "mysql_real_escape_string" );
	}

	public function openConnection() {
		$this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
		if (!$this->connection) {
			die("Database connection failed: " . mysqli_error());
		} else {
			$dbSelect = mysqli_select_db($this->connection, DB_NAME);
			if (!$dbSelect) {
				die("Database selection failed: " . mysqli_error());
			}
		}
	}

	public function closeConnection() {
		if(isset($this->connection)) {
			mysql_close($this->connection);
			unset($this->connection);
		}
	}

	public function query($sql) {
		$this->lastQuery = $sql;
		$result = mysqli_query($this->connection, $sql);
		$this->confirmQuery($result);
		return $result;
	}

	public function escapeValue( $value ) {
		if( $this->realEscapeStringExists ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $this->magicQuotesActive ) { $value = stripslashes( $value ); }
			$value = mysqli_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$this->magicQuotesActive ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}
	
	// "database-neutral" methods
	public function fetchArray($resultSet) {
		return mysqli_fetch_array($resultSet);
	}
	
	public function numRows($resultSet) {
		return mysqli_num_rows($resultSet);
	}
	
	public function insertId() {
		// get the last id inserted over the current db connection
		return mysqli_insert_id($this->connection);
	}
	
	public function affectedRows() {
		return mysqli_affected_rows($this->connection);
	}

	private function confirmQuery($result) {
		if (!$result) {
	    $output = "Database query failed: " . mysqli_error($this->connection) . "<br /><br />";
	    // $output .= "Last SQL query: " . $this->lastQuery;
	    die( $output );
		}
	}
	
}

$database = new MySQLDatabase();
$db =& $database;

?>