<?php

function generate_natto () {
	$natto = '';
	for ($i = 0; $i < 3; $i++) { $natto .= chr(rand(35, 126)); }
	return $natto;
}

function generate_unique_key () {
	$uniqueKey = '';
	for ($i = 0; $i < 10; $i++) { $uniqueKey .= chr(rand(97, 122)); }
	return $uniqueKey;
}

function user_registration($userName, $userPassword, $userEMail) {

	if ($_SESSION['lang'] == 'en') { $languageUrlPrefix = ''; } else { $languageUrlPrefix = $_SESSION['lang'] . '/'; }

	$natto = generate_natto();
	$uniqueKey = generate_unique_key();
	// $encrypted = md5(md5($userPassword).$natto);
	$encrypted = md5($userPassword);
	$registrationDateTime = date('Y-m-d H:i:s');
	$siteID = $_SESSION['siteID'];
	
	$query = "INSERT INTO j00mla_ver4_users (
		name,
		username, 
		usernameEnglish, 
		userNameJapanese, 
		userNameJapaneseReading, 
		password, 
		email, 
		usertype, 
		registerDate,
		natto, 
		uniqueKey, 
		verified,
		userRegistrationSiteID
	) VALUES (
		'$userName', 
		'$userName', 
		'$userName',
		'$userName',
		'$userName',
		'$encrypted', 
		'$userEMail', 
		'Registered',
		'$registrationDateTime',
		'$natto',
		'$uniqueKey', 
		'no',
		$siteID
	)";

	mysql_query ($query) or die ('Could not create user.');

	$siteName = getSiteTitle();
	$siteURL = getSiteURL();
	$siteAutomatedEmailAddress = getSiteAutomatedEmailAddress();
	
	$to = $userEMail;
	$subject = "E-mail verification request from $siteName";
	$message = "Dear $userName,\nThank you for your registration. Please visit the following URL to verify your e-mail address:\n\n$siteURL/" . $languageUrlPrefix . "email-verification/$userName/$uniqueKey/\n\nThanks again and kindest regards, $siteName";
	$from = $siteAutomatedEmailAddress;
	$headers = "From: $from";
	
	agileMail($to, $from, $subject, $message);

}

/* ------- UPDATE USER ------- */

function update_user($username, $password, $email)
{
	// Get natto from the DB
	$query1 = "SELECT natto FROM user WHERE userName='$username' limit 1";
	$result1 = mysql_query($query1);
	$userData = mysql_fetch_array($result1);
	$natto = $userData['natto'];

    if ($password != "")
    {
	// Now encrypt the new password using natto
	$encryptedPassword = md5(md5($password).$natto);

	// Store the password in the database
	$query2 = "UPDATE framework_user SET userPassword = '$encryptedPassword' WHERE userName='$username' limit 1";
	mysql_query ($query2) or die ('Could not update password.');
    }

    if ($email != "")
	{

	// Get natto using our function
	$uniquekey = generate_unique_key();

	// Store the e-mail in the database
	$query3 = "UPDATE framework_user SET userEMail = '$email', uniqueKey = '$uniqueKey', verified = 'no' WHERE userName='$userName' limit 1";
	mysql_query ($query3) or die ('Could not update e-mail.');

	// Mail verification mail to registered email address
	$to = $email;
	$subject = "E-mail verification request from Niseko Pass network site";
	$message = "Dear $username,\n\nPlease visit the following URL to verify that your new e-mail is valid:\nhttp://NisekoPass.com/eMailVerification.php?userName=$userName&verify=$uniqueKey\nIf this e-mail was sent to you in error please contact us at support@agilehokkaido.com.\n\nThanks again and kindest regards, Agile Hokkaido";
	$from = "support@agilehokkaido.com";
	$headers = "From: $from";
	mail("$to","$subject","$message","$headers");

	}
}

/* ------- RESEND VERIFICATION EMAIL ------- */

function resend_verification_email($userName)
{
	$query = "SELECT * FROM framework_user WHERE userName='$userName' limit 1";
	$result  = mysql_query($query);
	$userData = mysql_fetch_array($result);
	$userName = $userData['userName'];
	$uniqueKey = $userData['uniqueKey'];
	$email = $userData['userEMail'];

	// Resend verification mail to registered email address
	$to = $email;
	$subject = "E-mail verification request from NisekoPass.com";
	$message = "Dear $userName,\n\nPlease visit the following URL to verify that your new e-mail is valid:\nhttp://NisekoPass.com/dev/framework/eMailVerification.php?userName=$userName&uniqueKey=$uniqueKey\nIf this e-mail was sent to you in error please contact us at admin@NisekoPass.com.\n\nThanks again and kindest regards, Niseko Pass";
	$from = "testing@agilehokkaido.com";
	$headers = "From: $from";
	mail("$to","$subject","$message","$headers");

}
	
function getSnowLocationURL($snowLocationID) {

	$resultGetSnowLocationURL = mysql_query("SELECT * FROM snowLocation WHERE snowLocationID = $snowLocationID LIMIT 1");
	while($rowGetSnowLocationURL = mysql_fetch_array($resultGetSnowLocationURL)) {
		return $rowGetSnowLocationURL['snowLocationGoogleMapsURL'];
	}

}
	
function random_hex_color(){
    mt_srand((double)microtime()*1000000);
    $c = '';
    while(strlen($c)<6){
        $c .= sprintf("%02X", mt_rand(0, 255));
    }
    return $c;
}






function loadUserSessionArrays() {

	$_SESSION['userGroupArray'] = array();
	$_SESSION['userProjectArray'] = array();
	$_SESSION['userClientArray'] = array();
	$_SESSION['userAccommodationArray'] = array();
	$_SESSION['userPropertyArray'] = array();
	$_SESSION['userSiteManagerArray'] = array();
	$_SESSION['userRoles'] = array();
	
	$resultGetThisUsersGroups = mysql_query("SELECT shigoto_groupUser.groupID AS groupID FROM shigoto_groupUser LEFT JOIN shigoto_group ON shigoto_groupUser.groupID = shigoto_group.groupID WHERE shigoto_group.siteID = '$_SESSION[siteID]' AND shigoto_groupUser.userID = '$_SESSION[userID]'");
	
	
	while($rowGetThisUsersGroups = mysql_fetch_array($resultGetThisUsersGroups)) {
		$_SESSION['userGroupArray'][] = $rowGetThisUsersGroups['groupID'];
		$resultGetThisGroupsProjects = mysql_query("SELECT projectID FROM shigoto_project WHERE groupID = '$rowGetThisUsersGroups[groupID]'");
			while($rowGetThisGroupsProjects = mysql_fetch_array($resultGetThisGroupsProjects)) {
			$_SESSION['userProjectArray'][] = $rowGetThisGroupsProjects['projectID'];
		}
	}

	
	$result = mysql_query("	
							SELECT accounting_clientUser.clientID AS clientID 
							FROM accounting_clientUser LEFT JOIN accounting_client
							ON accounting_clientUser.clientID = accounting_client.clientID
							WHERE accounting_clientUser.userID = '$_SESSION[userID]' AND accounting_client.siteID = '$_SESSION[siteID]'
							ORDER BY accounting_clientUser.clientID ASC
	");

	while($row = mysql_fetch_array($result)) {
		$_SESSION['userClientArray'][] = $row['clientID'];
	}
	
	
	
	

	if (!empty($_SESSION['userClientArray'])) {
	
		$clientWhereClause = join(',',$_SESSION['userClientArray']);
	
		$result = mysql_query("SELECT DISTINCT accommodation_Accommodation.accommodationID
			FROM accommodation_AccommodationClient, accommodation_Accommodation WHERE accommodation_Accommodation.accommodationID = accommodation_AccommodationClient.accommodationID
			AND accommodation_AccommodationClient.clientID IN ($clientWhereClause)
			AND accommodation_Accommodation.siteID = '$_SESSION[siteID]'
			ORDER BY accommodation_Accommodation.accommodationID ASC");
		while($row = mysql_fetch_array($result)) { $_SESSION['userAccommodationArray'][] = $row['accommodationID']; }
	
		$result = mysql_query("SELECT DISTINCT property_property.propertyID
			FROM property_propertyClient, property_property WHERE property_property.propertyID = property_propertyClient.propertyID
			AND property_propertyClient.clientID IN ($clientWhereClause)
			AND property_property.siteID = '$_SESSION[siteID]'
			ORDER BY property_property.propertyID ASC");
		while($row = mysql_fetch_array($result)) { $_SESSION['userPropertyArray'][] = $row['propertyID']; }
		
	}
	

	
	
	
	
	
	
	
	
	
	
	
	
	$result = mysql_query("SELECT siteID FROM nisekocms_siteManager WHERE userID = '$_SESSION[userID]' ORDER BY siteID ASC");
	// this is deprecated but currently still in user *somewhere* in nisekocms
	while($row = mysql_fetch_array($result)) { $_SESSION['userSiteManagerArray'][] = $row['siteID']; }

	
	
	$result = mysql_query("SELECT role FROM nisekocms_siteUserRole WHERE siteID = '$_SESSION[siteID]' AND userID = '$_SESSION[userID]' LIMIT 1");
	if ($_SESSION['userID'] == 2) {
		$_SESSION['userRoles'][] = 'siteManager';
		while($row = mysql_fetch_array($result)) {
			if ($row['role'] != 'siteManager') { $_SESSION['userRoles'][] = $row['role']; }
			// have given self siteManager role on some sites already and don't want it twice in array
		}
	} else {
		while($row = mysql_fetch_array($result)) { $_SESSION['userRoles'][] = $row['role']; }
	}

	
	
	
}



function loadSiteSessionArrays() {

	$_SESSION['siteModuleArray'] = array();
	$result = mysql_query("SELECT moduleKey FROM nisekocms_siteModule WHERE siteID = '$_SESSION[siteID]' ORDER BY moduleKey ASC");
	while($row = mysql_fetch_array($result)) { $_SESSION['siteModuleArray'][] = $row['moduleKey']; }
	
	$resultGetSiteNetwork = mysql_query("SELECT siteNetwork FROM nisekocms_site WHERE siteID = '$_SESSION[siteID]' LIMIT 1");
	$rowGetSiteNetwork = mysql_fetch_array($resultGetSiteNetwork);
	$_SESSION['siteNetwork'] = $rowGetSiteNetwork['siteNetwork'];
	
	$_SESSION['networkSiteArray'] = array();
	$resultNetworkSiteArray = mysql_query("SELECT siteID FROM nisekocms_site WHERE siteNetwork = '$_SESSION[siteNetwork]' ORDER BY siteID");
	while($rowNetworkSiteArray = mysql_fetch_array($resultNetworkSiteArray)) { $_SESSION['networkSiteArray'][] = $rowNetworkSiteArray['siteID']; }
	
	
}







function agileTruncate($string, $length, $stopanywhere=false) {
    //truncates a string to a certain char length, stopping on a word if not specified otherwise.
    if (strlen($string) > $length) {
        //limit hit!
        $string = substr($string,0,($length -3));
        if ($stopanywhere) {
            //stop anywhere
            $string .= '...';
        } else{
            //stop on a word.
            $string = substr($string,0,strrpos($string,' ')).'...';
        }
    }
    return $string;
}




function generateUserToken() {
	$userToken = '';
	$userToken = md5($_SESSION['encrypted_id'] . generate_natto());
	return $userToken;
}

function setUserToken($userToken) {

	$userTokenExpiry = date("Y-m-d H:i:s", strtotime ("+1 hour")); // one hour expiry
	$userTokenIP = $_SERVER['REMOTE_ADDR'];
	$userTokenUserAgent = substr($_SERVER['HTTP_USER_AGENT'], 0, 255); // first 255 characters only
	
	$querySetToken = "
		UPDATE j00mla_ver4_users SET
			userToken = '$userToken',
			userTokenExpiry = '$userTokenExpiry',
			userTokenIP = '$userTokenIP',
			userTokenUserAgent = '$userTokenUserAgent'
		WHERE id = '$_SESSION[userID]' LIMIT 1
	";

	mysql_query($querySetToken);

}

function getExistingUserToken($userID) {
	// users can login with their tokens for only one hour after logging in
	// after that tokens must be reset
	$currentDateTime = date('Y-m-d H:i:s');
	$query = "SELECT userToken FROM j00mla_ver4_users WHERE id = '$userID' AND userTokenExpiry > '$currentDateTime' LIMIT 1";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	if (mysql_num_rows($result) == 1) { $userToken = $row['userToken']; } else { $userToken = 'expired'; }
	return $userToken;
}

function userIsLoggedIn($userID) {
	$query = "SELECT userLoggedIn FROM j00mla_ver4_users WHERE id = '$userID' LIMIT 1";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	if ($row['userLoggedIn'] == 1) { return true; } else { return false; }
}
?>