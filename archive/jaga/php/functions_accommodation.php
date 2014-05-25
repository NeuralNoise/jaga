<?php

/*
CREATE TABLE IF NOT EXISTS `accommodation_Accommodation` (
  `accommodationID` int(8) NOT NULL auto_increment,
  `siteID` int(8) NOT NULL,
  `accommodationCreatedByUserID` int(8) NOT NULL,
  `accommodationCreationDateTime` datetime NOT NULL,
  `accommodationOwnerUserID` int(8) NOT NULL,
  `accommodationCode` varchar(10) default NULL,
  `accommodationNameEnglish` varchar(255) default NULL,
  `accommodationNameJapanese` varchar(255) default NULL,
  `accommodationNameJapaneseReading` varchar(255) default NULL,
  `accommodationCategoryID` int(11) default '0',
  `accommodationDescriptionEnglish` text,
  `accommodationDescriptionJapanese` text,
  `accommodationMaxOccupancy` int(11) default '0',
  `accommodationParentId` int(11) default '0',
  `accommodationCompanyId` int(11) default '0',
  `accommodationStartDate` date default NULL,
  `accommodationEndDate` date default NULL,
  `accommodationNavigationUrl` varchar(255) default NULL,
  `accommodationIsPublic` int(1) NOT NULL,
  PRIMARY KEY  (`accommodationID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1011 ;
*/

function displayAccommodationTable($displayMode) {

	if ($displayMode == 'public') {
		$resultGetAccommodation = mysql_query("SELECT * FROM accommodation_Accommodation WHERE siteID = $_SESSION[siteID] AND accommodationIsPublic = 1");
	} elseif ($displayMode == 'owner') {
		$resultGetAccommodation = mysql_query("SELECT * FROM accommodation_Accommodation WHERE siteID = $_SESSION[siteID] AND accommodationOwnerUserID = $_SESSION[userID]");
	} elseif ($displayMode == 'admin') {
		if (isSiteManager()) {
			$resultGetAccommodation = mysql_query("SELECT * FROM accommodation_Accommodation WHERE siteID = $_SESSION[siteID]");
		}
	}
	
	








	echo '<div style="float:left;width:615px;text-align:left;margin:5px;border:1px solid #ccc;overflow:auto;">';
		
		
		if ($_SESSION['roleID'] == 'Site Manager' || $_SESSION['roleID'] == 'Super Administrator') {
			echo '<table style="width:100%;background-color:#fff;">';
				echo '<tr>';
					echo '<td class="borderAlignRight">';
						echo '<a class="agileLinkage" href="' . languageUrlPrefix() . 'accommodation/create/">' . agileResource('addNewAccommodation') . '</a>';
					echo '</td>';
				echo '</tr>';
			echo '</table>';
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		while($rowGetAccommodation = mysql_fetch_array($resultGetAccommodation)) {
		
			echo '<table style="width:100%;background-color:#fff;">';
			
			echo '<tr>';
				echo '<td class="borderAlignCenter" rowspan="4" style="width:150px;">';
					echo '<img src="/image.php?imageID=';
						echo getMainAccommodationImage($rowGetAccommodation['accommodationID']);
					echo '" style="width:150px;">';
				echo '</td>';
				echo '<td class="fieldLabel" colspan="2"><b>' . getAccommodationName($rowGetAccommodation['accommodationID']) . '</b></td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td class="borderAlignCenter">' . /* getAccommodationCompanyName($rowGetAccommodation['accommodationCompanyId']) . */ '</td>';
				echo '<td class="borderAlignCenter" style="width:125px;">' . getLocalizedMaxOccupancy($rowGetAccommodation['accommodationMaxOccupancy']) . '</td>';
			echo '</tr>';
		
			echo '<tr>';
				echo '<td class="borderAlignLeft" colspan="2">' . getAccommodationDescription($rowGetAccommodation['accommodationID']) . '</td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td class="borderAlignRight" colspan="2">';
					echo '<a class="agileLinkage" href="accommodationEnquiryForm.php?accommodationID=' . $rowGetAccommodation['accommodationID'] . '">' . agileResource('ratesAndAvailability') . '</a>';
					
					if ($_SESSION['roleID'] == 'Super Administrator') {
						echo '&nbsp;<a class="agileLinkage" href="/accommodation/' . $rowGetAccommodation['accommodationNavigationUrl'] . '/">' . agileResource('update') . '</a>';
					}
				echo '</td>';
			echo '</tr>';
			
			echo '</table>';
			
		}

	echo '</div>';
	
}


function displayAccommodationCRUD(
	$action, // either 'create' or 'update'
	$selector = '', // OLD $accommodationNavigationUrl
	$accommodationCode = '', 
	$accommodationNameEnglish = '', 
	$accommodationNameJapanese = '', 
	$accommodationNameJapaneseReading = '', 
	$accommodationDescriptionEnglish = '', 
	$accommodationDescriptionJapanese = '', 
	$accommodationMainImage = '', 
	$accommodationMaxOccupancy = 0, 
	$accommodationParentID = 0, 
	$accommodationCompanyID = 0, 
	$accommodationStartDate = '2011-12-15', 
	$accommodationEndDate = '2011-12-22', 
	$accommodationNavigationUrl = '' // NEW $accommodationNavigationUrl
	) {

	$resultGetSelectedAccommodation = mysql_query("SELECT * FROM accommodation_Accommodation WHERE accommodationNavigationUrl = '$selector' LIMIT 1");
	while($rowGetSelectedAccommodation = mysql_fetch_array($resultGetSelectedAccommodation)) {
		$accommodationID = $rowGetSelectedAccommodation['accommodationID'];
		$accommodationCode = $rowGetSelectedAccommodation['accommodationCode'];
		$accommodationNameEnglish = $rowGetSelectedAccommodation['accommodationNameEnglish'];
		$accommodationNameJapanese = $rowGetSelectedAccommodation['accommodationNameJapanese'];
		$accommodationNameJapaneseReading = $rowGetSelectedAccommodation['accommodationNameJapaneseReading'];
		$accommodationDescriptionEnglish = $rowGetSelectedAccommodation['accommodationDescriptionEnglish'];
		$accommodationDescriptionJapanese = $rowGetSelectedAccommodation['accommodationDescriptionJapanese'];
		$accommodationMainImage = $rowGetSelectedAccommodation['accommodationMainImage']; 
		$accommodationMaxOccupancy = $rowGetSelectedAccommodation['accommodationMaxOccupancy']; 
		$accommodationParentID = $rowGetSelectedAccommodation['accommodationParentID']; 
		$accommodationCompanyID = $rowGetSelectedAccommodation['accommodationCompanyID']; 
		$accommodationStartDate = $rowGetSelectedAccommodation['accommodationStartDate']; 
		$accommodationEndDate = $rowGetSelectedAccommodation['accommodationEndDate'];
		$accommodationNavigationUrl = $rowGetSelectedAccommodation['accommodationNavigationUrl'];
	}
	
	
		echo '<form method="post" action="/accommodation/' . $action . '/" enctype="multipart/form-data">';
			echo '<table style="margin:5px auto 5px auto;background-color:#fff;">';
			
				if ($action == 'update') {
					echo '<tr>';
					echo '<td class="fieldLabel" colspan="2">';
						echo '<img src="/image.php?imageID=' . getMainAccommodationImage($accommodationID) . '">';
						echo '<input type="hidden" name="accommodationID" value="' . $accommodationID . '">';
					echo '</td>';
				echo '</tr>';
				}
			
			
				echo '<tr>';
					echo '<td class="fieldLabel">' . agileResource('accommodationCode') . '</td>';
					echo '<td class="borderAlignLeft"><input type="text" name="accommodationCode" value="';
						echo $accommodationCode;
					echo '"></td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="fieldLabel">' . agileResource('accommodationNameEnglish') . '</td>';
					echo '<td class="borderAlignLeft"><input type="text" name="accommodationNameEnglish" value="';
						echo $accommodationNameEnglish;
					echo '"></td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="fieldLabel">' . agileResource('accommodationNameJapanese') . '</td>';
					echo '<td class="borderAlignLeft"><input type="text" name="accommodationNameJapanese" value="';
						echo $accommodationNameJapanese;
					echo '"></td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="fieldLabel">' . agileResource('accommodationNameJapaneseReading') . '</td>';
					echo '<td class="borderAlignLeft"><input type="text" name="accommodationNameJapaneseReading" value="';
						echo $accommodationNameJapaneseReading;
					echo '"></td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabel">' . agileResource('accommodationDescriptionEnglish') . '</td>';
					echo '<td class="borderAlignLeft"><textarea name="accommodationDescriptionEnglish">';
						echo $accommodationDescriptionEnglish;
					echo '</textarea></td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabel">' . agileResource('accommodationDescriptionJapanese') . '</td>';
					echo '<td class="borderAlignLeft"><textarea name="accommodationDescriptionJapanese">';
						echo $accommodationDescriptionJapanese;
					echo '</textarea></td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabel">' . agileResource('accommodationMainImage') . '</td>';
					echo '<td class="borderAlignLeft"><input type="file" name="accommodationMainImage"></td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="fieldLabel">' . agileResource('accommodationMaxOccupancy') . '</td>';
					echo '<td class="borderAlignLeft"><input type="text" name="accommodationMaxOccupancy" value="';
						echo $accommodationMaxOccupancy;
					echo '"></td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="fieldLabel">' . agileResource('accommodationParentID') . '</td>';
					echo '<td class="borderAlignLeft"><input type="text" name="accommodationParentID" value="';
						echo $accommodationParentID;
					echo '"></td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="fieldLabel">' . agileResource('accommodationCompanyID') . '</td>';
					echo '<td class="borderAlignLeft"><input type="text" name="accommodationCompanyID" value="';
						echo $accommodationCompanyID;
					echo '"></td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="fieldLabel">' . agileResource('accommodationStartDate') . '</td>';
					echo '<td class="borderAlignLeft"><input type="text" name="accommodationStartDate" value="';
						echo $accommodationStartDate;
					echo '"></td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="fieldLabel">' . agileResource('accommodationEndDate') . '</td>';
					echo '<td class="borderAlignLeft"><input type="text" name="accommodationEndDate" value="';
						echo $accommodationEndDate;
					echo '"></td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabel">' . agileResource('accommodationNavigationUrl') . '</td>';
					echo '<td class="borderAlignLeft"><input type="text" name="accommodationNavigationUrl" value="';
						echo $accommodationNavigationUrl;
					echo '"></td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="borderAlignRight" colspan="2"><input type="submit" name="submit" value="';
						if ($action == 'create') {
							echo agileResource('createAccommodation');
						} elseif ($action == 'update') {
							echo agileResource('updateAccommodation');
						}
						
					echo '"></td>';
				echo '</tr>';
			echo '</table>';
		echo '</form>';
}


function createAccommodation($accommodationCreatedByUserID, $accommodationCreationDateTime, $accommodationCode, $accommodationNameEnglish, $accommodationNameJapanese, $accommodationNameJapaneseReading, $accommodationCategoryID, $accommodationDescriptionEnglish, $accommodationDescriptionJapanese, $accommodationMaxOccupancy, $accommodationParentID, $accommodationCompanyID, $accommodationStartDate, $accommodationEndDate, $accommodationNavigationUrl, $accommodationMainImage) {

		$queryCreateAccommodation = "INSERT INTO accommodation_Accommodation (
			accommodationCreatedByUserID,
			accommodationCreationDateTime,
			accommodationCode,
			accommodationNameEnglish, 
			accommodationNameJapanese,
			accommodationNameJapaneseReading, 
			accommodationCategoryID,
			accommodationDescriptionEnglish,
			accommodationDescriptionJapanese,
			accommodationMaxOccupancy,
			accommodationParentID,
			accommodationCompanyID,
			accommodationStartDate,
			accommodationEndDate,
			accommodationNavigationUrl
		) VALUES (
			'$accommodationCreatedByUserID',
			'$accommodationCreationDateTime',
			'$accommodationCode',
			'$accommodationNameEnglish',
			'$accommodationNameJapanese',
			'$accommodationNameJapaneseReading',
			'$accommodationCategoryID',
			'$accommodationDescriptionEnglish',
			'$accommodationDescriptionJapanese',
			'$accommodationMaxOccupancy',
			'$accommodationParentID',
			'$accommodationCompanyID',
			'$accommodationStartDate',
			'$accommodationEndDate',
			'$accommodationNavigationUrl'
		)";
		
		mysql_query ($queryCreateAccommodation) or die (agileResource('couldNotCreateAccommodation'));
		
		$imageObjectID = mysql_insert_id();
		if ($accommodationMainImage['size'] != 0) { imageUpload($accommodationMainImage, 'accommodationMain', $imageObjectID); }
		
}



function updateAccommodation($accommodationID, $accommodationCode, $accommodationNameEnglish, $accommodationNameJapanese, $accommodationNameJapaneseReading, $accommodationCategoryID, $accommodationDescriptionEnglish, $accommodationDescriptionJapanese, $accommodationMaxOccupancy, $accommodationParentID, $accommodationCompanyID, $accommodationStartDate, $accommodationEndDate, $accommodationNavigationUrl, $accommodationMainImage) {

	$queryUpdateAccommodation = "UPDATE accommodation_Accommodation SET
		accommodationCode = '$accommodationCode',
		accommodationNameEnglish = '$accommodationNameEnglish',
		accommodationNameJapanese = '$accommodationNameJapanese',
		accommodationNameJapaneseReading = '$accommodationNameJapaneseReading',
		accommodationCategoryID = '$accommodationCategoryID',
		accommodationDescriptionEnglish = '$accommodationDescriptionEnglish',
		accommodationDescriptionJapanese = '$accommodationDescriptionJapanese',
		accommodationMaxOccupancy = '$accommodationMaxOccupancy',
		accommodationParentID = '$accommodationParentID',
		accommodationCompanyID = '$accommodationCompanyID',
		accommodationStartDate = '$accommodationStartDate',
		accommodationEndDate = '$accommodationEndDate',
		accommodationNavigationUrl = '$accommodationNavigationUrl'
		WHERE accommodationID = '$accommodationID' limit 1";
		
	mysql_query ($queryUpdateAccommodation) or die (agileResource('unableToUpdateAccommodation'));

	if ($accommodationMainImage['size'] != 0) { imageUpload($accommodationMainImage, 'accommodationMain', $accommodationID); }
	
}




function getMainAccommodationImage($accommodationID) {
	$resultMainAccommodationImage = mysql_query("SELECT * FROM image WHERE imageObject = 'accommodationMain' AND imageObjectID = '$accommodationID' ORDER BY imageSubmissionDateTime DESC LIMIT 1");
	while($rowGetAccommodationImage = mysql_fetch_array($resultMainAccommodationImage)) {
		$accommodationMainImageID = $rowGetAccommodationImage['imageID'];
	}
	return $accommodationMainImageID;
}

function getAccommodationCategoryName($accommodationCategoryID){
	$resultGetAccommodationCategoryName = mysql_query("SELECT * FROM accommodation_Category WHERE accommodationCategoryID = $accommodationCategoryID LIMIT 1");
	while($rowGetAccommodationCategoryName = mysql_fetch_array($resultGetAccommodationCategoryName)) {
	
		if ($_SESSION['lang'] == 'ja') {
			$accommodationCategoryName = $rowGetAccommodationCategoryName['accommodationCategoryJapanese'];
		} else {
			$accommodationCategoryName = $rowGetAccommodationCategoryName['accommodationCategoryEnglish'];
		}
		
		
	}
	return $accommodationCategoryName;
}


function getAccommodationCompanyName($accommodationCompanyID) {
	$resultGetAccommodationCompanyName = mysql_query("SELECT * FROM accommodation_Company WHERE accommodationCompanyID = $accommodationCompanyID LIMIT 1");
	while($rowGetAccommodationCompanyName = mysql_fetch_array($resultGetAccommodationCompanyName)) {
	
		if ($_SESSION['lang'] == 'ja') {
			$accommodationCompanyName = $rowGetAccommodationCompanyName['accommodationCompanyJapanese'];
		} else {
			$accommodationCompanyName = $rowGetAccommodationCompanyName['accommodationCompanyEnglish'];
		}
		
		
	}
	return $accommodationCompanyName;
}

function getAccommodationName($accommodationID) {
	$resultGetAccommodationName = mysql_query("SELECT * FROM accommodation_Accommodation WHERE accommodationID = $accommodationID LIMIT 1");
	while($rowGetAccommodationName = mysql_fetch_array($resultGetAccommodationName)) {
	
		if ($_SESSION['lang'] == 'ja') {
			$accommodationName = $rowGetAccommodationName['accommodationNameJapanese'];
		} else {
			$accommodationName = $rowGetAccommodationName['accommodationNameEnglish'];
		}
		
		
	}
	return $accommodationName;
}


function getAccommodationDescription($accommodationID) {
	$resultGetAccommodationDescription = mysql_query("SELECT * FROM accommodation_Accommodation WHERE accommodationID = $accommodationID LIMIT 1");
	while($rowGetAccommodationDescription = mysql_fetch_array($resultGetAccommodationDescription)) {
		if ($_SESSION['lang'] == 'ja') {
			$accommodationDescription = $rowGetAccommodationDescription['accommodationDescriptionJapanese'];
		} else {
			$accommodationDescription = $rowGetAccommodationDescription['accommodationDescriptionEnglish'];
		}
	}
	return $accommodationDescription;
}

function getLocalizedMaxOccupancy($maxOccupancy) {
	if ($_SESSION['lang'] == 'ja') {
		return $maxOccupancy . '&nbsp;' . agileResource('maxOccupancy');
	} else {
		return agileResource('maxOccupancy') . '&nbsp;' . $maxOccupancy;
	}
}




function displayAccommodationListBoxForClientCRUD($clientID) {

	// LOGIC: accommodation can only be tied to one client
	// We can only allow properties to be selected if they are already tied to a client OR already belong to the selected client

	$siteID = $_SESSION['siteID'];
	$accommodationArray = array();
	
	// load accommodation that are not tied to a client yet into $accommodationArray
	$resultGetAccommodationWithoutClients = mysql_query("
		SELECT accommodation_Accommodation.accommodationID AS accommodationID FROM accommodation_Accommodation 
		WHERE NOT EXISTS (
		SELECT * FROM accommodation_AccommodationClient 
		WHERE accommodation_Accommodation.accommodationID = accommodation_AccommodationClient.accommodationID)
		AND accommodation_Accommodation.siteID = $siteID
		ORDER BY accommodation_Accommodation.accommodationNameEnglish ASC");
	while ($rowGetAccommodationWithoutClients = mysql_fetch_array($resultGetAccommodationWithoutClients)) {$accommodationArray[] = $rowGetAccommodationWithoutClients['accommodationID']; }

	// also load properties that are already tied to selected client into $accommodationArray
	$resultGetThisClientsAccommodation = mysql_query("
		SELECT accommodationID FROM accommodation_AccommodationClient 
		WHERE accommodation_AccommodationClient.clientID = $clientID");
	while ($rowGetThisClientsAccommodation = mysql_fetch_array($resultGetThisClientsAccommodation)) {$accommodationArray[] = $rowGetThisClientsAccommodation['accommodationID']; }

	$selectableAccommodation = join(',',$accommodationArray);

	echo '<select name="accommodationID[]" multiple="multiple" style="width:300px;">';
	
	$queryDisplayAccommodationListbox = "
		SELECT * FROM accommodation_Accommodation
		WHERE siteID = $siteID 
		AND accommodationID IN ($selectableAccommodation) 
		ORDER BY accommodationNameEnglish ASC";
	
	$resultDisplayAccommodationListbox = mysql_query($queryDisplayAccommodationListbox);
	
		while ($rowDisplayAccommodationListbox = mysql_fetch_array($resultDisplayAccommodationListbox)) {
			echo '<option value="' . $rowDisplayAccommodationListbox['accommodationID'] . '"';
				if (clientOwnsAccommodation($clientID, $rowDisplayAccommodationListbox['accommodationID'])) { echo ' selected="true"'; }
			echo '>';
				echo $rowDisplayAccommodationListbox['accommodationNameEnglish'];
			echo '</option>';
		}
		
	echo '</select>';

}


function clientOwnsAccommodation($clientID, $accommodationID) {
	$query = "SELECT * FROM accommodation_AccommodationClient WHERE clientID = $clientID AND accommodationID = $accommodationID";
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 1) { return true; } else { return false; }
}









function displayAccommodationDropdown($accommodationID, $defaultOptionValue = 'all') {

	// echo $propertyID;

	$siteID = $_SESSION['siteID'];

	if (isModuleEnabled('realtycms')) {

		if ($_SESSION{'userRoleForCurrentSite'} == 'siteManager' || $_SESSION{'userRoleForCurrentSite'} == 'siteAccountant' ||$_SESSION{'userRoleForCurrentSite'} == 'siteStaff') {
			$hasAccommodationAccess = 'yes';
			$resultAccommodationDropdown = mysql_query("SELECT * FROM accommodation_Accommodation WHERE siteID = '$siteID' ORDER BY accommodationNameEnglish ASC");
		}  elseif ($_SESSION{'userRoleForCurrentSite'} == 'siteClient') {
			$hasAccommodationAccess = 'yes';
			$thisClientsProperties = join(",", $_SESSION['userAccommodationArray']);
			$resultAccommodationDropdown = mysql_query("SELECT * FROM accommodation_Accommodation WHERE siteID = '$siteID' AND accommodationID IN ('$thisClientsProperties') ORDER BY accommodationNameEnglish ASC");
		} else {
			$hasAccommodationAccess = 'no';
		}
			
		if ($hasAccommodationAccess == 'yes') {
	
			echo '<select name="accommodationID" style="width:150px;">';
			
				echo '<option value="' . $defaultOptionValue . '">';
					echo agileResource('accommodation');
				echo '</option>';
				
				while($rowAccommodationDropdown = mysql_fetch_array($resultAccommodationDropdown)) {
					echo '<option value="' . $rowAccommodationDropdown['accommodationID'] . '"';
						if ($accommodationID == $rowAccommodationDropdown['accommodationID']) { echo ' selected'; }
					echo '>';
						if ($_SESSION['lang'] == 'ja') {
							echo $rowAccommodationDropdown['accommodationNameJapanese'];
						} else {
							echo $rowAccommodationDropdown['accommodationNameEnglish'];
						}
					echo '</option>';
				}
			echo '</select>';
				
		} else {
			
			echo agileResource('youClientsAreNotLinkedToAnyAccommodation');
			
		}

	}
	
}















?>