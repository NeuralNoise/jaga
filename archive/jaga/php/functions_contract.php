<?php

function displayContractList() {

	echo '<div style="text-align:center;">';
		echo '<table style="margin:5px auto 5px auto;background-color:#fff;width:100%;font-family:verdana;font-size:10px;">';
		
			$thisUsersClientString = join(',', $_SESSION['userClientArray']);
			$queryThisUsersClients = "SELECT clientID FROM accounting_client WHERE clientID IN ($thisUsersClientString) ORDER BY clientNameEnglish";
			$resultThisUsersClients = mysql_query($queryThisUsersClients);
			while ($rowThisUsersClient = mysql_fetch_array($resultThisUsersClients)) {
				
				$clientID = $rowThisUsersClient['clientID'];
				
				echo '<tr style="background-color:#ddd;">';
					echo '<td class="borderAlignLeft" colspan="4">' . getClientName($rowThisUsersClient['clientID']) . '</td>';
				echo '</tr>';
				
					$queryThisClientsProperties = "SELECT * FROM property_propertyClient LEFT JOIN property_property ON property_propertyClient.propertyID = property_property.propertyID WHERE property_propertyClient.clientID = '$clientID' ORDER BY property_property.propertyNameEnglish";
					$resultThisClientsProperties = mysql_query($queryThisClientsProperties);
					while ($rowThisClientsProperties = mysql_fetch_array($resultThisClientsProperties)) {
				
						$propertyID = mysql_real_escape_string($rowThisClientsProperties['propertyID']);
						$contractID = getContractIdWithPropertyID($propertyID);
				
						echo '<tr style="background-color:#eee;">';
							echo '<td class="borderAlignCenter" style="width:25px;">&rarr;</td>';
							echo '<td class="borderAlignLeft">' . getPropertyName($propertyID) . '</td>';
							echo '<td class="borderAlignCenter" style="width:75px;">';
							
								if ($contractID != 0) {
									echo '<input type="button" value="';
									if (!userHasSignedContract($contractID, $propertyID, $_SESSION['userID'])) {
										echo agileResource('pleaseSign');
									} else {
										echo agileResource('viewContract');
									}
									echo '" onclick="window.location.href=\'' . languageUrlPrefix() . 'contracts/sign/' . $propertyID . '/\'">';
								}
								
							echo '</td>';
						echo '</tr>';
					}
			}
		echo '</table>';
	echo '</div>';


							
/*
CREATE TABLE IF NOT EXISTS `contract_contractClient` (
  `contractID` int(8) NOT NULL,
  `clientID` int(8) NOT NULL,
  `propertyID` int(8) NOT NULL,
  `managerSignatureUserID` int(8) NOT NULL,
  `managerSignatureDateTime` datetime NOT NULL,
  `managerSignatureIPAddress` varchar(39) NOT NULL,
  `managerSignatureNameSigned` varchar(255) NOT NULL,
  `clientSignatureUserID` int(8) NOT NULL,
  `clientSignatureDateTime` datetime NOT NULL,
  `clientSignatureIPAddress` varchar(39) NOT NULL,
  `clientSignatureNameSigned` varchar(255) NOT NULL,
  PRIMARY KEY  (`contractID`,`clientID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
*/

}

function displayManageContractList() {

	
	if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') {
		$query = "SELECT * FROM contract_contract WHERE siteID = '$_SESSION[siteID]' ORDER BY contractID DESC";
	} else {
		$clientArrayString = implode(",", $_SESSION['userClientArray']);
		$query = "
			SELECT * FROM contract_contractClient 
			LEFT JOIN contract_contract 
			ON contract_contractClient.contractID = contract_contract.contractID 
			WHERE contract_contract.siteID = '$_SESSION[siteID]'
			AND contract_contractClient.clientID IN ($clientArrayString)
			ORDER BY contract_contract.contractID DESC
		";
	}
	
	echo '<div style="text-align:center;">';
	echo '<table style="margin:5px 0px 5px 0px;width:100%;background-color:#fff;font-family:verdana;font-size:10px;">';
	
		if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') {
			echo '<tr>';
				echo '<td class="fieldLabelLeft" colspan="5">';
					echo '<input type="button" value="' . agileResource('createContract') . '" onclick="window.location.href=\'' . languageUrlPrefix() . 'manage-contracts/create/\'">';
				echo '</td>';
			echo '</tr>';
		}
	
		echo '<tr>';
			echo '<td class="fieldLabelCenter">' . agileResource('contractID') . '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('contractTitle') . '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('creator') . '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('creationDateTime') . '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('action') . '</td>';
		echo '</tr>';
	
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		echo '<tr>';
			echo '<td class="borderAlignCenter">' . $row['contractID'] . '</td>';
			
			echo '<td class="borderAlignCenter">';
				echo '<a href="' . languageUrlPrefix() . 'contracts/' . $row['contractID'] . '/">';
					if ($_SESSION['lang'] == 'ja') { echo $row['contractTitleJapanese']; } else { echo $row['contractTitleEnglish']; }
				echo '</a>';
			echo '</td>';
			echo '<td class="borderAlignCenter">' . getUserName($row['contractCreatedByUserID']) . '</td>';
			echo '<td class="borderAlignCenter">' . $row['contractCreationDateTime'] . '</td>';
			echo '<td class="borderAlignCenter">';
				if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') {
					echo '<input type="button" value="' . agileResource('updateContract') . '" onclick="window.location.href=\'' . languageUrlPrefix() . 'manage-contracts/update/' . $row['contractID'] . '/\'">';
					echo '<input type="button" value="' . agileResource('viewContract') . '" onclick="window.location.href=\'' . languageUrlPrefix() . 'manage-contracts/' . $row['contractID'] . '/\'">';
				}
			echo '</td>';
		echo '</tr>';
	}
	
	echo '</table>';
	echo '</div>';

}

function displayContractCrud($type = 'create', $contractID = 0,  $contractTitleEnglish = '',  $contractTitleJapanese = '',  $contractTitleJapaneseReading = '',  $contractContentEnglish = '',  $contractContentJapanese = '') {

	if ($type == 'update' || $type == 'view') {
		$query = "SELECT * FROM contract_contract WHERE contractID = '$contractID' LIMIT 1";
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result)) {
			$contractCreatedByUserID = $row['contractCreatedByUserID'];
			$contractCreationDateTime = $row['contractCreationDateTime'];
			$contractTitleEnglish = $row['contractTitleEnglish'];
			$contractTitleJapanese = $row['contractTitleJapanese'];
			$contractTitleJapaneseReading = $row['contractTitleJapaneseReading'];
			$contractContentEnglish = $row['contractContentEnglish'];
			$contractContentJapanese = $row['contractContentJapanese'];
		}
	}

	echo '<div style="text-align:center;">';
	
		if ($type == 'create') {
			echo '<form method="post" action="' . languageUrlPrefix() . 'manage-contracts/create/">';
		} elseif ($type == 'update') {
			echo '<form method="post" action="' . languageUrlPrefix() . 'manage-contracts/update/' . $contractID . '/">';
		}
	
			echo '<table style="margin:5px 0px 5px 0px;width:100%;background-color:#fff;font-family:verdana;font-size:10px;">';
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('contractTitleEnglish') . '</td>';
					echo '<td class="fieldLabelLeft">';
						if ($type == 'view') {
							echo $contractTitleEnglish;
						} elseif ($type == 'create' || $type == 'update') {
							echo '<input type="text" name="contractTitleEnglish" value="' . $contractTitleEnglish . '" style="width:200px;">';
						}
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('contractTitleJapanese') . '</td>';
					echo '<td class="fieldLabelLeft">';
						if ($type == 'view') {
							echo $contractTitleJapanese;
						} elseif ($type == 'create' || $type == 'update') {
							echo '<input type="text" name="contractTitleJapanese" value="' . $contractTitleJapanese . '" style="width:200px;">';
						}
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('contractTitleJapaneseReading') . '</td>';
					echo '<td class="fieldLabelLeft">';
						if ($type == 'view') {
							echo $contractTitleJapaneseReading;
						} elseif ($type == 'create' || $type == 'update') {
							echo '<input type="text" name="contractTitleJapaneseReading" value="' . $contractTitleJapaneseReading . '" style="width:200px;">';
						}
					echo '</td>';
				echo '</tr>';
				if ($type == 'update' || $type == 'view') {
					echo '<tr>';
						echo '<td class="fieldLabelLeft">' . agileResource('contractCreatedByUserID') . '</td>';
						echo '<td class="fieldLabelLeft">' . getUserName($contractCreatedByUserID) . '</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td class="fieldLabelLeft">' . agileResource('contractCreationDateTime') . '</td>';
						echo '<td class="fieldLabelLeft">' . $contractCreationDateTime . '</td>';
					echo '</tr>';
				}
				echo '<tr>';
					echo '<td class="fieldLabelCenter">' . agileResource('contractContentEnglish') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('contractContentJapanese') . '</td>';
				echo '</tr>';
				echo '<tr>';
					
						if ($type == 'view') {
							echo '<td class="fieldLabelLeft">';
								echo $contractContentEnglish;
							echo '</td>';
						} elseif ($type == 'create' || $type == 'update') {
							echo '<td class="fieldLabelCenter">';
								echo '<textarea name="contractContentEnglish" style="width:425px;height:600px;">' . $contractContentEnglish . '</textarea>';
							echo '</td>';
						}
					
						if ($type == 'view') {
							echo '<td class="fieldLabelLeft">';
								echo $contractContentJapanese;
							echo '</td>';
						} elseif ($type == 'create' || $type == 'update') {
							echo '<td class="fieldLabelCenter">';
								echo '<textarea name="contractContentJapanese" style="width:425px;height:600px;">' . $contractContentJapanese . '</textarea>';
							echo '</td>';
						}
					
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft" colspan="2">';
						echo 'When loaded up into the owner view:<br />';
						echo '{{{Property}}} will display the name of the property.<br />';
						echo '{{{Owner}}} will display the name of the owner.<br />';
						echo '{{{MonthlyFee}}} will display the monthly fee.';
					echo '</td>';
				echo '</tr>';
				
				if ($type == 'create' || $type == 'update') {
					echo '<tr>';
						echo '<td class="fieldLabelRight" colspan="2">';
							echo '<input type="submit" name="submit" value="';
								if ($type == 'create') { echo agileResource('createContract'); } elseif ($type == 'update') { echo agileResource('updateContract'); }
							echo '">';
						echo '</td>';
					echo '</tr>';
				}
			echo '</table>';
		if ($type == 'create' || $type == 'update') { echo '</form>'; }
	echo '</div>';

}

function insertContract($contractTitleEnglish, $contractTitleJapanese, $contractTitleJapaneseReading, $contractContentEnglish, $contractContentJapanese) {

	$siteID = $_SESSION['siteID'];
	$contractCreatedByUserID = $_SESSION['userID'];
	$contractCreationDateTime = date('Y-m-d H:i:s');

	$query = "INSERT INTO contract_contract (
			siteID,
			contractCreatedByUserID,
			contractCreationDateTime,
			contractTitleEnglish,
			contractTitleJapanese, 
			contractTitleJapaneseReading, 
			contractContentEnglish, 
			contractContentJapanese
	) VALUES (
			'$siteID', 
			'$contractCreatedByUserID', 
			'$contractCreationDateTime', 
			'$contractTitleEnglish', 
			'$contractTitleJapanese', 
			'$contractTitleJapaneseReading', 
			'$contractContentEnglish', 
			'$contractContentJapanese'
	)";
	mysql_query ($query) or die ('Could not create contract via insertContract()');

}

function updateContract($contractID, $contractTitleEnglish, $contractTitleJapanese, $contractTitleJapaneseReading, $contractContentEnglish, $contractContentJapanese) {

	$query = "
		UPDATE contract_contract SET
			contractTitleEnglish = '$contractTitleEnglish',
			contractTitleJapanese = '$contractTitleJapanese',
			contractTitleJapaneseReading = '$contractTitleJapaneseReading',
			contractContentEnglish = '$contractContentEnglish',
			contractContentJapanese = '$contractContentJapanese'
		WHERE contractID = '$contractID' LIMIT 1
	";
		
	mysql_query ($query) or die ("<pre>$query</pre>");

}

/*

CREATE TABLE IF NOT EXISTS `contract_contractClient` (
  `contractID` int(8) NOT NULL,
  `clientID` int(8) NOT NULL,
  `propertyID` int(8) NOT NULL,
  `managerSignatureUserID` int(8) NOT NULL,
  `managerSignatureDateTime` datetime NOT NULL,
  `managerSignatureIPAddress` varchar(39) NOT NULL,
  `managerSignatureNameSigned` varchar(255) NOT NULL,
  `clientSignatureUserID` int(8) NOT NULL,
  `clientSignatureDateTime` datetime NOT NULL,
  `clientSignatureIPAddress` varchar(39) NOT NULL,
  `clientSignatureNameSigned` varchar(255) NOT NULL,
  PRIMARY KEY  (`contractID`,`clientID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
*/

function displayContractSignView($propertyID) {

	$queryProperty = "SELECT * FROM property_property WHERE propertyID = '$propertyID' LIMIT 1";
	$resultProperty = mysql_query($queryProperty);
	while ($rowProperty = mysql_fetch_array($resultProperty)) { $contractID = $rowProperty['contractID']; }

	$queryContract = "SELECT * FROM contract_contract WHERE contractID = '$contractID' LIMIT 1";
	$resultContract = mysql_query($queryContract);
	while ($rowContract = mysql_fetch_array($resultContract)) {
		$contractCreatedByUserID = $rowContract['contractCreatedByUserID'];
		$contractCreationDateTime = $rowContract['contractCreationDateTime'];
		$contractTitleEnglish = $rowContract['contractTitleEnglish'];
		$contractTitleJapanese = $rowContract['contractTitleJapanese'];
		$contractTitleJapaneseReading = $rowContract['contractTitleJapaneseReading'];
		$contractContentEnglish = $rowContract['contractContentEnglish'];
		$contractContentJapanese = $rowContract['contractContentJapanese'];
	}
	
	
	
	$propertyName = getPropertyName($propertyID);
	$clientName = getClientName(getClientIDWithPropertyID($propertyID));
	$monthlyFee = number_format(getMonthlyFee($propertyID));
	
	/*
	{{{Property}}}
	{{{Owner}}}
	{{{MonthlyFee}}}
	*/
	
	$contractContentEnglish = str_replace('{{{Property}}}', $propertyName, $contractContentEnglish);
	$contractContentEnglish = str_replace('{{{Owner}}}', $clientName, $contractContentEnglish);
	$contractContentEnglish = str_replace('{{{MonthlyFee}}}', $monthlyFee, $contractContentEnglish);
	
	$contractContentJapanese = str_replace('{{{Property}}}', $propertyName, $contractContentJapanese);
	$contractContentJapanese = str_replace('{{{Owner}}}', $clientName, $contractContentJapanese);
	$contractContentJapanese = str_replace('{{{MonthlyFee}}}', $monthlyFee, $contractContentJapanese);
	
	echo '<div style="text-align:center;">';
	
		if (!userHasSignedContract($contractID, $propertyID, $_SESSION['userID'])) {
			echo '<form method="post" action="' . languageUrlPrefix() . 'contracts/sign/' . $propertyID . '/">';
			echo '<input type="hidden" name="contractID" value="' . $contractID . '">';
			echo '<input type="hidden" name="propertyID" value="' . $propertyID . '">';
		}
		
		echo '<table style="margin:5px 0px 5px 0px;width:100%;background-color:#fff;font-family:verdana;font-size:10px;">';
		
			echo '<tr>';
				echo '<td class="fieldLabelLeft" colspan="3">';
					echo '<h3 style="margin:0px;">';
						if ($_SESSION['lang'] == 'ja') { echo $contractTitleJapanese; } else { echo $contractTitleEnglish; }
					echo '</h3>';
				echo '</td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td class="borderAlignLeft" colspan="3">';
					if ($_SESSION['lang'] == 'ja') { echo $contractContentJapanese; } else { echo $contractContentEnglish; }
				echo '</td>';
			echo '</tr>';

			$querySignatures = "SELECT * FROM contract_signature WHERE contractID = '$contractID' ORDER BY signatureDateTime ASC";
			$resultSignatures = mysql_query($querySignatures);
			while ($rowSignaturees = mysql_fetch_array($resultSignatures)) {
			
				echo '<tr>';
					echo '<td class="borderAlignLeft" colspan="3">';
						echo '<i>Signed by</i> "' . $rowSignaturees['signatureNameSigned'] . '"';
						echo ' (' . getUserName($rowSignaturees['userID']) . ' | ' . $rowSignaturees['signatureDateTime'] . ' | ' . $rowSignaturees['signatureIPAddress'] . ')';
					echo '</td>';
				echo '</tr>';
			
			}
			

			
			
			// ALLOW USER TO SIGN IF HAS NOT YET SIGNED
			
			if (!userHasSignedContract($contractID, $propertyID, $_SESSION['userID'])) {
			
				echo '<tr>';
					echo '<td class="borderAlignLeft" colspan="3">';
						if ($_SESSION['lang'] == 'ja') {
							echo 'By entering your full name and clicking the Agree button, you confirm that you have read, understood and agree to the terms and conditions listed above.';
						} else {
							echo 'By entering your full name and clicking the Agree button, you confirm that you have read, understood and agree to the terms and conditions listed above.';
						}
					echo '</td>';
				echo '</tr>';
			
				echo '<tr>';
					echo '<td class="borderAlignCenter">';
						echo agileResource('yourFullName');
					echo '</td>';
					echo '<td class="borderAlignCenter">';
						echo '<input type="text" name="signature" value="">';
						echo '<input type="submit" name="submit" value="' . agileResource('signContract') . '">';
					echo '</td>';
					echo '<td class="borderAlignCenter">';
						echo $_SERVER['REMOTE_ADDR'];
					echo '</td>';
				echo '</tr>';
			
			}
			
		echo '</table>';
		if (!userHasSignedContract($contractID, $propertyID, $_SESSION['userID'])) { echo '</form>'; }
	echo '</div>';

}

function saveContractSignature($contractID, $propertyID, $signatureNameSigned) {

	$userID = $_SESSION['userID'];
	$signatureDateTime = date('Y-m-d H:i:s');
	$signatureIPAddress = $_SERVER['REMOTE_ADDR'];
		
	$query = "INSERT INTO contract_signature (
		contractID,
		propertyID,
		userID,
		signatureDateTime, 
		signatureIPAddress, 
		signatureNameSigned
	) VALUES (
		'$contractID', 
		'$propertyID', 
		'$userID', 
		'$signatureDateTime', 
		'$signatureIPAddress', 
		'$signatureNameSigned'
	)";
	
	mysql_query ($query) or die ('Could not save signature via saveContractSignature()');
	postToAuditTrail($userID, 'signedContract', 'successful', '', $signatureNameSigned, 'contract_signature', $contractID, '');

}

function userHasSignedContract($contractID, $propertyID, $userID) {
	$query = "SELECT * FROM contract_signature WHERE contractID = '$contractID' AND propertyID = '$propertyID' AND userID = '$userID' LIMIT 1";
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 1) { return true; } else { return false; }
}

function displayContractDropdown($contractID) {

	$siteID = $_SESSION['siteID'];
	
	echo '<select name="contractID">';
		echo '<option value="0">' . agileResource('selectContract') . '</option>';
		
		$query = "SELECT * FROM contract_contract WHERE siteID = '$siteID' ORDER BY contractID ASC";
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result)) {
			echo '<option value="' . $row['contractID'] . '"';
				if ($contractID == $row['contractID']) { echo ' selected'; }
			echo '>';
				if ($_SESSION['lang'] == 'ja') { echo $row['contractTitleJapanese']; } else { echo $row['contractTitleEnglish']; }
			echo '</option>';
		}
		
	echo '</select>';

}

function getContractIdWithPropertyID($propertyID) {

	$query = "SELECT * FROM property_property WHERE propertyID = '$propertyID' LIMIT 1";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) { $contractID = $row['contractID']; }
	return $contractID;

}

?>