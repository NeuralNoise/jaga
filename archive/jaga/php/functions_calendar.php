<?php

function displayNewCalendar(
	$selectedDate, 
	$siteID = 10
) {
	
	$selectedDateTimeStamp = strtotime($selectedDate);
	$selectedYear = date('Y', $selectedDateTimeStamp);
	$selectedMonth = date('m', $selectedDateTimeStamp);
	$selectedMonthName = date('F', $selectedDateTimeStamp);
	$selectedMonthFirstDay = date('Y-m-01', $selectedDateTimeStamp);
	$selectedMonthLastDay = date('Y-m-t', $selectedDateTimeStamp);
	$selectedMonthNumberOfDays = date('t', $selectedDateTimeStamp);
	$columnToPlaceFirstDay = date('w', strtotime($selectedMonthFirstDay));
	$numberOfDaysInFirstRow = 7 - $columnToPlaceFirstDay;
	$columnToPlaceLastDay = date('w', strtotime($selectedMonthLastDay));
	$numberOfDaysInLastRow = 1 + $columnToPlaceLastDay;
	if ($numberOfDaysInLastRow != 7) {
		$numberOfMiddleCalendarRows = ($selectedMonthNumberOfDays - $numberOfDaysInFirstRow - $numberOfDaysInLastRow) / 7;
	} else {
		$numberOfMiddleCalendarRows = ($selectedMonthNumberOfDays - $numberOfDaysInFirstRow) / 7;
	}
	
	$selectedDateMinusOneYear = date('Y-m-d' , strtotime($selectedDate . ' - 1 year'));
	$selectedDateMinusOneMonth = date('Y-m-d' , strtotime($selectedDate . ' - 1 month'));
	$selectedDateMinusOneDay = date('Y-m-d' , strtotime($selectedDate . ' - 1 day'));
	
	$selectedDatePlusOneDay = date('Y-m-d' , strtotime($selectedDate . ' + 1 day'));
	$selectedDatePlusOneMonth = date('Y-m-d' , strtotime($selectedDate . ' + 1 month'));
	$selectedDatePlusOneYear = date('Y-m-d' , strtotime($selectedDate . ' + 1 year'));
	
	$dateMarker = 1;
	
	if ($_SESSION['siteID'] != $siteID) { $siteUrl = getSiteURLWithID($siteID); } else { $siteUrl = ''; }
	// echo $siteUrl . 'ZZZ';

		echo '<table id="calendar_month">';
			echo '<tr>';
				echo '<td class="calendar_navigation" colspan="7">';
					echo '<a class="calendar_navigation_past" href="' . $siteUrl .'/' . languageUrlPrefix() . 'event-calendar/' . $selectedDateMinusOneYear . '/';
						if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
					echo '">|&#8249;&#8249;&#8249;</a> ';
					echo '<a class="calendar_navigation_past" href="' . $siteUrl .'/' . languageUrlPrefix() . 'event-calendar/' . $selectedDateMinusOneMonth . '/';
						if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
					echo '">|&#8249;&#8249;</a> ';
					echo '<a class="calendar_navigation_past" href="' . $siteUrl .'/' . languageUrlPrefix() . 'event-calendar/' . $selectedDateMinusOneDay . '/';
						if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
					echo '">|&#8249;</a> ';
					echo ' <a class="calendar_navigation_future" href="' . $siteUrl .'/' . languageUrlPrefix() . 'event-calendar/' . $selectedDatePlusOneYear . '/';
						if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
					echo '">&#8250;&#8250;&#8250;|</a>';
					echo ' <a class="calendar_navigation_future" href="' . $siteUrl .'/' . languageUrlPrefix() . 'event-calendar/' . $selectedDatePlusOneMonth . '/';
						if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
					echo '">&#8250;&#8250;|</a>';
					echo ' <a class="calendar_navigation_future" href="' . $siteUrl .'/' . languageUrlPrefix() . 'event-calendar/' . $selectedDatePlusOneDay . '/';
						if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
					echo '">&#8250;|</a>';
					echo '<h2 id="calendar_year_month">' . date('jS', $selectedDateTimeStamp) . ' ' . $selectedMonthName . ' ' . $selectedYear . '</h2>';
					echo '<div style="clear:both;">';
				echo '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<th class="calendar_dotw">' . agileResource('Sun') . '</th>';
				echo '<th class="calendar_dotw">' . agileResource('Mon') . '</th>';
				echo '<th class="calendar_dotw">' . agileResource('Tues') . '</th>';
				echo '<th class="calendar_dotw">' . agileResource('Wed') . '</th>';
				echo '<th class="calendar_dotw">' . agileResource('Thurs') . '</th>';
				echo '<th class="calendar_dotw">' . agileResource('Fri') . '</th>';
				echo '<th class="calendar_dotw">' . agileResource('Sat') . '</th>';
			echo '</tr>';
			echo '<tr>';
				// START FIRST ROW OF CALENDAR //
				for($i=0; $i<$columnToPlaceFirstDay; $i++) { echo '<td class="calendar_date_empty">&nbsp;</td>'; }
				for($i=6; $i>=$columnToPlaceFirstDay; $i=$i-1) {
				
					$twoDigitDateMarker = str_pad($dateMarker, 2, '0', STR_PAD_LEFT);
					$thisDate = $selectedYear . '-' . $selectedMonth . '-' . $twoDigitDateMarker;
					
					$numberOfEventsThisDate = getNumberOfEvents($thisDate);
					if ($selectedDate == $thisDate) { $calendarTdClass = 'calendar_date_selected';
					} elseif ($numberOfEventsThisDate > 0) { $calendarTdClass = 'calendar_date_events';
					} else { $calendarTdClass = 'calendar_date'; }
						
					echo '<td class="' . $calendarTdClass . '">';
						echo '<a href="' . $siteUrl .'/' . languageUrlPrefix() . 'event-calendar/' . $thisDate . '/';
							if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
						echo '" class="calendar_date_link">' . $dateMarker . '</a>';
					echo '</td>';
					$dateMarker = $dateMarker + 1;
					
				}
				// END FIRST ROW OF CALENDAR //
			echo '</tr>';
			
			
			// START MIDDLE ROWS OF CALENDAR //
			$rowCounter = 1;
			while ($rowCounter <= $numberOfMiddleCalendarRows) {
				echo '<tr>';
					$i=1;
					while ($i <= 7) {
						$twoDigitDateMarker = str_pad($dateMarker, 2, '0', STR_PAD_LEFT);
						$thisDate = $selectedYear . '-' . $selectedMonth . '-' . $twoDigitDateMarker;
						
						$numberOfEventsThisDate = getNumberOfEvents($thisDate);
						if ($selectedDate == $thisDate) { $calendarTdClass = 'calendar_date_selected';
						} elseif ($numberOfEventsThisDate > 0) { $calendarTdClass = 'calendar_date_events';
						} else { $calendarTdClass = 'calendar_date'; }
						
						echo '<td class="' . $calendarTdClass . '">';
							echo '<a href="' . $siteUrl .'/' . languageUrlPrefix() . 'event-calendar/' . $thisDate . '/';
								if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
							echo '" class="calendar_date_link">' . $dateMarker . '</a>';
						echo '</td>';
						$dateMarker = $dateMarker + 1;
						$i=$i+1;
					}
					$rowCounter = $rowCounter + 1;
				echo '</tr>';
			}
			// END MIDDLE ROWS OF CALENDAR //
			
			echo '<tr>';
				// START LAST ROW OF CALENDAR //
				if ($numberOfDaysInLastRow != 7) {
					$i=1;
					while ($i <= $numberOfDaysInLastRow) {
						$twoDigitDateMarker = str_pad($dateMarker, 2, '0', STR_PAD_LEFT);
						$thisDate = $selectedYear . '-' . $selectedMonth . '-' . $twoDigitDateMarker;
						
						$numberOfEventsThisDate = getNumberOfEvents($thisDate);
						if ($selectedDate == $thisDate) { $calendarTdClass = 'calendar_date_selected';
						} elseif ($numberOfEventsThisDate > 0) { $calendarTdClass = 'calendar_date_events';
						} else { $calendarTdClass = 'calendar_date'; }
						
						echo '<td class="' . $calendarTdClass . '">';
							echo '<a href="' . $siteUrl .'/' . languageUrlPrefix() . 'event-calendar/' . $thisDate . '/';
								if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
							echo '" class="calendar_date_link">' . $dateMarker . '</a>';
						echo '</td>';
						$dateMarker = $dateMarker + 1;
						$i=$i+1;
					}
					while ($i <= 7) {
						echo '<td class="calendar_date_empty">&nbsp;</td>';
						$i=$i+1;
					}
				}
				// END LAST ROW OF CALENDAR //
			echo '</tr>';
			
		echo '</table>';
	
}

function displayCalendarEntryLIST($selectedDate, $includeFollowingEvents = 0) {

	$currentDate = date('Y-m-d');
	$contentCategoryKey = 'events';
	$thisNetworkSiteArrayString = join(',', $_SESSION['networkSiteArray']);
	
	if ($includeFollowingEvents == 0) {
		$queryWhereClause = "AND eventDate = '$selectedDate'";
	} elseif ($includeFollowingEvents == 1) {
		$queryWhereClause = "AND eventDate >= '$selectedDate'";
	}
	
	// $queryNumberOfEvents = "
		// SELECT * FROM nisekocms_content 
		// WHERE entryPublished = '1' 
			// AND entryPublishStartDate <= '$currentDate' 
			// AND (entryPublishEndDate >= '$currentDate' OR entryPublishEndDate = '0000-00-00')
			// AND siteID IN ($thisNetworkSiteArrayString)
			// AND isEvent = '1'
			// $queryWhereClause
		// ORDER BY entrySubmissionDateTime DESC
	// ";
	
	$queryNumberOfEvents = "
		SELECT * FROM nisekocms_content 
		WHERE entryPublished = '1' 
			AND entryPublishStartDate <= '$currentDate' 
			AND (entryPublishEndDate >= '$currentDate' OR entryPublishEndDate = '0000-00-00')
			AND siteID IN ($thisNetworkSiteArrayString)
			AND isEvent = '1'
		ORDER BY eventDate DESC
	";
	
	$resultContentTestList = mysql_query($queryNumberOfEvents);
	
	if (is_authed()) { $rowSpan = 7; } else{ $rowSpan = 5; }
		
		echo '<table style="width:100%;margin:0px auto 0px auto;">';
		
			// echo '<tr>';
					// echo '<td class="fieldLabelLeft" colspan="' . $rowSpan . '"><h1 style="margin:0px;">' . agileResource(getContentListTitle($contentCategoryKey)) . '</h1></td>';
			// echo '</tr>';
			
			echo '<tr>';
					echo '<td class="fieldLabelLeft" colspan="' . $rowSpan . '">';
						echo '<h2 style="margin:0px;">';
							echo '<a href="' . languageUrlPrefix() . getContentNewCrudURL($contentCategoryKey) . '"';
								if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
							echo '>' . agileResource(getContentNewCrudTitle($contentCategoryKey)) . '</a>';
						echo '</h2>';
					echo '</td>';
			echo '</tr>';
		
			echo '<tr>';
					echo '<td class="fieldLabelCenter">' . agileResource('username') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('title') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('date') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('views') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('replies') . '</td>';
					if (is_authed()) { 
						echo '<td class="fieldLabelCenter">' . agileResource('public') . '</td>';
						echo '<td class="fieldLabelCenter">' . agileResource('action') . '</td>';
					}
			echo '</tr>';
		
			while($rowContentTestList = mysql_fetch_array($resultContentTestList)) {
			
				$replyCount = 0;
				
				echo '<tr';
					
					if ($rowContentTestList['eventDate'] == $selectedDate) {
						echo ' style="background-color:#ff9;"';
					}
				
				echo '>';
				
				
					echo '<td class="borderAlignLeft">' . getUserName($rowContentTestList['entrySubmittedByUserID']) . '</td>';
					echo '<td class="borderAlignLeft">';
						echo '<a href="' . languageUrlPrefix() . getContentListURL($contentCategoryKey) . $rowContentTestList['entryID'] . '/';
							if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
						echo '">';
							echo getContentTitle($rowContentTestList['entryID']);
						echo '</a>';
					echo '</td>';
					echo '<td class="borderAlignCenter">' . $rowContentTestList['eventDate'] . '</td>';
					echo '<td class="borderAlignCenter">' . $rowContentTestList['entryViews'] . '</td>';
					
					
					echo '<td class="borderAlignCenter">';
						$replyCount = getContentTotalReplyCount($rowContentTestList['entryID']);
						if ($replyCount != 0) { echo $replyCount; }
					echo '</td>';
					
					if (is_authed()) { 
						echo '<td class="borderAlignCenter">';
							if ($rowContentTestList['entryPublished'] == 1) { echo '&#10004;'; }
						echo '</td>';
						echo '<td class="borderAlignCenter">';
							if (userOwnsContent($rowContentTestList['entryID'])) {
								echo '<a href="' . languageUrlPrefix() . getContentUpdateCrudURL($contentCategoryKey) . $rowContentTestList['entryID'] . '/">';
									echo agileResource(getContentUpdateCrudTitle($contentCategoryKey));
								echo '</a>';
							} elseif ($_SESSION['userRoleForCurrentSite'] == 'siteManager') {
								echo '<a href="' . languageUrlPrefix() . getContentUpdateCrudURL($contentCategoryKey) . $rowContentTestList['entryID'] . '/">';
									echo agileResource('moderateContent');
								echo '</a>';
							}
						echo '</td>';
					}
				echo '</tr>';
			}
		echo '</table>';


}

function dispayCalendarEntryCRUD() {

}

function insertCalendarEntry() {

}

function updateCalendarEntry() {

}

function displayCalendarCategoryDropdown($calendarCategoryID) {

}

function getNumberOfEvents($thisDate) {

	$totalNumberOfEventsThisDate = 0;
	$currentDate = date('Y-m-d');
	$thisNetworkSiteArrayString = join(',', $_SESSION['networkSiteArray']);
	$queryNumberOfEvents = "
		SELECT * FROM nisekocms_content 
		WHERE entryPublished = '1' 
			AND entryPublishStartDate <= '$currentDate' 
			AND (entryPublishEndDate >= '$currentDate' OR entryPublishEndDate = '0000-00-00')
			AND siteID IN ($thisNetworkSiteArrayString)
			AND isEvent = '1'
			AND eventDate = '$thisDate'
		ORDER BY entrySubmissionDateTime DESC
	";
	$resultNumberOfEvents = mysql_query($queryNumberOfEvents);
	$totalNumberOfEventsThisDate = mysql_num_rows($resultNumberOfEvents);
	return $totalNumberOfEventsThisDate;

}

?>