<?php

function user_logout() {

	// reset user token
	$userToken = generateUserToken();
	setUserToken($userToken);
	
	// set userLoggedIn = 0 so other sites know when a logout has occurred
	$query = "UPDATE j00mla_ver4_users SET userLoggedIn = '0' WHERE id = '$_SESSION[userID]' LIMIT 1";
	mysql_query($query) OR die('could not set userLoggedIN boolean');

	// End the session and unset all vars
	session_unset ();
	session_destroy ();
}
	
?>