<?php

/* ------- GET Date & TIME ------- */

function getDateAndTimeThisLanguage () {
	if ($_SESSION['lang'] == 'ja') {
		echo date('Y年m月d日 H:i:s');
	} else {
		echo date('F jS, Y g:i:sa');
	}
}


function formatDateAndTime($dateAndTime) { // use unix time
	if ($_SESSION['lang'] == 'ja') {
		return date('Y年m月d日 H:i', $dateAndTime);
	} else {
		return date('F jS, Y g:ia', $dateAndTime);
	}
}

function getTimeFromTimestamp($dateAndTime) { // use unix time
	if ($_SESSION['lang'] == 'ja') {
		return date('H:i', $dateAndTime);
	} else {
		return date('g:ia', $dateAndTime);
	}
}

/* ------- CHANGE LANGUAGE ------- */

function changeLanguage ($lang)
{
	if ($lang == 'en') {
		$_SESSION['lang'] = 'en';
	} elseif ($lang == 'ja') {
		$_SESSION['lang'] = 'ja';
	} else {
		$_SESSION['lang'] = 'en';
	}
}

/* ------- GET USER PERSON NAME ------- */

function getUserActualNameThisLanguage() {

	if ($_SESSION['lang'] == 'ja') {
		$resultGetUserName = mysql_query("SELECT name FROM j00mla_ver4_users WHERE id = '$_SESSION[userID]' LIMIT 1");
		while($rowGetUserName = mysql_fetch_array($resultGetUserName)) {
			$userName = $rowGetUserName['name'];
		}
	} else {
		$resultGetUserName = mysql_query("SELECT name FROM j00mla_ver4_users WHERE id = '$_SESSION[userID]' LIMIT 1");
		while($rowGetUserName = mysql_fetch_array($resultGetUserName)) {
			$userName = $rowGetUserName['name'];
		}
	}
	
	return $userName;

	
}


/* ------- GET USER PERSON NAME ------- */

function getSnowLocationName($snowLocationID) {

	$resultGetSnowLocationName = mysql_query("SELECT * FROM snowLocation WHERE snowLocationID = '$snowLocationID' LIMIT 1");

	if ($_SESSION['lang'] == 'ja') {
		while($rowGetSnowLocationName = mysql_fetch_array($resultGetSnowLocationName)) {
			$snowLocationName = $rowGetSnowLocationName['snowLocationJapanese'];
		}
	} else {
		while($rowGetSnowLocationName = mysql_fetch_array($resultGetSnowLocationName)) {
			$snowLocationName = $rowGetSnowLocationName['snowLocationEnglish'];
		}
	}
	
	return $snowLocationName;
	
}


?>