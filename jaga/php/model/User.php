<?php

class User {

	public $userID;
	public $username;
	public $userEmail;
	
	public function __construct($userID = 0) {
	
		$this->userID = $userID;
		
		$query = "SELECT username, userEmail FROM jaga_User WHERE userID = '$userID' LIMIT 1";
		$core = Core::getInstance();
		$statement = $core->database->query($query);
		$row = $statement->fetch();
		
		$this->username = $row['username'];
		$this->userEmail = $row['userEmail'];

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
	
}

?>