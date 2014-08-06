<?php

class Authentication {

	public static function checkAuth($username, $password) {

		$encryptedPassword = md5($password);
		$errorArray = array();
	
		$core = Core::getInstance();
		$query = "SELECT userID, username, userEmail, userPassword FROM jaga_User WHERE username = :username OR userEmail = :username LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':username' => $username));
		

		if (!$row = $statement->fetch()) { // account does not exist
		
			$errorArray[] = 'That account does not exist. Please try again.';
			
		} else { // account exists => check password
		
			// PRE-DEPLOYMENT ONLY
			if ($row['userID'] != 2 && $row['userID'] != 3 && $row['userID'] != 64) { $errorArray[] = 'You are not a beta user.'; }
			
			
			if ($row['userPassword'] != $encryptedPassword) { $errorArray[] = 'Your password is incorrect. Please try again.'; }
		}

		return $errorArray;

	}
	
	public static function logout() {
	
		// kill session
		session_unset();
		session_destroy();
		
		// kill jaga_session
		$sessionID = $_COOKIE['TheKutchannel'];
		$currentDateTime = date('Y-m-d H:i:s');
		$core = Core::getInstance();
		$query = "UPDATE jaga_session SET sessionDateTimeExpire = :currentDateTime WHERE sessionID = :sessionID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':currentDateTime' => $currentDateTime, ':sessionID' => $sessionID));
		
		// kill cookie
		setcookie('TheKutchannel', 'loggedout', time()-3600, '/', '.kutchannel.net', FALSE);
		unset($_COOKIE['TheKutchannel']);
		
		
		
	}
	
	public static function register() {
	
	}
	
	public static function isLoggedIn() {
	
	}

}

?>