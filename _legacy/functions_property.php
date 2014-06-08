<?php

function displayPropertyList($selectedArea = 'all') {

		$siteID = $_SESSION['siteID'];
		
		if ($selectedArea == 'all') {
			$resultGetProperty = mysql_query("SELECT * FROM property_property WHERE siteID = '$siteID' AND propertyPublished = '1' AND propertyFeatured = '1' ORDER BY propertyNameEnglish ASC");
		} else {
			$queryGetProperty = "
				SELECT * FROM property_property 
				LEFT JOIN property_area 
				ON property_area.propertyAreaID = property_property.propertyAreaID 
				WHERE property_area.propertyAreaSeoUrl = '$selectedArea'
				AND propertyPublished = '1'
				AND property_property.siteID = '$siteID'
			";
			$resultGetProperty = mysql_query($queryGetProperty);
		}
		
		while($rowGetProperty = mysql_fetch_array($resultGetProperty)) {
		
			echo '<div class="realtyCmsPropertyListTile">';
				echo '<table class="realtyCmsPropertyListTile" style="width:100%;background-color:#fff;font-family:verdana;font-size:10px;">';
					echo '<tr>';
						echo '<td class="propertyAttributeLogo">';
							echo '<img src="/agileThemes/nisown/images/snowflake_small.png">';
						echo '</td>';
						echo '<td class="propertyAttribute" colspan="2">';
							echo '<h3 class="realtyCmsPropertyListTilePropertyName">' . $rowGetProperty['propertyNameEnglish'] . '</h3>';
						echo '</td>';
						echo '<td class="propertyAttributeImage" rowspan="6" style="width:200px;">';
							echo '<img src="/image.php?imageID=';
								echo getMainPropertyImage($rowGetProperty['propertyID']);
							echo '" style="width:150px;">';
						echo '</td>';
					echo '</tr>';
					
					echo '<tr>';
						echo '<td class="propertyAttributeLogo">';
							echo '<img src="/agileThemes/nisown/images/nisownPropertyBedroomIcon.png">';
						echo '</td>';
						echo '<td class="propertyAttribute">';
							echo agileResource('bedrooms');
						echo '</td>';
						echo '<td class="propertyAttribute">' . number_format($rowGetProperty['propertyNumberOfBedrooms']) . '</td>';
					echo '</tr>';
					
					echo '<tr>';
						echo '<td class="propertyAttributeLogo">';
							echo '<img src="/agileThemes/nisown/images/nisownPropertyBathroomIcon.png">';
						echo '</td>';
						echo '<td class="propertyAttribute">';
							echo agileResource('bathrooms');
						echo '</td>';
						echo '<td class="propertyAttribute">' . number_format($rowGetProperty['propertyNumberOfBathrooms']) . '</td>';
					echo '</tr>';
					
					echo '<tr>';
						echo '<td class="propertyAttributeLogo">';
							echo '<img src="/agileThemes/nisown/images/nisownPropertyFloorAreaIcon.png">';
						echo '</td>';
						echo '<td class="propertyAttribute">';
							echo agileResource('floorArea');
						echo '</td>';
						echo '<td class="propertyAttribute">' . number_format($rowGetProperty['propertyFloorArea'],2) . '&#x33a1;</td>';
					echo '</tr>';
					
					echo '<tr>';
						echo '<td class="propertyAttributeLogo">';
							echo '<img src="/agileThemes/nisown/images/nisownPropertyOccupancyIcon.png">';
						echo '</td>';
						echo '<td class="propertyAttribute">';
							echo agileResource('sleeps');
						echo '</td>';
						echo '<td class="propertyAttribute">';
							echo number_format($rowGetProperty['propertyOccupancy']);
						echo '</td>';
					echo '</tr>';
					

					if ($rowGetProperty['propertyLinkStatus'] == 1) {
						echo '<tr>';
							echo '<td class="propertyAttributeLogo">';
								echo '<img src="/agileThemes/nisown/images/arrow.png">';
							echo '</td>';
							echo '<td class="propertyAttribute" colspan="2">';
								echo '<a class="realtyCmsPropertyListTileGetMoreInfo" href="';
									echo $rowGetProperty['propertyLinkUrl'];
								echo '">' . $rowGetProperty['propertyLinkAnchorText'] . '</a>';
							echo '</td>';
						echo '</tr>';
					}
					
				echo '</table>';
			echo '</div>';
		}
	
}


function displayPublicViewOfSingleProperty($propertyID) {

		$siteID = $_SESSION['siteID'];
		
		$resultGetProperty = mysql_query("SELECT * FROM property_property WHERE propertyID = '$propertyID' AND siteID = '$siteID' LIMIT 1");

		while($rowGetProperty = mysql_fetch_array($resultGetProperty)) {
		
			echo '<div class="realtyCmsPropertyListTile">';
				echo '<table class="realtyCmsPropertyListTile" style="width:100%;background-color:#fff;font-family:verdana;font-size:10px;">';
					echo '<tr>';
						echo '<td class="propertyAttributeLogo">';
							echo '<img src="/agileThemes/nisown/images/snowflake_small.png">';
						echo '</td>';
						echo '<td class="propertyAttribute" colspan="2">';
							echo '<h3 class="realtyCmsPropertyListTilePropertyName">' . $rowGetProperty['propertyNameEnglish'] . '</h3>';
						echo '</td>';
						echo '<td class="propertyAttributeImage" rowspan="';
						
							// if ($rowGetProperty['propertyLinkStatus'] == 1) { echo '6'; } else { echo '5'; }
							// doesn't like 5 for some reason
							
							echo '6';
							
						echo '" style="width:200px;">';
							echo '<img src="/image.php?imageID=';
								echo getMainPropertyImage($rowGetProperty['propertyID']);
							echo '" style="width:150px;">';
						echo '</td>';
					echo '</tr>';
					
					echo '<tr>';
						echo '<td class="propertyAttributeLogo">';
							echo '<img src="/agileThemes/nisown/images/nisownPropertyBedroomIcon.png">';
						echo '</td>';
						echo '<td class="propertyAttribute">';
							echo agileResource('bedrooms');
						echo '</td>';
						echo '<td class="propertyAttribute">' . number_format($rowGetProperty['propertyNumberOfBedrooms']) . '</td>';
					echo '</tr>';
					
					echo '<tr>';
						echo '<td class="propertyAttributeLogo">';
							echo '<img src="/agileThemes/nisown/images/nisownPropertyBathroomIcon.png">';
						echo '</td>';
						echo '<td class="propertyAttribute">';
							echo agileResource('bathrooms');
						echo '</td>';
						echo '<td class="propertyAttribute">' . number_format($rowGetProperty['propertyNumberOfBathrooms']) . '</td>';
					echo '</tr>';
					
					echo '<tr>';
						echo '<td class="propertyAttributeLogo">';
							echo '<img src="/agileThemes/nisown/images/nisownPropertyFloorAreaIcon.png">';
						echo '</td>';
						echo '<td class="propertyAttribute">';
							echo agileResource('floorArea');
						echo '</td>';
						echo '<td class="propertyAttribute">' . number_format($rowGetProperty['propertyFloorArea'],2) . '&#x33a1;</td>';
					echo '</tr>';
					
					echo '<tr>';
						echo '<td class="propertyAttributeLogo">';
							echo '<img src="/agileThemes/nisown/images/nisownPropertyOccupancyIcon.png">';
						echo '</td>';
						echo '<td class="propertyAttribute">';
							echo agileResource('sleeps');
						echo '</td>';
						echo '<td class="propertyAttribute">';
							echo number_format($rowGetProperty['propertyOccupancy']);
						echo '</td>';
					echo '</tr>';
					

					if ($rowGetProperty['propertyLinkStatus'] == 1) {
						echo '<tr>';
							echo '<td class="propertyAttributeLogo">';
								echo '<img src="/agileThemes/nisown/images/arrow.png">';
							echo '</td>';
							echo '<td class="propertyAttribute" colspan="2">';
								echo '<a class="realtyCmsPropertyListTileGetMoreInfo" href="';
									echo $rowGetProperty['propertyLinkUrl'];
								echo '">' . $rowGetProperty['propertyLinkAnchorText'] . '</a>';
							echo '</td>';
						echo '</tr>';
					}
					
				echo '</table>';
			echo '</div>';
		}
	
}


function getAreaNameSeoUrl($propertyAreaID) {
	$resultGetAreaNameSeoUrl = mysql_query("SELECT propertyAreaSeoUrl FROM property_area WHERE propertyAreaID = '$propertyAreaID' LIMIT 1");
	while($rowGetAreaNameSeoUrl = mysql_fetch_array($resultGetAreaNameSeoUrl)) { $areaNameSeoUrl = $rowGetAreaNameSeoUrl['propertyAreaSeoUrl']; }
	return $areaNameSeoUrl;
}


function getPropertyIdWithSeoUrl($propertyNameSeoUrl) {
	$resultGetPropertyIdWithSeoUrl = mysql_query("SELECT propertyID FROM property_property WHERE propertyNameSeoUrl = '$propertyNameSeoUrl'");
	if (mysql_num_rows($resultGetPropertyIdWithSeoUrl) > 1) { die ("there is more than one property with the same seo url"); }
	while($rowGetPropertyIdWithSeoUrl = mysql_fetch_array($resultGetPropertyIdWithSeoUrl)) { $propertyID = $rowGetPropertyIdWithSeoUrl['propertyID']; }
	return $propertyID;
}

function getMainPropertyImage($propertyID) {
	
	$propertyMainImageID = 0;
	
	$resultMainPropertyImage = mysql_query("SELECT propertyPrimaryImageID FROM property_property WHERE propertyID = '$propertyID' LIMIT 1");
	while($rowGetPropertyImage = mysql_fetch_array($resultMainPropertyImage)) { $propertyMainImageID = $rowGetPropertyImage['propertyPrimaryImageID']; }
	
	if ($propertyMainImageID == 0) {
		$resultMostRecentPropertyImage = mysql_query("SELECT * FROM image WHERE imageObject = 'property' AND imageObjectID = '$propertyID' ORDER BY imageSubmissionDateTime LIMIT 1");
		while($rowGetMostRecentPropertyImage = mysql_fetch_array($resultMostRecentPropertyImage)) { $propertyMainImageID = $rowGetMostRecentPropertyImage['imageID']; }
	}
	
	return $propertyMainImageID;
	
}

function getPropertyName($propertyID) {
	$resultGetPropertyName = mysql_query("SELECT * FROM property_property WHERE propertyID = $propertyID LIMIT 1");
	while($rowGetPropertyName = mysql_fetch_array($resultGetPropertyName)) {
	
		if ($_SESSION['lang'] == 'ja') {
			$propertyName = $rowGetPropertyName['propertyNameJapanese'];
		} else {
			$propertyName = $rowGetPropertyName['propertyNameEnglish'];
		}
		
		
	}
	return $propertyName;
}

function getPropertyDescription($propertyID) {
	$resultGetPropertyDescription = mysql_query("SELECT * FROM property_property WHERE propertyID = $propertyID LIMIT 1");
	while($rowGetPropertyDescription = mysql_fetch_array($resultGetPropertyDescription)) {
		if ($_SESSION['lang'] == 'ja') {
			$propertyDescription = $rowGetPropertyDescription['propertyDescriptionJapanese'];
		} else {
			$propertyDescription = $rowGetPropertyDescription['propertyDescriptionEnglish'];
		}
	}
	return $propertyDescription;
}

function displayPropertyDropdown($propertyID, $defaultOptionValue = 'all') {

	// echo $propertyID;

	$siteID = $_SESSION['siteID'];

	if (isModuleEnabled('realtycms')) {

		if ($_SESSION{'userRoleForCurrentSite'} == 'siteManager' || $_SESSION{'userRoleForCurrentSite'} == 'siteAccountant' ||$_SESSION{'userRoleForCurrentSite'} == 'siteStaff') {
			$hasPropertyAccess = 'yes';
			$resultPropertyDropdown = mysql_query("SELECT * FROM property_property WHERE siteID = '$siteID' ORDER BY propertyNameEnglish ASC");
		}  elseif ($_SESSION{'userRoleForCurrentSite'} == 'siteClient') {
			$hasPropertyAccess = 'yes';
			$thisClientsProperties = join(",", $_SESSION['userPropertyArray']);
			$resultPropertyDropdown = mysql_query("SELECT * FROM property_property WHERE siteID = '$siteID' AND propertyID IN ('$thisClientsProperties') ORDER BY propertyNameEnglish ASC");
		} else { // IF NONE OF THE ABOVE
			$hasPropertyAccess = 'no';
		}
			
		if ($hasPropertyAccess == 'yes') {
	
			echo '<select name="propertyID" style="width:150px;">';
			
				echo '<option value="' . $defaultOptionValue . '">';
					echo agileResource('property');
				echo '</option>';
				
				while($rowPropertyDropdown = mysql_fetch_array($resultPropertyDropdown)) {
					echo '<option value="' . $rowPropertyDropdown['propertyID'] . '"';
						if ($propertyID == $rowPropertyDropdown['propertyID']) { echo ' selected'; }
					echo '>';
						if ($_SESSION['lang'] == 'ja') {
							echo $rowPropertyDropdown['propertyNameJapanese'];
						} else {
							echo $rowPropertyDropdown['propertyNameEnglish'];
						}
					echo '</option>';
				}
			echo '</select>';
				
		} else {
			
			echo '<input type="hidden" name="propertyID" value="0">';
			echo agileResource('yourClientsAreNotLinkedToAnyProperties');
			
		}

	}
	
}

function displayPropertyListBoxForClientCRUD($clientID) {

	// LOGIC: property can only be tied to one client
	// We can only allow properties to be selected if they are already tied to a client OR already belong to the selected client

	$siteID = $_SESSION['siteID'];
	$propertyArray = array();
	
	// load property that are not tied to a client yet into $propertyArray
	$resultGetPropertiesWithoutClients = mysql_query("
		SELECT property_property.propertyID AS propertyID FROM property_property 
		WHERE NOT EXISTS (
		SELECT * FROM property_propertyClient 
		WHERE property_property.propertyID = property_propertyClient.propertyID)
		AND property_property.siteID = $siteID
		ORDER BY property_property.propertyNameEnglish ASC");
	while ($rowGetPropertiesWithoutClients = mysql_fetch_array($resultGetPropertiesWithoutClients)) {$propertyArray[] = $rowGetPropertiesWithoutClients['propertyID']; }

	// also load properties that are already tied to selected client into $propertyArray
	$resultGetThisClientsProperty = mysql_query("
		SELECT propertyID FROM property_propertyClient 
		WHERE property_propertyClient.clientID = $clientID");
	while ($rowGetThisClientsProperty = mysql_fetch_array($resultGetThisClientsProperty)) {$propertyArray[] = $rowGetThisClientsProperty['propertyID']; }

	$selectableProperty = join(',',$propertyArray);

	$queryDisplayPropertyListbox = "
		SELECT * FROM property_property
		WHERE siteID = $siteID 
		AND propertyID IN ($selectableProperty) 
		ORDER BY propertyNameEnglish ASC";
		
	echo '<select name="propertyID[]" multiple="multiple" style="width:300px;">';
	
	$resultDisplayPropertyListbox = mysql_query($queryDisplayPropertyListbox);
	
		while ($rowDisplayPropertyListbox = mysql_fetch_array($resultDisplayPropertyListbox)) {
			echo '<option value="' . $rowDisplayPropertyListbox['propertyID'] . '"';
				if (clientOwnsProperty($clientID, $rowDisplayPropertyListbox['propertyID'])) { echo ' selected="true"'; }
			echo '>';
				echo $rowDisplayPropertyListbox['propertyNameEnglish'];
			echo '</option>';
		}
		
	echo '</select>';

}

function clientOwnsProperty($clientID, $propertyID) {
	$query = "SELECT * FROM property_propertyClient WHERE clientID = $clientID AND propertyID = $propertyID";
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 1) { return true; } else { return false; }
}

function displayManagePropertyList($sqlLimit) {

	if ($_SESSION['userRoleForCurrentSite'] == 'siteManager' || $_SESSION['userRoleForCurrentSite'] == 'siteAccountant' ||$_SESSION['userRoleForCurrentSite'] == 'siteStaff') {
	
		echo '<div style="text-align:center;">';
			echo '<table style="margin:5px auto 5px auto;background-color:#fff;width:100%;font-family:verdana;font-size:10px;">';
	
					echo '<td class="fieldLabelLeft" colspan="12">';
						echo '<input type="button" value="' . agileResource('createProperty') . '" onclick="window.location.href=\'' . languageUrlPrefix() . ' property/create/\'">';
					echo '</td>';
				echo '</tr>';
	
				echo '<tr>';
					echo '<td class="fieldLabelCenter">' . agileResource('propertyID') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('propertyName') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('country') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('state') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('city') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('propertyArea') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('propertyClassification') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('propertyStatus') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('propertyType') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('propertyPublished') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('propertyFeatured') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('action') . '</td>';
				echo '</tr>';
	

	
				$iRow = 0;
				$resultGetProperty = mysql_query("SELECT * FROM property_property WHERE siteID = '$_SESSION[siteID]' ORDER BY propertyNameEnglish ASC");
				while($rowGetProperty = mysql_fetch_array($resultGetProperty)) {
					if ($iRow % 2 == 0) { $trStyleAttribute = 'background-color:#fff;'; } else { $trStyleAttribute = 'background-color:#eee;'; }
					echo '<tr style="' . $trStyleAttribute . '">';
						echo '<td class="borderAlignCenter">' . $rowGetProperty['propertyID'] . '</td>';
						

						echo '<td class="borderAlignCenter">' . getPropertyName($rowGetProperty['propertyID']) . '</td>';
						echo '<td class="borderAlignCenter">' . getCountryName($rowGetProperty['countryID']) . '</td>';
						echo '<td class="borderAlignCenter">' . getStateName($rowGetProperty['stateID']) . '</td>';
						echo '<td class="borderAlignCenter">' . getCityName($rowGetProperty['cityID']) . '</td>';
						echo '<td class="borderAlignCenter">' . getpropertyArea($rowGetProperty['propertyAreaID']) . '</td>';
						echo '<td class="borderAlignCenter">' . getPropertyClassification($rowGetProperty['propertyClassificationID']) . '</td>';
						echo '<td class="borderAlignCenter">' . getPropertyStatus($rowGetProperty['propertyStatusID']) . '</td>';
						echo '<td class="borderAlignCenter">' . getPropertyType($rowGetProperty['propertyTypeID']) . '</td>';
						
						echo '<td class="borderAlignCenter">';
							if ($rowGetProperty['propertyPublished'] == 1) { echo '&#10004;'; } else { echo '&nbsp;'; }
						echo '</td>';
						echo '<td class="borderAlignCenter">';
							if ($rowGetProperty['propertyFeatured'] == 1) { echo '&#10004;'; } else { echo '&nbsp;'; }
						echo '</td>';
						echo '<td class="borderAlignCenter">';
							echo '<input type="button" value="' . agileResource('updateProperty') . '" onclick="window.location.href=\'' . languageUrlPrefix() . ' property/update/' . $rowGetProperty['propertyID'] . '/\'">';
						echo '</td>';
					echo '</tr>';
					$iRow++;
				}
				
			echo '</table>';
		echo '</div>';
		
		
		
	}
}

function displayPropertyCrud(
		$type = 'create',
		$propertyID = 0,
		$propertyNameSeoUrl = '',
		$propertyNameEnglish = '',
		$propertyNameJapanese = '',
		$propertyNameJapaneseReading = '',
		$propertyAreaID = 0,
		$propertyTypeID = 0,
		$propertyAddress1English = '',
		$propertyAddress2English = '',
		$propertyAddress1Japanese = '',
		$propertyAddress2Japanese = '',
		$cityID = 0,
		$stateID = 0,
		$countryID = 0,
		$propertyAddressPostalCode = '',
		$propertyDescriptionEnglish = '',
		$propertyDescriptionJapanese = '',
		$propertyDistanceFromSkiHill = '',
		$propertyLandSize = '',
		$propertyFloorArea = '',
		$propertyNumberOfBedrooms = '',
		$propertyNumberOfToilets = '',
		$propertyNumberOfBathrooms = '',
		$propertyOccupancy = '',
		$propertyPrice = '',
		$propertyPriceRental = '',
		$propertyFeatured = 0,
		$propertyDisplay = '',
		$propertyClassificationID = '',
		$propertyStatusID = 0,
		$propertyDateTimeSold = '',
		$propertyMainSiteID = 0,
		$accommodationMainSiteID = 0,
		$propertyPublished = 0,
		$propertyURL = '',
		$propertyHasMonthlyFee = 0,
		$propertyMonthlyFee = 0,
		$propertyMonthlyTransactionDate = 0,
		$propertyFeature = array(),
		$propertyPrimaryImageID = 0,
		$contractID = 0,
		$propertyLinkStatus = 0,
		$propertyLinkUrl = '',
		$propertyLinkAnchorText = ''
	) {

			echo '<form method="post" action="';
				if ($type == 'create') {
					echo languageUrlPrefix() . 'property/create/';
				} elseif ($type == 'update') {
					echo languageUrlPrefix() . 'property/update/' . $propertyID . '/';
				}
				
			echo '" enctype="multipart/form-data">';
			
			echo '<table style="margin:5px auto 5px auto;background-color:#fff;width:100%;font-family:verdana;font-size:10px;">';
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('propertyNameEnglish') . '</td>';
					echo '<td class="fieldLabelCenter"><input type="text" name="propertyNameEnglish" value="' . $propertyNameEnglish . '"></td>';
					echo '<td class="fieldLabelLeft">' . agileResource('propertyNameJapanese') . '</td>';
					echo '<td class="fieldLabelCenter"><input type="text" name="propertyNameJapanese" value="' . $propertyNameJapanese . '"></td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('propertyNameSeoUrl') . '</td>';
					echo '<td class="fieldLabelCenter"><input type="text" name="propertyNameSeoUrl" value="' . $propertyNameSeoUrl . '" onKeyPress="return urlFriendly(event)"></td>';
					echo '<td class="fieldLabelLeft">' . agileResource('propertyNameJapaneseReading') . '</td>';
					echo '<td class="fieldLabelCenter"><input type="text" name="propertyNameJapaneseReading" value="' . $propertyNameJapaneseReading . '"></td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('propertyAddress1English') . '</td>';
					echo '<td class="fieldLabelCenter"><input type="text" name="propertyAddress1English" value="' . $propertyAddress1English . '"></td>';
					echo '<td class="fieldLabelLeft">' . agileResource('propertyAddress1Japanese') . '</td>';
					echo '<td class="fieldLabelCenter"><input type="text" name="propertyAddress1Japanese" value="' . $propertyAddress1Japanese . '"></td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('propertyAddress2English') . '</td>';
					echo '<td class="fieldLabelCenter"><input type="text" name="propertyAddress2English" value="' . $propertyAddress2English . '"></td>';
					echo '<td class="fieldLabelLeft">' . agileResource('propertyAddress2Japanese') . '</td>';
					echo '<td class="fieldLabelCenter"><input type="text" name="propertyAddress2Japanese" value="' . $propertyAddress2Japanese . '"></td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelCenter" colspan="2" rowspan="2">';
							displayGeographyWidget($countryID, $stateID, $cityID);
					echo '</td>';
					echo '<td class="fieldLabelLeft">' . agileResource('propertyAddressPostalCode') . '</td>';
					echo '<td class="fieldLabelCenter"><input type="text" name="propertyAddressPostalCode" value="' . $propertyAddressPostalCode . '"></td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('contract') . '</td>';
					echo '<td class="fieldLabelCenter">';
						displayContractDropdown($contractID);
					echo '</td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft" colspan="2">' . agileResource('propertyDescriptionEnglish') . '</td>';
					echo '<td class="fieldLabelLeft" colspan="2">' . agileResource('propertyDescriptionJapanese') . '</td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="borderAlignCenter" colspan="2"><textarea class="ckeditor" name="propertyDescriptionEnglish">' . $propertyDescriptionEnglish . '</textarea></td>';
					echo '<td class="borderAlignCenter" colspan="2"><textarea class="ckeditor" name="propertyDescriptionJapanese">' . $propertyDescriptionJapanese . '</textarea></td>';
				echo '</tr>';

				echo '<tr>';
					echo '<td class="fieldLabelCenter">' . agileResource('propertyArea') . ' ';
						displayPropertyAreaDropdown($propertyAreaID);
					echo '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('propertyType') . ' ';
						displayPropertyTypeDropdown($propertyTypeID);
					echo '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('propertyClassification') . ' ';
						displayPropertyClassificationDropdown($propertyClassificationID);
					echo '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('propertyStatus') . ' ';
						displayPropertyStatusDropdown($propertyStatusID);
					echo '</td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('propertyDistanceFromSkiHill') . '</td>';
					echo '<td class="fieldLabelCenter"><input type="text" name="propertyDistanceFromSkiHill" value="' . $propertyDistanceFromSkiHill . '"></td>';
					echo '<td class="fieldLabelLeft">' . agileResource('propertyLandSize') . '</td>';
					echo '<td class="fieldLabelCenter"><input type="text" name="propertyLandSize" value="' . $propertyLandSize . '"></td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('propertyFloorArea') . '</td>';
					echo '<td class="fieldLabelCenter"><input type="text" name="propertyFloorArea" value="' . $propertyFloorArea . '"></td>';
					echo '<td class="fieldLabelLeft">' . agileResource('propertyNumberOfBedrooms') . '</td>';
					echo '<td class="fieldLabelCenter"><input type="text" name="propertyNumberOfBedrooms" value="' . $propertyNumberOfBedrooms . '"></td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('propertyNumberOfToilets') . '</td>';
					echo '<td class="fieldLabelCenter"><input type="text" name="propertyNumberOfToilets" value="' . $propertyNumberOfToilets . '"></td>';
					echo '<td class="fieldLabelLeft">' . agileResource('propertyNumberOfBathrooms') . '</td>';
					echo '<td class="fieldLabelCenter"><input type="text" name="propertyNumberOfBathrooms" value="' . $propertyNumberOfBathrooms . '"></td>';
				echo '</tr>';
				
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('propertyOccupancy') . '</td>';
					echo '<td class="fieldLabelCenter"><input type="text" name="propertyOccupancy" value="' . $propertyOccupancy . '"></td>';
					echo '<td class="fieldLabelLeft">' . agileResource('propertyPrice') . '</td>';
					echo '<td class="fieldLabelCenter"><input type="text" name="propertyPrice" value="' . $propertyPrice . '"></td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft">';
						echo agileResource('propertyFeatured');
					echo '</td>';
					echo '<td class="fieldLabelCenter">';
						echo '<input type="radio" name="propertyFeatured" value="1"';
							if ($propertyFeatured == 1) { echo ' checked'; }
						echo '>' . agileResource('propertyFeaturedYes');
						echo '<input type="radio" name="propertyFeatured" value="0"';
							if ($propertyFeatured == 0) { echo ' checked'; }
						echo '>' . agileResource('propertyFeaturedNo');
					echo '</td>';
					echo '<td class="fieldLabelLeft">';
						echo agileResource('propertyPublished');
					echo '</td>';
					echo '<td class="fieldLabelCenter">';
						echo '<input type="radio" name="propertyPublished" value="1"';
							if ($propertyPublished == 1) { echo ' checked'; }
						echo '>' . agileResource('propertyPublishedYes');
						echo '<input type="radio" name="propertyPublished" value="0"';
							if ($propertyPublished == 0) { echo ' checked'; }
						echo '>' . agileResource('propertyPublishedNo');
					echo '</td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelCenter" colspan="2">';
						echo agileResource('propertyFeatures');
					echo '</td>';
					echo '<td class="fieldLabelCenter" colspan="2">';
						echo agileResource('propertyImages');
					echo '</td>';
				echo '</tr>';
				
				echo '<tr>';
				
					echo '<td class="fieldLabelCenter" colspan="2">';
					echo '<div style="text-align:left;width:100%;height:100px;overflow:auto;">';
						$resultGetPropertyFeatures = "SELECT * FROM property_feature WHERE siteID = '$_SESSION[siteID]' ORDER BY featureNameEnglish ASC";
						$queryGetPropertyFeatures = mysql_query($resultGetPropertyFeatures);
						while ($rowGetPropertyFeatures = mysql_fetch_array($queryGetPropertyFeatures)) {
							echo '<input type="checkbox" name="propertyFeature[]" value="' . $rowGetPropertyFeatures['featureID'] . '"';
							
								if (in_array($rowGetPropertyFeatures['featureID'], $propertyFeature)) { echo ' checked'; }
							
							echo '> ';
							if ($_SESSION['lang'] == 'ja') {
								echo $rowGetPropertyFeatures['propertyFeatureJapanese'];
							} else {
								echo $rowGetPropertyFeatures['featureNameEnglish'];
							}
							echo '<br />';
						}
					echo '</div>';
					echo '</td>';
					
					echo '<td class="fieldLabelCenter" colspan="2">';
						echo '<div style="text-align:left;width:100%;height:100px;overflow:auto;">';
						
							echo '<table style="background-color:#fff;width:100%;font-family:verdana;font-size:10px;">';
							
								echo '<tr>';
									echo '<td class="fielLabelLeft" colspan="3"><input type="file" name="imageToBeUploaded" value="' . agileResource('addAnImage') . '"></td>';
								echo '</tr>';
								
								$queryGetImages = "SELECT * FROM image WHERE siteID = '$_SESSION[siteID]' AND imageObject = 'property' AND imageObjectID = '$propertyID' ORDER BY imageSubmissionDateTime DESC";
								$resultGetImages = mysql_query($queryGetImages);
								while ($rowGetImages = mysql_fetch_array($resultGetImages)) {
									echo '<tr>';
										echo '<td class="borderAlignCenter" style="width:32px;">';
											echo '<a href="' . languageUrlPrefix() . 'view-image/' . $rowGetImages['imageID'] . '/" target="_blank">';
											$imageDimensions = array();
											$imageDimensions = agileDBImageScale($rowGetImages['imageID'], 30, 30);
											echo '<img src="/image.php?imageID=' . $rowGetImages['imageID'] . '" style="width:' . $imageDimensions[1] . 'px;height:' . $imageDimensions[2] . 'px;">';
											echo '</a>';
										echo '</td>';
										echo '<td class="borderAlignCenter" style="width:32px;">' . $rowGetImages['imageID'] . '</td>';
										echo '<td class="borderAlignLeft">' . $rowGetImages['imageName'] . '</td>';
										echo '<td class="borderAlignCenter" style="width:32px;">';
										echo '<input type="radio" name="propertyPrimaryImageID" value="' . $rowGetImages['imageID'] . '"';
											if ($propertyPrimaryImageID == $rowGetImages['imageID']) { echo ' checked'; }
										echo '>';
										echo '</td>';
									echo '</tr>';
								}
								
							echo '</table>';
						
						echo '</div>';
					echo '</td>';
					
				echo '</tr>';
				
				
				
				
				
				
				
				
				
				
				echo '<tr>';
					
					echo '<td class="fieldLabelCenter">';
						echo '<input type="checkbox" name="propertyLinkStatus" value="1"';
							if ($propertyLinkStatus == 1) { echo ' checked'; }
						echo '> ';
						echo agileResource('propertyLinkUrl');
					echo '</td>';
					
					echo '<td class="fieldLabelCenter" colspan="3">';
						echo agileResource('propertyLinkUrl');
						echo ' <input type="text" name="propertyLinkUrl" style="width:150px;" value="' . $propertyLinkUrl . '">';
						echo agileResource('propertyLinkAnchorText');
						echo ' <input type="text" name="propertyLinkAnchorText" style="width:150px;" value="' . $propertyLinkAnchorText . '">';
					echo '</td>';
					
				echo '</tr>';

				
				
				
				
				
				
				
				
				
				
				
				
				
				
				echo '<tr>';
					echo '<td class="fieldLabelCenter">';
						echo '<input type="checkbox" name="propertyHasMonthlyFee" value="1"';
							if ($propertyHasMonthlyFee == 1) { echo ' checked'; }
						echo '> ';
						echo agileResource('propertyHasMonthlyFee');
					echo '</td>';
					echo '<td class="fieldLabelCenter">';
						
						echo agileResource('propertyMonthlyFee');
						echo ' <input type="text" name="propertyMonthlyFee" style="width:50px;" value="' . $propertyMonthlyFee . '">';
					echo '</td>';
					echo '<td class="fieldLabelCenter">';
						
						echo agileResource('propertyMonthlyTransactionDate');
						// echo ' <input type="text" name="propertyMonthlyTransactionDate" style="width:50px;" value="' . $propertyMonthlyTransactionDate . '">';
						echo ' <select name="propertyMonthlyTransactionDate">';
							$days = 1;
							while ($days <= 28) {
								echo '<option value="' . $days . '"';
									if ($propertyMonthlyTransactionDate == $days) { echo ' selected'; }
								echo '>' . $days . '</option>';
								$days = $days + 1;
							}
						echo '</select>';
						
					echo '</td>';
					echo '<td class="fieldLabelCenter">';
						echo '<input type="submit" name="submit" value="';
						if ($type == 'create') {
							echo agileResource('createProperty');
						} elseif ($type == 'update') {
							echo agileResource('updateProperty');
						}
					echo '"></td>';
				echo '</tr>';
				
			echo '</table>';
			
		echo '</form>';

}

function displayPropertyAreaDropdown($propertyAreaID = 0) {

	if ($_SESSION['lang'] == 'ja') {
		$query = "SELECT * FROM property_area WHERE siteID = '$_SESSION[siteID]' ORDER BY propertyAreaEnglish ASC";
	} else {
		$query = "SELECT * FROM property_area WHERE siteID = '$_SESSION[siteID]' ORDER BY propertyAreaJapaneseReading ASC";
	}
	
	$result = mysql_query($query);
	echo '<select name="propertyAreaID">';
		echo '<option value="0">' . agileResource('propertyArea') . '</option>';
		while ($row = mysql_fetch_array($result)) {
			echo '<option value="' . $row['propertyAreaID'] . '"';
				if ($propertyAreaID == $row['propertyAreaID']) { echo ' selected'; }
			echo '>';
				if ($_SESSION['lang'] == 'ja') {
					echo $row['propertyAreaJapanese'];
				} else {
					echo $row['propertyAreaEnglish'];
				}
			echo '</option>';
		}
	echo '</select>';
	
}

function displayPropertyClassificationDropdown($propertyClassificationID = 0) {

	if ($_SESSION['lang'] == 'ja') {
		$query = "SELECT * FROM property_classification WHERE siteID = '$_SESSION[siteID]' ORDER BY propertyClassificationEnglish ASC";
	} else {
		$query = "SELECT * FROM property_classification WHERE siteID = '$_SESSION[siteID]' ORDER BY propertyClassificationJapaneseReading ASC";
	}
	
	$result = mysql_query($query);
	echo '<select name="propertyClassificationID">';
		echo '<option value="0">' . agileResource('propertyClassification') . '</option>';
		while ($row = mysql_fetch_array($result)) {
			echo '<option value="' . $row['propertyClassificationID'] . '"';
				if ($propertyClassificationID == $row['propertyClassificationID']) { echo ' selected'; }
			echo '>';
				if ($_SESSION['lang'] == 'ja') {
					echo $row['propertyClassificationJapanese'];
				} else {
					echo $row['propertyClassificationEnglish'];
				}
			echo '</option>';
		}
	echo '</select>';
}

function displayPropertyStatusDropdown($propertyStatusID = 0) {

	if ($_SESSION['lang'] == 'ja') {
		$query = "SELECT * FROM property_status WHERE siteID = '$_SESSION[siteID]' ORDER BY propertyStatusEnglish ASC";
	} else {
		$query = "SELECT * FROM property_status WHERE siteID = '$_SESSION[siteID]' ORDER BY propertyStatusJapaneseReading ASC";
	}
	
	$result = mysql_query($query);
	echo '<select name="propertyStatusID">';
		echo '<option value="0">' . agileResource('propertyStatus') . '</option>';
		while ($row = mysql_fetch_array($result)) {
			echo '<option value="' . $row['propertyStatusID'] . '"';
				if ($propertyStatusID == $row['propertyStatusID']) { echo ' selected'; }
			echo '>';
				if ($_SESSION['lang'] == 'ja') {
					echo $row['propertyStatusJapanese'];
				} else {
					echo $row['propertyStatusEnglish'];
				}
			echo '</option>';
		}
	echo '</select>';

}

function displayPropertyTypeDropdown($propertyTypeID = 0) {

	if ($_SESSION['lang'] == 'ja') {
		$query = "SELECT * FROM property_type WHERE siteID = '$_SESSION[siteID]' ORDER BY propertyTypeEnglish ASC";
	} else {
		$query = "SELECT * FROM property_type WHERE siteID = '$_SESSION[siteID]' ORDER BY propertyTypeJapaneseReading ASC";
	}
	
	$result = mysql_query($query);
	echo '<select name="propertyTypeID">';
		echo '<option value="0">' . agileResource('propertyType') . '</option>';
		while ($row = mysql_fetch_array($result)) {
			echo '<option value="' . $row['propertyTypeID'] . '"';
				if ($propertyTypeID == $row['propertyTypeID']) { echo ' selected'; }
			echo '>';
				if ($_SESSION['lang'] == 'ja') {
					echo $row['propertyTypeJapanese'];
				} else {
					echo $row['propertyTypeEnglish'];
				}
			echo '</option>';
		}
	echo '</select>';

}

function getPropertyArea($propertyAreaID) {

	if ($propertyAreaID != 0) {
		$propertyArea = 'propertyAreaDoesNotExist';
	} else {
		$propertyArea = '';
	}
	$query = "SELECT * FROM property_area WHERE propertyAreaID = '$propertyAreaID' LIMIT 1;";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		if ($_SESSION['lang'] == 'ja') {
			$propertyArea = $row['propertyAreaJapanese'];
		} else {
			$propertyArea = $row['propertyAreaEnglish'];
		}
	}
	return $propertyArea;

}

function getPropertyClassification($propertyClassificationID) {

	if ($propertyClassificationID != 0) {
		$propertyClassification = 'propertyClassificationDoesNotExist';
	} else {
		$propertyClassification = '';
	}

	
	$query = "SELECT * FROM property_classification WHERE siteID = '$_SESSION[siteID]' AND propertyClassificationID = '$propertyClassificationID' LIMIT 1;";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		if ($_SESSION['lang'] == 'ja') {
			$propertyClassification = $row['propertyClassificationJapanese'];
		} else {
			$propertyClassification = $row['propertyClassificationEnglish'];
		}
	}
	return $propertyClassification;

}

function getPropertyFeature($propertyFeatureID) {

	if ($propertyFeatureID != 0) {
		$propertyFeature = 'propertyFeatureDoesNotExist';
	} else {
		$propertyFeature = '';
	}
	
	$query = "SELECT * FROM property_feature WHERE siteID = '$_SESSION[siteID]' AND featureID = '$propertyFeatureID' LIMIT 1;";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		if ($_SESSION['lang'] == 'ja') {
			$propertyFeature = $row['propertyFeatureJapanese'];
		} else {
			$propertyFeature = $row['featureNameEnglish'];
		}
	}
	return $propertyFeature;

}

function getPropertyStatus($propertyStatusID) {

	if ($propertyStatusID != 0) {
		$propertyStatus = 'propertyStatusDoesNotExist';
	} else {
		$propertyStatus = '';
	}
	
	$query = "SELECT * FROM property_status WHERE siteID = '$_SESSION[siteID]' AND propertyStatusID = '$propertyStatusID' LIMIT 1;";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		if ($_SESSION['lang'] == 'ja') {
			$propertyStatus = $row['propertyStatusJapanese'];
		} else {
			$propertyStatus = $row['propertyStatusEnglish'];
		}
	}
	return $propertyStatus;

}

function getPropertyType($propertyTypeID) {

	if ($propertyTypeID != 0) {
		$propertyType = 'propertyTypeDoesNotExist';
	} else {
		$propertyType = '';
	}

	
	$query = "SELECT * FROM property_type WHERE siteID = '$_SESSION[siteID]' AND propertyTypeID = '$propertyTypeID' LIMIT 1;";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		if ($_SESSION['lang'] == 'ja') {
			$propertyType = $row['propertyTypeJapanese'];
		} else {
			$propertyType = $row['propertyTypeEnglish'];
		}
	}
	return $propertyType;
	
}

function insertProperty(
	$propertyNameSeoUrl,
	$propertyNameEnglish,
	$propertyNameJapanese,
	$propertyNameJapaneseReading,
	$propertyAreaID,
	$propertyTypeID,
	$propertyAddress1English,
	$propertyAddress2English,
	$propertyAddress1Japanese,
	$propertyAddress2Japanese,
	$cityID,
	$stateID,
	$countryID,
	$propertyAddressPostalCode,
	$propertyDescriptionEnglish,
	$propertyDescriptionJapanese,
	$propertyDistanceFromSkiHill,
	$propertyLandSize,
	$propertyFloorArea,
	$propertyNumberOfBedrooms,
	$propertyNumberOfToilets,
	$propertyNumberOfBathrooms,
	$propertyOccupancy,
	$propertyPrice,
	$propertyPriceRental,
	$propertyFeatured,
	$propertyDisplay,
	$propertyClassificationID,
	$propertyStatusID,
	$propertyDateTimeSold,
	$propertyMainSiteID,
	$accommodationMainSiteID,
	$propertyPublished,
	$propertyURL,
	$propertyHasMonthlyFee,
	$propertyMonthlyFee,
	$propertyMonthlyTransactionDate,
	$propertyFeature,
	$imageToBeUploaded,
	$propertyPrimaryImageID,
	$contractID,
	$propertyLinkStatus,
	$propertyLinkUrl,
	$propertyLinkAnchorText
) {

	$siteID = $_SESSION['siteID'];
	$propertyDateTimeAdded = date('Y-m-d H:i:s');
	
		$queryInsertProperty = "INSERT INTO property_property (
			siteID,
			propertyDateTimeAdded,
			propertyNameSeoUrl,
			propertyNameEnglish,
			propertyNameJapanese,
			propertyNameJapaneseReading,
			propertyAreaID,
			propertyTypeID,
			propertyAddress1English,
			propertyAddress2English,
			propertyAddress1Japanese,
			propertyAddress2Japanese,
			cityID,
			stateID,
			countryID,
			propertyAddressPostalCode,
			propertyDescriptionEnglish,
			propertyDescriptionJapanese,
			propertyDistanceFromSkiHill,
			propertyLandSize,
			propertyFloorArea,
			propertyNumberOfBedrooms,
			propertyNumberOfToilets,
			propertyNumberOfBathrooms,
			propertyOccupancy,
			propertyPrice,
			propertyPriceRental,
			propertyFeatured,
			propertyDisplay,
			propertyClassificationID,
			propertyStatusID,
			propertyDateTimeSold,
			propertyMainSiteID,
			accommodationMainSiteID,
			propertyPublished,
			propertyURL,
			propertyHasMonthlyFee,
			propertyMonthlyFee,
			propertyMonthlyTransactionDate,
			propertyPrimaryImageID,
			contractID,
			propertyLinkStatus,
			propertyLinkUrl,
			propertyLinkAnchorText
		) VALUES (
			'$siteID',
			'$propertyDateTimeAdded',
			'$propertyNameSeoUrl',
			'$propertyNameEnglish',
			'$propertyNameJapanese',
			'$propertyNameJapaneseReading',
			'$propertyAreaID',
			'$propertyTypeID',
			'$propertyAddress1English',
			'$propertyAddress2English',
			'$propertyAddress1Japanese',
			'$propertyAddress2Japanese',
			'$cityID',
			'$stateID',
			'$countryID',
			'$propertyAddressPostalCode',
			'$propertyDescriptionEnglish',
			'$propertyDescriptionJapanese',
			'$propertyDistanceFromSkiHill',
			'$propertyLandSize',
			'$propertyFloorArea',
			'$propertyNumberOfBedrooms',
			'$propertyNumberOfToilets',
			'$propertyNumberOfBathrooms',
			'$propertyOccupancy',
			'$propertyPrice',
			'$propertyPriceRental',
			'$propertyFeatured',
			'$propertyDisplay',
			'$propertyClassificationID',
			'$propertyStatusID',
			'$propertyDateTimeSold',
			'$propertyMainSiteID',
			'$accommodationMainSiteID',
			'$propertyPublished',
			'$propertyURL',
			'$propertyHasMonthlyFee',
			'$propertyMonthlyFee',
			'$propertyMonthlyTransactionDate',
			'$propertyPrimaryImageID',
			'$contractID',
			'$propertyLinkStatus',
			'$propertyLinkUrl',
			'$propertyLinkAnchorText'
		)";
		mysql_query ($queryInsertProperty) or die ('could not create property via insertProperty()');
		$propertyID = mysql_insert_id();
		insertPropertyFeatures($propertyID, $propertyFeature);
		if (!empty($imageToBeUploaded)) {
			imageUpload($imageToBeUploaded, 'property', $propertyID);
		}
		
}

function updateProperty(
	$propertyID,
	$propertyNameSeoUrl,
	$propertyNameEnglish,
	$propertyNameJapanese,
	$propertyNameJapaneseReading,
	$propertyAreaID,
	$propertyTypeID,
	$propertyAddress1English,
	$propertyAddress2English,
	$propertyAddress1Japanese,
	$propertyAddress2Japanese,
	$cityID,
	$stateID,
	$countryID,
	$propertyAddressPostalCode,
	$propertyDescriptionEnglish,
	$propertyDescriptionJapanese,
	$propertyDistanceFromSkiHill,
	$propertyLandSize,
	$propertyFloorArea,
	$propertyNumberOfBedrooms,
	$propertyNumberOfToilets,
	$propertyNumberOfBathrooms,
	$propertyOccupancy,
	$propertyPrice,
	$propertyPriceRental,
	$propertyFeatured,
	$propertyDisplay,
	$propertyClassificationID,
	$propertyStatusID,
	$propertyDateTimeSold,
	$propertyMainSiteID,
	$accommodationMainSiteID,
	$propertyPublished,
	$propertyURL,
	$propertyHasMonthlyFee,
	$propertyMonthlyFee,
	$propertyMonthlyTransactionDate,
	$propertyFeature,
	$imageToBeUploaded,
	$propertyPrimaryImageID,
	$contractID,
	$propertyLinkStatus,
	$propertyLinkUrl,
	$propertyLinkAnchorText 
) {
	
	$query = "UPDATE property_property SET
			propertyNameSeoUrl = '$propertyNameSeoUrl',
			propertyNameEnglish = '$propertyNameEnglish',
			propertyNameJapanese = '$propertyNameJapanese',
			propertyNameJapaneseReading = '$propertyNameJapaneseReading',
			propertyAreaID = '$propertyAreaID',
			propertyTypeID = '$propertyTypeID',
			propertyAddress1English = '$propertyAddress1English',
			propertyAddress2English = '$propertyAddress2English',
			propertyAddress1Japanese = '$propertyAddress1Japanese',
			propertyAddress2Japanese = '$propertyAddress2Japanese',
			cityID = '$cityID',
			stateID = '$stateID',
			countryID = '$countryID',
			propertyAddressPostalCode = '$propertyAddressPostalCode',
			propertyDescriptionEnglish = '$propertyDescriptionEnglish',
			propertyDescriptionJapanese = '$propertyDescriptionJapanese',
			propertyDistanceFromSkiHill = '$propertyDistanceFromSkiHill',
			propertyLandSize = '$propertyLandSize',
			propertyFloorArea = '$propertyFloorArea',
			propertyNumberOfBedrooms = '$propertyNumberOfBedrooms',
			propertyNumberOfToilets = '$propertyNumberOfToilets',
			propertyNumberOfBathrooms = '$propertyNumberOfBathrooms',
			propertyOccupancy = '$propertyOccupancy',
			propertyPrice = '$propertyPrice',
			propertyPriceRental = '$propertyPriceRental',
			propertyFeatured = '$propertyFeatured',
			propertyDisplay = '$propertyDisplay',
			propertyClassificationID = '$propertyClassificationID',
			propertyStatusID = '$propertyStatusID',
			propertyDateTimeSold = '$propertyDateTimeSold',
			propertyMainSiteID = '$propertyMainSiteID',
			accommodationMainSiteID = '$accommodationMainSiteID',
			propertyPublished = '$propertyPublished',
			propertyURL = '$propertyURL',
			propertyHasMonthlyFee = '$propertyHasMonthlyFee',
			propertyMonthlyFee = '$propertyMonthlyFee',
			propertyMonthlyTransactionDate = '$propertyMonthlyTransactionDate',
			propertyPrimaryImageID = '$propertyPrimaryImageID',
			contractID = '$contractID',
			propertyLinkStatus = '$propertyLinkStatus',
			propertyLinkUrl = '$propertyLinkUrl',
			propertyLinkAnchorText = '$propertyLinkAnchorText'
		WHERE propertyID = $propertyID LIMIT 1";
	
	// echo '<pre>' . $query . '</pre>';
	mysql_query ($query) or die ('Could not update property via updateProperty()');
	
	deletePropertyFeatures($propertyID);
	insertPropertyFeatures($propertyID, $propertyFeature);
	
	if (!empty($imageToBeUploaded)) {
		imageUpload($imageToBeUploaded, 'property', $propertyID);
	}
	
}


function getThisPropertysFeatures($propertyID) {
	$propertyFeature = array();
	$queryGetThisPropertysFeatures = "SELECT featureID FROM property_propertyFeature WHERE propertyID = '$propertyID' AND siteID = '$_SESSION[siteID]';";
	$resultGetThisPropertysFeatures = mysql_query($queryGetThisPropertysFeatures);
	while ($rowGetThisPropertysFeatures = mysql_fetch_array($resultGetThisPropertysFeatures)) {
		$propertyFeature[] = $rowGetThisPropertysFeatures['featureID'];
	}
	return $propertyFeature;
}

function insertPropertyFeatures($propertyID, $propertyFeature) {

	$siteID = $_SESSION['siteID'];
	if (!empty($propertyFeature)) {
		foreach ($propertyFeature as $featureID) {
			$queryInsertPropertyFeature = "INSERT INTO property_propertyFeature (propertyID, featureID, siteID) VALUES ('$propertyID', '$featureID', '$siteID');";
			mysql_query($queryInsertPropertyFeature);
		}
	}

}

function deletePropertyFeatures($propertyID) {

	$siteID = $_SESSION['siteID'];
	$queryDeletePropertyFeature = "DELETE FROM property_propertyFeature WHERE propertyID = '$propertyID' AND siteID = '$siteID';";
	mysql_query($queryDeletePropertyFeature);

}


function displayRealtyCmsAreaNavigation($selectedArea) {
	
	$query = "SELECT * FROM property_area ORDER BY propertyAreaEnglish ASC";
	$result = mysql_query($query);
	
	echo '<div id="realtyCmsAreaNavigation">';
	echo '<h2 class="realtyCmsAreaNavigationHeader">' . agileResource('areas') . '</h2>';
	
	while ($row = mysql_fetch_array($result)) {
	
		if ($selectedArea == $row['propertyAreaSeoUrl']) { $divClass = 'realtyCmsAreaNavigationLinkSelected'; } else { $divClass = 'realtyCmsAreaNavigationLink'; }
		echo '<div class="' . $divClass . '">';
		echo '<a class="' . $divClass . '" href="' . languageUrlPrefix() . 'property/' . $row['propertyAreaSeoUrl'] . '/">';
			// if ($_SESSION['lang'] == 'ja') { echo $row['propertyAreaJapanese']; } else { echo $row['propertyAreaEnglish']; }
			echo ($_SESSION['lang'] == 'ja') ? $row['propertyAreaJapanese'] : $row['propertyAreaEnglish']; // trying php shorthand... not much shorter!
		echo '</a>';
		echo '</div>';
	}

	echo '</div>';

}







function getPropertyFeatureName($featureID) {
	$resultGetPropertyFeatureName = mysql_query("SELECT * FROM property_feature WHERE featureID = '$featureID' LIMIT 1");
	while($rowGetPropertyFeatureName = mysql_fetch_array($resultGetPropertyFeatureName)) {
		if ($_SESSION['lang'] == 'ja') {
			$propertyFeatureName = $rowGetPropertyFeatureName['propertyFeatureJapanese'];
		} else {
			$propertyFeatureName = $rowGetPropertyFeatureName['featureNameEnglish'];
		}
	}
	return $propertyFeatureName;
}



































function displayOwnerPropertyDetails() {

	if (
		$_SESSION['userRoleForCurrentSite'] == 'siteManager' || 
		$_SESSION['userRoleForCurrentSite'] == 'siteAccountant' || 
		$_SESSION['userRoleForCurrentSite'] == 'siteStaff' || 
		$_SESSION['userRoleForCurrentSite'] == 'siteClient'
	) {
	
		$propertyIdString = join(',', $_SESSION['userPropertyArray']);
		$resultGetPropertyQuery  = "SELECT * FROM property_property WHERE siteID = '$_SESSION[siteID]' AND propertyID IN ($propertyIdString) ORDER BY propertyNameEnglish ASC";
		
		// echo $resultGetPropertyQuery;
	
	
		/*
Property name
Full property address
Floor Area
Land size
Monthly fee (plus tax)
Photos
		*/
	

		echo '<div style="text-align:center;">';
			
				$resultGetPropertyResult = mysql_query($resultGetPropertyQuery);
				while($rowGetProperty = mysql_fetch_array($resultGetPropertyResult)) {
				
					echo '<table style="margin:5px auto 5px auto;background-color:#fff;width:100%;font-family:verdana;font-size:10px;">';
						echo '<tr>';
							echo '<td class="fieldLabelCenter">' . agileResource('propertyID') . '</td>';
							echo '<td class="fieldLabelCenter">' . agileResource('propertyName') . '</td>';
							echo '<td class="fieldLabelCenter">' . agileResource('propertyFullAddress') . '</td>';
							echo '<td class="fieldLabelCenter">' . agileResource('floorArea') . '</td>';
							echo '<td class="fieldLabelCenter">' . agileResource('landSize') . '</td>';
							echo '<td class="fieldLabelCenter">' . agileResource('monthlyFee') . '</td>';
						echo '</tr>';
				
						echo '<tr>';
							echo '<td class="borderAlignCenter">' . $rowGetProperty['propertyID'] . '</td>';
							echo '<td class="borderAlignLeft">' . getPropertyName($rowGetProperty['propertyID']) . '</td>';
							echo '<td class="borderAlignLeft">';
							
								if ($_SESSION['lang'] == 'ja') {
									echo $rowGetProperty['propertyAddress1Japanese'] . ' ';
									if ($rowGetProperty['propertyAddress2Japanese'] != '') { echo $rowGetProperty['propertyAddress2Japanese'] . ' '; }
								} else { 
									echo $rowGetProperty['propertyAddress1English'] . ' ';
									if ($rowGetProperty['propertyAddress2English'] != '') { echo $rowGetProperty['propertyAddress2English'] . ' '; }
								}
									
							
								echo getCityName($rowGetProperty['cityID']) . ', ';
								echo getStateName($rowGetProperty['stateID']) . ', ';
								echo getCountryName($rowGetProperty['countryID']) . ' ';
								echo $rowGetProperty['propertyAddressPostalCode'];
								
							echo '</td>';
							echo '<td class="borderAlignRight">' . $rowGetProperty['propertyFloorArea'] . '</td>';
							echo '<td class="borderAlignRight">' . $rowGetProperty['propertyLandSize'] . '</td>';
							echo '<td class="borderAlignRight">&yen;' . number_format($rowGetProperty['propertyMonthlyFee']) . '</td>';
						echo '</tr>';
						
						echo '<tr>';
						
							echo '<td class="borderAlignLeft" colspan="6">';
							
								$propertyImageQuery = "SELECT imageID FROM image WHERE siteID = '$_SESSION[siteID]' AND imageObject = 'property' AND imageObjectID = '$rowGetProperty[propertyID]'";
								$propertyImageResult = mysql_query($propertyImageQuery);
								while ($rowPropertyImage = mysql_fetch_array($propertyImageResult)) {
									echo '<img src="/image.php?imageID=' . $rowPropertyImage['imageID'] . '" style="height:100px;">';
								}
								
							echo '</td>';
							 
						echo '</tr>';
						

				}
				
				
				
				
				
				
				
				
				
	
/*
CREATE TABLE IF NOT EXISTS `property_property` (
  `propertyID` int(8) NOT NULL auto_increment,
  `siteID` int(8) NOT NULL,
  `propertyDateTimeAdded` datetime NOT NULL,
  `propertyNameSeoUrl` varchar(255) NOT NULL,
  `propertyNameEnglish` varchar(255) NOT NULL,
  `propertyNameJapanese` varchar(255) NOT NULL,
  `propertyNameJapaneseReading` varchar(255) NOT NULL,
  `propertyAreaID` int(8) NOT NULL,
  `propertyTypeID` int(8) NOT NULL,
  `propertyAddress1English` varchar(100) NOT NULL,
  `propertyAddress2English` varchar(100) NOT NULL,
  `propertyAddress1Japanese` varchar(255) NOT NULL,
  `propertyAddress2Japanese` varchar(255) NOT NULL,
  `cityID` int(8) NOT NULL,
  `stateID` int(8) NOT NULL,
  `countryID` int(8) NOT NULL,
  `propertyAddressPostalCode` varchar(20) NOT NULL,
  `propertyDescriptionEnglish` text NOT NULL,
  `propertyDescriptionJapanese` text NOT NULL,
  `propertyDistanceFromSkiHill` decimal(10,2) NOT NULL,
  `propertyLandSize` decimal(10,2) NOT NULL,
  `propertyFloorArea` decimal(10,2) NOT NULL,
  `propertyNumberOfBedrooms` decimal(3,1) NOT NULL,
  `propertyNumberOfToilets` decimal(3,1) NOT NULL,
  `propertyNumberOfBathrooms` decimal(3,1) NOT NULL,
  `propertyOccupancy` int(6) NOT NULL,
  `propertyPrice` decimal(15,2) NOT NULL,
  `propertyPriceRental` varchar(50) NOT NULL,
  `propertyFeatured` int(1) NOT NULL,
  `propertyDisplay` int(1) NOT NULL,
  `propertyClassificationID` int(4) NOT NULL,
  `propertyStatusID` int(4) NOT NULL,
  `propertyDateTimeSold` datetime NOT NULL,
  `propertyMainSiteID` int(8) NOT NULL,
  `accommodationMainSiteID` int(8) NOT NULL,
  `propertyPublished` int(1) NOT NULL,
  `propertyURL` varchar(100) NOT NULL,
  `propertyHasMonthlyFee` int(1) NOT NULL,
  `propertyMonthlyFee` decimal(12,2) NOT NULL,
  `propertyMonthlyTransactionDate` int(2) NOT NULL,
  `propertyPrimaryImageID` int(8) NOT NULL,
  `contractID` int(8) NOT NULL,
  `propertyLinkStatus` int(1) NOT NULL,
  `propertyLinkUrl` varchar(255) NOT NULL,
  `propertyLinkAnchorText` varchar(255) NOT NULL,
  PRIMARY KEY  (`propertyID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100063 ;
*/
			
				
				
			echo '</table>';
		echo '</div>';
	
		
	}
}



?>