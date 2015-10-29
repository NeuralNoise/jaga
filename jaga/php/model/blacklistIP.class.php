<?php

class BlacklistIP extends ORM {

	public $ip;
	public $channelID;
	public $blockedByUserID;
	public $dateTimeBlocked;
	public $dateTimeOfBlockExpiration;
	public $attemptsSinceBlocked;
	
	public function __construct($ip = '') {
	
		if ($ip) {
		
			$core = Core::getInstance();
			$query = "SELECT * FROM jaga_BlacklistIP WHERE ip = :ip LIMIT 1";
			$statement = $core->database->prepare($query);
			$statement->execute(array(':ip' => $ip));
			if (!$row = $statement->fetch()) { die('BlacklistIP entry does not exist.'); }
			foreach ($row AS $key => $value) { if (!is_int($key)) { $this->$key = $value; } }
			
		} else {

			$this->ip = '';
			if (isset($_SESSION['channelID'])) { $this->channelID = $_SESSION['channelID']; } else { $this->channelID = 0; }
			$this->blockedByUserID = $_SESSION['userID'];
			$this->dateTimeBlocked = date('Y-m-d H:i:s');
			$this->dateTimeOfBlockExpiration =  date('Y-m-d H:i:s', strtotime('+1 year'));
			$this->attemptsSinceBlocked = 0;

		}
		
	}
	
	public static function getIpBlacklist() {
		
		$core = Core::getInstance();
		$query = "SELECT ip FROM jaga_BlacklistIP";
		$statement = $core->database->query($query);

		$ipBlacklist = array();
		while ($row = $statement->fetch()) { $ipBlacklist[] = $row['ip']; }
		return $ipBlacklist;
		
	}
	
	public static function validate($inputArray) {
		
		$errorArray = array();
		// if ($inputArray['xxxxxxx'] == 0) { $errorArray['xxxxxxx'][] = 'xxxxxxx blah blah blah.'; }
		return $errorArray;
		
	}
	
	public static function plusone($ip) {
		
		$core = Core::getInstance();
		$query = "UPDATE jaga_BlacklistIP SET attemptsSinceBlocked = attemptsSinceBlocked + 1 WHERE ip = :ip LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':ip' => $ip));

	}
	
}

?>