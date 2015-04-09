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
			$this->accountRecoveryMash = Utilities::generateMash();
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

	public function getAccountRecoveryID($accountRecoveryMash) {

		$accountRecoveryID = 0;
		$core = Core::getInstance();
		$query = "SELECT accountRecoveryID FROM jaga_AccountRecovery WHERE accountRecoveryMash = :accountRecoveryMash ORDER BY accountRecoveryRequestDateTime DESC LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':accountRecoveryMash' => $accountRecoveryMash));
		if ($row = $statement->fetch()) { $accountRecoveryID = $row['accountRecoveryID']; }
		return $accountRecoveryID;
	
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

	public function resetPasswordRequestValidation($accountRecoveryMash, $username, $password, $confirmPassword, $raptcha) {
		
		$errorArray = array();
		$userID = User::getUserID($username);
		$accountRecoveryID = self::getAccountRecoveryID($accountRecoveryMash);
		$accountRecovery = new AccountRecovery($accountRecoveryID);
		$currentDateTime = date('Y-m-d H:i:s');
		
		if ($username == '') { $errorArray['username'][] = "Please enter a username."; }
		if (!User::usernameExists($username)) { $errorArray['username'][] = "That username is not associated with a Kutchannel account."; }
		if ($userID != 0 && $userID != $accountRecovery->accountRecoveryUserID) { $errorArray['username'][] = "This password reset URL is not associated with that username."; }
		
		// is $accountRecoveryMash for a record within the last 24 hours?
		if ($currentDateTime >= date('Y-m-d H:i:s', strtotime($accountRecovery->accountRecoveryRequestDateTime . " +1 day"))) {
			$errorArray['accountRecoveryMash'][] = "This password reset URL has expired... <a href=\"/account-recovery/\">REQUEST ANOTHER</a>.";
		}
		
		// if user exists, is $accountRecoveryMash the most recent record for this user?
		if ($userID != 0 && !self::isMostRecentAccountRecoveryMash($accountRecoveryMash, $userID)) {
			$errorArray['error'][] = "This is not the most recent account recovery request for this user. Perhaps you submitted the account recovery form more than once? Please check your inbox for a newer Account Recovery email from The Kutchannel or <a href=\"/account-recovery/\">REQUEST ANOTHER</a>.";
		}
		
		if ($password == '') { $errorArray['password'][] = "Please enter a password."; }
		if ($confirmPassword == '') { $errorArray['confirmPassword'][] = "You must enter your password twice."; }
		if ($password != $confirmPassword) { $errorArray['password'][] = "Your passwords did not match."; }
		
		if ($raptcha == '') { $errorArray['raptcha'][] = "You must accurately enter the security code."; }
		if ($raptcha != $_SESSION['raptcha']) { $errorArray['raptcha'][] = "The security code was incorrect."; }

		
		
		
		
		
		return $errorArray;
	}
	
	public function isMostRecentAccountRecoveryMash($accountRecoveryMash, $userID) {
		
		$core = Core::getInstance();
		$query = "
			SELECT accountRecoveryMash FROM jaga_AccountRecovery 
			WHERE accountRecoveryUserID = :userID
			ORDER BY accountRecoveryRequestDateTime DESC
			LIMIT 1
		";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID));
		if ($row = $statement->fetch()) { $armash = $row['accountRecoveryMash']; } else { $armash = ''; }
		if ($armash == $accountRecoveryMash) { return true; } else { return false; }
		
	}
	
}

?>