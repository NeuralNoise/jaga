<?php

include($_SERVER['DOCUMENT_ROOT'] . '/agileIncludes/config.php');

// ini_set('display_errors', 1);

if (isset($_GET['lang'])) { setLanguage($_GET['lang']); } else { setLanguage('en'); }
if (!is_authed()) { header("Location: /"); }
if ($_SESSION['userRoleForCurrentSite'] != 'siteManager') { header("Location: /"); }


if ($_GET['action'] == "list") {

	displayHeader();
		displayLanguageResourceLIST();
	displayFooter();
		
} elseif ($_GET['action'] == "addLanguageResource") {

	if ($_SESSION['userID'] != 2) { die('Only network administrators can add language resource keys.'); }

	if (!isset($_POST['submit'])) {
		displayHeader();
			displayLanguageResourceCRUD('create');
		displayFooter();
	} else {
		
		$languageResourceID = mysql_real_escape_string($_POST['languageResourceID']);
		$languageResourceEnglish = mysql_real_escape_string($_POST['languageResourceEnglish']);
		$languageResourceJapanese = mysql_real_escape_string($_POST['languageResourceJapanese']);
		
		$queryInsertLanguageResource = "
			INSERT INTO nisekocms_resource (resourceID, resourceEnglish, resourceJapanese)
			VALUES ('$languageResourceID', '$languageResourceEnglish','$languageResourceJapanese')
		";

		mysql_query($queryInsertLanguageResource) or die ('Could not addLanguageResource.');
		
		$forwardUrl = '/' . languageUrlPrefix() . 'resource/#' . $languageResourceID;
		header("Location: $forwardUrl");
		
	}

} elseif ($_GET['action'] == "updateLanguageResource") {
	
	if ($_SESSION['userID'] != 2) { die('Only network administrators can update language resource keys.'); }
	
	$languageResourceID = mysql_real_escape_string(urldecode($_GET['languageResourceID']));

		

	if (!isset($_POST['submit'])) {

		$languageResourceEnglish = agileResource($languageResourceID, 'en');
		$languageResourceJapanese = agileResource($languageResourceID, 'ja');
		
		displayHeader();
			displayLanguageResourceCRUD('update', $languageResourceID, $languageResourceEnglish, $languageResourceJapanese);
		displayFooter();
		
	} else {
	
		if ($languageResourceID != $_POST['languageResourceID']) { die('get and post do not match'); }
		
		$languageResourceEnglish = mysql_real_escape_string($_POST['languageResourceEnglish']);
		$languageResourceJapanese = mysql_real_escape_string($_POST['languageResourceJapanese']);
		
		$queryUpdateLanguageResource = "
			UPDATE  nisekocms_resource SET
				resourceEnglish = '$languageResourceEnglish',
				resourceJapanese = '$languageResourceJapanese'
			WHERE resourceID = '$languageResourceID' LIMIT 1
		";
		
		// echo $queryUpdateLanguageResource;

		mysql_query($queryUpdateLanguageResource) or die ('Could not updateLanguageResource.');
		
		$forwardUrl = '/' . languageUrlPrefix() . 'resource/#' . $languageResourceID;
		header("Location: $forwardUrl");
		
	}

} elseif ($_GET['action'] == "createException") {

	if (!isset($_POST['submit'])) {
		
		$resourceID = mysql_real_escape_string(urldecode($_GET['resourceID']));
		
		$queryGetDefaultValues = "SELECT resourceEnglish, resourceJapanese FROM nisekocms_resource WHERE resourceID = '$resourceID' LIMIT 1";
		$resultGetDefaultValues = mysql_query($queryGetDefaultValues);
		while ($rowGetDefaultValues = mysql_fetch_array($resultGetDefaultValues)) {
			$resourceExceptionEnglish = $rowGetDefaultValues['resourceEnglish'];
			$resourceExceptionJapanese = $rowGetDefaultValues['resourceJapanese'];
		}
		
		displayHeader();
		
			echo '<div style="text-align:center;">';
		
				echo '<form method="post" action="' . languageUrlPrefix() . '"language-exception/create/' . $resourceID . '/">';
				echo '<table style="margin:5px auto 5px auto;background-color:#fff;font-family:verdana;font-size:10px;">';
					echo '<input type="hidden" name="resourceID" value="' . $resourceID . '">';
					echo '<tr>';
						echo '<td class="borderAlignCenter">' . agileResource('resourceID') . '</td>';
						echo '<td class="borderAlignCenter">' . agileResource('resourceExceptionEnglish') . '</td>';
						echo '<td class="borderAlignCenter">' . agileResource('resourceExceptionJapanese') . '</td>';
						echo '<td class="borderAlignCenter">' . agileResource('action') . '</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td class="borderAlignCenter">' . $resourceID . '</td>';
						echo '<td class="borderAlignCenter"><input type="text" name="resourceExceptionEnglish" value="' . $resourceExceptionEnglish . '"></td>';
						echo '<td class="borderAlignCenter"><input type="text" name="resourceExceptionJapanese" value="' . $resourceExceptionJapanese . '"></td>';
						echo '<td class="borderAlignCenter"><input type="submit" name="submit" value="' . agileResource('createResourceException') . '"></td>';
					echo '</tr>';
				echo '</table>';
				echo '</form>';
		
		displayFooter();
		
	} elseif (isset($_POST['submit'])) {
	
		$resourceID = mysql_real_escape_string($_POST['resourceID']);
		$siteID = $_SESSION['siteID'];
		$resourceExceptionEnglish = mysql_real_escape_string($_POST['resourceExceptionEnglish']);
		$resourceExceptionJapanese = mysql_real_escape_string($_POST['resourceExceptionJapanese']);
		
		$queryInsertResourceException = "INSERT INTO nisekocms_resourceException (resourceID, siteID, resourceExceptionEnglish, resourceExceptionJapanese) VALUES ('$resourceID', '$siteID', '$resourceExceptionEnglish', '$resourceExceptionJapanese')";
		mysql_query($queryInsertResourceException) or die ('Could not create resourceException.');
		
		$forwardUrl = '/' . languageUrlPrefix() . 'resource/#' . $resourceID;
		header("Location: $forwardUrl");
	
	}

} elseif ($_GET['action'] == "updateException") {

	
	
	if (!isset($_POST['submit'])) {
		
		$resourceID = mysql_real_escape_string(urldecode($_GET['resourceID']));
		
		$queryGetDefaultValues = "SELECT resourceExceptionEnglish, resourceExceptionJapanese FROM nisekocms_resourceException WHERE resourceID = '$resourceID' LIMIT 1";
		$resultGetDefaultValues = mysql_query($queryGetDefaultValues);
		while ($rowGetDefaultValues = mysql_fetch_array($resultGetDefaultValues)) {
			$resourceExceptionEnglish = $rowGetDefaultValues['resourceExceptionEnglish'];
			$resourceExceptionJapanese = $rowGetDefaultValues['resourceExceptionJapanese'];
		}
		
		displayHeader();
		
			echo '<form method="post" action="' . languageUrlPrefix() . '"language-exception/create/' . $resourceID . '/">';
				echo '<table style="margin:5px auto 5px auto;background-color:#fff;font-family:verdana;font-size:10px;">';
					echo '<input type="hidden" name="resourceID" value="' . $resourceID . '">';
					echo '<tr>';
						echo '<td class="borderAlignCenter">' . agileResource('resourceID') . '</td>';
						echo '<td class="borderAlignCenter">' . agileResource('resourceExceptionEnglish') . '</td>';
						echo '<td class="borderAlignCenter">' . agileResource('resourceExceptionJapanese') . '</td>';
						echo '<td class="borderAlignCenter">' . agileResource('action') . '</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td class="borderAlignCenter">' . $resourceID . '</td>';
						echo '<td class="borderAlignCenter"><input type="text" name="resourceExceptionEnglish" value="' . $resourceExceptionEnglish . '"></td>';
						echo '<td class="borderAlignCenter"><input type="text" name="resourceExceptionJapanese" value="' . $resourceExceptionJapanese . '"></td>';
						echo '<td class="borderAlignCenter"><input type="submit" name="submit" value="' . agileResource('updateResourceException') . '"></td>';
					echo '</tr>';
				echo '</table>';
				echo '</form>';
		
		displayFooter();
		
	} elseif (isset($_POST['submit'])) {
	
		$resourceID = mysql_real_escape_string($_POST['resourceID']);
		$siteID = $_SESSION['siteID'];
		$resourceExceptionEnglish = mysql_real_escape_string($_POST['resourceExceptionEnglish']);
		$resourceExceptionJapanese = mysql_real_escape_string($_POST['resourceExceptionJapanese']);
		
		$queryUpdateResourceException = "
		UPDATE nisekocms_resourceException SET 
			resourceExceptionEnglish = '$resourceExceptionEnglish', 
			resourceExceptionJapanese = '$resourceExceptionJapanese'
		WHERE resourceID = '$resourceID' AND siteID = '$siteID' LIMIT 1";
		mysql_query($queryUpdateResourceException) or die ('Could not update resourceException.');
		
		$forwardUrl = '/' . languageUrlPrefix() . 'resource/#' . $resourceID;
		header("Location: $forwardUrl");
	
	}

}



?>