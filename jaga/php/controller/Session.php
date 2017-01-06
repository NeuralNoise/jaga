<?php

class Session extends ORM {

	static $sessionArray;
		
	public $sessionID;
	public $userID;
	public $sessionDateTimeSet;
	public $sessionDateTimeExpire;
	public $sessionIP;
	public $sessionUserAgent;

	public function __construct($sessionID = null) {

		$this->sessionID = $_COOKIE['jaga'];
		if (isset($_SESSION['userID'])) { $this->userID = $_SESSION['userID']; } else { $this->userID = 0; }
		$this->sessionDateTimeSet = date('Y-m-d H:i:s');
		$this->sessionDateTimeExpire = date("Y-m-d H:i:s", strtotime("+1 month"));
		$this->sessionIP = $_SERVER['REMOTE_ADDR'];
		$this->sessionUserAgent = $_SERVER['HTTP_USER_AGENT'];
		
		if ($sessionID) {
			
			$query = "SELECT * FROM jaga_Session WHERE sessionID = :sessionID LIMIT 1";
			$core = Core::getInstance();
			$statement = $core->database->prepare($query);
			$statement->execute(array(':sessionID' => $sessionID));
			if ($row = $statement->fetch()) {
				foreach ($row AS $property => $value) { if (isset($this->$property)) { $this->$property = $value; } }
			}

		}

	}

	public static function getSession($name) {
		if (isset(self::$sessionArray[$name])) {
			return self::$sessionArray[$name];
		} else {
			return "Session variable '$name' has not been set properly.";
		}
	}
    
	public static function setSession($name, $value) {
		
		self::$sessionArray[$name] = $value;
		
		if (!isset($_SESSION)) { session_start(); }
		$_SESSION[$name] = $value;
		
	}
	
	public static function unsetSession($name) {
	
		unset(self::$sessionArray[$name]);
		unset($_SESSION[$name]);
		
	}

	public static function sessionDump () {
		return self::$sessionArray;
	}

	public static function getUserSessions($userID) {

		$query = "SELECT sessionID FROM jaga_Session WHERE userID = :userID ORDER BY sessionDateTimeSet DESC";
		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID));
		
		$sessions = array();
		while ($row = $statement->fetch()) { $sessions[] = $row['sessionID']; }
		return $sessions;
		
	}
	
	public static function getUniqueSessionIPs($userID) {

		$query = "SELECT DISTINCT(sessionIP) AS sessionIP FROM jaga_Session WHERE userID = :userID";
		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID));
		
		$sessionIPs = array();
		while ($row = $statement->fetch()) { $sessionIPs[] = $row['sessionIP']; }
		return $sessionIPs;
		
	}
	
	public static function getUniqueUserIDs($sessionIPs) {

		$sessionIPsString = '"' . join('","',$sessionIPs) . '"';
	
		// print_r($sessionIPsString); die();
	
		$query = "SELECT DISTINCT(userID) AS userID FROM jaga_Session WHERE sessionIP IN ($sessionIPsString)";
		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		$statement->execute();
		
		$userIDs = array();
		while ($row = $statement->fetch()) { $userIDs[] = $row['userID']; }
		return $userIDs;
		
	}

}

?>