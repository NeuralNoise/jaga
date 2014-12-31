<?php

class Audit {

	// ORM NOT REQUIRED
	// NO UPDATE OR DELETE DUNCTIONALITY REQUIRED

	public function __construct($auditID) {
	
		if ($auditID != 0) {
		
			$core = Core::getInstance();
			$query = "SELECT * FROM jaga_Audit WHERE auditID = :auditID LIMIT 1";
			$statement = $core->database->prepare($query);
			$statement->execute(array(':auditID' => $auditID));
			if (!$row = $statement->fetch()) { die('Audit entry does not exist.'); }
			foreach ($row AS $key => $value) { if (!is_int($key)) { $this->$key = $value; } }
			
		} else {

			$this->auditID = 0;
			$this->channelID = 0;
			$this->auditDateTime = '0000-00-00 00:00:00';
			$this->auditUserID = 0;
			$this->auditIP = '0.0.0.0';
			$this->auditAction = '';
			$this->auditOldData = '';
			$this->auditNewData = '';
			$this->auditResult = '';
			$this->auditObject = '';
			$this->auditObjectID = 0;
			$this->auditValue = '';
			$this->auditNote = '';

		}
	}
	
	public function createAuditEntry() {
	
	}
	
}

?>