<?php

class User extends ORM {


	public $userID;
	public $username;
	public $userDisplayName;
	public $userEmail;
	public $userEmailVerified;
	public $userAcceptsEmail;
	public $userPassword;
	public $userRegistrationChannelID;
	public $userRegistrationDateTime;
	public $userLastVisitDateTime;
	public $userTestMode;
	public $userBlackList;
	public $userSelectedLanguage;
	
	public function __construct($userID = 0) {

		if ($userID == 0) {
			
			$this->userID = 0;
			$this->username = '';
			$this->userDisplayName = '';
			$this->userEmail = '';
			$this->userEmailVerified = 0;
			$this->userAcceptsEmail = 1;
			$this->userPassword = '';
			$this->userRegistrationChannelID = Channel::getSelectedChannelID();
			$this->userRegistrationDateTime = '0000-00-00 00:00:00';
			$this->userLastVisitDateTime = '0000-00-00 00:00:00';
			$this->userTestMode = 0;
			$this->userBlackList = 0;
			$this->userSelectedLanguage = 'en';
			
		} else {
			
			$query = "SELECT * FROM jaga_User WHERE userID = :userID LIMIT 1";
			$core = Core::getInstance();
			$statement = $core->database->prepare($query);
			$statement->execute(array(':userID' => $userID));
			$row = $statement->fetch();
			foreach ($row AS $property => $value) { if (!is_int($property)) { $this->$property = $value; } }

		}

	}
	
	public function getUserIDwithUserNameOrEmail($username) {
	
		$core = Core::getInstance();
		$query = "SELECT userID FROM jaga_User WHERE username = :username OR userEmail = :username LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':username' => $username));
		$row = $statement->fetch();
		return $row['userID'];
	
	}
	
	public function getUserID($username) {
	
		$core = Core::getInstance();
		$query = "SELECT userID FROM jaga_User WHERE username = :username OR userEmail = :username LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':username' => $username));
		$row = $statement->fetch();
		return $row['userID'];
	
	}

	public function getUsername($userID) {
	
		$core = Core::getInstance();
		$query = "SELECT username FROM jaga_User WHERE userID = :userID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID));
		$row = $statement->fetch();
		return $row['username'];
	
	}
	
	public function usernameExists($username) {
	
		$core = Core::getInstance();
		$query = "SELECT userID FROM jaga_User WHERE username = :username LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':username' => $username));
		if ($row = $statement->fetch()) { return true; } else { return false; }
	
	}
	
	public function userIDexists($userID) {
	
		$core = Core::getInstance();
		$query = "SELECT userID FROM jaga_User WHERE userID = :userID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID));
		if ($row = $statement->fetch()) { return true; } else { return false; }
	
	}
	
	public function emailInUse($userEmail) {
	
		$core = Core::getInstance($userEmail);
		$query = "SELECT userEmail FROM jaga_User WHERE userEmail = :userEmail LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userEmail' => $userEmail));
		if ($row = $statement->fetch()) { return true; } else { return false; }
	
	}
	
	public function setUserLastVisitDateTime($userID) {
		$userLastVisitDateTime = date('Y-m-d H:i:s');
		$core = Core::getInstance();
		$query = "UPDATE jaga_User SET userLastVisitDateTime = '$userLastVisitDateTime' WHERE userID = :userID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID));
	}
	
	public function getUserSelectedLanguage($userID) {
		$core = Core::getInstance();
		$query = "SELECT userSelectedLanguage FROM jaga_User WHERE userID = :userID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID));
		$row = $statement->fetch();
		if ($row['userSelectedLanguage'] == '') { return 'en'; } else { return $row['userSelectedLanguage']; }
	}
	
}

?>