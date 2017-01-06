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
	public $userShadowBan;
	
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
			$this->userRegistrationDateTime = date('Y-m-d H:i:s');
			$this->userLastVisitDateTime = '0000-00-00 00:00:00';
			$this->userTestMode = 0;
			$this->userBlackList = 0;
			$this->userSelectedLanguage = 'en';
			$this->userShadowBan = 0;
			
		} else {
			
			$query = "SELECT * FROM jaga_User WHERE userID = :userID LIMIT 1";
			$core = Core::getInstance();
			$statement = $core->database->prepare($query);
			$statement->execute(array(':userID' => $userID));
			$row = $statement->fetch();
			foreach ($row AS $property => $value) { if (!is_int($property)) { $this->$property = $value; } }

		}

	}
	
	public function getUserDisplayName() {
		$username = $this->username;
		$userDisplayName = $this->userDisplayName;
		if ($userDisplayName != '') { return $userDisplayName; } else { return $username; }
	}
	
	public function profileImage($width = 50) {
		return Image::getObjectMainImagePath('User', $this->userID, $width);
	}
	
	public function recentPosts($limit = '100') {
		
		
		$currentDate = date('Y-m-d H:i:s');
		
		$query = "
			SELECT * FROM jaga_Content 
			WHERE contentPublishStartDate <= '$currentDate' AND (contentPublishEndDate >= '$currentDate' OR contentPublishEndDate = '0000-00-00')
			AND contentSubmittedByUserID = :userID
			ORDER BY contentLastModified DESC
			LIMIT $limit
		";
		
		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $this->userID));
		
		$recentPosts = array();
		while ($row = $statement->fetch()) { $recentPosts[] = $row['contentID']; }
		return $recentPosts;
			
	}
	
	public function hulkSmash() {

		$sessionIDs = Session::getUserSessions($this->userID);
		$sessionIPs = Session::getUniqueSessionIPs($this->userID);
		$userIDs = Session::getUniqueUserIDs($sessionIPs);
		
		foreach ($userIDs AS $thisUserID) {
			$thisSessionIDs = Session::getUserSessions($thisUserID);
			foreach ($thisSessionIDs AS $thisSessionID) { if (!in_array($thisSessionID, $sessionIDs)) { $sessionIDs[] = $thisSessionID; } }
			$thisSessionIPs = Session::getUniqueSessionIPs($thisUserID);
			foreach ($thisSessionIPs AS $thisSessionIP) { if (!in_array($thisSessionIP, $sessionIPs)) { $sessionIPs[] = $thisSessionIP; } }
		}

		// for each sessionID
		foreach ($sessionIDs AS $sessionID) {
			// delete session
			$session = new Session($sessionID);
			$conditions = array('sessionID' => $sessionID);
			Content::delete($session, $conditions);
		}

		// for each IP
		foreach ($sessionIPs AS $sessionIP) {
			// add IP to blacklist
			$blacklistIP = new BlacklistIP($sessionIP);
			BlacklistIP::insert($blacklistIP);
		}
		
		// for each bad actor
		foreach ($userIDs AS $userID) {

			// disable account & blacklist
			$user = new User($userID);
			$user->userPassword = 'no';
			$user->userEmailVerified = 0;
			$user->userAcceptsEmail = 0;
			$user->userBlacklist = 1;
			$user->userChannelAllocation = 0;
			$user->userShadowBan = 1;
			$conditions = array('userID' => $userID);
			User::update($user, $conditions);
			
			// unpublish posts
			// delete comments
			
		}
		
		// send report to admin (users, posts, comments, IPs, sessions)
	
	}

	public static function getUserIDwithUserNameOrEmail($username) {
	
		$core = Core::getInstance();
		$query = "SELECT userID FROM jaga_User WHERE username = :username OR userEmail = :username LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':username' => $username));
		$row = $statement->fetch();
		return $row['userID'];
	
	}
	
	public static function getUserID($username) {
	
		$core = Core::getInstance();
		$query = "SELECT userID FROM jaga_User WHERE username = :username OR userEmail = :username LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':username' => $username));
		$row = $statement->fetch();
		return $row['userID'];
	
	}

	public static function getUsername($userID) {
	
		$core = Core::getInstance();
		$query = "SELECT username FROM jaga_User WHERE userID = :userID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID));
		$row = $statement->fetch();
		return $row['username'];
	
	}
	
	public static function getUserIdWithEmail($userEmail) {
	
		$core = Core::getInstance();
		$query = "SELECT userID FROM jaga_User WHERE userEmail = :userEmail LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userEmail' => $userEmail));
		$row = $statement->fetch();
		return $row['userID'];
	
	}
	
	public static function usernameExists($username) {
	
		$core = Core::getInstance();
		$query = "SELECT userID FROM jaga_User WHERE username = :username LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':username' => $username));
		if ($row = $statement->fetch()) { return true; } else { return false; }
	
	}
	
	public static function userIDexists($userID) {
	
		$core = Core::getInstance();
		$query = "SELECT userID FROM jaga_User WHERE userID = :userID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID));
		if ($row = $statement->fetch()) { return true; } else { return false; }
	
	}
	
	public static function userBlacklisted($userID) {
	
		$core = Core::getInstance();
		$query = "SELECT userID FROM jaga_User WHERE userBlacklist = 1 AND userID = :userID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID));
		if ($row = $statement->fetch()) { return true; } else { return false; }
	
	}
	
	public static function emailInUse($userEmail) {
	
		$core = Core::getInstance($userEmail);
		$query = "SELECT userEmail FROM jaga_User WHERE userEmail = :userEmail LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userEmail' => $userEmail));
		if ($row = $statement->fetch()) { return true; } else { return false; }
	
	}
	
	public static function setUserLastVisitDateTime($userID) {
		$userLastVisitDateTime = date('Y-m-d H:i:s');
		$core = Core::getInstance();
		$query = "UPDATE jaga_User SET userLastVisitDateTime = '$userLastVisitDateTime' WHERE userID = :userID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID));
	}
	
	public static function getUserSelectedLanguage($userID) {
		$core = Core::getInstance();
		$query = "SELECT userSelectedLanguage FROM jaga_User WHERE userID = :userID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID));
		$row = $statement->fetch();
		if ($row['userSelectedLanguage'] == '') { return 'en'; } else { return $row['userSelectedLanguage']; }
	}
	

}

?>