<?php

class BlacklistDomain extends ORM {

	public $domain;
	public $channelID;
	public $blockedByUserID;
	public $dateTimeBlocked;
	public $dateTimeOfBlockExpiration;
	public $attemptsSinceBlocked;
	
	public function __construct($domain = '') {
	
		if ($domain) {
		
			$core = Core::getInstance();
			$query = "SELECT * FROM jaga_BlacklistDomain WHERE domain = :domain LIMIT 1";
			$statement = $core->database->prepare($query);
			$statement->execute(array(':domain' => $domain));
			if (!$row = $statement->fetch()) { die('BlacklistDomain entry does not exist.'); }
			foreach ($row AS $key => $value) { if (!is_int($key)) { $this->$key = $value; } }
			
		} else {

			$this->domain = '';
			if (isset($_SESSION['channelID'])) { $this->channelID = $_SESSION['channelID']; } else { $this->channelID = 0; }
			$this->blockedByUserID = $_SESSION['userID'];
			$this->dateTimeBlocked = date('Y-m-d H:i:s');
			$this->dateTimeOfBlockExpiration =  date('Y-m-d H:i:s', strtotime('+1 year'));
			$this->attemptsSinceBlocked = 0;

		}
		
	}
	
	public static function isBlacklisted($domain_name_string) {
		
		$isBlacklisted = false;
		
		$domain_name_potential_matches = explode('.',$domain_name_string);
		$count = count($domain_name_potential_matches);

		for ($i = 0; $i < $count; $i++) {

			$domain_name_potential_match_string = implode('.',$domain_name_potential_matches);

			$core = Core::getInstance();
			$query = "SELECT domain FROM jaga_BlacklistDomain WHERE domain = :domain LIMIT 1";
			$statement = $core->database->prepare($query);
			$statement->bindParam(':domain', $domain_name_potential_match_string, PDO::PARAM_STR);
			$statement->execute();
			if ($row = $statement->fetch()) {
				self::plusone($domain_name_potential_match_string);
				$isBlacklisted = true;
			}
			
			array_shift($domain_name_potential_matches);

		}

		return $isBlacklisted;
		
	}
	
	public static function getDomainBlacklist() {
		
		$core = Core::getInstance();
		$query = "SELECT domain FROM jaga_BlacklistDomain";
		$statement = $core->database->query($query);

		$domainBlacklist = array();
		while ($row = $statement->fetch()) { $domainBlacklist[] = str_replace('\.','.',$row['domain']); }
		return $domainBlacklist;
		
	}
	
	public static function validate($inputArray) {
		
		$errorArray = array();
		// if ($inputArray['xxxxxxx'] == 0) { $errorArray['xxxxxxx'][] = 'xxxxxxx blah blah blah.'; }
		return $errorArray;
		
	}
	
	public static function plusone($domain_name_potential_match_string) {
		
		$core = Core::getInstance();
		$query = "UPDATE jaga_BlacklistDomain SET attemptsSinceBlocked = attemptsSinceBlocked + 1 WHERE domain = :domain_name_potential_match_string LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->bindParam(':domain_name_potential_match_string', $domain_name_potential_match_string, PDO::PARAM_STR);
		$statement->execute();

	}
	
}

?>