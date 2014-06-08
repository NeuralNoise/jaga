<?php

	/*
	function getSiteID() {
		$siteFile = "siteID.txt";
		$siteFileContents = fopen($siteFile, 'r');
		$siteID = fread($siteFileContents, 8);
		fclose($siteFileContents);
		return $siteID;
	}
	*/

	function getSiteID() {
		$siteID = 0;
		$httpHost = $_SERVER['HTTP_HOST'];
		$url = preg_replace('/^www./', '', $httpHost);
		$siteURL = 'http://' . $url;
		$resultGetSiteID = mysql_query("SELECT * FROM nisekocms_site WHERE siteUrlEnglish = '$siteURL' LIMIT 1");
		while($rowGetSiteID = mysql_fetch_array($resultGetSiteID)) { $siteID = $rowGetSiteID['siteID']; }
		return $siteID;
	}
	
	function getSiteURL() {
		$siteID = $_SESSION['siteID'];
		$resultGetSiteURL = mysql_query("SELECT * FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetSiteURL = mysql_fetch_array($resultGetSiteURL)) {
			if ($_SESSION['lang'] == 'ja') {
				return $rowGetSiteURL['siteUrlJapanese'];
			} else {
				return $rowGetSiteURL['siteUrlEnglish'];
			}
		}
	}
	
	
function getCurrencySymbol() {

	$currencySymbol = '';
	$siteID = $_SESSION['siteID'];
	$resultGetSiteCurrency = mysql_query("SELECT iso4217 FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
	while($rowGetSiteCurrency = mysql_fetch_array($resultGetSiteCurrency)) {
		if ($rowGetSiteCurrency['iso4217'] == 'JPY') {
			$currencySymbol = '&yen;';
		} elseif ($rowGetSiteCurrency['iso4217'] == 'USD') {
			$currencySymbol = '&dollar;';
		}
	}
	return $currencySymbol;

}
	
	
function getSiteGoogleSiteVerification($siteID) {
	$resultGetSiteGoogleSiteVerification = mysql_query("SELECT siteGoogleSiteVerification FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
	while($rowGetSiteGoogleSiteVerification = mysql_fetch_array($resultGetSiteGoogleSiteVerification)) {
		return $rowGetSiteGoogleSiteVerification['siteGoogleSiteVerification'];
	}	
}
	
	
	
	
	
	
	
	
	
	function getSiteHeadline() {
		$siteID = $_SESSION['siteID'];
		$resultGetSiteURL = mysql_query("SELECT * FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetSiteURL = mysql_fetch_array($resultGetSiteURL)) {
			if ($_SESSION['lang'] == 'ja') {
				return $rowGetSiteURL['siteHeadlineJapanese'];
			} else {
				return $rowGetSiteURL['siteHeadlineEnglish'];
			}
		}
	}
	
	/*
	function getSiteTagline() {
		$siteID = $_SESSION['siteID'];
		$resultGetSiteURL = mysql_query("SELECT * FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetSiteURL = mysql_fetch_array($resultGetSiteURL)) {
			if ($_SESSION['lang'] == 'ja') {
				return $rowGetSiteURL['siteTagLineJapanese'];
			} else {
				return $rowGetSiteURL['siteTagLineEnglish'];
			}
		}
	}
	*/
	
	
	
	
	
	
	
	
	
	function getSiteAutomatedEmailAddress() {
		$siteID = $_SESSION['siteID'];
		$resultGetSiteAutomatedEmailAddress = mysql_query("SELECT siteAutomatedEmailAddress FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetSiteAutomatedEmailAddress = mysql_fetch_array($resultGetSiteAutomatedEmailAddress)) {
			return $rowGetSiteAutomatedEmailAddress['siteAutomatedEmailAddress'];
		}
	}
	
	function getSiteTitle() {
		$siteID = $_SESSION['siteID'];
		$resultGetSiteTitle = mysql_query("SELECT * FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetSiteTitle = mysql_fetch_array($resultGetSiteTitle)) {
			if ($_SESSION['lang'] == 'ja') {
				return $rowGetSiteTitle['siteTitleJapanese'];
			} else {
				return $rowGetSiteTitle['siteTitleEnglish'];
			}
		}
	}
	
	function getSiteGoogleAdSenseID() {
		$siteID = $_SESSION['siteID'];
		$resultGetSiteGoogleAdSenseID = mysql_query("SELECT siteGoogleAdSenseID FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetSiteGoogleAdSenseID = mysql_fetch_array($resultGetSiteGoogleAdSenseID)) {
			return $rowGetSiteGoogleAdSenseID['siteGoogleAdSenseID'];
		}
	}
	
	function getSiteTitleWithID($siteID) {
		$resultGetSiteTitle = mysql_query("SELECT * FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetSiteTitle = mysql_fetch_array($resultGetSiteTitle)) {
			if ($_SESSION['lang'] == 'ja') {
				return $rowGetSiteTitle['siteTitleJapanese'];
			} else {
				return $rowGetSiteTitle['siteTitleEnglish'];
			}
		}
	}
	
	function getSiteURLWithID($siteID) {
		$siteURL = '';
		$resultGetSiteURL = mysql_query("SELECT siteUrlEnglish FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetSiteURL = mysql_fetch_array($resultGetSiteURL)) { $siteURL = $rowGetSiteURL['siteUrlEnglish']; }
		return $siteURL;
	}
	
	function getSiteTagLine() {
		$siteID = $_SESSION['siteID'];
		$resultGetSiteTagLine = mysql_query("SELECT * FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetSiteTagLine = mysql_fetch_array($resultGetSiteTagLine)) {
			if ($_SESSION['lang'] == 'ja') {
				return $rowGetSiteTagLine['siteTagLineJapanese'];
			} else {
				return $rowGetSiteTagLine['siteTagLineEnglish'];
			}
		}
	}
	
	function getSiteKeywords() {
		$siteID = $_SESSION['siteID'];
		$resultGetSiteKeywords = mysql_query("SELECT * FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetSiteKeywords = mysql_fetch_array($resultGetSiteKeywords)) {
			if ($_SESSION['lang'] == 'ja') {
				return $rowGetSiteKeywords['siteKeywordsJapanese'];
			} else {
				return $rowGetSiteKeywords['siteKeywordsEnglish'];
			}
		}
	}
	
	function getSiteDescription() {
		$siteID = $_SESSION['siteID'];
		$resultGetSiteDescription = mysql_query("SELECT * FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetSiteDescription = mysql_fetch_array($resultGetSiteDescription)) {
			if ($_SESSION['lang'] == 'ja') {
				return $rowGetSiteDescription['siteDescriptionJapanese'];
			} else {
				return $rowGetSiteDescription['siteDescriptionEnglish'];
			}
		}
	}
	
	function getSiteIntro() {
		$siteID = $_SESSION['siteID'];
		$resultGetSiteIntro = mysql_query("SELECT * FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetSiteIntro = mysql_fetch_array($resultGetSiteIntro)) {
			if ($_SESSION['lang'] == 'ja') {
				return $rowGetSiteIntro['siteIntroJapanese'];
			} else {
				return $rowGetSiteIntro['siteIntroEnglish'];
			}
		}
	}
	
	function getSiteAnalytics() {
		$siteID = $_SESSION['siteID'];
		$resultGetSiteAnalytics = mysql_query("SELECT * FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetSiteAnalytics = mysql_fetch_array($resultGetSiteAnalytics)) {
			return $rowGetSiteAnalytics['siteGoogleAnalyticsID'];
		}
	}
	
	function getSiteTwitter() {
		$siteID = $_SESSION['siteID'];
		$resultGetSiteTwitter = mysql_query("SELECT * FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetSiteTwitter = mysql_fetch_array($resultGetSiteTwitter)) {
			return $rowGetSiteTwitter['siteTwitter'];
		}
	}

	function getSiteTwitterWithSiteID($siteID) {
		$resultGetSiteTwitter = mysql_query("SELECT * FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetSiteTwitter = mysql_fetch_array($resultGetSiteTwitter)) {
			return $rowGetSiteTwitter['siteTwitter'];
		}
	}
	
	function getSiteTheme() {
		$siteID = $_SESSION['siteID'];
		$resultGetSiteTheme = mysql_query("SELECT siteTheme FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetSiteTheme = mysql_fetch_array($resultGetSiteTheme)) {
			return $rowGetSiteTheme['siteTheme'];
		}
	}
	
	function getSiteDefaultContentCategory() {
		$siteID = $_SESSION['siteID'];
		$resultGetSiteDefaultContentCategory = mysql_query("SELECT siteContentCategoryID FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetSiteDefaultContentCategory = mysql_fetch_array($resultGetSiteDefaultContentCategory)) {
			return $rowGetSiteDefaultContentCategory['siteContentCategoryID'];
		}
	}
	
	function getSiteDefaultContentSection() {
		$siteID = $_SESSION['siteID'];
		$resultGetSiteDefaultContentSection = mysql_query("SELECT siteContentSectionID FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetSiteDefaultContentSection = mysql_fetch_array($resultGetSiteDefaultContentSection)) {
			return $rowGetSiteDefaultContentSection['siteContentSectionID'];
		}
	}
	
	function recordSiteStatistics() {

		$siteID = $_SESSION['siteID'];
		if (isset($_SESSION['userID'])) { $userID = $_SESSION['userID']; } else { $userID = 0; }
		$pageLocation = $_SERVER['PHP_SELF'];
		$pageServedDateTime = date('Y-m-d H:i:s');
		$httpUserAgent = $_SERVER['HTTP_USER_AGENT'];
		$httpReferer = $_SERVER['HTTP_REFERER'];
		$remoteAddr = $_SERVER['REMOTE_ADDR'];
		
		$queryRecordSiteStatistics = "INSERT INTO trafficStatistics (
			siteID,
			userID,
			pageLocation,
			pageServedDateTime,
			httpUserAgent,
			httpReferer,
			remoteAddr
			) VALUES (
			'$siteID',
			'$userID',
			'$pageLocation',
			'$pageServedDateTime',
			'$httpUserAgent',
			'$httpReferer',
			'$remoteAddr'
		)";

		
		// echo $queryRecordSiteStatistics;
		mysql_query ($queryRecordSiteStatistics) or die ('Error in queryRecordSiteStatistics()');


}
	
	function siteIsPublic() {
		$siteID = $_SESSION['siteID'];
		$resultIsSitePublic = mysql_query("SELECT siteIsPublic FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowIsSitePublic = mysql_fetch_array($resultIsSitePublic)) {
			if ($rowIsSitePublic['siteIsPublic'] == 1) {
				return true;
			} else {
				return false;
			};
		}
	}

	
function getSiteContactFormToAddress($siteID) {
	$query = "SELECT siteContactFormToAddress FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result)) { $siteContactFormToAddress = $row['siteContactFormToAddress']; }
	return $siteContactFormToAddress;
}

function getSitePrimaryColor($siteID) {
	$query = "SELECT sitePrimaryColor FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result)) { $sitePrimaryColor = $row['sitePrimaryColor']; }
	return $sitePrimaryColor;
}

function getSiteSecondaryColor($siteID) {
	$query = "SELECT siteSecondaryColor FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result)) { $siteSecondaryColor = $row['siteSecondaryColor']; }
	return $siteSecondaryColor;
}

function getSiteBackgroundColor($siteID) {
	$query = "SELECT siteBackgroundColor FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result)) { $siteBackgroundColor = $row['siteBackgroundColor']; }
	return $siteBackgroundColor;
}
	
	
?>