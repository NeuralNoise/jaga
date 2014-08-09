<?php

class Session {

	static $sessionArray;
		
	public $sessionID;
	public $userID;
	public $sessionDateTimeSet;
	public $sessionDateTimeExpire;
	public $sessionIP;
	public $sessionUserAgent;

	public function __construct() {

		$this->sessionID = $_COOKIE['TheKutchannel'];
		$this->userID = $_SESSION['userID'];
		$this->sessionDateTimeSet = date('Y-m-d H:i:s');
		$this->sessionDateTimeExpire = date("Y-m-d H:i:s", strtotime("+1 month"));
		$this->sessionIP = $_SERVER['REMOTE_ADDR'];
		$this->sessionUserAgent = $_SERVER['HTTP_USER_AGENT'];

	}
	
	public function createAuthSession() {
		
		$core = Core::getInstance();
		$query = "INSERT INTO jaga_session (sessionID,userID,sessionDateTimeSet,sessionDateTimeExpire,sessionIP,sessionUserAgent
		) VALUES (:sessionID, :userID, :sessionDateTimeSet, :sessionDateTimeExpire, :sessionIP, :sessionUserAgent)";
		$statement = $core->database->prepare($query);
		
		$statement->bindParam(':sessionID', $this->sessionID);
		$statement->bindParam(':userID', $this->userID);
		$statement->bindParam(':sessionDateTimeSet', $this->sessionDateTimeSet);
		$statement->bindParam(':sessionDateTimeExpire', $this->sessionDateTimeExpire);
		$statement->bindParam(':sessionIP', $this->sessionIP);
		$statement->bindParam(':sessionUserAgent', $this->sessionUserAgent);
		
		$statement->execute();
		
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
	
	public static function getAuthSessionUserID($sessionID) {
	
		$core = Core::getInstance();
		$currentDateTime = date('Y-m-d H:i:s');
		$query = "SELECT userID FROM jaga_session WHERE sessionID = :sessionID AND sessionDateTimeExpire > :currentDateTime LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':sessionID' => $sessionID, ':currentDateTime' => $currentDateTime));
		$userID = 0;
		if ($row = $statement->fetch()) { $userID = $row['userID']; }
		return $userID;
		
	}

}

?>