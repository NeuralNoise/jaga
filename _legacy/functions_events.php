<?php

function displayCalendar(
	$selectedMonthName, 
	$selectedYear, 
	$selectedDate, 
	$columnToPlaceFirstDay, 
	$dateMarker, 
	$numberOfMiddleCalendarRows, 
	$numberOfDaysInLastRow, 
	$tableStyleAttribute = 'margin:0px;width:100%;background-color:#fff;'
) {
	
		echo '<table style="' . $tableStyleAttribute . '">';
		
			echo '<tr>';
				echo '<td class="fieldLabelLeft" colspan="4">';
				echo $selectedMonthName . '&nbsp;' . $selectedYear;
				echo '</td>';
				echo '<td class="fieldLabelCenter" colspan="3">';
				displayDateInput($selectedDate, 'date', 1, 100);
				echo '</td>';
			echo '</tr>';
		
			echo '<tr>';
				echo '<td class="fieldLabelCenter" style="width:88px;">' . agileResource('Sun') . '</td>';
				echo '<td class="fieldLabelCenter" style="width:87px;">' . agileResource('Mon') . '</td>';
				echo '<td class="fieldLabelCenter" style="width:88px;">' . agileResource('Tues') . '</td>';
				echo '<td class="fieldLabelCenter" style="width:87px;">' . agileResource('Wed') . '</td>';
				echo '<td class="fieldLabelCenter" style="width:88px;">' . agileResource('Thurs') . '</td>';
				echo '<td class="fieldLabelCenter" style="width:87px;">' . agileResource('Fri') . '</td>';
				echo '<td class="fieldLabelCenter" style="width:88px;">' . agileResource('Sat') . '</td>';
			echo '</tr>';
			
			echo '<tr>';
				// START FIRST ROW OF CALENDAR //
				for($i=0; $i<$columnToPlaceFirstDay; $i++) {
					echo '<td class="fieldLabelCenter">&nbsp;</td>';
				}
				for($i=6; $i>=$columnToPlaceFirstDay; $i=$i-1) {
					echo '<td class="borderAlignCenter">' . $dateMarker . '</td>';
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
							echo '<td class="borderAlignCenter">' . $dateMarker . '</td>';
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
						echo '<td class="borderAlignCenter">' . $dateMarker . '</td>';
						$dateMarker = $dateMarker + 1;
						$i=$i+1;
					}
					while ($i <= 7) {
						echo '<td class="fieldLabelCenter">&nbsp;</td>';
						$i=$i+1;
					}
				}
				// END LAST ROW OF CALENDAR //
			echo '</tr>';
			
		echo '</table>';

}

// nisekocalendar index
function displayEventsForThisCategory($eventCategoryID) {

	$queryGetThisCategory = "SELECT * FROM nisekocms_eventCategory WHERE id = '$eventCategoryID' LIMIT 1"; // GET CATEGORY INFO
	$resultGetThisCategory = mysql_query($queryGetThisCategory);
	while ($rowGetThisCategory = mysql_fetch_array($resultGetThisCategory)) { $categoryName = $rowGetThisCategory['catname']; }

		echo '<table style="width:100%;">';
		
			echo '<tr style="background-color:#115b8a;">';
				echo '<td colspan="2">';
					echo '<div>';
						echo '<h3 style="float:left;margin:0px 0px 0px 10px;color:#ffffff;">' . $categoryName . '</h3>';
						echo '<a href="#" style="float:right;margin:2px 2px 0px 0px;color:#ffffff;text-decoration:none;">';
							echo '<img src="agileThemes/kutchannel/images/plus-symbol.png">';
						echo '</a>';
						echo '<a href="#" style="float:right;margin:2px 2px 0px 0px;color:#ffffff;text-decoration:none;">';
							echo agileResource('testing');
						echo '</a>';
						echo '<a href="#" style="float:right;margin:2px 10px 0px 0px;color:#ffffff;text-decoration:none;">';
							echo '&nbsp;<img src="agileThemes/kutchannel/images/upper-right-arrow.png">';
						echo '</a>';
						echo '<a href="#" style="float:right;margin:2px 2px 0px 0px;color:#ffffff;text-decoration:none;">';
							echo agileResource('testing');
						echo '</a>';
						echo '<div style="clear:both;"></div>';
					echo '</div>';
				echo '</td>';
			echo '</tr>';
			$queryGetEventsForThisCategory = "SELECT * FROM nisekocms_event WHERE eventCategoryID = '$eventCategoryID' ORDER BY eventStartDateTime DESC LIMIT 7";
			
			$resultGetEventsForThisCategory = mysql_query($queryGetEventsForThisCategory);
			$rowCount = 0;
			while ($rowGetEventsForThisCategory = mysql_fetch_array($resultGetEventsForThisCategory)) {
				if (($rowCount % 2) == 0) { $trStyleAttribute = 'background-color:#fff;'; } else { $trStyleAttribute = 'background-color:#eee;'; }
				echo '<tr style="' . $trStyleAttribute . '">';
					echo '<td class="borderAlignLeft">';
						echo getUserName($rowGetEventsForThisCategory['eventSubmittedByUserID']);
					echo '</td>';
					echo '<td class="borderAlignLeft">';
						echo '<a href="/' . languageUrlPrefix() . 'event/' . $rowGetEventsForThisCategory['eventID'] . '/">';
							echo $rowGetEventsForThisCategory['eventTitleEnglish'];
						echo '</a>';
					echo '</td>';
				echo '</tr>';
				$rowCount++;
			}
			
		echo '</table>';
			
}

// kutchannel index
/*
function displayUpcomingEvents($numberOfEvents) {

	echo '<table style="width:100%;">';
		echo '<tr style="background-color:#115b8a;">';
			echo '<td colspan="2" class="borderAlignCenter">';
				
				echo '<div>';
						echo '<h3 style="float:left;margin:0px 0px 0px 10px;color:#ffffff;">';
							echo agileResource('events');
						echo '</h3>';

						echo '<a href="http://nisekocalendar.com/' . languageUrlPrefix() . 'events/submit/';
						echo '" style="float:right;margin:2px 2px 0px 0px;color:#ffffff;text-decoration:none;"';
						echo '>';
							echo '<img src="agileThemes/kutchannel/images/plus-symbol.png">';
						echo '</a>';
						
						echo '<a href="http://nisekocalendar.com/' . languageUrlPrefix() . 'events/submit/';
						echo '" style="float:right;margin:2px 2px 0px 0px;color:#ffffff;text-decoration:none;"';
						echo '>';
							echo agileResource('addNewEvent');
						echo '</a>';
						
						echo '<a href="http://nisekocalendar.com/' . languageUrlPrefix() . 'events/';
						echo '" style="float:right;margin:2px 10px 0px 0px;color:#ffffff;text-decoration:none;"';
						echo '>';
							echo '<img src="agileThemes/kutchannel/images/upper-right-arrow.png">';
						echo '</a>';
						
						echo '<a href="http://nisekocalendar.com/' . languageUrlPrefix() . 'events/';
						echo '" style="float:right;margin:2px 2px 0px 0px;color:#ffffff;text-decoration:none;"';
						echo '>';
							echo agileResource('more');
						echo '</a>';

						echo '<div style="clear:both;"></div>';
					echo '</div>';

			echo '</td>';
		echo '</tr>';
		
	$resultGetEvents = mysql_query("SELECT * FROM nisekocms_event ORDER BY dates DESC LIMIT $numberOfEvents");
	$rowCount = 0;
	while($rowGetEvents = mysql_fetch_array($resultGetEvents)) {
		if (($rowCount % 2) == 0) { $trStyleAttribute = 'background-color:#fff;'; } else { $trStyleAttribute = 'background-color:#eee;'; }
		echo '<tr style="' . $trStyleAttribute . '">';
			echo '<td class="borderAlignLeft">';
				echo getUserName($rowGetEvents['eventSubmittedByUserID']);
			echo '</td>';
			echo '<td class="borderAlignLeft">';
				echo '<a href="/' . languageUrlPrefix() . 'event/' . $rowGetEvents['eventID'] . '/">';
				echo $rowGetEvents['eventTitleEnglish'];
			echo '</a>';
			echo '</td>';
		echo '</tr>';
		$rowCount++;
	}
	echo '</table>';
}
*/

/*

CREATE TABLE IF NOT EXISTS `nisekocms_event` (
  `eventID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `eventVenueID` int(8) unsigned NOT NULL DEFAULT '0',
  `eventCategoryID` int(8) unsigned NOT NULL DEFAULT '0',
  `eventStartDateTime` datetime NOT NULL,
  `eventEndDateTime` datetime NOT NULL,
  `dates` date NOT NULL DEFAULT '0000-00-00',
  `enddates` date DEFAULT NULL,
  `times` time DEFAULT NULL,
  `endtimes` time DEFAULT NULL,
  `eventTitleEnglish` varchar(100) NOT NULL DEFAULT '',
  `alias` varchar(100) NOT NULL DEFAULT '',
  `eventSubmittedByUserID` int(8) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  `modified_by` int(11) unsigned NOT NULL DEFAULT '0',
  `author_ip` varchar(15) NOT NULL DEFAULT '',
  `eventDateTimeSubmitted` datetime NOT NULL,
  `datdescription` mediumtext NOT NULL,
  `meta_keywords` varchar(200) NOT NULL DEFAULT '',
  `meta_description` varchar(255) NOT NULL DEFAULT '',
  `recurrence_number` int(2) NOT NULL DEFAULT '0',
  `recurrence_type` int(2) NOT NULL DEFAULT '0',
  `recurrence_counter` date NOT NULL DEFAULT '0000-00-00',
  `datimage` varchar(100) NOT NULL DEFAULT '',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `registra` tinyint(1) NOT NULL DEFAULT '0',
  `unregistra` tinyint(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`eventID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=427 ;


*/

function displayEventList($eventCategoryID) {


}

function displayEventCrud($type = 'create') {

}




?>