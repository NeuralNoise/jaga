<?php

function getUserName($userID) {
	$resultGetUserName = mysql_query("SELECT * FROM j00mla_ver4_users WHERE id = $userID LIMIT 1");
	while($rowGetUserName = mysql_fetch_array($resultGetUserName)) {
		$userName = $rowGetUserName['username'];
	}
	return $userName;
}

function getUserEmail($userID) {
	$resultGetUserEMail = mysql_query("SELECT email FROM j00mla_ver4_users WHERE id = $userID LIMIT 1");
	while($rowGetUserEMail = mysql_fetch_array($resultGetUserEMail)) {
		$userEmail = $rowGetUserEMail['email'];
	}
	return $userEmail;
}

function isSiteManager() {

	$siteID = $_SESSION['siteID'];
	if (isset($_SESSION['userID'])) { $userID = $_SESSION['userID']; } else { $userID = 0; }

	$result = mysql_query("SELECT * FROM nisekocms_siteManager WHERE siteID = $siteID AND userID = $userID LIMIT 1");
	if (mysql_num_rows($result) == 1) { return true; } else { return false; }

}

function userExists($userEmail) {
	$resultCheckForUser = mysql_query("SELECT * FROM j00mla_ver4_users WHERE email = '$userEmail' LIMIT 1");
	if (mysql_num_rows($resultCheckForUser) == 1) { return true; } else { return false; }

}

function getUserIdWithEmail($userEmail) {
	$resultGetUserIdWithEmail = mysql_query("SELECT id FROM j00mla_ver4_users WHERE email = '$userEmail' LIMIT 1");
	while($rowGetUserIdWithEmail = mysql_fetch_array($resultGetUserIdWithEmail)) { return $rowGetUserIdWithEmail['id']; }
}

function displayUserList() {
	
	
		if ($_SESSION['userRoleForCurrentSite'] == 'siteAdmin') {
			$result = mysql_query("SELECT * FROM j00mla_ver4_users ORDER BY name ASC");
		} elseif ($_SESSION['userRoleForCurrentSite'] == 'siteManager') {
			// find usersThatAreAuthorizedForSite
			$resultGetThisSitesAuthorizedUsers = mysql_query("
				SELECT nisekocms_siteUserRole.userID
				FROM j00mla_ver4_users, nisekocms_siteUserRole
				WHERE j00mla_ver4_users.id = nisekocms_siteUserRole.userID
				AND nisekocms_siteUserRole.siteID = $_SESSION[siteID]
				ORDER BY nisekocms_siteUserRole.userID
			");
			$usersAuthorizedForThisSiteArray = array();
			while($rowGetThisSitesAuthorizedUsers = mysql_fetch_array($resultGetThisSitesAuthorizedUsers)) { $usersAuthorizedForThisSiteArray[] = $rowGetThisSitesAuthorizedUsers['userID']; }
			$usersAuthorizedForThisSite = join(',',$usersAuthorizedForThisSiteArray);
			$result = mysql_query("SELECT * FROM j00mla_ver4_users WHERE id IN ($usersAuthorizedForThisSite) ORDER BY name ASC");
		} else {
			$result = mysql_query("SELECT * FROM j00mla_ver4_users WHERE id = $_SESSION[userID] LIMIT 1");
		}
		
	echo '<table style="width:100%;margin:5px auto 5px auto;background-color:#fff;font-family:verdana;font-size:10px;">';
	
		echo '<tr>';
			echo '<td class="fieldLabelLeft" colspan="7">';
				echo '<input type="button" value="' . agileResource('createUser') . '" onclick="window.location.href=\'' . languageUrlPrefix() . 'user/create/check-for-existing-account/\'">';
			echo '</td>';
		echo '</tr>';
		
		echo '<tr>';
			if ($_SESSION['roleID'] == 'Super Administrator') { echo '<td class="fieldLabel">' . agileResource('id') . '</td>'; }
			echo '<td class="fieldLabelCenter">' . agileResource('name') . '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('email') . '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('role') . '</td>';
			if ($_SESSION['roleID'] == 'Super Administrator') { echo '<td class="fieldLabelCenter">' . agileResource('verified') . '</td>'; }
			echo '<td class="fieldLabelCenter">' . agileResource('clients') . '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('groups') . '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('lastLogin') . '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('action') . '</td>';
		echo '</tr>';

		while($row = mysql_fetch_array($result)) {
			
			echo '<tr>';
				if ($_SESSION['roleID'] == 'Super Administrator') { echo '<td class="borderAlignCenter">' . $row['id'] . '</td>'; }
				echo '<td class="borderAlignCenter">' . $row['name'] . '</td>';
				echo '<td class="borderAlignCenter">' . $row['email'] . '</td>';
				echo '<td class="borderAlignCenter">' . agileResource(userRoleForCurrentSite($row['id'], $_SESSION['siteID'])) . '</td>';
				if ($_SESSION['roleID'] == 'Super Administrator') { echo '<td class="borderAlignCenter">' . $row['verified'] . '</td>'; }	
				echo '<td class="borderAlignCenter">';

					$thisSitesClientsArray = array();
					$thisSitesClientsArray = getThisSitesClients();
					if (!empty($thisSitesClientsArray)) {

						$thisSitesClients = join(',',getThisSitesClients());
						if (empty($thisSitesClients)) { $thisSitesClients = 0; }
						$resultGetUserClients = mysql_query("SELECT * FROM accounting_clientUser WHERE userID = '$row[id]' AND clientID IN ($thisSitesClients)");
							
						if (mysql_num_rows($resultGetUserClients) != 0) {
							echo '<a class="agileTooltip">';
								echo '<span>';
									echo '<p style="text-align:left;">';
										while($rowGetUserClient = mysql_fetch_array($resultGetUserClients)) { echo getClientName($rowGetUserClient['clientID']) . '<br />'; }
									echo '</p>';
								echo '</span>';
								echo agileResource('clients');
								echo '&nbsp;';
								echo '(' . mysql_num_rows($resultGetUserClients) . ')';
							echo '</a>';
						}

					}
					

				echo '</td>';
				
				echo '<td class="borderAlignCenter">';
						
					$thisSitesGroups = join(',',getThisSitesGroups());
					$resultGetUserGroups = mysql_query("SELECT * FROM shigoto_groupUser WHERE userID = $row[id] AND groupID IN ($thisSitesGroups)");
							
					if (mysql_num_rows($resultGetUserGroups) != 0) {
						echo '<a class="agileTooltip">';
							echo '<span>';
								echo '<p style="text-align:left;">';
									while($rowGetUserGroup = mysql_fetch_array($resultGetUserGroups)) { echo getGroupName($rowGetUserGroup['groupID']) . '<br />'; }
								echo '</p>';
							echo '</span>';
							echo agileResource('groups');
							echo '&nbsp;';
							echo '(' . mysql_num_rows($resultGetUserGroups) . ')';
						echo '</a>';
					}	
				echo '</td>';
			
				echo '<td class="borderAlignCenter">' . $row['lastvisitDate'] . '</td>';
			
				echo '<td class="borderAlignCenter">';
					echo '<input type="button" value="' . agileResource('updateUser') . '" onclick="window.location.href=\'' . languageUrlPrefix() . 'user/update/' . $row['id'] .'/\'">';
				echo '</td>';
			echo '</tr>';
		}
	
	echo '</table>';
	
	
}

function displayUserCRUD(
		$type = 'create', 
		$userID = 0, 
		$userName = '', 
		$userEMail = '', 
		$userPassword = '', 
		$confirmUserPassword = '', 
		$siteUserRole = 'registered', 
		$clientArray = array(),
		$groupArray = array(),
		$errorArray = array()
	) {
	
			echo '<form action="' . languageUrlPrefix() . 'user/' . $type . '/';
				if ($type == 'update' && $userID != 0) { echo $userID . '/'; }
			echo '" method="post" />';
			
			if ($type == 'update') { echo '<input type="hidden" name="userID" value="' . $userID . '">'; }
			
			echo '<table style="border:1px solid #ccc;margin:5px auto 5px auto;">';
		
			
			
				echo '<tr>';
					echo '<td class="borderAlignLeft">' . agileResource('username') . '</td>';
					echo '<td class="borderAlignLeft">';
						if ($type == 'create' || $userID == $_SESSION['userID']) {
							echo '<input type="text" style="width:300px;" maxlength="255" name="userName" value="' . $userName . '" />';
						} else {
							echo '<input type="hidden" name="userName" value ="'. $userName . '">';
							echo $userName;
						}
					echo '</td>';
					
					
					
				echo '</tr>';
				
				
				echo '<tr>';
					echo '<td class="borderAlignLeft">' . agileResource('email') . '</td>';
					echo '<td class="borderAlignLeft">';
						if ($type == 'create' || $userID == $_SESSION['userID']) {
							echo '<input type="text" style="width:300px;" maxlength="255" name="userEMail" value="' . $userEMail . '" />';
						} else {
							echo '<input type="hidden" name="userEMail" value ="'. $userEMail . '">';
							echo $userEMail;
						}
					echo '</td>';
				echo '</tr>';
				
				
				echo '<tr>';
					echo '<td class="borderAlignLeft">' . agileResource('password') . '</td>';
					echo '<td class="borderAlignLeft">';

						if ($type == 'create') {
							echo agileResource('passwordWillBeMailedDirectlyToTheUser');
						} elseif ($type == 'update') {
							if ($userID == $_SESSION['userID']) {
								echo '<input type="password" style="width:300px;" maxlength="20" name="userPassword" value="' . $userPassword . '" />';
							} else {
								echo '********';
							}
						}
						
					echo '</td>';
				echo '</tr>';
				
				if ($type == 'update' && $userID == $_SESSION['userID']) {
					echo '<tr>';
						echo '<td class="borderAlignLeft">' . agileResource('confirmPassword') . '</td>';
						echo '<td class="borderAlignLeft">';
							if ($userID == $_SESSION['userID']) {
								echo '<input type="password" style="width:300px;" maxlength="20" name="confirmUserPassword" value="' . $confirmUserPassword . '" />';
							} else {
								echo '********';
							}
						echo '</td>';
					echo '</tr>';
				}
				
				if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') {
					echo '<tr>';
						echo '<td class="borderAlignLeft">' . agileResource('siteUserRole') . '</td>';
						echo '<td class="borderAlignLeft">';
								echo '<input type="radio" name="siteUserRole" value="registered"';
								
									if (isPrimarySiteManager($userID)) { echo ' disabled="disabled"'; }
									if ($siteUserRole == 'registered') { echo ' checked'; }
									
								echo '> ' . agileResource('registered') . '<br />';
								echo '<input type="radio" name="siteUserRole" value="siteClient"';
								
									if (isPrimarySiteManager($userID)) { echo ' disabled="disabled"'; }
									if ($siteUserRole == 'siteClient') { echo ' checked'; }
									
								echo '> ' . agileResource('siteClient') . '<br />';
								echo '<input type="radio" name="siteUserRole" value="siteStaff"';
								
									if (isPrimarySiteManager($userID)) { echo ' disabled="disabled"'; }
									if ($siteUserRole == 'siteStaff') { echo ' checked'; }
									
								echo '> ' . agileResource('siteStaff') . '<br />';
								echo '<input type="radio" name="siteUserRole" value="siteAccountant"';
								
									if (isPrimarySiteManager($userID)) { echo ' disabled="disabled"'; }
									if ($siteUserRole == 'siteAccountant') { echo ' checked'; }
									
								echo '> ' . agileResource('siteAccountant') . '<br />';
								echo '<input type="radio" name="siteUserRole" value="siteManager"';
								
									if (isPrimarySiteManager($userID)) { echo ' disabled="disabled"'; }
									if ($siteUserRole == 'siteManager') { echo ' checked'; }
									
								echo '> ' . agileResource('siteManager');
								
								if (isPrimarySiteManager($userID)) { echo '<input type="hidden" name="siteUserRole" value="siteManager">'; }

						echo '</td>';
					echo '</tr>';
				}
				
				
				
				if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') {
					echo '<tr>';
						echo '<td class="borderAlignLeft">' . agileResource('client') . '</td>';
						echo '<td class="borderAlignLeft">';
							
							echo '<select name="clientID[]" multiple="multiple" style="width:300px;">';

								$resultGetThisSitesClients = mysql_query("SELECT * FROM accounting_client WHERE siteID = $_SESSION[siteID] ORDER BY clientNameEnglish ASC");
								while($rowGetThisSitesClients = mysql_fetch_array($resultGetThisSitesClients)) {
									echo '<option value="' . $rowGetThisSitesClients['clientID'] . '"';
									
									
									
									
									
									
									
									
									
									if (!empty($clientArray)) { // if client is empty
										if (empty($errorArray)) { // if there are no errors (in practice if submitted form data had no validation problems this won't be displayed)
											if (in_array($rowGetThisSitesClients['clientID'], getUserClientArray($userID))) { echo ' selected="true"'; }
										} elseif (!empty($errorArray)) { // there were errors, use submitted values
											if (in_array($rowGetThisSitesClients['clientID'], $clientArray)) { echo ' selected="true"'; }
										}
									}
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									echo '>';
									if ($_SESSION['lang'] == 'ja') {
										echo $rowGetThisSitesClients['clientNameJapanese'];
									} else {
										echo $rowGetThisSitesClients['clientNameEnglish'];
									}
									echo ' (' . $rowGetThisSitesClients['clientID'] . ')';
									echo '</option>';
								}


							echo '</select>';
						echo '</td>';
					echo '</tr>';
				}
				
				if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') {
					echo '<tr>';
						echo '<td class="borderAlignLeft">' . agileResource('group') . '</td>';
						echo '<td class="borderAlignLeft">';
							
							echo '<select name="groupID[]" multiple="multiple" style="width:300px;">';

								//echo <option value="1">' </option>
								
								$resultGetThisSitesGroups = mysql_query("SELECT * FROM shigoto_group WHERE siteID = $_SESSION[siteID] ORDER BY groupNameEnglish ASC");
								while($rowGetThisSitesGroups = mysql_fetch_array($resultGetThisSitesGroups)) {
									echo '<option value="' . $rowGetThisSitesGroups['groupID'] . '"';
									
									if (!empty($groupArray)) {
										if (empty($errorArray)) {
											if (in_array($rowGetThisSitesGroups['groupID'], getUserGroupArray($userID))) { echo ' selected="true"'; }
										} elseif (!empty($errorArray)) {
											if (in_array($rowGetThisSitesGroups['groupID'], $groupArray)) { echo ' selected="true"'; }
										}
									}
									
									
									echo '>';
									if ($_SESSION['lang'] == 'ja') {
										echo $rowGetThisSitesGroups['groupNameJapanese'];
									} else {
										echo $rowGetThisSitesGroups['groupNameEnglish'];
									}
									echo ' (' . $rowGetThisSitesGroups['groupID'] . ')';
									echo '</option>';
								}


							echo '</select>';
						echo '</td>';
					echo '</tr>';
				}
				
				echo '<tr>';
					echo '<td class="borderAlignRight" colspan="2"><input type="submit" name="submit" value="';
						if ($type == 'create') { echo agileResource('createUser'); } elseif ($type == 'update') { echo agileResource('updateUser'); }
					echo '" /></td>';
				echo '</tr>';
				
				if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') {
					
						echo '<td class="borderAlignLeft" colspan="2">';
							echo '<ul>';
								if ($type == 'create') {
									echo '<li>' . agileResource('afterUserIsCreatedOnlyUserCanUpdateUsernameAndEmail') . '</li>';
								} elseif ($type == 'update') {
									echo '<li>' . agileResource('onlyUserCanUpdateUsernameMailPassword') . '</li>';
								}
								echo '<li>' . agileResource('usersWithRoleRegisteredAreNotDisplayedInTheUserList') . '</li>';
								echo '<li>' . agileResource('usersWithRoleRegisteredCannotLoginToSitesThatArePrivate') . '</li>';
								echo '<li>' . agileResource('thisSiteIs') . ': ';
									echo '<b>';
										if (siteIsPublic()) { echo agileResource('public'); } else { echo agileResource('private'); }
									echo '</b>';
								echo '</li>';
								
								echo '<li>' . agileResource('userWillHaveAccessToSelectedClients') . '</li>';
								echo '<li>' . agileResource('userWillHaveAccessToSelectedGroupsProjects') . '</li>';
							echo '</ul>';
						echo '</td>';
						
					
				}
			
					
				if (!empty($errorArray)) {	
					echo '<tr>';
						echo '<td class="borderAlignLeft" colspan="2">';
							print_r($errorArray);
						echo '</td>';
					echo '</tr>';
				}
				
			echo '</table>';
			echo '</form>';

	}


function displayCheckForExistingAccountForm($userEmail = '') {
	
		echo '<table style="border:1px solid #ccc;margin:5px auto 5px auto;">';
			echo '<form action="' . languageUrlPrefix() . 'user/create/check-for-existing-account/" method="post" />';
			
				echo '<tr>';
					echo '<td class="borderAlignCenter">';
						echo '<input type="text" size="20" maxlength="255" name="userEmail" value="' . $userEmail . '" />';
					echo '</td>';
				echo '</tr>';
					
				echo '<tr>';
					echo '<td class="borderAlignCenter">';
						echo '<input type="submit" name="submit" value="' . agileResource('checkForExistingAccount') . '" />';
					echo '</td>';
				echo '</tr>';
						
			echo '</form>';
		echo '</table>';
		
	}

function createUser($userName, $userEMail, $userPassword) {

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
			'yes',
			$siteID
		)";

		mysql_query ($query) or die ('could not create user via createUser()');

		return mysql_insert_id();
		
	}
	
function insertIntoUserSiteRole($siteID, $userID, $role) {
	
		if ($role != 'registered') {
			$query = "INSERT INTO nisekocms_siteUserRole (
				siteID,
				userID, 
				role
			) VALUES (
				$siteID, 
				$userID, 
				'$role'
			)";
			mysql_query ($query) or die ('could not add user role via insertIntoUserSiteRole()');
		}
	
	}

function insertIntoClientUserPerSiteSettings($clientID) {
	
	// $siteID = $_SESSION['siteID'];
	
	$queryGetSitesAuthorizedUsers = "SELECT * FROM nisekocms_siteUserRole WHERE siteID = '$_SESSION[siteID]' AND role != 'siteClient'";
	// only give access to staff, accountants, and managers
	$resultGetSitesAuthorizedUsers = mysql_query($queryGetSitesAuthorizedUsers);
	
	while ($rowGetSitesAuthorizedUsers = mysql_fetch_array($resultGetSitesAuthorizedUsers)) {
		$userID = $rowGetSitesAuthorizedUsers['userID'];
		$query = "INSERT INTO accounting_clientUser (
			clientID,
			userID
		) VALUES (
			'$clientID', 
			'$userID'
		)";
		mysql_query ($query) or die ('could not add user to client via insertIntoClientUserPerSiteSettings()');
	}
}
	
function updateUser($userID, $userName, $userEMail, $userPassword) {
	
	
		if ($userPassword != '') {
			$password = md5($userPassword); // encrypt password
			$query = "
				UPDATE j00mla_ver4_users
				SET name = '$userName',
					username = '$userName',
					usernameEnglish = '$userName',
					userNameJapanese = '$userName',
					userNameJapaneseReading = '$userName',
					email = '$userEMail',
					password = '$password'
				WHERE id = $userID
				LIMIT 1
			";
		} elseif ($userPassword == '') {
			$query = "
				UPDATE j00mla_ver4_users
				SET name = '$userName',
					username = '$userName',
					usernameEnglish = '$userName',
					userNameJapanese = '$userName',
					userNameJapaneseReading = '$userName',
					email = '$userEMail'
				WHERE id = $userID
				LIMIT 1
			";
		}

		mysql_query ($query) or die ('could not update user via updateUser()');
	
	}
	
function hasClientAccessOnCurrentSite() {

	$thisSiteClientArray = array();
	$siteID = $_SESSION['siteID'];
	if (isset($_SESSION['userID'])) { $userID = $_SESSION['userID']; } else { $userID = 0; }

	
	$resultGetThisSitesClients = mysql_query("SELECT * FROM accounting_client WHERE siteID = $siteID");
	while($rowGetThisSitesClients = mysql_fetch_array($resultGetThisSitesClients)) { $thisSiteClientArray['clientID'][] = $rowGetThisSitesClients['clientID']; }
	
	
	$thisUsersClients = join(",", $thisSiteClientArray['clientID']);
	
	// echo $thisUsersClients;
	
	$resultGetClientsForThisUser = mysql_query("SELECT * FROM accounting_clientUser WHERE userID = $userID AND clientID IN ('$thisUsersClients')");
	if (mysql_num_rows($resultGetClientsForThisUser) >= 1) { return true; } else { return false; }
	

}

function isModuleEnabled($moduleKey) {
	$siteID = $_SESSION['siteID'];
	$result = mysql_query("SELECT * FROM nisekocms_siteModule WHERE siteID = $siteID AND moduleKey = '$moduleKey' LIMIT 1");
	if (mysql_num_rows($result) == 1) { return true; } else { return false; }
}

function userRoleForCurrentSite($userID, $siteID) {
	$resultUserRoleForCurrentSite = mysql_query("SELECT role FROM nisekocms_siteUserRole WHERE userID = '$userID' AND siteID = '$siteID' LIMIT 1");
	if (mysql_num_rows($resultUserRoleForCurrentSite) == 1) {
		while($rowUserRoleForCurrentSite = mysql_fetch_array($resultUserRoleForCurrentSite)) { return $rowUserRoleForCurrentSite['role']; }
	} else { return 'registered'; }
}

function getUserClientArray($userID) {
	$userClientArray = array();
	$resultGetUserClientArray = mysql_query("SELECT clientID FROM accounting_clientUser WHERE userID = $userID ORDER BY clientID ASC");
	while($rowGetUserClientArray = mysql_fetch_array($resultGetUserClientArray)) {
		$userClientArray[] = $rowGetUserClientArray['clientID'];
	}
	return $userClientArray;
}

function getUserGroupArray($userID) {
	$userGroupArray = array();
	$resultGetUserGroupArray = mysql_query("SELECT groupID FROM shigoto_groupUser WHERE userID = $userID ORDER BY groupID ASC");
	while($rowGetUserGroupArray = mysql_fetch_array($resultGetUserGroupArray)) {
		$userGroupArray[] = $rowGetUserGroupArray['groupID'];
	}
	return $userGroupArray;
}

function insertIntoAccountingClientUser($userID, $clientArray) {
	if (!empty($clientArray)) {
		foreach ($clientArray as $clientID) {
			$query = "INSERT INTO accounting_clientUser (
				clientID,
				userID
			) VALUES (
				$clientID, 
				$userID
			)";
			mysql_query ($query) or die ('could not add user role via insertIntoUserSiteRole()');
		}
	}
}

function insertIntoShigotoGroupUser($userID, $groupArray) {
	if (!empty($groupArray)) {
		foreach ($groupArray as $groupID) {
			$query = "INSERT INTO shigoto_groupUser (
				groupID,
				userID
			) VALUES (
				$groupID, 
				$userID
			)";
			mysql_query ($query) or die ('could not add user to groups via insertIntoShigotoGroupUser()');
		}
	}
}

function updateSiteUserRole($userID, $siteUserRole) {

	$siteID = $_SESSION['siteID'];
	
	// delete user role for this site (there should be only one record)
	$query = "DELETE FROM nisekocms_siteUserRole WHERE userID = $userID AND siteID = $siteID LIMIT 1";
	mysql_query ($query) or die ('could not change via updateSiteUserRole()');
	
	// if user role is not registerd THEN insert the new role (registered users have no special priveleges)
	if ($siteUserRole != 'registered') {
		insertIntoUserSiteRole($siteID, $userID, $siteUserRole);
	}
	
}

function updateAccountingClientUser($userID, $clientArray) {
	
	// remove this user's access to this site's clients
	$thisSitesClients = join(',',getThisSitesClients());
	if (empty($thisSitesClients)) { $thisSitesClients = 0; }
	$query = "DELETE FROM accounting_clientUser WHERE userID = $userID AND clientID IN ($thisSitesClients)";
	
	mysql_query ($query) or die ('could not remove user-client priveleges in updateAccountingClientUser()');
	

	// connect user with new client list
	insertIntoAccountingClientUser($userID, $clientArray);

}

function updateShigotoGroupUser($userID, $groupArray) {

	// remove this user's access to this site's groups
	$thisSitesGroups = join(',',getThisSitesGroups());
	$query = "DELETE FROM shigoto_groupUser WHERE userID = $userID AND groupID IN ($thisSitesGroups)";
	mysql_query ($query) or die ('could not remove user-client priveleges in updateShigotoGroupUser()');

	// connect user with new group list
	insertIntoShigotoGroupUser($userID, $groupArray);

}

function isPrimarySiteManager($userID) {
	$siteID = $_SESSION['siteID'];
	$resultIsUserThePrimarySiteManager = mysql_query("SELECT * FROM nisekocms_site WHERE siteID = '$siteID' AND siteManagerUserID = '$userID' LIMIT 1");
	if (mysql_num_rows($resultIsUserThePrimarySiteManager) == 1) { return true; } else { return false; }
}

function getUsersClientArray($userID) {

	$userClientArray = array();
	$thisSitesClients = join(',',getThisSitesClients());
	if (empty($thisSitesClients)) { $thisSitesClients = 0; }
	$resultGetUserClients = mysql_query("SELECT clientID FROM accounting_clientUser WHERE userID = $userID AND clientID IN ($thisSitesClients)");
	while ($rowGetUserClients = mysql_fetch_array($resultGetUserClients)) { $userClientArray[] = $rowGetUserClients['clientID']; }
	return $userClientArray;
	
}

?>