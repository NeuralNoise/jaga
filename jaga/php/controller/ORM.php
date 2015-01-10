<?php

class ORM {

	public static function insert($object) {

		$objectName = get_class($object);
		$objectVariableArray = get_object_vars($object);
		$objectPropertyArray = array_keys($objectVariableArray);
		$tablePrefix = self::getTablePrefix();
		$tableName = $tablePrefix . $objectName;

		if (!self::tableExists($tableName)) { die('ORM::insert($object) => A table does not exist with that object name.'); }
		
		// create insert query
		$query = "INSERT INTO `$tableName` (" . implode(', ', $objectPropertyArray) . ") VALUES (:" . implode(', :', $objectPropertyArray) . ")";

		// build prepared statement
		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		foreach ($objectVariableArray AS $property => $value) {
			$attribute = ':' . $property;
			$statement->bindValue($attribute, $value);
		}
		
		// execute
		if (!$statement->execute()){ die("ORM::insert(\$object) => There was a problem saving your new $objectName."); }
		
		// get new objectID
		$auditObjectID = $core->database->lastInsertId();
		
		// ADD TO AUDIT TRAIL (for each value?)
		$ioa = new Audit(); // Instance of Audit
		unset($ioa->auditID);
		$ioa->auditAction = 'create';
		$ioa->auditObject = $objectName;
		$ioa->auditObjectID = $auditObjectID;
		$ioa->auditOldValue = '';
		$ioa->auditNewValue = '';
		$ioa->auditResult = 'success';
		Audit::createAuditEntry($ioa);
		
		// return new objectID
		return $auditObjectID;
		
	}
	
	public static function update($object, $conditions) {
		
		$objectName = get_class($object);
		// print_r($object);
		$objectVariableArray = get_object_vars($object);
		$tablePrefix = self::getTablePrefix();
		$tableName = $tablePrefix . $objectName;
		if (!self::tableExists($tableName)) { die('ORM::insert($object) => A table does not exist with that object name.'); }
		
		$scooby = array();
		foreach ($conditions AS $condition => $value) { $scooby[] = "$condition = :$condition"; }
		$scoobyString =  implode(' AND ', $scooby);
		
		$shaggy = array();
		foreach ($objectVariableArray AS $property => $value) { $shaggy[] = "$property = :$property"; }
		$shaggyString =  implode(', ', $shaggy);
		
		// create insert query
		$query = "UPDATE $tableName SET $shaggyString WHERE $scoobyString LIMIT 1";
		
		// print_r($query);
		// build prepared statement
		
		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		
		foreach ($conditions AS $condition => $value) {
			$attribute = ':' . $condition;
			$statement->bindValue($attribute, $value);
		}
		
		foreach ($objectVariableArray AS $property => $value) {
			$attribute = ':' . $property;
			$statement->bindValue($attribute, $value);
		}
		
		// execute
		if (!$statement->execute()){ die("ORM::update(\$object) => There was a problem saving your new $objectName."); }
		
	}
	
	public static function delete($object) {
		
		$objectName = get_class($object);
		$objectVariableArray = get_object_vars($object);
		$tablePrefix = self::getTablePrefix();
		$tableName = $tablePrefix . $objectName;
		if (!self::tableExists($tableName)) { die('ORM::delete($object) => A table does not exist with that object name.'); }
		
		// create delete query
		$scooby = array();
		foreach ($objectVariableArray AS $key => $value) { $scooby[] = "$key = '$value'"; }
		$scoobyString = implode(' AND ', $scooby);
		$query = "DELETE FROM $tableName WHERE $scoobyString LIMIT 1";
		
		// build prepared statement
		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		
		// execute
		if (!$statement->execute()){ die("ORM::delete(\$object) => There was a problem deleting your $objectName."); }
		
	}

	private static function getTablePrefix() {
		$tablePrefix = 'jaga_';
		return $tablePrefix;
	}
	
	private static function tableExists($tableName) {
	
		$core = Core::getInstance();
		$queryTableCheck = "SELECT 1 FROM `$tableName` LIMIT 1";
		$statement = $core->database->prepare($queryTableCheck);
		$statement->execute();
		if ($row = $statement->fetch()){ return true; } else { return false; }
		
	}

}

?>