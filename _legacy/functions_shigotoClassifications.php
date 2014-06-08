<?php

function displayShigotoClassificationList() {
	
	// $query = "SELECT * FROM shigoto_classification WHERE siteID = '$_SESSION[siteID]' ORDER BY classificationDisplayOrder ASC";
	$query = "SELECT * FROM shigoto_classification WHERE (siteID = '0' OR siteID = '$_SESSION[siteID]') ORDER BY classificationDisplayOrder ASC";
	// "granddaddy" and give all sites access to classifications with no siteID.
	$result = mysql_query($query);
	
	echo '<table style="margin:5px auto 5px auto;background-color:#fff;font-family:verdana;font-size:10px;">';
	
		echo '<tr>';
			echo '<td class="fieldLabelLeft" colspan="6">';
				echo '<input type="button" value="' . agileResource('addClassification') . '" onclick="window.location.href=\'' . languageUrlPrefix() . 'shigoto-classifications/create/\'">';
			echo '</td>';
		echo '</tr>';
	
		echo '<tr>';
			echo '<td class="fieldLabelCenter">' . agileResource('classificationID') . '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('siteID') . '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('classification') . '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('group') . '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('classificationDisplayOrder') . '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('action') . '</td>';
		echo '</tr>';
	
	while ($row = mysql_fetch_array($result)) {
		echo '<tr>';
			echo '<td class="borderAlignCenter">' . $row['classificationID'] . '</td>';
			echo '<td class="borderAlignCenter">' . $row['siteID'] . '</td>';
			echo '<td class="borderAlignCenter">' . getShigotoClassificationNameWithID($row['classificationID']) . '</td>';
			echo '<td class="borderAlignCenter">' . getGroupName($row['groupID']) . '</td>';
			echo '<td class="borderAlignCenter">' . $row['classificationDisplayOrder'] . '</td>';
			echo '<td class="borderAlignCenter">';
			
				if ($row['siteID'] != 0 && $row['siteID'] == $_SESSION['siteID']) {
					echo '<input type="button" value="' . agileResource('updateClassification') . '" onclick="window.location.href=\'' . languageUrlPrefix() . 'shigoto-classifications/update/' . $row['classificationID'] . '/\'">';
				}


			echo '</td>';
		echo '</tr>';
	}
	echo '</table>';

}

function displayShigotoClassificationCrud($type = 'create', $classificationID = 0, $classificationEnglish = '', $classificationJapanese = '', $classificationDisplayOrder = 0) {

	if ($type == 'create') {
		$formActionUrl = languageUrlPrefix() . 'shigoto-classifications/create/';
		$formButtonValue = 'createClassification';
	} elseif ($type == 'update') {
		$formActionUrl = languageUrlPrefix() . 'shigoto-classifications/update/' . $classificationID . '/';
		$formButtonValue = 'updateClassification';
	}

	echo '<form action="' . $formActionUrl. '" method="post">';
		if ($type == 'update') { echo '<input type="hidden" name="transactionID" value="' . $classificationID . '">'; }
		echo '<table style="border-style:none;background-color:#fff;margin:5px auto 5px auto;font-family:verdana;font-size:10px;">';

			echo '<tr>';
				echo '<td class="borderAlignLeft">' . agileResource('classificationEnglish') . '</td>';
				echo '<td class="borderAlignCenter"><input type="text" name="classificationEnglish" value="' . $classificationEnglish . '"></td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td class="borderAlignLeft">' . agileResource('classificationJapanese') . '</td>';
				echo '<td class="borderAlignCenter"><input type="text" name="classificationJapanese" value="' . $classificationJapanese . '"></td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td class="borderAlignLeft">' . agileResource('classificationDisplayOrder') . '</td>';
				echo '<td class="borderAlignCenter">';
					echo '<select name="classificationDisplayOrder">';
						$displayOrderDropdownCount = 0;
						while ($displayOrderDropdownCount <= 100) {
							echo '<option value="' . $displayOrderDropdownCount . '"';
								if ($classificationDisplayOrder == $displayOrderDropdownCount) { echo ' selected'; }
							echo '>' . $displayOrderDropdownCount . '</option>';
							$displayOrderDropdownCount += 1;
						}
					echo '</select>';
				echo '</td>';
			echo '</tr>';
		
			echo '<tr>';
				echo '<td class="borderAlignRight" colspan="2"><input type="submit" name="submit" value="' . agileResource($formButtonValue) . '"></td>';
			echo '</tr>';
		
		echo '</table>';
	echo '</form>';

}

function insertShigotoClassification($classificationEnglish, $classificationJapanese, $classificationDisplayOrder) {

		$siteID = $_SESSION['siteID'];

		$query = "INSERT INTO shigoto_classification (
			siteID,
			classificationEnglish,
			classificationJapanese, 
			classificationDisplayOrder
		) VALUES (
			'$siteID',
			'$classificationEnglish',
			'$classificationJapanese',
			'$classificationDisplayOrder'
		)";

		mysql_query ($query) or die ('Could not insert classification. insertShigotoClassification() failed. Please notify support.');

}

function updateShigotoClassification($classificationID, $classificationEnglish, $classificationJapanese, $classificationDisplayOrder) {

	$query = "UPDATE shigoto_classification SET
			classificationEnglish = '$classificationEnglish',
			classificationJapanese = '$classificationJapanese',
			classificationDisplayOrder = '$classificationDisplayOrder'
			WHERE classificationID = '$classificationID' LIMIT 1";
	mysql_query($query) or die ('Could not update classification. updateShigotoClassification() failed. Please notify support.');

}

function classificationIsForCurrentSite($classificationID) {
	$query = "SELECT siteID FROM shigoto_classification WHERE classificationID = '$classificationID' LIMIT 1";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		if ($row['siteID'] == $_SESSION['siteID']) { return true; } else { return false; }
	}
}

function getShigotoClassificationEnglish($classificationID) {
	$classificationEnglish = '';
	$query = "SELECT classificationEnglish FROM shigoto_classification WHERE classificationID = '$classificationID' LIMIT 1";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) { $classificationEnglish = $row['classificationEnglish']; }
	return $classificationEnglish;
}

function getShigotoClassificationJapanese($classificationID) {
	$classificationJapanese = '';
	$query = "SELECT classificationJapanese FROM shigoto_classification WHERE classificationID = '$classificationID' LIMIT 1";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) { $classificationJapanese = $row['classificationJapanese']; }
	return $classificationJapanese;
}

function getShigotoClassificationNameWithID($classificationID) {
	
	$classificationName = '';
	$query = "SELECT * FROM shigoto_classification WHERE classificationID = '$classificationID' LIMIT 1";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		if ($_SESSION['lang'] == 'ja') {
			$classificationName = $row['classificationJapanese'];
		} else {
			$classificationName = $row['classificationEnglish'];
		}
	}
	return $classificationName;
	
}

function getShigotoClassificationDisplayOrder($classificationID) {
	$classificationDisplayOrder = 0;
	$query = "SELECT classificationDisplayOrder FROM shigoto_classification WHERE classificationID = '$classificationID' LIMIT 1";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) { $classificationDisplayOrder = $row['classificationDisplayOrder']; }
	return $classificationDisplayOrder;
}


?>