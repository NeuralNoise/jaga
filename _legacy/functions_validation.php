<?php

function usernameIsValid($userName) {
			// Check if the username is alphanumeric or hyphen or underscore
			if (eregi("^[A-Z0-9_-]+$", $userName) == 1) { return true; } else { return false; }
}

function usernameIsAvailable($userName) {
			// Check to see if the username already exists
			$result = mysql_query("SELECT * FROM j00mla_ver4_users WHERE name = '$userName' OR username = '$userName' LIMIT 1");
			if (mysql_num_rows($result) == 0) { return true; } else { return false; }
}

function emailIsFormattedProperly($userEMail) {
			// Check if the email is formatted properly
			if (eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", $userEMail) == 1) { return true; } else { return false; }
}

function emailIsNotCurrentlyRegistered($userEMail) {
			// Check to see if the email already exists
			$result = mysql_query("SELECT email FROM j00mla_ver4_users WHERE email = '$userEMail' LIMIT 1");
			if (mysql_num_rows($result) == 0) { return true; } else { return false; }
}

function passwordsMatch($userPassword, $confirmUserPassword) {
			// Check if the passwords match
			if ($userPassword == $confirmUserPassword) { return true; } else { return false; }
}

function requiredFieldsArePopulated($fieldArray) {
			// Check if field missing in fields 
			$missingFieldArray = array();
			foreach ($fieldArray as $key => $value) {
				if ($value == '') {
					$missingFieldArray[] = $key;
				}
			}
			return $missingFieldArray;
}

function createUserFormInputValidates($userName, $userEMail) {

	$errorArray = array();
	
	if (!usernameIsValid($userName)) { $errorArray[] = 'userNameIsNotValid'; }
	if (!usernameIsAvailable($userName)) { $errorArray[] = 'userNameIsNotAvailable'; }
	if (!emailIsFormattedProperly($userEMail)) { $errorArray[] = 'emailIsNotFormattedProperly'; }
	if (!emailIsNotCurrentlyRegistered($userEMail)) { $errorArray[] = 'emailIsAlreadyRegistered'; }

	$fieldArray = array();
	$fieldArray['userName'] = $userName;
	$fieldArray['userEMail'] = $userEMail;

	$missingFieldArray = requiredFieldsArePopulated($fieldArray);
	if (!empty($missingFieldArray)) { $errorArray[] = 'requiredFieldsAreMissing'; }
	
	return $errorArray;

}

function updateUserFormInputValidates($userID, $userName, $userEMail, $userPassword, $confirmUserPassword) {

	$errorArray = array();
	
	if (!usernameIsValid($userName)) { $errorArray[] = 'userNameIsNotValid'; }
	if (getUserName($userID) != $userName) { if (!usernameIsAvailable($userName)) { $errorArray[] = 'userNameIsNotAvailable'; } }
	if (!emailIsFormattedProperly($userEMail)) { $errorArray[] = 'emailIsNotFormattedProperly'; }
	if (getUserEmail($userID) != $userEMail) { if (!emailIsNotCurrentlyRegistered($userEMail)) { $errorArray[] = 'emailIsAlreadyRegistered'; } }
	if (!passwordsMatch($userPassword, $confirmUserPassword)) { $errorArray[] = 'passwordsDoNotMatch'; }

	$fieldArray = array();
	$fieldArray['userName'] = $userName;
	$fieldArray['userEMail'] = $userEMail;
	
	if ($userID != $_SESSION['userID']) { // if user editing self than blank password fields OK and password is not updated
		$fieldArray['userPassword'] = $userPassword;
		$fieldArray['confirmUserPassword'] = $confirmUserPassword;
	}
	
	$missingFieldArray = requiredFieldsArePopulated($fieldArray);
	if (!empty($missingFieldArray)) { $errorArray[] = 'requiredFieldsAreMissing'; }
	
	return $errorArray;
	
}




























?>