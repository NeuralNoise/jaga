<?php

class Authentication {

	public static function checkAuth($username, $password) {

		$encryptedPassword = md5($password);
		$errorArray = array();
	
		$core = Core::getInstance();
		$query = "SELECT userID, username, userEmail, userPassword, userSelectedLanguage FROM jaga_User WHERE userBlacklist = 0 AND username = :username OR userEmail = :username LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':username' => $username));

		$ipBlacklist = BlacklistIP::getIpBlacklist();
		if (in_array($_SERVER['REMOTE_ADDR'],$ipBlacklist)) {
			$errorArray['spam'][] = "We are experiencing technical difficulty. Please try again later.";
			BlacklistIP::plusone($_SERVER['REMOTE_ADDR']);
		}

		if (
			(!$row = $statement->fetch()) || 
			($row['userPassword'] != $encryptedPassword) 
		) {
			$errorArray['login'][] = 'Authentication failed. Please try again or <a href="/account-recovery/">recover your account details</a> using your email address.';
		}

		if ($row['userSelectedLanguage'] == 'ja') { $_SESSION['lang'] = 'ja'; } else { $_SESSION['lang'] = 'en'; }
		
		return $errorArray;

	}
	
	public static function logout() {
	
		// kill session
		session_unset();
		session_destroy();
		
		// kill jaga_session
		$sessionID = $_COOKIE['jaga'];
		$currentDateTime = date('Y-m-d H:i:s');
		$core = Core::getInstance();
		$query = "UPDATE jaga_session SET sessionDateTimeExpire = :currentDateTime WHERE sessionID = :sessionID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':currentDateTime' => $currentDateTime, ':sessionID' => $sessionID));
		
		// kill cookie
		setcookie('jaga', 'loggedout', time()-3600, '/', '.jaga.io', FALSE);
		unset($_COOKIE['jaga']);
		
		
		
	}
	
	public static function register($username, $userEmail, $password, $confirmPassword, $raptcha, $obFussyCat) {
	
		$errorArray = array();
		
		$ipBlacklist = BlacklistIP::getIpBlacklist();
		if (in_array($_SERVER['REMOTE_ADDR'],$ipBlacklist)) {
			$errorArray['spam'][] = "We are experiencing technical difficulty. Please try again later.";
			BlacklistIP::plusone($_SERVER['REMOTE_ADDR']);
		}
		
		$domainBlacklist = BlacklistDomain::getDomainBlacklist();
		
		if (preg_match('/('.implode('|', $domainBlacklist).')$/i', $userEmail)) {
			
			$errorArray['spam'][] = "We are experiencing technical difficulty. Please try again later.";
			// BlacklistDomain::plusone($domain);
			
		} else {

			if ($username == '') {
				$errorArray['username'][] = "The username field is required.";
			} else {
				if (User::usernameExists($username)) { $errorArray['username'][] = "That username is already taken."; }
				if (!preg_match('/^[A-Za-z0-9_-]+$/',$username)) {
					$errorArray['username'][] = "Your username can contain only letters, numbers, hyphens, and underscores.";
				}
			}
			
			if ($userEmail == '') {
				$errorArray['userEmail'][] = "The 'email' field is required.";
			} else {
				if (!preg_match('/^\b[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}\b$/',$userEmail)) {
					$errorArray['userEmail'][] = "That email address appears to be formatted incorrectly.";
				}
				if (User::emailInUse($userEmail)) { $errorArray['userEmail'][] = "That email address is already in use."; }		
			}

			if ($password == '') { $errorArray['password'][] = "The password field is required."; }
			if ($confirmPassword == '') { $errorArray['confirmPassword'][] = "The confirm password field is required."; }
			if ($password != '' && $confirmPassword != '' && $password != $confirmPassword) {
				$errorArray['passwords'][] = "The passwords you entered did not match.";
			}
			
			if ($raptcha != $_SESSION['raptcha']) { $errorArray['raptcha'][] = "The code did not match."; }
			
			if (!$obFussyCat) { $errorArray['obFussyCat'][] = "Fussy cat is fussy."; }
		
		}

		return $errorArray;
		
	}
	
	public static function isLoggedIn() {
		
		if (isset($_SESSION['userID']) && $_SESSION['userID'] != 0) { return true; } else { return false; }
		
	}
	
	public static function isAdmin() {

		if (in_array($_SESSION['userID'],Config::read('admin.userIdArray'))) { return true; } else { return false; }
		
	}

}

?>