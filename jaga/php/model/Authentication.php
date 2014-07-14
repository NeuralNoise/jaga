<?php

class Authentication {

	public static function checkAuth($username, $password) {

		$encryptedPassword = md5($password);
		$errorArray = array();
	
		$core = Core::getInstance();
		$query = "SELECT id, username, email, password FROM jaga_user WHERE username = :username OR email = :username LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':username' => $username));
		

		if (!$row = $statement->fetch()) { // account does not exist
		
			$errorArray[] = 'That account does not exist. Please try again.';
			
		} else { // account exists => check password
		
			// PRE-DEPLOYMENT ONLY
			if ($row['id'] != 2 && $row['id'] != 3 && $row['id'] != 64) { $errorArray[] = 'You are not a beta user.'; }
			
			
			if ($row['password'] != $encryptedPassword) { $errorArray[] = 'Your password is incorrect. Please try again.'; }
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