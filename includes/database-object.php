<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.

require_once(LIB_ROOT.DS.'database.php'); 

/*
	These are Common Database Methods to find individual or all records of any table (can be used for all classes)
	This file will only work in or above PHP version  5.3, called Late Binding	http://www.php.net/lsb
*/
class DatabaseObject {
	
	// Finds all records of selected table
	public static function findAll() {
		return static::findBySql("SELECT * FROM ".static::$tblName);
	}
	
	// Finds all records of selected table in DESC(Descending) Order
	public static function findAllByDescOrder() {
		return static::findBySql("SELECT * FROM ".static::$tblName ." ORDER BY id DESC");
	}
  
  	//	Find last record of any table
	public static function findLastRecord() {
		$resultArray = static::findBySql("SELECT * FROM ".static::$tblName." ORDER BY id DESC LIMIT 1");
		
		return !empty($resultArray) ? array_shift($resultArray) : false;
	}
	
	//	Find last record of any table
	public static function findLastRecord1() {
		$resultArray = static::findBySql("SELECT * FROM ".static::$tblName." ORDER BY p_id DESC LIMIT 1");
		
		return !empty($resultArray) ? array_shift($resultArray) : false;
	}
	
	//	Find record from table by ID
	public static function findById($id=0) {
		$resultArray = static::findBySql("SELECT * FROM ".static::$tblName." WHERE id={$id} LIMIT 1");
		
		return !empty($resultArray) ? array_shift($resultArray) : false;
	}
	public static function findByProId($id) {
		$resultArray = static::findBySql("SELECT * FROM ".static::$tblName." WHERE p_id={$id} LIMIT 1");
		
		return !empty($resultArray) ? array_shift($resultArray) : false;
	}

	public static function findBySql($sql="") {
		global $database;
		$resultSet = $database->query($sql);
		$object_array = array();
		
		while ($row = $database->fetchArray($resultSet)) {
			$object_array[] = static::instantiate($row);
		}
		
		return $object_array;
	}

	public static function countAll() {
		global $database;
		$sql = "SELECT COUNT(*) FROM ".static::$tblName ." LIMIT 0, 10";
		$resultSet = $database->query($sql);
		$row = $database->fetchArray($resultSet);
		
		return array_shift($row);
	}
	
	protected static function instantiate($record) {
		// Could check that $record exists and is an array
		$object = new static;
/* 
		Simple, long-form approach: (this is just for understanding how attricbutes will be instantiated)
		$object->id 		= $record['id'];
		$object->username 	= $record['username'];
		$object->password 	= $record['password'];
		$object->first_name = $record['first_name'];
		$object->last_name 	= $record['last_name'];
*/
		// More dynamic, short-form approach: (in this method, all table keys and values are instantiated dynamically)
		foreach($record as $attribute=>$value){
			if($object->hasAttribute($attribute)) {
				$object->$attribute = $value;
			}
		}
		
		return $object;
	}
	
	private function hasAttribute($attribute) {
		// We don't care about the value, we just want to know if the key exists
		// Will return true or false
		return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() { 
		// return an array of attribute names and their values from selected table dynamically
		$attributes = array();
		
		foreach(static::$tblFields as $field ) {
			if(property_exists($this, $field)) {
			$attributes[$field] = $this->$field;
			}
		}
		
		return $attributes;
	}
	
	protected function sanitizedAttributes() {
		global $database;
		$cleanAttributes = array();
		// sanitize the values before submitting
		// Note: does not alter the actual value of each attribute
		foreach($this->attributes() as $key => $value){
				$cleanAttributes[$key] = $database->escapeValue($value);
		}
		
		
		return $cleanAttributes;
	}
	
	public function save() {
	  // This is more secure function than create() or update(), as even if record doesn't have ID, it'll create or update
	  return isset($this->id) ? $this->update() : $this->create();
	}
	
	public function create() {
		global $database;
/*	  
		Below is example, for manual inserting keys and their values
		$sql = "INSERT INTO users (";
		$sql .= "username, email, name, password";
		$sql .= ") VALUES ('";
		$sql .= $database->escapeValue($this->username) ."', '";
		$sql .= $database->escapeValue($this->email) ."', '";
		$sql .= $database->escapeValue($this->name) ."', '";
		$sql .= $database->escapeValue($this->password) ."')";
*/		
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		
		$attributes = $this->sanitizedAttributes();
		$tblNN = static::$tblName;
		$attrkeysss = join(", ", array_keys($attributes));
		$attrvalss = join("', '", array_values($attributes));
		$sql = "";
		$sql .= "INSERT INTO $tblNN ( $attrkeysss ) VALUES ('$attrvalss')";
		
		
		if($database->query($sql)) {
			return $this->id = $database->insertId();
			
			//return true;
		} else {
			
			return mysqli_error($database);
			//return false;
		}
	}

	public function update() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitizedAttributes();
		
		//echo "<br /> <br /> <br />";
		//print_r($attributes);
		
		$attributePairs = array();
	
		foreach($attributes as $key => $value) {
			$attributePairs[] = "{$key}='{$value}'";
		}		
		
		$sql = "UPDATE ".static::$tblName." SET ";
		$sql .= join(", ", $attributePairs);
		$sql .= " WHERE id=". $database->escapeValue($this->id);

		$database->query($sql);
		
		return ($database->affectedRows() == 1) ? true : false;
	}

	public function delete() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
		$sql = "DELETE FROM ".static::$tblName;
		$sql .= " WHERE id=". $database->escapeValue($this->id);
		$sql .= " LIMIT 1";
		$database->query($sql);
		
		return ($database->affectedRows() == 1) ? true : false;
		
		// NB: After deleting, the instance of User still 
		// exists, even though the database entry does not.
		// This can be useful, as in:
		//   echo $user->first_name . " was deleted";
		// but, for example, we can't call $user->update() 
		// after calling $user->delete().
	}

}