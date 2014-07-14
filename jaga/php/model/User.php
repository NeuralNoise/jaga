<?php

class User {

	public $userID;
	public $username;
	public $userEmail;
	
	public function __construct($userID = 0) {
	
		$this->userID = $userID;
		
		$query = "SELECT userName, email FROM jaga_user WHERE id = '$userID' LIMIT 1";
		$core = Core::getInstance();
		$statement = $core->database->query($query);
		$row = $statement->fetch();
		
		$this->username = $row['userName'];
		$this->userEmail = $row['email'];

	}
	
	public function getUserIDwithUserNameOrEmail($username) {
	
		$core = Core::getInstance();
		$query = "SELECT id FROM jaga_user WHERE username = :username OR email = :username LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':username' => $username));
		$row = $statement->fetch();
		return $row['id'];
	
	}
	
	public function usernameExists($username) {
	
		$core = Core::getInstance();
		$query = "SELECT id FROM jaga_user WHERE username = :username LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':username' => $username));
		if ($row = $statement->fetch()) { return true; } else { return false; }
	
	}
	
}

?>