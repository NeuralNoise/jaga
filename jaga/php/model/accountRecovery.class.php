<?php

class AccountRecovery extends ORM {

	public $accountRecoveryID;
	public $accountRecoveryEmail;
	public $accountRecoveryUserID;
	public $accountRecoveryRequestDateTime;
	public $accountRecoveryRequestedFromIP;
	public $accountRecoveryMash;
	public $accountRecoveryVisited;
	
	public function __construct($accountRecoveryID) {

		if ($accountRecoveryID == 0) {
			
			$this->accountRecoveryID = 0;
			$this->accountRecoveryEmail = '';
			$this->accountRecoveryUserID = 0;
			$this->accountRecoveryRequestDateTime = '0000-00-00 00:00:00';
			$this->accountRecoveryRequestedFromIP = $_SERVER['REMOTE_ADDR'];
			$natto = Utilites::generateNatto();
			$this->accountRecoveryMash = md5(time() . $natto);
			$this->accountRecoveryVisited = 0;
			
		} else {
			
			$query = "SELECT * FROM jaga_AccountRecovery WHERE accountRecoveryID = :accountRecoveryID LIMIT 1";
			$core = Core::getInstance();
			$statement = $core->database->prepare($query);
			$statement->execute(array(':accountRecoveryID' => $accountRecoveryID));
			$row = $statement->fetch();
			foreach ($row AS $property => $value) { if (!is_int($property)) { $this->$property = $value; } }

		}

	}

	public function accountRecoveryRequestValidation($userEmail, $raptcha) {
		
		$errorArray = array();
		
		if ($userEmail == '') {
			$errorArray['userEmail'][] = "The 'email' field is required.";
		} elseif (!preg_match('/^\b[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}\b$/',$userEmail)) {
			$errorArray['userEmail'][] = "That email address appears to be formatted incorrectly.";
		} elseif (!User::emailInUse($userEmail)) {
			$errorArray['userEmail'][] = "We do not seem to have an account for that email address.";
		}

		if ($raptcha != $_SESSION['raptcha']) { $errorArray['raptcha'][] = "The code did not match. Please try again."; }
		
		return $errorArray;
	}
	
}

?>