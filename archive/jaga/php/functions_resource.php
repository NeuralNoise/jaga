<?php

function agileResource($keyword, $lang = '') {

	$siteID = $_SESSION['siteID'];
	if ($lang == '') { $lang = $_SESSION['lang']; }

	if ($lang == 'ja') {
		$queryAddOneToResourceCount = "UPDATE nisekocms_resource SET resourceJapaneseCount = resourceJapaneseCount + 1 WHERE resourceID = '$keyword'";
	} else {
		$queryAddOneToResourceCount = "UPDATE nisekocms_resource SET resourceEnglishCount = resourceEnglishCount + 1 WHERE resourceID = '$keyword'";
	}
	mysql_query($queryAddOneToResourceCount) or die (agileResource('errorInAgileResource'));

	if ($lang == 'ja') {
	
		// keyword exsists once in resource
		$resultGetResource = mysql_query("SELECT resourceJapanese FROM nisekocms_resource WHERE resourceID = '$keyword' LIMIT 1");
		if (mysql_num_rows($resultGetResource) == 1) { 
		
			// is there an exception for this keyword on this site
			$queryCheckForException = "SELECT * FROM nisekocms_resourceException WHERE resourceID = '$keyword' AND siteID = '$siteID' LIMIT 1";
			$resultCheckForException = mysql_query($queryCheckForException);
			if (mysql_num_rows($resultCheckForException) == 1) { 
				// yes: use exception
				while($rowCheckForException = mysql_fetch_array($resultCheckForException)) { $languageResource = $rowCheckForException['resourceExceptionJapanese']; }
			} else { 
				// no: use keyword in resource
				while($rowGetResource = mysql_fetch_array($resultGetResource)) { $languageResource = $rowGetResource['resourceJapanese']; }
			
			}
			
		} else {
			 $languageResource = $keyword;
		}
		
		
	} else {
	
		// keyword exsists once in resource
		$resultGetResource = mysql_query("SELECT resourceEnglish FROM nisekocms_resource WHERE resourceID = '$keyword' LIMIT 1");
		if (mysql_num_rows($resultGetResource) == 1) { 
		
			// is there an exception for this keyword on this site
			$queryCheckForException = "SELECT * FROM nisekocms_resourceException WHERE resourceID = '$keyword' AND siteID = '$siteID' LIMIT 1";
			$resultCheckForException = mysql_query($queryCheckForException);
			if (mysql_num_rows($resultCheckForException) == 1) { 
				// yes: use exception
				while($rowCheckForException = mysql_fetch_array($resultCheckForException)) { $languageResource = $rowCheckForException['resourceExceptionEnglish']; }
			} else { 
				// no: use keyword in resource
				while($rowGetResource = mysql_fetch_array($resultGetResource)) { $languageResource = $rowGetResource['resourceEnglish']; }
			
			}
			
		} else {
			 $languageResource = $keyword;
		}
		
	}
	
	return $languageResource;
	
}

function languageUrlPrefix() {
	if ($_SESSION['lang'] == 'en') {
		$languageUrlPrefix = '';
	} else {
		$languageUrlPrefix = $_SESSION['lang'] . '/';
	}
	return $languageUrlPrefix;
}

function getCityName($cityID) {
	$query = "SELECT * FROM nisekocms_geographyCity WHERE cityID = $cityID LIMIT 1";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) { if ($_SESSION['lang'] == 'ja') { $cityName = $row['cityNameJapanese']; } else { $cityName = $row['cityNameEnglish']; } }
	return $cityName;
}

function getStateName($stateID) {
	$query = "SELECT * FROM nisekocms_geographyState WHERE stateID = $stateID LIMIT 1";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) { if ($_SESSION['lang'] == 'ja') { $stateName = $row['stateNameJapanese']; } else { $stateName = $row['stateNameEnglish']; } }
	return $stateName;
}

function getCountryName($countryID) {
	$query = "SELECT * FROM nisekocms_geographyCountry WHERE countryID = $countryID LIMIT 1";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) { if ($_SESSION['lang'] == 'ja') { $countryName = $row['countryNameJapanese']; } else { $countryName = $row['countryNameEnglish']; } }
	return $countryName;
}

function displayGeographyWidget($countryID = 0, $stateID = 0, $cityID = 0) {


								echo '<div style="margin:0px auto 0px auto;width:312px;background-color:#fff;">';
									echo '<div id="countryDropdown" style="float:left;width:100px;height:20px;margin:1px;border:1px solid #ccc;">';
								
									echo '<select name="countryID" style="width:100px;" onchange="displayStateDropdownWithCountry(this.value)">';
									echo '<option value="0">' . agileResource('country') . '</option>';
									$resultGetCountries = mysql_query("SELECT * FROM nisekocms_geographyCountry ORDER BY countryNameEnglish ASC");
									while ($rowGetCountries = mysql_fetch_array($resultGetCountries)) {
										echo '<option value="' . $rowGetCountries['countryID'] . '"';
											if ($countryID == $rowGetCountries['countryID']) { echo ' selected'; }
										echo '>' . $rowGetCountries['countryNameEnglish'] . '</option>';
									}

									echo '</select>';
								
									echo '</div>';
							
									echo '<div id="stateDropdown" style="float:left;width:100px;height:20px;margin:1px;border:1px solid #ccc;">';
								
									if ($stateID != 0) {
										echo '<select name="stateID" style="width:100px;" onchange="displayCityDropdownWithState(this.value)">';
										echo '<option value="0">' . agileResource('state') . '</option>';
										$resultGetStates = mysql_query("SELECT * FROM nisekocms_geographyState WHERE countryID = $countryID ORDER BY stateNameEnglish ASC");
										while ($rowGetStates = mysql_fetch_array($resultGetStates)) {
											echo '<option value="' . $rowGetStates['stateID'] . '"';
												if ($stateID == $rowGetStates['stateID']) { echo ' selected'; }
											echo '>' . $rowGetStates['stateNameEnglish'] . '</option>';
										}

										echo '</select>';
									}
								
								
								
									echo '</div>';
								
									echo '<div id="cityDropdown" style="float:left;width:100px;height:20px;margin:1px;border:1px solid #ccc;">';
								
									if ($cityID != 0) {
										echo '<select name="cityID" style="width:100px;">';
										echo '<option value="0">' . agileResource('city') . '</option>';
										$resultGetCities = mysql_query("SELECT * FROM nisekocms_geographyCity WHERE countryID = $countryID AND stateID = $stateID ORDER BY cityNameEnglish ASC");
										while ($rowGetCities = mysql_fetch_array($resultGetCities)) {
											echo '<option value="' . $rowGetCities['cityID'] . '"';
												if ($cityID == $rowGetCities['cityID']) { echo ' selected'; }
											echo '>' . $rowGetCities['cityNameEnglish'] . '</option>';
										}

										echo '</select>';
									}
								
								
									echo '</div>';
								
									echo '<div style="clear:left;"></div>';
								
										echo '<div id="cityDropdown" style="float:left;width:308px;height:35px;margin:1px;border:1px solid #ccc;">';
											echo agileResource('dontSeeTheLocationYoureLookingFor') . '<br />';
											echo '<a href="' . languageUrlPrefix() . 'add-state/">' . agileResource('addState') . '</a>';
											echo '&nbsp;';
											echo '<a href="' . languageUrlPrefix() . 'add-city/">' . agileResource('addCity') . '</a>';
										echo '</div>';
								
									echo '<div style="clear:left;"></div>';
								echo '</div>';
							

}

function displayLanguageResourceLIST() {
	
	echo '<div style="text-align:center;">';
	
		echo '<table style="margin:5px auto 5px auto;background-color:#fff;font-family:verdana;font-size:10px;">';
		
			if ($_SESSION['userID'] == 2) {
				echo '<tr>';
					echo '<td class="borderAlignLeft" colspan="7">';
						echo '<a href="/' . languageUrlPrefix() . 'language-resource/create/">' . agileResource('createLanguageResource') . '</a>';
					echo '</td>';
				echo '</tr>';
			}
		
			echo '<tr>';
				echo '<td class="borderAlignCenter">ID</td>';
				echo '<td class="borderAlignCenter">' . agileResource('exception') . '</td>';
				echo '<td class="borderAlignCenter" colspan="2">English</td>';
				echo '<td class="borderAlignCenter" colspan="2">日本語</td>';
				if ($_SESSION['userID'] == 2) {
					echo '<td class="borderAlignCenter">' . agileResource('action') . '</td>';
				}
			echo '</tr>';

			$result = mysql_query("SELECT * FROM nisekocms_resource ORDER BY resourceEnglish");
			while($row = mysql_fetch_array($result)) {
				echo '<tr>';
					echo '<td class="borderAlignLeft"><a name="' . $row['resourceID'] . '">' . $row['resourceID'] . '</a></td>';
					echo '<td class="borderAlignCenter">';
					
						$queryCheckException = "SELECT * FROM nisekocms_resourceException WHERE siteID = '$_SESSION[siteID]' AND resourceID = '$row[resourceID]' LIMIT 1";
						
						$resultCheckException = mysql_query($queryCheckException);
						if (mysql_num_rows($resultCheckException) == 1) {
							echo '<a href="' . languageUrlPrefix() . 'language-exception/update/' . urlencode($row['resourceID']) . '/"><img src="agileImages/exception.png"></a>';
						} elseif (mysql_num_rows($resultCheckException) == 0) {
							echo '<a href="' . languageUrlPrefix() . 'language-exception/create/' . urlencode($row['resourceID']) . '/">' . agileResource('addResourceLanguageException') . '</a>';
						} else { echo agileResource('exceptionError'); }
					
					echo '</td>';
					echo '<td class="borderAlignRight" style="color:#f00;">' . $row['resourceEnglishCount'] . '</td>';
					echo '<td class="borderAlignLeft">' . $row['resourceEnglish'] . '</td>';
					echo '<td class="borderAlignRight" style="color:#f00;">' . $row['resourceJapaneseCount'] . '</td>';
					echo '<td class="borderAlignLeft">' . $row['resourceJapanese'] . '</td>';
					if ($_SESSION['userID'] == 2) {
						echo '<td class="borderAlignCenter">';
							echo '<a href="/' . languageUrlPrefix() . 'language-resource/update/' . $row['resourceID'] . '/">' . agileResource('update') . '</a>';
						echo '</td>';
					}
				echo '</tr>';
			}

		echo '</table>';
		
	echo '</div>';
		
}

function displayLanguageResourceCRUD($type, $languageResourceID = '', $languageResourceEnglish = '', $languageResourceJapanese = '') {
	
	if ($type != 'create' && $type != 'update') { die('$type unacceptable'); }

	echo '<div style="text-align:center;">';
		
		if ($type == 'create') {
			echo '<form method="post" action="' . languageUrlPrefix() . '"language-resource/create/">';
		} elseif ($type == 'update') {
			echo '<form method="post" action="' . languageUrlPrefix() . '"language-resource/update/' . $languageResourceID . '/">';
			echo '<input type="hidden" name="languageResourceID" value="' . $languageResourceID . '">';
		}
			echo '<table style="margin:5px auto 5px auto;background-color:#fff;font-family:verdana;font-size:10px;">';
				
				echo '<tr>';
					echo '<td class="borderAlignCenter">' . agileResource('languageResourceID') . '</td>';
					echo '<td class="borderAlignCenter">' . agileResource('languageResourceEnglish') . '</td>';
					echo '<td class="borderAlignCenter">' . agileResource('languageResourceJapanese') . '</td>';
					echo '<td class="borderAlignCenter">' . agileResource('action') . '</td>';
				
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="borderAlignCenter">';
						if ($type == 'create') {
							echo '<input type="text" name="languageResourceID" value="' . $languageResourceID . '">';
						} else { echo $languageResourceID; }
					echo '</td>';
					echo '<td class="borderAlignCenter"><input type="text" name="languageResourceEnglish" value="' . $languageResourceEnglish . '"></td>';
					echo '<td class="borderAlignCenter"><input type="text" name="languageResourceJapanese" value="' . $languageResourceJapanese . '"></td>';
					echo '<td class="borderAlignCenter"><input type="submit" name="submit" value="' . agileResource('createLanguageResource') . '"></td>';
				echo '</tr>';
				
			echo '</table>';
		echo '</form>';
	
	echo '</div>';
}

?>