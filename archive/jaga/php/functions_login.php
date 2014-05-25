<?php

function login($userName, $userPassword) {

	$escapedUserName = mysql_real_escape_string($userName);
	$escapedPassword = mysql_real_escape_string($userPassword);

	// get the user using the username
	$queryGetUser = "SELECT * FROM j00mla_ver4_users WHERE username='$escapedUserName' OR email='$escapedUserName' LIMIT 1";
	$result = mysql_query($queryGetUser);
	$user = mysql_fetch_array($result);
	$numrows = mysql_num_rows($result);

	// get encrypted password from DB
	$passwordParts = explode(':', $user['password']);
	$passwordFromDB = $passwordParts[0];
	$joomlaSalt = $passwordParts[1];
	
	// encrypt user-entered password
	$saltedPassword = $escapedPassword . $joomlaSalt;
	$encryptedPassword = md5($saltedPassword);

	if ($numrows == 1 && $passwordFromDB == $encryptedPassword) {
	
		$_SESSION['userID'] = $user['id'];
		$_SESSION['userName'] = $user['username'];
		if ($user['id'] == 2 || $user['id'] == 62 || $user['id'] == 64) { $_SESSION['userRole'] = 'siteManager'; } else { $_SESSION['userRole'] = 'registered'; }
		if ($user['testMode'] == 1) { $_SESSION['testMode'] = 'on'; } else { $_SESSION['testMode'] = 'off'; }
		
		$_SESSION['userToken'] = generateUserToken();
		setUserToken($_SESSION['userToken']);
		
		$_SESSION['userLoggedIn'] = 1;
		$query = "UPDATE j00mla_ver4_users SET userLoggedIn = '1' WHERE id = '$_SESSION[userID]' LIMIT 1";
		mysql_query($query) OR die('could not set userLoggedIN boolean');
		
		updateUserLastVisitDate();
		postToAuditTrail($_SESSION['userID'], 'loginAttempt', 'successful');

		return 'ok';
			
	} else {
	
		postToAuditTrail($userName, 'loginAttempt', 'notAuthorized');
		return 'ng';
		
	}

}

function updateUserLastVisitDate() {
	$userID = $_SESSION['userID'];
	$lastVisitDate = date('Y-m-d H:i:s');
	$query = "UPDATE j00mla_ver4_users SET lastvisitDate = '$lastVisitDate' WHERE id = '$userID' LIMIT 1";
	mysql_query($query);
}






?>